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
 * Core Validator : check password validity of a user
 *
 * File version: 1.1
 * Last update: 06/03/2024
 */

namespace validator;

/**
 * Checks the new password validity when it is renewed
 */
class Password extends \Validator {

    protected function initVariables() {
        return array('login_password', 'login_password2', 'password');
    }

    protected function initOptionalVariables() {
        return array('password');
    }

    /**
     * Checks if the password matches the format set for the
     * CFG_CHECK_PWD_VALIDITY parameter.
     * @param String $value Password
     * @return boolean TRUE if the password is valid, FALSE otherwise
     */
    protected function check_login_password($value) {
        $userID = $this->getValue('user_id');
        if (isset($userID) && $value === \General::getDummyPassword()) {
            return TRUE;
        }
        if (is_string(CFG_CHECK_PWD_VALIDITY) && !preg_match(CFG_CHECK_PWD_VALIDITY, $value)) {
            $this->setErrorMessage(LC_MSG_ERR_PASSWORD_BADLENGTH);
            return FALSE;
        } elseif (!is_string(CFG_CHECK_PWD_VALIDITY)) {
            $errMsg = LC_MSG_ERR_PASSWORD_INVALID . ' ';
            if (is_string(CFG_CHECK_PWD_LOWERCASE_REGEXP) && !preg_match('/' . CFG_CHECK_PWD_LOWERCASE_REGEXP . '/', $value)) {
                $this->setErrorMessage($errMsg . LC_FORM_LBL_PASSWORD_EXPECTED_LOWERCASE);
                return FALSE;
            }
            if (is_string(CFG_CHECK_PWD_UPPERCASE_REGEXP) && !preg_match('/' . CFG_CHECK_PWD_UPPERCASE_REGEXP . '/', $value)) {
                $this->setErrorMessage($errMsg . LC_FORM_LBL_PASSWORD_EXPECTED_UPPERCASE);
                return FALSE;
            }
            if (is_string(CFG_CHECK_PWD_NUMBER_REGEXP) && !preg_match('/' . CFG_CHECK_PWD_NUMBER_REGEXP . '/', $value)) {
                $this->setErrorMessage($errMsg . LC_FORM_LBL_PASSWORD_EXPECTED_NUMBER);
                return FALSE;
            }
            if (is_string(CFG_CHECK_PWD_SPECIAL_REGEXP) && !preg_match('/' .CFG_CHECK_PWD_SPECIAL_REGEXP . '/', $value)) {
                $this->setErrorMessage($errMsg . LC_FORM_LBL_PASSWORD_EXPECTED_SPECIAL);
                return FALSE;
            }
            if (is_string(CFG_CHECK_PWD_LENGTH_REGEXP) && !preg_match('/' . CFG_CHECK_PWD_LENGTH_REGEXP . '/', $value)) {
                $this->setErrorMessage($errMsg . LC_FORM_LBL_PASSWORD_EXPECTED_LENGTH);
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Checks if the second password entered for confirmation is equal to the
     * first password
     * @param String $value Second password
     * @return boolean TRUE if the second password is equal to the first
     *  password, FALSE otherwise.
     */
    protected function check_login_password2($value) {
        // Must match the password value
        $userID = $this->getValue('user_id');
        $dummyPassword = \General::getDummyPassword();
        if (((isset($userID) && ($value !== $dummyPassword || $this->getValue('login_password') !== $dummyPassword)) || !isset($userID)) && $this->getValue('login_password') !== $value) {
            $this->setErrorMessage(LC_MSG_ERR_PWD_MISMATCH);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Checks if the password is not the same than the old original password
     * @param String $value New password
     * @return boolean TRUE if the new password is not equal to the previous one,
     * FALSE otherwise.
     */
    protected function check_password($value) {
        // New password must be different than the previous one
        if ($value === $this->getValue('login_password')) {
            $this->setErrorMessage(LC_MSG_ERR_PWD_IDENTICAL);
            $this->setErrorVariable('login_password');
            return FALSE;
        }
        return TRUE;
    }

}
