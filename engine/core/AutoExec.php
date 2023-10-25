<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr 
 * Copyright (C) 2017 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Core Autoexec service 
 *
 * File version: 1.3
 * Last update: 09/01/2022
 */

/**
 * ZnetDK AutoExec class
 */
Class AutoExec {
    static private $mainScriptFile = 'index.php';
    static private $autoexecArgument = 'autoexec';
    static private $autoExecControllerName = 'autoexec';
    static private $autoExecActionName = 'main';
    static private $processStateRunning = 'Running';
    static private $processStateTerminated = 'Terminated';
    static private $processMaxExecutionTime = 'PT1H'; // DateInterval format
    
    /**
     * Executes in a background process the 'autoexec' actions defined for the
     * modules or the application.
     * @return boolean Value TRUE if the index.php script is called for executing
     * an autoexec action, otherwise FALSE.
     */
    static public function launch() {
        if (self::getLoginName() === self::$autoexecArgument) {
            self::setLastExecutionTime();
            if (CFG_AUTOEXEC_LOG_ENABLED) {
                \General::writeSystemLog('Autoexec', "Launching '" . self::$autoExecControllerName . "::" . self::$autoExecActionName . "()'...["
                    . $_SERVER['REQUEST_TIME_FLOAT'] . ']', TRUE);
            }
            $returnCode = \MainController::execute(self::$autoExecControllerName, self::$autoExecActionName);
            if (CFG_AUTOEXEC_LOG_ENABLED) {
                \General::writeSystemLog('Autoexec', "Returned value = " . (empty($returnCode) ? '?' : $returnCode) . ' ['
                    . $_SERVER['REQUEST_TIME_FLOAT'] . ']', TRUE);
            }
            self::setProcessState(FALSE);
            return TRUE;
        }
        self::triggerAutoAction();
        return FALSE;
    }
    
    /**
     * Returns the 'autoexec' string if the application is launched in command
     * line for auto execution purpose 
     * @return string The value 'autoexec' if the application is launched in
     * command line with the expected parameters, NULL otherwise.
     */
    static public function getLoginName() {
        if (key_exists('argc', $_SERVER) && $_SERVER['argc'] === 3
                && $_SERVER['argv'][1] === self::$autoexecArgument) {
            return self::$autoexecArgument;
        } else {
            return NULL;
        }
    }
    
    /**
     * Triggers the actions declared into the 'autoexec' controller found in the
     * application or its modules.
     */
    static private function triggerAutoAction() {
        if (is_null(CFG_AUTOEXEC_PHP_BINARY_PATH)) {
            return FALSE; // The PHP binary is not configured
        }
        $className = MainController::getControllerName(self::$autoExecControllerName,
                self::$autoExecActionName, FALSE);
        if ($className === FALSE) {
            return FALSE; // No controller found for auto-execution!
        }
        if (!self::doesTimeElapsedForNextAutoexec()) {
            return FALSE; // the time elapsed since the last execution is too low
        }
        if (self::isExecutionTimeTooLong()) {
            // The execution time of the previous process is too long (more than 1 hour)
            // So the synchronization file is removed
            self::removeSynchronizationFile();
        }
        if (self::getProcessState() === self::$processStateRunning
                || self::setProcessState(TRUE) === FALSE) {
            if (CFG_AUTOEXEC_LOG_ENABLED) {
                \General::writeSystemLog('Autoexec', "triggerAutoAction"
                    . "[" . $_SERVER['REQUEST_TIME_FLOAT'] . ']'
                    . ": the autoexec process is already running!", TRUE);
            }
            return FALSE; //The autoexec process is running
        }
        $output = array();
        $return_var = 0;
        $command = General::getFilledMessage(CFG_AUTOEXEC_PHP_BINARY_PATH,
                ZNETDK_ROOT, self::$mainScriptFile, self::$autoexecArgument, ZNETDK_APP_NAME);
        if (CFG_AUTOEXEC_LOG_ENABLED) {
            \General::writeSystemLog('Autoexec', "triggerAutoAction"
                . "[" . $_SERVER['REQUEST_TIME_FLOAT'] . ']'
                . ": Exec command : '{$command}'", TRUE);
        }
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen($command, 'r')); 
        } else {
            exec($command, $output, $return_var);
        }
        if (CFG_AUTOEXEC_LOG_ENABLED) {
            $outputString = count($output) === 0 ? '** Empty **' : print_r($output, TRUE);
            \General::writeSystemLog('Autoexec', "triggerAutoAction"
                . "[" . $_SERVER['REQUEST_TIME_FLOAT'] . ']'
                . ": Returned value = '{$return_var}', Output : '{$outputString}'", TRUE);
        }
        if ($return_var !== 0) {
            if (count($output) === 0) {
                $output[] = 'Unable to execute the following command: ' . $command;
            }
            $textError = 'Autoexec - ' . implode(PHP_EOL, $output);
            General::writeErrorLog('ZNETDK ERROR', $textError, TRUE);
        }
    }
    /**
     * Checks if the autoexec controller action can be launched or not according
     * to the time elapsed since the last execution time and the number of
     * seconds set for the CFG_AUTOEXEC_FREQUENCY parameter.
     */
    static private function doesTimeElapsedForNextAutoexec() {
        $lastExecutionTime = self::getLastExecutionTime();
        $currentTime = new \DateTime('now');
        $interval = $lastExecutionTime->diff($currentTime);
        $seconds = $interval->days * 24 * 60 * 60;
        $seconds += $interval->h * 60 * 60;
        $seconds += $interval->i * 60;
        $seconds += $interval->s;
        if ($seconds <= CFG_AUTOEXEC_FREQUENCY) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * Reads from the synchronisation file the last execution time of the
     * 'autoexec' controller action.
     * @return \DateTime The last execution date and time
     */
    static private function getLastExecutionTime() {
        self::initSynchronization();
        $synchroInfos = explode(';', file_get_contents(CFG_AUTOEXEC_SYNCHRO_FILE));
        return new \DateTime($synchroInfos[0]);
    }
    
    /**
     * Writes within the synchronisation file the current time
     */
    static private function setLastExecutionTime() {
        self::initSynchronization();
        $synchroInfos = explode(';', file_get_contents(CFG_AUTOEXEC_SYNCHRO_FILE));
        $synchroInfos[0] = General::getCurrentW3CDate(TRUE);
        file_put_contents(CFG_AUTOEXEC_SYNCHRO_FILE, implode(';', $synchroInfos), LOCK_EX);
    }
    
    /**
     * Sets within the synchronization file that auto-execution process is
     * running
     */
    static private function setProcessState($isRunning) {
        self::initSynchronization();
        $state = $isRunning === TRUE ? self::$processStateRunning : self::$processStateTerminated;
        $synchroInfos = explode(';', file_get_contents(CFG_AUTOEXEC_SYNCHRO_FILE));
        if ($synchroInfos[1] === $state) {
            return FALSE;
        }
        $synchroInfos[1] = $state;
        file_put_contents(CFG_AUTOEXEC_SYNCHRO_FILE, implode(';', $synchroInfos), LOCK_EX);
        return TRUE;
    }
    
    /**
     * Provides the current state of the autoexecution process
     * @return string The running state
     */
    static private function getProcessState() {
        self::initSynchronization();
        $synchroInfos = explode(';', file_get_contents(CFG_AUTOEXEC_SYNCHRO_FILE));
        return $synchroInfos[1];
    }
    
    static private function initSynchronization() {
        if (!self::isSynchronizationFileOk()) {
            // Error detected in synchonization file format
            // So the synchronization file is removed.
            self::removeSynchronizationFile();
        }
        if (!file_exists(CFG_AUTOEXEC_SYNCHRO_FILE)) {
            $synchroInfos = array();
            $synchroInfos[0] = General::getCurrentW3CDate(TRUE);
            $synchroInfos[1] = self::$processStateTerminated;
            file_put_contents(CFG_AUTOEXEC_SYNCHRO_FILE, implode(';', $synchroInfos), LOCK_EX);
        } 
    }
    
    /**
     * Removes the synchronization file
     */
    static private function removeSynchronizationFile() {
        if (unlink(CFG_AUTOEXEC_SYNCHRO_FILE)) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__ 
                . ": error detected on file " . CFG_AUTOEXEC_SYNCHRO_FILE . "'. So it is removed!", TRUE);
        } else {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__ 
                . ": error detected on file " . CFG_AUTOEXEC_SYNCHRO_FILE . "'. File can't be removed!", TRUE);
        }
    }
    
    /**
     * Checks if the synchronization file is well formated
     * @return boolean Returns FALSE if the synchronization file is not well
     * formated. Otherwise returns TRUE, even if the synchronization file is
     * missing.
     */
    static private function isSynchronizationFileOk() {
        if (!file_exists(CFG_AUTOEXEC_SYNCHRO_FILE)) {
            return TRUE;
        }
        $synchroInfos = explode(';', file_get_contents(CFG_AUTOEXEC_SYNCHRO_FILE));
        if (count($synchroInfos) !== 2) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__ 
                    . ": the count of parameters (" . count($synchroInfos) . ") within the '"
                    . CFG_AUTOEXEC_SYNCHRO_FILE . "' file must be equal to 2!", TRUE);
            return FALSE; // 2 values are expected
        }
        // Check the date and time format
        $executionDateTime = is_string($synchroInfos[0]) 
                ? \DateTime::createFromFormat('Y-m-d H:i:s', $synchroInfos[0]) : FALSE;
        if (!$executionDateTime || $executionDateTime->format('Y-m-d H:i:s') !== $synchroInfos[0]) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__ 
                    . ": the format of the '{$synchroInfos[0]}' date within the '"
                    . CFG_AUTOEXEC_SYNCHRO_FILE . "' is invalid!", TRUE);
            return FALSE; // Date time format invalid
        }
        // Check the status
        if ($synchroInfos[1] !== self::$processStateTerminated 
                && $synchroInfos[1] !== self::$processStateRunning) {
            General::writeErrorLog('ZNETDK ERROR', __METHOD__ 
                    . ": the status '{$synchroInfos[1]}' within the '"
                    . CFG_AUTOEXEC_SYNCHRO_FILE . "' file is not "
                    . "'" . self::$processStateTerminated . "' or '"
                    . self::$processStateRunning . "'!", TRUE);
            return FALSE; // Status is invalid
        }
        return TRUE;
    }
    
    /**
     * Checks if execution time is too long
     * @return boolean Returns TRUE if the execution time is longer than the 
     * time allowed for execution (see $processMaxExecutionTime property).
     */
    static private function isExecutionTimeTooLong() {
        $processState = self::getProcessState();
        // Check if the execution time is not too long
        if ($processState === self::$processStateRunning) {
            $lastExecutionDateTime = self::getLastExecutionTime();
            $lastExecutionDateTimeString = $lastExecutionDateTime->format('Y-m-d H:i:s');
            $currentDateTime = new DateTime('now');
            if (CFG_AUTOEXEC_LOG_ENABLED) {
                \General::writeSystemLog('Autoexec', 'isExecutionTimeTooLong'
                    . "[" . $_SERVER['REQUEST_TIME_FLOAT'] . ']'
                    . ": Status = {$processState}, last exec = {$lastExecutionDateTimeString}, current date time = '"
                    . $currentDateTime->format('Y-m-d H:i:s') . "', max exec time = '"
                    . self::$processMaxExecutionTime . "'", TRUE);
            }
            $lastExecutionDateTime->add(new DateInterval(self::$processMaxExecutionTime));
            if ($lastExecutionDateTime < $currentDateTime) {
                General::writeErrorLog('ZNETDK ERROR', __METHOD__ 
                    . ": the process is still running ('{$processState}') from '{$lastExecutionDateTimeString}' and the max execution time allowed ('"
                    . self::$processMaxExecutionTime . "') is elapsed!", TRUE);
                return TRUE; // Process execution time too long
            }
        }
        return FALSE;
    }
}