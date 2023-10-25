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
 * File version: 1.0
 * Last update: 09/18/2015
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
     * @param String $value Login name
     * @return boolean FALSE if the login name stored in session is different 
     * than the one used to connect. Returns TRUE otherwise. 
     */
    protected function check_login_name($value) {
        $login_name_in_session = \UserSession::getLoginName();
        if (isset($login_name_in_session) && $login_name_in_session !== $value) {
            // User login is not the same in session 
            $this->setErrorMessage(LC_MSG_ERR_DIFF_LOGIN);
            return FALSE;
        } else {
            return TRUE;
        }
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
