<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr 
 * Copyright (C) 2019 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * Core Asynchronous Execution service 
 *
 * File version: 1.2
 * Last update: 08/31/2022
 */

/**
 * ZnetDK AsyncExec class
 */
Class AsyncExec {
    static private $mainScriptFile = 'index.php';
    static private $asyncExecArgument = 'async';
    
    /**
     * Launch the controller action specified as command line arguments (PHP CLI)
     * If the CFG_ASYNCEXEC_LOG_ENABLED parameter is set to TRUE into the 
     * 'config.php' of the application, execution traces are added to the 
     * ZnetDK 'system.log' file.
     * @return boolean Value TRUE if the call to the 'index.php' matching a 
     * command line asynchronous controller action execution. Returns FALSE
     * otherwise. 
     */
    static public function launch() {
        $controllerAction = self::getControllerAction();
        if ($controllerAction === FALSE) {
            return FALSE;
        }
        if (CFG_ASYNCEXEC_LOG_ENABLED) {
            \General::writeSystemLog(__METHOD__, "Launching process ID=" . $controllerAction['process_id']
                . ", '" . $controllerAction['class'] . "::" . $controllerAction['method']
                . "('" . $controllerAction['parameters'] ."')'... [" . date('Y-m-d H:m:i') . ']', TRUE);
        }
        $returnCode = $controllerAction['class']::doAsynchronousAction($controllerAction['process_id'],
            $controllerAction['method'], $controllerAction['parameters']);
        if (CFG_ASYNCEXEC_LOG_ENABLED) {
            \General::writeSystemLog(__METHOD__, "Returned value = " . (empty($returnCode) ? '?' : $returnCode) . ' ['
                . date('Y-m-d H:m:i') . ']', TRUE);
        }
        return TRUE;
    }
    
    /**
     * Returns the login name of the user who requested the execution.
     * @return string The login name of the original user, NULL otherwise.
     */
    static public function getLoginName() {
        if (key_exists('argc', $_SERVER) && $_SERVER['argc'] === 8
                && $_SERVER['argv'][1] === self::$asyncExecArgument) {
            return \General::sanitize($_SERVER['argv'][3]);
        } else {
            return NULL;
        }
    }
    
    static private function getControllerAction() {
        // Check command line arguments
        if (!key_exists('argc', $_SERVER) || $_SERVER['argc'] !== 8
                || $_SERVER['argv'][1] !== self::$asyncExecArgument) {
            return FALSE; // Bad arguments !
        }
        $loginName = \General::sanitize($_SERVER['argv'][3]);
        $processKey = $_SERVER['argv'][4];        
        $controllerName = \General::sanitize($_SERVER['argv'][5], 'action');
        $actionName = \General::sanitize($_SERVER['argv'][6], 'action');
        $stringParameters = \General::sanitize($_SERVER['argv'][7]);
        // Process authentication...
        $processId = self::checkAndRemoveAuthenticationKey($processKey, $loginName,
            $controllerName, $actionName);
        if ($processId === FALSE) {
            return FALSE; // Authentication failed
        }
        // Does user exist?
        if (!self::doesLoginNameExist($loginName)) {
            return FALSE; // Unknown login name
        }
        // Does controller and action exist?
        if (!self::isControllerActionAsynchronous($controllerName, $actionName)) {
            return FALSE; // The controller action is invalid
        }
        return array(
            'process_id' => $processId,
            'class' => MainController::getControllerName($controllerName, $actionName),
            'method' => $actionName,
            'parameters' => $stringParameters
        );
    }
    
    /**
     * Submits the asynchronous execution of the specified controller action
     * @param string $controllerName The name of the controller
     * @param string $actionName The name of the action
     * @param string $stringParameters Optionals parameters passed as string value
     * @return string|boolean The process identifier if the action could be
     * submited. Returns FALSE in the following cases:
     * - The CFG_ASYNCEXEC_PHP_BINARY_PATH parameter is NULL,
     * - The specified controller action not exists,
     * - The process key could not be written into the CFG_ASYNCEXEC_AUTHENTICATION_PATH directory,
     * - The system call for executing the controller action failed.
     */
    static public function submitActionToLaunch($controllerName, $actionName, $stringParameters = '') {
        if (is_null(CFG_ASYNCEXEC_PHP_BINARY_PATH)) {
            return FALSE; // The PHP binary is not configured
        }
        if (!self::isControllerActionAsynchronous($controllerName, $actionName)) {
            return FALSE; // The controller action is invalid
        }
        $processKey = self::writeAuthenticationKey(UserSession::getLoginName(), $controllerName, $actionName);
        if ($processKey === FALSE) {
            return FALSE; // The process key can't be written on filesystem
        }
        $output = array();
        $return_var = 0;
        $command = General::getFilledMessage(CFG_ASYNCEXEC_PHP_BINARY_PATH,
            ZNETDK_ROOT, self::$mainScriptFile, self::$asyncExecArgument,
            ZNETDK_APP_NAME, UserSession::getLoginName(), $processKey,
            $controllerName, $actionName, $stringParameters);
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen($command, 'r')); 
        } else {
            exec($command, $output, $return_var);
        }
        if ($return_var !== 0) {
            if (count($output) === 0) {
                $output[] = 'Unable to execute the following command: ' . $command;
            }
            $textError = __METHOD__ . ' - ' . implode(PHP_EOL, $output);
            General::writeErrorLog('ZNETDK ERROR', $textError, TRUE);
        }
        return $processKey;
    }
    
    static private function writeAuthenticationKey($loginName, $controllerName, $actionName) {
        $processKey = date('YmdHis'). '-' . session_id();
        $authenticationKey = General::encrypt($processKey,
            self::getAuthenticationString($loginName, $controllerName, $actionName));
        $authenticationFilePath = self::getAuthenticationFilePath($processKey);
        if (file_put_contents($authenticationFilePath, $authenticationKey, LOCK_EX) === FALSE) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__
                . " - Unable to write the file '{$authenticationFilePath}'!", TRUE);
            return FALSE;
        }
        return $processKey;
    }
    
    static private function checkAndRemoveAuthenticationKey($processKey, $loginName, $controllerName, $actionName) {
        $authenticationFilePath = self::getAuthenticationFilePath($processKey);
        if (!file_exists($authenticationFilePath)) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__
                . " - The file '{$authenticationFilePath}' not exists!", TRUE);
            return FALSE;
        }
        $checkedProcessKey = General::decrypt(file_get_contents($authenticationFilePath),
            self::getAuthenticationString($loginName, $controllerName, $actionName));
        if (!unlink($authenticationFilePath)) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__
                . " - Unable to remove the file '{$authenticationFilePath}'!", TRUE);
            return FALSE;
        }
        if ($checkedProcessKey === $processKey) {
            return $processKey;
        }
        return FALSE;
    }
    
    static private function getAuthenticationString($loginName, $controllerName, $actionName) {
        return base64_encode($actionName.'µ' . $loginName . '{'.$controllerName);
    }
    
    static private function getAuthenticationFilePath($processKey) {
        return CFG_ASYNCEXEC_AUTHENTICATION_PATH . DIRECTORY_SEPARATOR . "{$processKey}.auth";
    }
    
    static private function isControllerActionAsynchronous($controllerName, $actionName) {
        $className = MainController::getControllerName($controllerName, $actionName);
        if ($className === FALSE) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__
                . " - The controller action '{$controllerName}::{$actionName}' not found!", TRUE);
            return FALSE; // No controller found
        }
        return $className::isAsynchronousAction($actionName);
    }
    
    static private function doesLoginNameExist($loginName) {
        return UserManager::getUserInfos($loginName) !== FALSE;
    }
    
}
