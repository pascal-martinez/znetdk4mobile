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
 * Core application controller for user management
 *
 * File version: 1.14
 * Last update: 09/21/2024
 */

namespace controller;

/**
 * ZnetDK Core controller for user management
 */
class Users extends \AppController {

    /**
     * Evaluates whether action is allowed or not.
     * When authentication is required, action is allowed if connected user has
     * full menu access or if has a profile allowing access to the users view.
     * If no authentication is required, action is allowed if the user view menu
     * item is declared in the 'menu.php' script of the application.
     * @param string $action Action name
     * @return Boolean TRUE if action is allowed, FALSE otherwise
     */
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        $menuItem = CFG_PAGE_LAYOUT === 'mobile' ? 'z4musers' : 'users';
        return CFG_AUTHENT_REQUIRED === TRUE
            ? self::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }            

    // Action methods

    /**
     * Returns the list of the users defined for the application
     * @return \Response Response returned to the main controller
     */
    static protected function action_all() {
        $response = new \Response();
        // Get order specifications from request
        $request = new \Request();
        $first = $request->first;
        $rows = $request->rows;
        $sortfield = $request->sortfield === 'user' ? 'user_name' : $request->sortfield;
        $sortorder = $request->sortorder;
        $sortCriteria = isset($sortfield) && isset($sortorder) ? $sortfield . ($sortorder == -1 ? ' DESC' : '') : 'login_name';
        $searchCriteria = is_string($request->search_criteria) ? json_decode($request->search_criteria, TRUE) : NULL;
        $users = array();
        // JSON Response
        $response->total = \UserManager::getSearchedUsers($first, $rows, $searchCriteria, $sortCriteria, $users);
        $response->rows = CFG_PAGE_LAYOUT !== 'mobile' ? self::getInHtml($users) : $users;
        $response->success = TRUE;
        return $response;
    }

    static protected function getInHtml($users) {
        foreach ($users as $key => $user) {
            $users[$key]['user'] = "<div class=\"user-name\">{$user['user_name']}</div>"
                . "<div class=\"expiration-date expired-{$user['has_expired']}\">"
                    . "<i class=\"fa fa-calendar-o fa-lg\"></i>"
                    . "<span>{$user['expiration_date_locale']}</span></div>"
                . "<div class=\"user-email\">"
                    . "<i class=\"fa fa-envelope fa-lg\"></i>"
                    . "<span>{$user['user_email']}</span></div>";
                if (!empty($user['user_phone'])) {
                    $users[$key]['user'] .= "<div class=\"user-phone\">"
                        . "<i class=\"fa fa-phone-square fa-lg\"></i>"
                        . "<span>{$user['user_phone']}</span></div>";
                }
                if (!empty($user['notes'])) {
                $users[$key]['user'] .= "<div class=\"notes\">"
                    . "<i class=\"fa fa-sticky-note fa-lg\"></i>"
                    . "<i>{$user['notes']}</i></div>";
                }

        }
        return $users;
    }

    /**
     * Returns the informations of the specified user through the POST 'id'
     * parameter
     * @return \Response Response returned to the main controller
     */
    static protected function action_detail() {
        $request = new \Request();
        $response = new \Response();
        $response->setResponse(\UserManager::getUserInfosById($request->id, TRUE));
        return $response;
    }

    /**
     * Returns the suggested words found for searching users by keyword
     */
    static protected function action_suggestions() {
        // 1) Read POST parameters */
        $request = new \Request();
        $query = $request->query === NULL ? $request->criteria : $request->query;
        // 2) Request the rows matching the criterium from the database
        $response = new \Response();
        $response->setResponse(\UserManager::getFoundKeywords($query));
        // 3) Return JSON response
        return $response;
    }

    /**
     * Returns the list of user profile defined for the application
     * @return \Response Response returned to the main controller
     */
    static protected function action_profiles() {
        $response = new \Response();
        // Get profiles from DB
        $response->rows = \ProfileManager::getProfiles();
        $response->success = TRUE;
        return $response;
    }

    /**
     * Saves the user data sent thru the HTTP request
     * @return \Response Response returned to the main controller
     */
    static protected function action_save() {
        $response = new \Response();
        $request = new \Request();
        $isNewUser = $request->user_id ? FALSE : TRUE;
        $summary = $isNewUser ? LC_FORM_TITLE_USER_NEW : LC_FORM_TITLE_USER_MODIFY;
        $validator = new \validator\User();
        if ($validator->validate()) { // Data validation is OK
            $userRow = $validator->getValues();
            // Convert string number to boolean
            $userRow['full_menu_access'] = ($userRow['full_menu_access'] == 1);
            // Password is stored only if is new or has been changed
            if ($userRow['login_password'] === \General::getDummyPassword()) {
                unset($userRow['login_password']);
                $doesPasswordChanged = FALSE;
            } else { // Hashed password is stored in the database
                $passwordInClear = $userRow['login_password'];
                $doesPasswordChanged = TRUE;
                $userRow['login_password'] = \MainController::execute('Users', 'hashPassword', $passwordInClear);
            }
            // Password 2 is always removed (not stored)
            unset($userRow['login_password2']);
            // Storing data into the database
            $userRow['user_id'] = \UserManager::storeUser($userRow, $request->profiles);
            $response->setSuccessMessage(CFG_PAGE_LAYOUT === 'mobile' ? NULL : $summary, LC_MSG_INF_USERSTORED);
            $loginName = \UserSession::getLoginName();
            if (isset($loginName) && $loginName !== $userRow['login_name'] && $doesPasswordChanged === TRUE) {
                try { // Notifying user for his account creation or his password change
                    \MainController::executeAll('Users', 'notify', $isNewUser, $passwordInClear, $userRow);
                } catch (\Exception $e) {
                    $response->setWarningMessage($summary, $e->getMessage());
                }
            }
        } else { //Data validation failed...
            $response->setFailedMessage($summary, $validator->getErrorMessage(),
                    $validator->getErrorVariable());
        }
        return $response; // JSON response sent back to the main controller
    }

    /**
     * Removes the user specified in the HTTP request
     * @return \Response Response returned to the main controller
     */
    static protected function action_remove() {
        /* Reading POST values of the HTTP request... */
        $request = new \Request();
        $userID = $request->user_id;
        \UserManager::removeUser($userID);
        /* Réponse retournée au contrôleur principal */
        $response = new \Response();
        $response->setSuccessMessage(CFG_PAGE_LAYOUT === 'mobile' ? NULL : LC_FORM_TITLE_USER_REMOVE, LC_MSG_INF_USERREMOVED);
        return $response;
    }

    // Public methods that can be optionnaly overidden by the application controller
    // This application controller must be named \app\controller\Users.

    /**
     * Generates a hashed version of the password specified in clear.
     * @param string $password Password in clear
     * @return string Hashed password
     */
    static public function hashPassword($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Generates automatically a temporary password
     * @param int $length Number of expected characters
     * @return string Auto-generated password
     */
    static public function getAutoGeneratedPassword($length = 12) {
        $halfLength = round($length / 2);
        $newLength = $halfLength * 2;
        if (extension_loaded('openssl')) {
            $password = bin2hex(openssl_random_pseudo_bytes($halfLength));
        } elseif (function_exists('random_bytes')) {
            $password = bin2hex(random_bytes($halfLength));
        }
        if (!isset($password) || strlen($password) != $newLength) {
            throw new \Exception('USR-101: password auto-generation failed!');
        }
        return $password;
    }

    /**
     * Returns the user name of the currently connected user
     * @return string User name or NULL if the user name can't be read in the
     * database or if no user is authenticated.
     */
    static public function getUserName() {
        return \UserSession::getUserName();
    }

    /**
     * Returns the user email of the currently connected user
     * @return string User email or NULL if the user email can't be read in the
     * database or if no user is authenticated.
     */
    static public function getUserEmail() {
        return \UserSession::getUserEmail();
    }

    /**
     * Changes the user password from the HTTP parameters
     * @return boolean|array TRUE if the password has been changed successfully
     * else the error message and error variable returned by the password
     * validator
     */
    static public function changePassword() {
        $validator = new \validator\Password(FALSE);
        if ($validator->validate()) { // Password validation is OK
            $hashedPassword = \MainController::execute('Users', 'hashPassword',
                    $validator->getValue('login_password'));
            \UserManager::changeUserPassword($validator->getValue('login_name'),
                    $hashedPassword);
            return TRUE;
        } else {
            return [$validator->getErrorMessage(), $validator->getErrorVariable()];
        }
    }

    /**
     * Disables the user account for the specified user
     * @param string $loginName Login name of the user account to disable
     * @return boolean TRUE if user account has been disabled successfully
     */
    static public function disableUser($loginName) {
        \UserManager::disableUser($loginName);
            return TRUE;
    }

    /**
     * Indicates whether the user has the specified profile or not
     * @param string $profileName Profile name
     * @return boolean TRUE if user has the specified profile, otherwise FALSE
     */
    static public function hasProfile($profileName) {
        return \UserSession::hasUserProfile($profileName);
    }

    /**
     * Indicates whether the connected user has the specified menu item
     * @param string $menuItem The menu item
     * @return boolean TRUE if the user has access to the specified menu item
     */
    static public function hasMenuItem($menuItem) {
        \UserSession::isAuthenticated(); // HTTP error 401 if user's session has expired
        $loginName = \UserSession::getLoginName();
        if (is_null($loginName)) {
            return FALSE;
        } else {
            return \UserManager::hasUserMenuItem($loginName, $menuItem);
        }
    }
}
