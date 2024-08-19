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
 * Core Validator : check user informations for new and existing users
 *
 * File version: 1.4
 * Last update: 08/14/2024
 */

namespace validator;

/**
 * Checks the user informations entered in the user management form 
 */
class User extends \validator\Password {

    protected function initVariables() {
        return array('user_id', 'user_name', 'user_email', 'login_name', 'login_password', 'login_password2',
            'expiration_date', 'full_menu_access', 'user_enabled', 'user_phone', 'notes');
    }

    protected function initOptionalVariables() {
        return array('user_id', 'full_menu_access', 'user_phone', 'notes');
    }

    /**
     * Checks the user name validity
     * @param string $value User name
     * @return boolean FALSE if user name is invalid
     */
    protected function check_user_name($value) {
        // Max length : 100 characters
        if (strlen($value) > 100) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_BADLENGTH);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Checks the user's email address validity 
     * @param string $value Email address
     * @return boolean FALSE if email address is invalid
     */
    protected function check_user_email($value) {
        // Must match an email format
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage(LC_MSG_ERR_EMAIL_INVALID);
            return FALSE;
        }
        // Must be unique
        $userID = \UserManager::getUserIdByEmail($value);
        if (!is_null($userID) && $userID != $this->getValue('user_id')) {
            $this->setErrorMessage(LC_MSG_ERR_EMAIL_EXISTS);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Checks the login name validity
     * @param string $value Login name
     * @return boolean FALSE if login name is invalid
     */
    protected function check_login_name($value) {
        // Min length : 6 characters
        // Max length : 20 characters
        if (strlen($value) < 6 || strlen($value) > 20) {
            $this->setErrorMessage(LC_MSG_ERR_LOGIN_BADLENGTH);
            return FALSE;
        }
        // Must be unique
        $userRow = \UserManager::getUserInfos($value);
        if ($userRow !== FALSE && $userRow['user_id'] != $this->getValue('user_id')) {
            $this->setErrorMessage(LC_MSG_ERR_LOGIN_EXISTS);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Checks the expiration date validity
     * @param string $value Expiration date
     * @return boolean FALSE if expiration date is invalid
     */
    protected function check_expiration_date($value) {
        // Must be a valid W3C formated date
        if (!\General::isW3cDateValid($value)) {
            $this->setErrorMessage(LC_MSG_ERR_DATE_INVALID);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Checks the activation status of the user
     * @param boolean $value Value of the activation status
     * @return boolean FALSE if value is not equal to -1, 0 or 1
     */
    protected function check_user_enabled($value) {
        if ($value < -1 || $value > 1) {
            $this->setErrorMessage(LC_FORM_LBL_USER_STATUS . ' - ' . LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Checks the full menu access value of the user
     * @param boolean $value Value of the full menu access status
     * @return boolean FALSE if value is not equal to 0 or 1
     */
    protected function check_full_menu_access($value) {
        if ($value < 0 || $value > 1) {
            $this->setErrorMessage(LC_FORM_LBL_USER_MENU_ACCESS . ' - ' . LC_MSG_ERR_VALUE_INVALID);
            return FALSE;
        }
        return TRUE;
    }

}
