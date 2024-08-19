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

use \validator\Authentication;

/**
 * ZnetDK core: login checking
 */
class LoginHelper {
    protected $validator;
    protected $isNewPasswordValidation;
    protected $hasPasswordExpired = FALSE;
    protected $lastErrorMessage = NULL;
    protected $lastErrorVariable = NULL;
    protected $dbUser = NULL;
    protected $isUserAuthenticated = FALSE;
    protected $loginThrottling;

    /**
     * Instantiates a new login helper object
     * @param array $credentials The login name, password and access mode values
     * for web service authentication throw HTTP Basic authentication.
     */
    public function __construct($credentials = NULL) {
        $this->validator = new Authentication(FALSE);
        if (!is_null($credentials)) {
            $this->validator->setValues($credentials);
        }
        $this->isNewPasswordValidation = !(is_null($this->login_password)
                && is_null($this->login_password2));
        $this->loginThrottling = new LoginThrottling($this->login_name);
    }

    /**
     * Check credentials.
     * @throws \Exception Authentication failed
     */
    public function check() {
        $remainingLockoutTime = $this->loginThrottling->getRemainingLockoutTimeInSeconds();
        if ($remainingLockoutTime > 0) {
            $this->setLastError(General::getFilledMessage(
                LC_MSG_ERR_LOGIN_THROTTLING_TOO_MUCH_ATTEMPTS, $remainingLockoutTime),
                'login_name');
        }
        if (!$this->validator->validate()) {
            //Data validation failed...
            $this->setLastError($this->validator->getErrorMessage(),
                    $this->validator->getErrorVariable());
        }
        try {
            $this->checkLoginName();
            $this->checkPassword();
            // Authentication has succeed
            UserSession::resetAuthentHasFailed();
            $this->checkUserDisabled();
            $this->checkUserArchived();
        } catch (\Exception $ex) {
            $this->loginThrottling->setLoginFailed();
            throw $ex;
        }
        $this->isUserAuthenticated = TRUE;
        $this->checkPasswordHasExpired();
    }

    /**
     * Change user's password if user is authenticated and they new password and
     * confirmation are set in the HTTP request.
     * @return boolean|array TRUE is password changing succeeded, FALSE if
     * password changing is not required.
     * @throws \Exception Password changing has failed.
     */
    public function changePasswordIfRequested() {
        if (!$this->isNewPasswordValidation) {
            return FALSE;
        }
        $changePwdStatus = MainController::execute('Users', 'changePassword');
        if ($changePwdStatus === TRUE) {
            return TRUE;
        }
        // Password change failed
        $changePwdErrMsg = is_array($changePwdStatus) && count($changePwdStatus) === 2
            ? $changePwdStatus[0] : $changePwdStatus;
        $changePwdErrVar = is_array($changePwdStatus) && count($changePwdStatus) === 2
            ? $changePwdStatus[1] : 'login_password';
        $this->setLastError($changePwdErrMsg, $changePwdErrVar);
    }
    
    /**
     * Sets in session user's data required when they are authenticated
     * successfully.
     */
    public function setUserAuthenticatedInSession() {
        UserSession::setUserAuthenticated($this->getUserInfosFromDB(), $this->access);
    }

    /**
     * If login attempts traced in user's session is greater than the number of
     * attempts configured before user disabling, user's account is disabled.
     * @return boolean TRUE if user's login is valid and user's account was not
     * yet disabled and user's account has been disabled successfully. FALSE
     * otherwise. 
     */
    public function disableUserIfTooMuchAttempts() {
        if ($this->doesLoginNameExistAndIsEnabled()) {
            $loginName = $this->getDbUserVal('login_name');
            // Password is invalid but user exists and they account is enabled...
            UserSession::setAuthentHasFailed($loginName);
            if (UserSession::isMaxNbrOfFailedAuthentReached()
                    && MainController::execute('Users', 'disableUser', $loginName)) {
                return TRUE;
            }
        }
        return FALSE;
    }

    /**
     * For tracking connections purpose, trigger notification of user login
     * attempt. 
     * To catch this notification, a 'Security::loginResult' public 
     * static method is to declare in the application or in in a module.
     */
    public function notify() {
        try {
            $loginName = $this->getDbUserVal('login_name');
        } catch (\Exception $ex) {
            $loginName = $this->login_name;
        }
        MainController::executeAll('Security', 'loginResult', array(
            'login_date' => \General::getCurrentW3CDate(TRUE),
            'login_name' => $loginName,
            'ip_address' => \Request::getRemoteAddress(),
            'status' => $this->isUserAuthenticated,
            'message' => $this->isNewPasswordValidation 
                && $this->isUserAuthenticated ? LC_MSG_INF_PWDCHANGED 
                : strval($this->lastErrorMessage)
        ));
    }

