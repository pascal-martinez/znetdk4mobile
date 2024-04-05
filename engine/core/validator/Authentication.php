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
 * Core Validator : check credentials of a user for authentication 
 *
 * File version: 1.1
 * Last update: 03/19/2024
 */

namespace validator;

/**
 * Checks if the user login and the type of access are valid 
 */
class Authentication extends \Validator {

    protected function initVariables() {
        return array('login_name', 'password', 'access');
    }

    protected function initOptionalVariables() {
        return array('access');
    }

    /**
     * Checks if the login name is the same than the one memorized in the
     * user session.
     * @param String $loginName Login name
     * @return boolean FALSE if the login name stored in session is different
     * than the one used to connect. Returns TRUE otherwise.
     */
    protected function check_login_name($loginName) {
        $loginNameInSession = \UserSession::getLoginName();
        if (!isset($loginNameInSession) || $loginNameInSession === $loginName) {
            return TRUE; // No login name in user session or login names are identical
        }
        if (filter_var($loginName, FILTER_VALIDATE_EMAIL)) {
            // $loginName is a well formated email address
            $user = \UserManager::getUserInfosByEmail($loginName);
            if (is_array($user) && $user['login_name'] === $loginNameInSession) {
                return TRUE; // The user email has been used as login name
            }
        }
        $this->setErrorMessage(LC_MSG_ERR_DIFF_LOGIN);
        return FALSE; // User login is not the same in session
    }

    /**
     * Checks if the specified type of access is among the expected values.
     * @param String $value Type of access to the application
     * @return boolean TRUE if specified access is 'public' or 'private', FALSE
     * otherwise.
     */
    protected function check_access($value) {
        if ($value !== 'public' && $value !== 'private') {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
