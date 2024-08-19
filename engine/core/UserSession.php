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
 * Core User session API
 *
 * File version: 1.14
 * Last update: 08/07/2024
 */
Class UserSession {
    static private $customVarPrefix = "zdkcust-";

    /**
     * Sets the specified value in user session for the current application
     * @param string $variable Name of the variable in the user session
     * @param string $value Value to set in session
     */
    static private function setValue($variable, $value) {
        if (!isset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME])) {
            $_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME] = array();
        }
        $_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME][$variable] = $value;
    }

    /**
     * Gets from the user session and the current application, the value for the
     * specified variable name.
     * @param string $variable Name of the variable that contains the requested
     * value
     * @return mixed NULL if the requested variable does not exist in the user
     * session, otherwise the value found.
     */
    static private function getValue($variable) {
        if (!isset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME])
                || !isset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME][$variable])) {
            return NULL;
        } else {
            return $_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME][$variable];
        }
    }

    /**
     * Returns the access mode stored in session for the current user
     * @return string Value 'public' or 'private'
     */
    static private function getAccessMode() {
        if (!is_null(self::getValue('last_time_access'))) {
            return 'public';
        } else {
            return 'private';
        }
    }

    /**
     * Indicated whether the user session has timed out
     * @return boolean TRUE is session has timed out
     */
    static private function hasSessionTimedOut() {
        if (self::getAccessMode() === 'public') {
            $current_time = new \DateTime('now');
            $interval = self::getValue('last_time_access')->diff($current_time);
            $minutes = $interval->days * 24 * 60;
            $minutes += $interval->h * 60;
            $minutes += $interval->i;
            if ($minutes <= CFG_SESSION_TIMEOUT) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Returns the number of times the current user failed to authenticate.
     * @return int Number of failed authentications
     */
    static private function getNbrOfFailedAuthent() {
        if (!is_null(self::getValue('nbr_of_failed_authent'))) {
            return self::getValue('nbr_of_failed_authent');
        } else {
            return 0;
        }
    }

    /**
     * Reset the last time HTTP requests sent by the current user.
     */
    static private function renewSessionTime() {
        self::setValue('last_time_access', new \DateTime("now"));
    }

    /**
     * Returns the IP address stored in session for the connected user
     * @return string User IP address stored in session
     */
    static private function getRemoteAddress() {
        if (!is_null(self::getValue('ip_address'))) {
            return self::getValue('ip_address');
        } else {
            return NULL;
        }
    }

    static private function getAbosulteURI() {
        if (!is_null(self::getValue('application_uri'))) {
            return self::getValue('application_uri');
        } else {
            return NULL;
        }
    }

    static private function getApplicationVersion() {
        return CFG_VIEW_PAGE_RELOAD === FALSE ? CFG_APPLICATION_VERSION : FALSE;
    }

    /**
     * Returns the login log filename
     * @param string $loginName Login name
     * @return string|false The login log filename of FALSE if the directory
     * is missing and can't be created
     */
    static private function getLoginLogFilename($loginName) {
        $fileDir = ZNETDK_ROOT . CFG_ZNETDK_LOGIN_LOG_DIR . DIRECTORY_SEPARATOR;
        if (!is_dir($fileDir) && !mkdir($fileDir, 0755)) {
            General::writeErrorLog(__METHOD__, 'Unable to create the login log directory.');
            return FALSE;
        }
        return $fileDir . General::getApplicationID() . "_{$loginName}";
    }

    /**
     * Traces the session ID of the logged in user in order to check if multiple
     * session exist for the same login name.
     * @param string $loginName Login name of the logged in user.
     * @return boolean TRUE if session ID is traced for the login name, FALSE
     * otherwise.
     */
    static private function traceLastLoginSessionId($loginName) {
        if (CFG_AUTHENT_REQUIRED === TRUE && CFG_SESSION_ONLY_ONE_PER_USER === TRUE) {
            $filePath = self::getLoginLogFilename($loginName);
            if ($filePath === FALSE) {
                return FALSE;
            }
            if (!file_put_contents($filePath, session_id(), LOCK_EX)) {
                General::writeErrorLog(__METHOD__, 'Unable to write the login log entry.');
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Checks if the current user's session ID matches the session ID tracked
     * when user logged in for the last time.
     * @return boolean TRUE is session IDs match or if no login name is
     * currently stored in session or if authentication is not required and
     * sessions are not limited to a login name per user.
     */
    static private function isLastLoginSessionId() {
        if (CFG_AUTHENT_REQUIRED === TRUE && CFG_SESSION_ONLY_ONE_PER_USER === TRUE) {
            $loginName = self::getValue('login_name');
            if (is_null($loginName)) {
                return TRUE;
            }
            $filePath = self::getLoginLogFilename($loginName);
            if ($filePath === FALSE) {
                return FALSE; // login log directory creation failed
            }
            $tracedSessionId = file_exists($filePath) ? file_get_contents($filePath) : FALSE;
            if ($tracedSessionId === FALSE) {
                return FALSE; // login log file has been removed
            }
            return $tracedSessionId === session_id();
        }
        return TRUE;
    }

    /**
     * Clears the custom variables added to the user session
     */
    static private function clearCustomValues() {
        $prefixLength = strlen(self::$customVarPrefix);
        $sessionKeys = array_keys($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]);
        foreach($sessionKeys as $key) {
           $prefix = substr($key,0,$prefixLength);
           if ($prefix === self::$customVarPrefix) {
               unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME][$key]);
           }
        }
    }

    /**
     * Returns the sanitized value specified in parameter
     * @param mixed $value Value to sanitize
     * @return mixed Sanitized value
     */
    static private function getCleanedValue($value) {
        if (is_array($value)) {
            self::cleanArrayValues($value);
            return $value;
        } elseif (is_numeric($value)) {
            return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        } elseif (is_bool($value)) {
            return $value;
        } else {
            return \General::sanitize($value, 'default', FILTER_FLAG_STRIP_LOW);
        }
    }
    /**
     * Sanitizes the values of the array preserving without encoding the codes
     * @param array $array Array containing the values to sanitize
     */
    static private function cleanArrayValues(&$array) {
        foreach ($array as &$value) {
            if (!is_array($value)) {
                $value = \General::sanitize($value, 'default', FILTER_FLAG_STRIP_LOW);
            } else {
                self::cleanArrayValues($value);
            }
        }
    }

    /* Public methods */

    /**
     * Indicates whether the user is authenticated or not.
     * @param boolean $silent if TRUE, no HTTP error 401 is returned (set to
     * FALSE by default).
     * @return boolean TRUE if user is authenticated else FALSE
     */
    static public function isAuthenticated($silent = FALSE) {
        if (!CFG_AUTHENT_REQUIRED) {
            return TRUE;
        }
        $isTokenValid = self::isUITokenValid(FALSE);
        $isLastLoginSessionId = self::isLastLoginSessionId();
        if (self::getLoginName() && $isTokenValid && $isLastLoginSessionId) {
            // User is authenticated
            if (self::getAccessMode() === 'public') {
                if (!self::hasSessionTimedOut()) {
                    self::renewSessionTime();
                    return TRUE;
                } else {
                    $message = LC_MSG_WARN_SESS_TIMOUT;
                }
            } else { // Private acess : user session never times out
                return TRUE;
            }
        } else { // User not authenticated
            $message = LC_MSG_WARN_NO_AUTH;
        }
        if ($silent) {
            return FALSE;
        } else {
            $summary = LC_FORM_TITLE_LOGIN;
            $response = new \Response(FALSE);
            $response->is_disconnected = is_null(self::getValue('login_name'))
                    || !$isTokenValid || !$isLastLoginSessionId;
            if ($response->is_disconnected === FALSE
                    && ($appVersion = self::getApplicationVersion()) !== FALSE) {
                $response->appver = $appVersion;
                $response->reload_summary = LC_MSG_WARN_NEW_VERSION_SUMMARY;
                $response->reload_msg = LC_MSG_WARN_NEW_VERSION_MSG;
            } elseif ($response->is_disconnected === TRUE
                    && \Request::getMethod() === 'POST') {
                $summary = LC_MSG_WARN_LOGGED_OUT_SUMMARY;
                $message = LC_MSG_WARN_LOGGED_OUT_MSG;
            }
            $response->doHttpError(401, $summary, $message);
        }
    }

    /**
     * Returns the login name stored in session for the user only if the URI
     * and the IP address have not changed since the previous call
     * If the application is executed in command line, the 'autoexec' value or
     * the specified login name set as parameter is returned
     * @return string The login name of the connected user, 'autoexec' or NULL
     *  otherwise.
     */
    static public function getLoginName() {
        if (!is_null(self::getValue('login_name')) &&
                \Request::getRemoteAddress() === self::getRemoteAddress() &&
                \General::getAbsoluteURI() === self::getAbosulteURI()) {
            return self::getValue('login_name');
        } else {
            $autoexecLoginName = AutoExec::getLoginName();
            if (is_null($autoexecLoginName)) {
                return AsyncExec::getLoginName();
            }
            return $autoexecLoginName;
        }
    }

    /**
     * Returns the user ID stored in the user session for the current user
     * @return string Identifier of the user
     */
    static public function getUserId() {
        if (!is_null(self::getValue('user_id'))) {
            return self::getValue('user_id');
        } else {
            return NULL;
        }
    }

    /**
     * Stores in session the user ID of the current user.
     * @param integer $userId Identifier of the user in the datatabase
     */
    static public function setUserId($userId) {
        self::setValue('user_id', $userId);
    }

    /**
     * Stores in session the profiles for the authenticated user
     * @param array $userProfiles
     */
    static public function setUserProfiles($userProfiles) {
        self::setValue('user_profiles', $userProfiles);
    }

    /**
     * Returns the profiles for the authenticated user
     * @return array All the profiles assigned to the authenticated user
     */
    static public function getUserProfiles() {
        if (!is_null(self::getValue('user_profiles'))) {
            return self::getValue('user_profiles');
        } else {
            return [];
        }
    }

    /**
     * Checks if the authenticated user has the specified profile name
     * @param string $profileName Profile name to check
     * @return boolean TRUE if user has the specified profile, FALSE otherwise.
     */
    static public function hasUserProfile($profileName) {
        $profiles = self::getValue('user_profiles');
        if (is_array($profiles)) {
            return array_search($profileName, $profiles) !== FALSE;
        }
        return FALSE;
    }

    /**
     * Stores in session the user's name
     * @param string $userName User name
     */
    static public function setUserName($userName) {
        self::setValue('user_name', $userName);
    }

    /**
     * Returns the user's name stored in session for the current user
     * @return string User's name
     */
    static public function getUserName() {
        if (!is_null(self::getValue('user_name'))) {
            return self::getValue('user_name');
        } else {
            return NULL;
        }
    }

    /**
     * Stores in session the user's email
     * @param string $userEmail User email
     */
    static public function setUserEmail($userEmail) {
        self::setValue('user_email', $userEmail);
    }

    /**
     * Returns the user's email stored in session for the current user
     * @return string User's email
     */
    static public function getUserEmail() {
        if (!is_null(self::getValue('user_email'))) {
            return self::getValue('user_email');
        } else {
            return NULL;
        }
    }

    /**
     * Stores in session the full menu access state
     * @param boolean $fullMenuAccess TRUE if user has full menu access
     */
    static public function setFullMenuAccess($fullMenuAccess) {
        self::setValue('full_menu_access', $fullMenuAccess == TRUE);
    }

    /**
     * Returns the full menu access state for the current user
     * @return boolean Full menu access state
     */
    static public function hasFullMenuAccess() {
        if (!is_null(self::getValue('full_menu_access'))) {
            return self::getValue('full_menu_access');
        } else {
            return NULL;
        }
    }

    /**
     * Returns the language code stored in the user session
     * @return string Language code
     */
    static public function getLanguage() {
        if (!is_null(self::getValue('lang'))) {
            return self::getValue('lang');
        } else {
            return NULL;
        }
    }

    /**
     * Store in the user session his prefered language
     * @param string $language Language code to set
     */
    static public function setLanguage($language) {
        self::setValue('lang', $language);
    }

    /**
     * Stored in session the fact that the specified user failed to authenticate
     * @param string $loginName Login of the user
     */
    static public function setAuthentHasFailed($loginName) {
        if (!is_null(self::getValue('nbr_of_failed_authent'))
                && !is_null(self::getValue('user_failed_authent'))
                && self::getValue('user_failed_authent') === $loginName) {
            self::setValue('nbr_of_failed_authent', self::getValue('nbr_of_failed_authent') + 1);
        } else {
            self::setValue('nbr_of_failed_authent', 1);
            self::setValue('user_failed_authent', $loginName);
        }
    }

    /**
     * Indicates whether the number of allowed authentication has been reached
     * @return boolean TRUE if the user failed to authenticate 3 times or more
     */
    static public function isMaxNbrOfFailedAuthentReached() {
        $isPositiveInteger = is_int(CFG_NBR_FAILED_AUTHENT)
                && CFG_NBR_FAILED_AUTHENT > 0;
        if ($isPositiveInteger 
                && self::getNbrOfFailedAuthent() >= CFG_NBR_FAILED_AUTHENT) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Resets in session the information concerning the authentication failure
     * of the current user.
     */
    static public function resetAuthentHasFailed() {
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['nbr_of_failed_authent']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['user_failed_authent']);
    }


    /**
     * Update data in user's session from user informations when user 
     * authentication succeeded.
     * @param array $userInfos User informations read from database.
     * @param string $accessMode Value 'public' or 'private'.
     */
    static public function setUserAuthenticated($userInfos, $accessMode) {
        self::setLoginName($userInfos['login_name']);
        self::setUserId($userInfos['user_id']);
        self::setUserName($userInfos['user_name']);
        self::setUserEmail($userInfos['user_email']);
        self::setFullMenuAccess($userInfos['full_menu_access']);
        self::setUserProfiles(\UserManager::getUserProfilesAsArray($userInfos['user_id']));
        self::setAccessMode($accessMode);
    }

    /**
     * Stores in session the login name of the current user and its associated
     * information(IP adddress and URI of the application accessed).
     * @param string $loginName
     */
    static public function setLoginName($loginName) {
        self::setValue('login_name', $loginName);
        self::setValue('ip_address', \Request::getRemoteAddress());
        self::setValue('application_uri', \General::getAbsoluteURI());
        self::traceLastLoginSessionId($loginName);
    }

    /**
     * Stores in session the last time HTTP request when 'public' mode is set,
     * in order to calculate when the next request will be received, if the max
     * time without activity has been exceeded or not.
     * @param string $accessMode Value 'public' or 'private' allowed.
     */
    static public function setAccessMode($accessMode) {
        if (!isset($accessMode)) {
            $accessMode = CFG_SESSION_DEFAULT_MODE;
        }
        if ($accessMode === 'public') {
            self::setValue('last_time_access', new \DateTime("now"));
        } elseif (!is_null(self::getValue ('last_time_access'))) {
            unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['last_time_access']);
        }
    }

    /**
     * Clears all the current user information stored in session
     */
    static public function clearUserSession() {
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['login_name']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['user_id']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['user_name']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['user_email']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['user_profiles']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['full_menu_access']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['last_time_access']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['ip_address']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['application_uri']);
        unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME]['ui_token']);
        self::clearCustomValues();
        self::resetAuthentHasFailed();
    }

    /**
     * Stores a custom value in the user session.
     * The variable name is prefixed with the string "zdkcust-" to be sure that
     * all existing variable in session with the same name will not be overwritten.
     * @param string $variableName Name of the variable stored in session
     * @param mixed $value Value to store in session
     * @param boolean $sanitize When set to TRUE (set to FALSE by default),
     * value is sanitized before being stored in session.
     * @return boolean TRUE if value has been set properly in session,
     * otherwise returns FALSE.
     */
    static public function setCustomValue($variableName, $value, $sanitize = FALSE) {
        if (isset($variableName) && isset($value)) {
            $sessionVar = 'zdkcust-'.$variableName;
            self::setValue($sessionVar, $sanitize ? self::getCleanedValue($value) : $value);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Returns the value of the specified variable stored in session
     * @param string $variableName Name of the variable stored in session
     * @param boolean $sanitize When set to TRUE (set to FALSE by default),
     * value is sanitized before being returned from session.
     * @return mixed Value read in session for the specified variable
     */
    static public function getCustomValue($variableName, $sanitize = FALSE) {
        $sessionVar = 'zdkcust-'.$variableName;
        if (!is_null(self::getValue($sessionVar))) {
            return $sanitize ? self::getCleanedValue(self::getValue($sessionVar))
                    : self::getValue($sessionVar);
        } else {
            return NULL;
        }
    }

    /**
     * Removes the specified custom variable stored in session.
     * @param string $variableName Name of the variable to remove from session
     * @return boolean TRUE if the variable exists and has been removed, FALSE
     * otherwise
     */
    static public function removeCustomValue($variableName) {
        $sessionVar = 'zdkcust-'.$variableName;
        if (!is_null(self::getValue($sessionVar))) {
            unset($_SESSION[\General::getAbsoluteURI() . ZNETDK_APP_NAME][$sessionVar]);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Generates a new UI token and memorizes it in user's session
     * If token already exists in user's session then it is directly returned.
     * @return string|NULL The UI token, NULL if token generation failed or
     * if user is not authenticated
     */
    static public function setUIToken() {
        $tokenInSession = self::getUIToken();
        if (!is_null($tokenInSession)) {
            return $tokenInSession;
        }
        try {
            $token = \MainController::execute('Users', 'getAutoGeneratedPassword', 24);
        } catch (\Exception $ex) {
            General::writeErrorLog(__METHOD__, $ex->getMessage());
            return NULL;
        }
        self::setValue('ui_token', $token);
        return $token;
    }

    /**
     * Returns the UI token memorized in user's session
     * @return string The UI token or NULL if no token exists
     */
    static public function getUIToken() {
        return self::getValue('ui_token');
    }

    /**
     * Checks if the UI token sent in POST request is the same than the one
     * stored in user's session
     * @param Boolean $silent Specifies if an error message is traced into the
     * errors.log file when no token exists in the HTTP POST request while a
     * token exists in the user's session.
     * @return boolean TRUE if this is a GET request, if no token is stored in
     * session and if POST request token matches the one stored in Session.
     */
    static public function isUITokenValid($silent = TRUE) {
        if (Request::getMethod() === 'GET') {
            return TRUE;
        }
        $sessionToken = self::getUIToken();
        if (is_null($sessionToken)) {
            return TRUE;
        }
        $requestToken = Request::getUIToken();
        if ($requestToken === $sessionToken) {
            return TRUE;
        } elseif (is_null($requestToken) && $silent === FALSE) {
            General::writeErrorLog(__METHOD__, 'UI token not sent in HTTP request');
        }
        return FALSE;
    }

}
