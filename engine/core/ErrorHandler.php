<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr 
 * Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Error handler of the application
 *
 * File version: 1.4
 * Last update: 12/22/2024
 */

/**
 * Handles all errors triggered by the application
 */
class ErrorHandler {

    static private $isErrorTrackingEnabled;

    /**
     * Inits the error handler
     */
    static public function init() {
        self::$isErrorTrackingEnabled = TRUE;
        set_error_handler("\\ErrorHandler::handleRuntimeError");
        register_shutdown_function(array("\\ErrorHandler", 'handleFatalError'));
        // If a message exists in the output buffer, it is traced and next removed
        $error = ob_get_contents();
        if (is_string($error) and strlen($error) > 0) {
            \General::writeErrorLog('ZNETDK WARNING', 'Existing error in the output buffer: ' . strip_tags($error), TRUE);
            ob_clean();
        }
        // Output is buffered
        ob_start();
    }

    /**
     * Suspends the error handling
     */
    static public function suspend() {
        self::$isErrorTrackingEnabled = FALSE;
    }

    /**
     * Restarts the error handler
     */
    static public function restart() {
        self::$isErrorTrackingEnabled = TRUE;
    }

    /**
     * Handles the runtime errors triggered by the PHP interpreter
     * @param Number $errno Error number of the error
     * @param String $errstr String of the error message
     * @param String $errfile Name of the script file in error
     * @param Number $errline Line number of the error in the PHP script
     */
    static public function handleRuntimeError($errno, $errstr, $errfile, $errline) {
        if (self::$isErrorTrackingEnabled) {
            $errorMessage = self::formatErrorMessage($errstr, $errfile, $errline);
            \General::writeErrorLog(self::getErrorLevelString($errno), $errorMessage, true);
        }
    }

    /**
     * Handles the fatal errors detected by the PHP interpreter
     */
    static public function handleFatalError() {
        $error = self::getLastFatalErrorMessage();
        if (is_array($error)) {
            $errorMessage = self::formatErrorMessage($error['message'], $error['file'], $error['line']);
            \General::writeErrorLog($error['stringType'], $errorMessage, true);
            // Empty the output buffer
            ob_end_clean();
            // The error is output in JSON format
            $response = new \Response(FALSE);
            $summary = defined('LC_MSG_CRI_ERR_SUMMARY') ? LC_MSG_CRI_ERR_SUMMARY : 'Error';
            $detail = defined('LC_MSG_CRI_ERR_DETAIL') ? LC_MSG_CRI_ERR_DETAIL : '%1';
            $response->doHttpError(500, $summary, \General::getFilledMessage(
                    $detail, $errorMessage),FALSE);
        }
        // Flush output buffer and stop buffering
        ob_end_flush();
    }

    /**
     * Returns the formated message of the specified error
     * @param String $message Original error message
     * @param String $file Filename of the PHP script in error
     * @param String $line Line number of the detected error in the PHP script
     * @return String Formated error message
     */
    static public function formatErrorMessage($message, $file, $line) {
        return $message . ' - ' . $file . '(' . $line . ')';
    }

    /**
     * Returns the last fatal error message triggered by the PHP interpreter
     * @return Array Details of the fatal error, FALSE if the error has an 
     * unknown type.
     */
    static private function getLastFatalErrorMessage() {
        $error = error_get_last();
        if (isset($error['type']) && ($error['type'] === E_ERROR ||
                $error['type'] === E_PARSE ||
                $error['type'] === E_COMPILE_ERROR)) {
            $error['message'] = \General::sanitize($error['message'], 'default', FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            $error['stringType'] = self::getErrorLevelString($error['type']);
            return $error;
        } else {
            return NULL;
        }
    }

    /**
     * Returns the error level string of the specified error level constant
     * @param Integer $errorLevel Constant of the error level
     * @return string String matching the specified error level constant value
     */
    static private function getErrorLevelString($errorLevel) {
        switch ($errorLevel) {
            case E_ERROR:return 'E_ERROR';
            case E_WARNING:return 'E_WARNING';
            case E_PARSE:return 'E_PARSE';
            case E_NOTICE: return 'E_NOTICE';
            case E_CORE_ERROR: return 'E_CORE_ERROR';
            case E_CORE_WARNING: return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:return 'E_COMPILE_ERROR';
            case E_CORE_WARNING: return 'E_COMPILE_WARNING';
            case E_USER_ERROR: return 'E_USER_ERROR';
            case E_USER_WARNING: return 'E_USER_WARNING';
            case E_USER_NOTICE: return 'E_USER_NOTICE';
            case /*E_STRICT*/2048: return 'E_STRICT';
            case E_RECOVERABLE_ERROR: return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED: return 'E_DEPRECATED';
            case E_USER_DEPRECATED: return 'E_USER_DEPRECATED';
            default: return "E_UNSPECIFIED_ERROR";
        }
    }

}
