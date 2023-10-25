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
 * Core Validator : check profile informations for new and existing profiles
 *
 * File version: 1.2
 * Last update: 09/02/2022
 */

namespace validator;

/**
 * Checks the profile informations entered in the profile management form 
 */
class Profile extends \Validator {

    protected function initVariables() {
        return array('profile_id', 'profile_name', 'profile_description');
    }

    protected function initOptionalVariables() {
        return array('profile_id');
    }

    /**
     * Checks the user name validity
     * @param string $value User name
     * @return boolean FALSE if user name is invalid
     */
    protected function check_profile_name($value) {
        // Max length : 50 characters
        if (strlen($value) > 50) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_BADLENGTH);
            return FALSE;
        }
        // Must be unique
        $profileRow = \ProfileManager::getProfileInfos($value);
        if (is_array($profileRow) && $profileRow['profile_id'] != $this->getValue('profile_id')) {
            $this->setErrorMessage(\General::getFilledMessage(LC_MSG_ERR_PROFILE_EXISTS,$value));
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Checks the user's email address validity 
     * @param string $value
     * @return boolean FALSE if email address is invalid
     */
    protected function check_profile_description($value) {
        // Max length : 200 characters
        if (strlen($value) > 200) {
            $this->setErrorMessage(LC_MSG_ERR_VALUE_BADLENGTH);
            return FALSE;
        }
        return TRUE;
    }

}
