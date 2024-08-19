<?php

/*
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://www.znetdk.fr
 * Copyright (C) 2024 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Core Failed login class
 *
 * File version: 1.0
 * Last update: 08/10/2024
 */

/**
 * ZnetDK core: throttles new login attempts after multiple login failures
 */
class LoginThrottling {

    protected $loginName;
    protected $firstLoginDateTime;
    protected $lastLoginDateTime;
    protected $loginAttemptCount;
    protected $remainingLockoutTimeInSeconds;

    /**
     * Instantiates a new login throttle.
     * @param string $loginName Login name to throttle
     */
    public function __construct($loginName) {
        $this->loginName = $loginName;
        // Retrieve existing login history
        $this->readHistory();
        // Calculates the remaining lockout time and reset login history if
        // lockout is over.
        if ($this->loginAttemptCount >= CFG_LOGIN_THROTTLING_ATTEMPTS_BEFORE_LOCKOUT) {
            $timeElapsedSinceLastLogin = $this->getTimeElapsedSinceLastLogin(time());
            $this->remainingLockoutTimeInSeconds = $timeElapsedSinceLastLogin > CFG_LOGIN_THROTTLING_LOCKOUT_DELAY
                    ? 0 : CFG_LOGIN_THROTTLING_LOCKOUT_DELAY - $timeElapsedSinceLastLogin;
            if ($this->remainingLockoutTimeInSeconds === 0) {
                $this->reset();
            }
        }
    }

    /**
     * Returns the remaining time in seconds of login lockout for the login name
     * specified when calling the class' constructor.
     * @return integer The remaining number of seconds
     */
    public function getRemainingLockoutTimeInSeconds() {
        return $this->remainingLockoutTimeInSeconds;
    }

    /**
     * Sets a new login failure for the login name specifed when calling the
     * class' contructor.
     * @return boolean TRUE on succes, FALSE otherwise.
     */
    public function setLoginFailed() {
        $filePath = $this->getFilePath();
        if ($filePath === FALSE) {
            return FALSE;
        }
        $lastLoginTimestamp = time();
        $timeElapsedSinceLastLogin = $this->getTimeElapsedSinceLastLogin($lastLoginTimestamp);
        if ($timeElapsedSinceLastLogin > CFG_LOGIN_THROTTLING_ATTEMPTS_WINDOW_TIME) {
            $this->reset();
            $lastLoginTimestamp = $this->firstLoginDateTime->getTimestamp();
        }
        $newCount = $this->loginAttemptCount+1;
        $content = $this->firstLoginDateTime->getTimestamp() . ';'
                . $lastLoginTimestamp . ';' . strval($newCount);
        if (!file_put_contents($filePath, $content, LOCK_EX)) {
            General::writeErrorLog(__METHOD__, 'Unable to write the failed login log entry.');
            return FALSE;
        }
        $this->loginAttemptCount = $newCount;
        $this->lastLoginDateTime->setTimestamp($lastLoginTimestamp);
        return TRUE;
    }

    /**
     * Returns the login history filepath.
     * @return boolean FALSE if the login log dir does not exist and could not
     * be created, FALSE otherwise.
     */
    protected function getFilePath() {
        $fileDir = ZNETDK_ROOT . CFG_ZNETDK_LOGIN_LOG_DIR . DIRECTORY_SEPARATOR;
        if (!is_dir($fileDir) && !mkdir($fileDir, 0755)) {
            General::writeErrorLog(__METHOD__, 'Unable to create the login log directory.');
            return FALSE;
        }
        $encodedLoginName = base64_encode($this->loginName);
        $safeLoginName = str_replace(['/', '=', '+'], [',', ';', '!'], $encodedLoginName);
        return $fileDir . General::getApplicationID() . "_{$safeLoginName}"
            . '_failed';
    }

    /**
     * Reads login history for the login name specified on object instantiation.
     * @return boolean TRUE on success, FALSE otherwise.
     */
    protected function readHistory() {
        $this->firstLoginDateTime = new DateTime('now');
        $this->lastLoginDateTime = clone $this->firstLoginDateTime;
        $this->loginAttemptCount = 0;
        $filePath = $this->getFilePath();
        if ($filePath === FALSE) {
            return FALSE; // login log directory creation failed
        }
        $content = file_exists($filePath) ? file_get_contents($filePath) : FALSE;
        if ($content === FALSE) {
            return FALSE; // login log file has been removed
        }
        $contentAsArray = explode(';', $content);
        if (count($contentAsArray) === 3) {
            $this->firstLoginDateTime->setTimestamp($contentAsArray[0]);
            $this->lastLoginDateTime->setTimestamp($contentAsArray[1]);
            $this->loginAttemptCount = intval($contentAsArray[2]);
            return TRUE;
        }
        \General::writeErrorLog(__METHOD__, 'Login log entry is invalid.');
        return FALSE;
    }

    /**
     * Remove the login history filename and reset the object properties.
     * @return boolean TRUE on success, FALSE otherwise.
     */
    protected function reset() {
        $filePath = $this->getFilePath();
        if ($filePath === FALSE) {
            return FALSE;
        }
        if (file_exists($filePath) && !unlink($filePath)) {
            General::writeErrorLog(__METHOD__, "Unable to remove file '{$filePath}'.");
            return FALSE;
        }
        $this->readHistory();
        return TRUE;
    }

    /**
     * Calculates the time elapsed since the last login.
     * @param integer $now The timestamp for now.
     * @return integer The number of seconds elapsed since the last login
     */
    protected function getTimeElapsedSinceLastLogin($now) {
        $nowDateTime = new DateTime();
        $nowDateTime->setTimestamp($now);
        return $now - $this->lastLoginDateTime->getTimestamp();
    }

}