    /**
     * Returns the last variable name in error.
     * @return String Error variable name.
     */
    public function getLastErrorVariable() {
        return $this->lastErrorVariable;
    }

    /**
     * Specifies whether the user's password has expired or not.
     * @return Boolean TRUE if user's password has expired, FALSE otherwise.
     */
    public function hasPasswordExpired() {
        return $this->hasPasswordExpired;
    }

    /**
     * Specifies whether the user's email address has been used or not to log in
     * to the application.
     * @return boolean TRUE if user's email address has been used,
     * FALSE otherwise.
     */
    public function isLoggedInWithEmailAddress() {
        try {
            return $this->isUserAuthenticated === TRUE
                    && $this->login_name === $this->getDbUserVal('user_email');
        } catch (\Exception $ex) {
            return FALSE;
        }
    }

    /**
     * Returns the POST paramater sent by the HTTP request to log in.
     * @param string $name Name of the POST parameter.
     * @return string Value for the specified parameter name, NULL otherwise.
     */
    public function __get($name) {
        return $this->validator->getValue($name);
    }

    /**
     * Sets the last error detected during credentials validation.
     * @param String $msg Error message to return
     * @param String $varName Name of the concerned POST parameter.
     * @throws \Exception Error message
     */
    protected function setLastError($msg, $varName = NULL) {
        $this->lastErrorMessage = $msg;
        $this->lastErrorVariable = !is_null($varName) ? $varName
            : ($this->isNewPasswordValidation ? 'password' : 'login_name');
        throw new \Exception($msg);
    }

    /**
     * Returns user's informations read in database from the login name sent as
     * POST parameter.
     * @return array User's informations read in database.
     * @throws \Exception No user found for the specified login name.
     */
    protected function getUserInfosFromDB() {
        if (is_null($this->dbUser)) {
            $this->dbUser = UserManager::getUserInfosByCredential($this->login_name);
        }
        if (is_array($this->dbUser)) {
            return $this->dbUser;
        }
        throw new \Exception("No user found for '{$this->login_name}'.");
    }
    
    /**
     * Returns the value of the specified column name in database for the user
     * found from their login name.
     * @param String $columnName Name of the column
     * @return String The value of the specified column name.
     * @throws \Exception Unknown column name.
     */
    protected function getDbUserVal($columnName) {
        $this->getUserInfosFromDB();
        if (key_exists($columnName, $this->dbUser)) {
            return $this->dbUser[$columnName];
        }
        throw new \Exception("Column '{$columnName}' is unknown");
    }

    /**
     * Checks if a user exists in database and their account is enabled for the
     * login name sent by the HTTP request.
     * @return boolean TRUE is a user exists and is enabled, FALSE otherwise.
     */
    protected function doesLoginNameExistAndIsEnabled() {
        try {
            return $this->getDbUserVal('user_enabled') === '1';
        } catch (\Exception $ex) {
            return FALSE;
        }
    }

    /**
     * Checks if the sent login name matches an existing user account (case 
     * sensitive checking).
     */
    protected function checkLoginName() {
        try {
            $loginName = $this->getDbUserVal('login_name');
            if ($loginName !== $this->login_name
                    && $this->getDbUserVal('user_email') !== $this->login_name) {
                // Case sensitive mismatch on login name
                $this->setLastError(LC_MSG_ERR_LOGIN, 'login_name');
            }
        } catch (\Exception $ex) {
            // User unknown or user exists but he's disabled and his password is invalid.
            $this->setLastError(LC_MSG_ERR_LOGIN);
        }
    }

    /**
     * Checks password validity.
     */
    protected function checkPassword() {
        if(!MainController::execute('Security', 'isPasswordValid',
                $this->password, $this->getDbUserVal('login_password'))) {
            $this->setLastError(LC_MSG_ERR_LOGIN);
        }
    }

    /**
     * Checks if user's account is disabled.
     */
    protected function checkUserDisabled() {
        if ($this->getDbUserVal('user_enabled') === '0') {
            $this->setLastError(LC_MSG_ERR_LOGIN, 'login_name');
        }
    }

    /**
     * Checks if user's account is archived.
     */
    protected function checkUserArchived() {
        if ($this->getDbUserVal('user_enabled') === '-1') {
            $this->setLastError(LC_MSG_ERR_LOGIN, 'login_name');
        }
    }

    /**
     * Checks if user's password has expired.
     */
    protected function checkPasswordHasExpired() {
        if (new \DateTime($this->getDbUserVal('expiration_date')) < new \DateTime('now')
                    && !$this->isNewPasswordValidation) {
            $this->hasPasswordExpired = TRUE;
            $this->setLastError(LC_MSG_ERR_LOGIN_EXPIRATION, 'login_name');
        }
    }

}
