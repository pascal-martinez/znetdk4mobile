<?php
/*
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
 * Core User Management API
 *
 * File version: 1.11
 * Last update: 06/05/2024
 */

/**
 * ZnetDK core user management API
 */
class UserManager {

    /**
     * Returns all the declared users for using the application
     * @param int $first The first rows to select
     * @param int $rows The number of rows to select
     * @param string $searchCriteria The search criteria for selecting users
     * @param string $sortCriteria Sorting criteria of the user list
     * @param array $users The array of users to fill in by the method
     * @return int The number of users returned in the $users array
     */
    static public function getSearchedUsers($first, $rows, $searchCriteria, $sortCriteria, &$users) {
        $usersDAO = new \model\Users();
        $usersDAO->excludeAutoexecUser();
        $userIds = [];
        if ($searchCriteria !== FALSE) {
            $usersDAO->setSearchCriteriaAsFilter($searchCriteria);
        }
        $usersDAO->setSortCriteria($sortCriteria);
        try {
            $total = $usersDAO->getCount();
            if (!is_null($first) && !is_null($rows)) {
                $usersDAO->setLimit($first, $rows);
            }
            while ($userRow = $usersDAO->getResult()) {
                self::addExtraInfosForEditing($userRow, FALSE);
                $users[] = $userRow;
                $userIds[] = $userRow['user_id'];
            }
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-001: unable to request the user list", $e, TRUE);
        }
        self::addProfilesToSearchedUsers($userIds, $users);
        return $total;
    }

    /**
     * For each user found by the getSearchedUsers() method, adds the list of
     * user's profiles (only one SQL query is executed)
     * @param array $userIds Internal identifiers of the users to which user's
     * profiles are added.
     * @param array $users The list of users to complete with user's profiles
     */
    static private function addProfilesToSearchedUsers($userIds, &$users) {
        // Get the profiles for all_users
        $userProfilesDAO = new \model\UserProfiles();
        $userProfilesDAO->setUsersAsFilter($userIds);
        $userProfilesDAO->setSortCriteria('user_id, profile_name');
        $allUserProfiles = [];
        try {
            while ($profileRow = $userProfilesDAO->getResult()) {
                $allUserProfiles[$profileRow['user_id']][] = $profileRow;
            }
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-023: unable to get the profiles for the multiple users", $e, TRUE);
        }
        foreach ($users as $key => $user) {
            $users[$key]['has_profiles'] = '0';
            $profileNames = []; $profileIDs = [];
            $userProfiles = key_exists($user['user_id'], $allUserProfiles) ? $allUserProfiles[$user['user_id']] : [];
            foreach ($userProfiles as $userProfile) {
                $profileNames[] = $userProfile['profile_name'];
                $profileIDs[] = $userProfile['profile_id'];
            }
            if (count($profileIDs) > 0) {
                $users[$key]['user_profiles'] = implode(', ', $profileNames);
                $users[$key]['profiles[]'] = $profileIDs;
                $users[$key]['has_profiles'] = '1';
            }
        }
    }

    /**
     * Adds to the user stored data the extra informations for editing in a web
     * browser data form.
     * The extra informations are the user's profile identifiers, an indicator
     * of existing profiles for the user, an indicator of account expiration.
     * Finally for security purpose, the password returned is a dummy password.
     * @param array $userRow The user informations stored in database that are
     * to be filled out
     * @param boolean $withProfiles When set to TRUE, profile infos are also
     * added as extra infos.
     */
    static private function addExtraInfosForEditing(&$userRow, $withProfiles = TRUE) {
        if ($withProfiles) {
            $profiles = array();
            $profileIDs = array();
            self::getUserProfiles($userRow['user_id'], $profiles, $profileIDs);
            $userRow['has_profiles'] = '0';
            if (count($profileIDs)) {
                $userRow['user_profiles'] = $profiles;
                $userRow['profiles[]'] = $profileIDs;
                $userRow['has_profiles'] = '1';
            }
        }
        $userRow['has_expired'] = $userRow['expiration_date']
                <= General::getCurrentW3CDate() ? '1' : '0';
        // Original password is not provided, a dummy value is returned instead
        $userRow['login_password'] = \General::getDummyPassword();
        $userRow['login_password2'] = \General::getDummyPassword();
    }

    /**
     * Returns the list of all the users declared in the application
     * @param string $sortCriteria Sorting criteria of the user list
     * @param array $users The array of users to fill in by the method
     * @return int The number of users returned in the $users array
     */
    static public function getAllUsers($sortCriteria, &$users) {
        return self::getSearchedUsers(NULL, NULL, FALSE, $sortCriteria, $users);
    }

    /**
     * Returns the user information stored in the database from his login name.
     * @param string $loginName User's login name
     * @return array User information
     */
    static public function getUserInfos($loginName) {
        $usersDAO = new \model\Users();
        $usersDAO->setFilterCriteria($loginName);
        try {
            return $usersDAO->getResult();
        } catch (\Exception $e) {
            $response = new \Response(FALSE);
            $response->setCriticalMessage(
                    "USR-002: unable to query the user information", $e,TRUE);
        }
    }

    /**
     * Returns the user information stored in the database from the user ID.
     * @param string $userId User identifier
     * @param boolean $forEditing When set to TRUE, extra informations for
     * editing purpose are added to the returned informations of the user
     * @return array User's informations
     */
    static public function getUserInfosById($userId, $forEditing = FALSE) {
        $usersDAO = new \model\Users();
        try {
            $userInfos = $usersDAO->getById($userId);
            if ($userInfos !== FALSE && $forEditing === TRUE) {
                self::addExtraInfosForEditing($userInfos);
            }
            return $userInfos;
        } catch (\Exception $e) {
            $response = new \Response();
            $response->setCriticalMessage(
                    "USR-018: unable to query the user informations by ID", $e,TRUE);
        }
    }

    /**
     * Returns the user information stored in the database from her or his name.
     * @param string $userName Name of the user
     * @return array User information
     */
    static public function getUserInfosByName($userName) {
        $usersDAO = new \model\Users();
        $usersDAO->setNameAsFilter($userName);
        try {
            return $usersDAO->getResult();
        } catch (\Exception $e) {
            $response = new \Response();
            $response->setCriticalMessage(
                    "USR-019: unable to query the user informations by name", $e,TRUE);
        }
    }

    /**
     * Returns the profiles granted to the specified user
     * @param string $userId Internal identifier of the user
     * @param string $profileNamesAsList List of the profile names in string
     * format, each profile name sepated by a comma (ie ", ").
     * @param array $profileIDs Profile Identifiers
     */
    static public function getUserProfiles($userId, &$profileNamesAsList, &$profileIDs) {
        $userProfilesDAO = new \model\UserProfiles();
        $userProfilesDAO->setFilterCriteria($userId);
        $userProfilesDAO->setSortCriteria('profile_name');
        $profiles = self::getUserProfilesAsArray($userId);
        if (count($profiles) > 0) {
            $profileIDs = array_keys($profiles);
            $profileNamesAsList = implode(', ', array_values($profiles));
        }
    }

    /**
     * Returns the profiles granted to the specified user
     * @param string $userId Internal identifier of the user
     * @return Array User profiles of the specified user, the array's keys are
     * the profile identifiers, the array's values are the corresponding profile
     * names.
     */
    static public function getUserProfilesAsArray($userId) {
        $userProfilesDAO = new \model\UserProfiles();
        $userProfilesDAO->setFilterCriteria($userId);
        $userProfilesDAO->setSortCriteria('profile_name');
        $profiles = [];
        try {
            while ($profileRow = $userProfilesDAO->getResult()) {
                $profiles[$profileRow['profile_id']] = $profileRow['profile_name'];
            }
            return $profiles;
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-003: unable to get the profiles for the user ID={$userId}", $e, TRUE);
        }
    }

    /**
     * Stores in database the user informations
     * @param array $userRow User informations to store in database as an indexed
     * array. If the 'user_id' key is set, the user is updated. Otherwise the user
     * is inserted.
     * @param array $userProfiles User profiles granted to the user
     * @return int The stored user identifier.
     */
    static public function storeUser($userRow, $userProfiles) {
        $userDAO = new \model\Users();
        $userDAO->beginTransaction();
        try { // First Insert user row
            $userID = $userDAO->store($userRow, FALSE);
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-004: unable to store the user", $e, TRUE);
        }
        // Next Insert/Update user profiles
        // --> Existing profiles for the user are removed first
        self::removeUserProfiles($userID);
        if (isset($userProfiles) && is_array($userProfiles)) {
        // --> Insert profiles for the user
            self::addProfilesToUser($userID, $userProfiles);
        }
        $userDAO->commit();
        return $userID;
    }

    /**
     * Removes the profiles granted to the specified user.
     * No commit is performed by the method.
     * @param string $userID User ID to remove in database
     */
    static private function removeUserProfiles($userID) {
        $userProfilesDAO = new \model\UserProfiles();
        $userProfilesDAO->setFilterCriteria($userID);
        try {
            $userProfilesDAO->remove(NULL, FALSE);
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-005: unable to remove the profiles for the user ID '$userID'", $e, TRUE);
        }
    }

    /**
     * Adds the specified profiles to the user indicated as input parameter
     * @param string $userID User identifier in database
     * @param array $userProfiles User profiles to grant to the user
     */
    static private function addProfilesToUser($userID, $userProfiles) {
        $userProfilesDAO = new \model\UserProfiles();
        try {
            foreach ($userProfiles as $value) {
                $userProfileRow = array('user_id' => $userID, 'profile_id' => $value);
                $userProfilesDAO->store($userProfileRow, FALSE);
            }
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-006: unable to add profiles to the user ID '$userID'", $e, TRUE);
        }
    }

    /**
     * Removes the specified user in the database
     * @param string $userID User identifier in database
     */
    static public function removeUser($userID) {
        try {
            $userDAO = new \model\Users();
            $userDAO->beginTransaction();
            // Removal hooks are called to remove custom user data
            MainController::executeAll('Users', 'onRemove', $userID);
            // Next existing user's profiles are removed
            self::removeUserProfiles($userID);
            //Finally, the user is removed
            $userDAO->remove($userID, FALSE);
        } catch (\Exception $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-007: unable to remove the user with user ID '$userID'", $e, TRUE);
        }
        //Changes are commited
        $userDAO->commit();
    }

    /**
     * Return the user name of the specified user
     * @param string $loginName User login name
     * @return string The user name or NULL if the user name can't be queried.
     */
    static public function getUserName($loginName) {
        $userDAO = new \model\Users();
        $userDAO->setFilterCriteria($loginName);
        try {
            $userRow = $userDAO->getResult();
            $userName = $userRow['user_name'];
        } catch (\PDOException $e) {
            \General::writeErrorLog("ZNETDK ERROR", "USR-008: unable to query the user name for the login name '$loginName'! (".
                    $e->getCode().")", TRUE);
            $userName = NULL;
        }
        return $userName;
    }

    /**
     * Returns the email address of the specified user
     * @param string $loginName User login name
     * @return string The user email or NULL if the user email can't be queried.
     */
    static public function getUserEmail($loginName) {
        $userDAO = new \model\Users();
        $userDAO->setFilterCriteria($loginName);
        try {
            $userRow = $userDAO->getResult();
            $userEmail = $userRow['user_email'];
        } catch (\PDOException $e) {
            \General::writeErrorLog("ZNETDK ERROR", "USR-009: unable to query the user email for the login name '$loginName'! (".
                    $e->getCode().")", TRUE);
            $userEmail = NULL;
        }
        return $userEmail;
    }

    /**
     * Changes the password for the specified user
     * @param string $credential User login name or email address
     * @param string $newPassword New user password to store
     * @param boolean $isTemporary If set to TRUE, the expiration date is set to
     * today to force user to change the temporary password and the user is
     * enabled if she or he was disabled.
     * @return Boolean TRUE on success, FALSE if no user exists for the
     * specified credential.
     */
    static public function changeUserPassword($credential, $newPassword, $isTemporary = FALSE) {
        $userRow = self::getUserInfosByCredential($credential);
        if (!is_array($userRow)) {
            return FALSE;
        }
        $user['user_id'] = $userRow['user_id'];
        $user['login_password'] = $newPassword;
        $user['expiration_date'] = $isTemporary
                ? \General::getCurrentW3CDate() : self::getUserExpirationDate();
        if ($isTemporary) {
            $user['user_enabled'] = 1;
        }
        $userDAO = new \model\Users();
        try {
            $userDAO->store($user);
            return TRUE;
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-010: unable to change the user password for the login name '{$credential}'", $e, TRUE);
        }
    }

    /**
     * Returns the calculated date when user account will expire. This date is
     * evaluated from the current date and the number of months configured for
     * the parameter CFG_DEFAULT_PWD_VALIDITY_PERIOD.
     * @return DateTime Expiration date of the user account in W3C format
     */
    static private function getUserExpirationDate() {
        $expiration_date = new \DateTime('now');
        $expiration_date->add(new \DateInterval('P' . CFG_DEFAULT_PWD_VALIDITY_PERIOD . 'M'));
        return $expiration_date->format('Y-m-d');
    }

    /**
     * Disables the specified user
     * @param string $loginName User's login name
     */
    static public function disableUser($loginName) {
        $userDAO = new \model\Users();
        $userDAO->setFilterCriteria($loginName);
        try {
            $userRow = $userDAO->getResult();
            $user['user_id'] = $userRow['user_id'];
            $user['user_enabled'] = 0;
            $user['expiration_date'] = \General::getCurrentW3CDate();
            $userDAO->store($user);
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-011: unable to disable the user account for the login name '$loginName'", $e, TRUE);
        }
    }

    /**
     * Indicates whether the specified user has a full access to the navigation
     * menu.
     * @param string $loginName User's login name
     * @return boolean TRUE if the user has a full access to the navigation menu,
     *  otherwise FALSE
     */
    static public function hasUserFullMenuAccess($loginName) {
        if ($loginName === UserSession::getLoginName()) {
            return UserSession::hasFullMenuAccess();
        }
        $userDAO = new \model\Users();
        $userDAO->setFilterCriteria($loginName);
        try {
            $userRow = $userDAO->getResult();
        } catch (\PDOException $e) {
            \General::writeErrorLog("ZNETDK ERROR", "USR-012: unable to query the full menu access status for the login name '$loginName'! (".
                    $e->getCode().")", TRUE);
            return FALSE;
        }
        return $userRow['full_menu_access'] == TRUE;
    }

    /**
     * Indicates whether the specified user has the specified profile
     * @param string $loginName User's login name
     * @param string $profileName Profile name
     * @return boolean TRUE if the user has the specified profile, otherwise FALSE
     */
    static public function hasUserProfile($loginName, $profileName) {
        if (!isset($loginName) || !isset($profileName)) {
            return FALSE;
        }
        $userProfilesDAO = new \model\UserProfiles();
        $userProfilesDAO->setLoginNameAndProfileNameAsFilters($loginName, $profileName);
        try {
            return $userProfilesDAO->getResult() !== FALSE ? TRUE : FALSE;
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-013: unable to query the user's profile '$profileName' for the login name '$loginName'", $e, TRUE);
        }
    }

    /**
     * Returns the menu items granted to the specified user
     * @param string $loginName User's login name
     * @return array Menu items granted to the user
     */
    static public function getGrantedMenuItemsToUser($loginName) {
        $userMenuObj = new \model\UserMenus();
        $userMenuObj->setFilterCriteria($loginName);
        $allowedMenuItems = array();
        try {
            while ($row = $userMenuObj->getResult()) {
                $allowedMenuItems[] = $row['menu_id'];
            }
        } catch (\PDOException $e) {
            \General::writeErrorLog("ZNETDK ERROR", "USR-014: unable to query the granted menu items for the login name '$loginName'! (".
                    $e->getCode().")", TRUE);
        }
        return $allowedMenuItems;
    }

    /**
     * Returns the identifier of the user found from his email address
     * @param string $email Email address of the user to find
     * @return int Row identifier of the user found from his email address,
     * otherwise NULL
     */
    static public function getUserIdByEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return NULL;
        }
        $usersDAO = new \model\Users();
        $usersDAO->setEmailAsFilter($email);
        try {
            $userRow = $usersDAO->getResult();
            $userID = $userRow === FALSE ? NULL : $userRow['user_id'];
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-015: unable to query a user from his email '$email'", $e, TRUE);
        }
        return $userID;
    }

    /**
     * Returns a user's information stored in the database from their email.
     * @param string $email Email address of the user to find out
     * @return array User's information or FALSE if user does not exist or
     * if their login name is 'autoexec'.
     */
    static public function getUserInfosByEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        }
        $usersDAO = new \model\Users();
        $usersDAO->setEmailAsFilter($email);
        try {
            $userInfos = $usersDAO->getResult();
        } catch (\Exception $e) {
            $response = new \Response();
            $response->setCriticalMessage(
                    "USR-020: unable to query user's information by email", $e,TRUE);
        }
        return $userInfos === FALSE ? FALSE
            : (\AutoExec::getLoginName() === $userInfos['login_name'] ? FALSE
                : $userInfos);
    }

    /**
     * Returns user's information stored in the database from their login name
     * or email address.
     * @param string $credential Login name or Email address
     * @return array User's information or FALSE if user does not exist or
     * if their login name is 'autoexec'.
     */
    static public function getUserInfosByCredential($credential) {
        $user = self::getUserInfosByEmail($credential);
        return $user === FALSE ? self::getUserInfos($credential) : $user;
    }

    /**
     * Returns the users matching the specified profile name
     * @param string $profileName Name of the profile assigned to the users who
     * are searched
     * @param string $sortCriteria Sort criteria of the users returned (for
     * example 'expiration_date DESC, user_name ASC')
     * @param boolean $includeArchived When set to FALSE, archived users are
     * excluded from the returned array.
     * @return array A table of users found or an empty table if no users were
     * found
     */
    static public function getUsersHavingProfile($profileName, $sortCriteria = NULL, $includeArchived = TRUE) {
        $users = array();
        $profile = ProfileManager::getProfileInfos($profileName);
        if ($profile === FALSE) {
            return $users;
        }
        $userProfilesDAO = new \model\UserProfiles();
        $userProfilesDAO->setProfileIdAsFilter($profile['profile_id'], $includeArchived);
        if (!is_null($sortCriteria)) {
            $userProfilesDAO->setSortCriteria($sortCriteria);
        }
        try {
            while ($row = $userProfilesDAO->getResult()) {
                $users[] = $row;
            }
            return $users;
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-016: unable to query the users matching the '$profileName' profile!", $e, TRUE);
        }
    }

    /**
     * Checks whether a user has access to the specified menu item
     * @param string $loginName A user's login name
     * @param string $menuItem The identifier of the menu item
     * @return boolean TRUE if the user has access to the specified menu item.
     * FALSE otherwise
     */
    static public function hasUserMenuItem($loginName, $menuItem) {
        $hasFullMenuAccess = self::hasUserFullMenuAccess($loginName);
        if ($hasFullMenuAccess && MenuManager::getMenuItem($menuItem) !== NULL) {
            return TRUE;
        }
        $userMenuObj = new \model\UserMenus();
        $userMenuObj->setLoginNameAndMenuItemAsFilter($loginName, $menuItem);
        try {
            return $userMenuObj->getResult() !== FALSE;
        } catch (\PDOException $e) {
            \General::writeErrorLog("ZNETDK ERROR", "USR-017: unable to request the menu item '$menuItem' for the login name '$loginName'! (".
                    $e->getCode().")", TRUE);
        }
    }

    /**
     * Returns the suggestions of user name, login name and profile name found
     * for the specified keyword in parameter.
     * @param string $keyword The keyword for getting suggestions
     * @return array The array of maximum 10 values found. Each array entry is
     * an indexed array with only one key named 'label' and containing the
     * suggestion found.
     */
    static public function getFoundKeywords($keyword) {
        $usersDAO = new model\UserSuggestions();
        $usersDAO->setKeywordAsFilter($keyword);
        $usersDAO->setLimit(0, 10);
        $suggestions = array();
        try {
            while($row = $usersDAO->getResult()) {
                $suggestions[] = array('label'=>$row['suggestion']);
            }
            return $suggestions;
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-018: unable to request the suggestions of users", $e, TRUE);
        }
    }

    /**
     * Returns a reset password confirmation URL for the specified email address.
     * First check if a previous request already exists in database. If so, 10
     * minutes must be elapsed before sending a new confirmation URL.
     * @return string The URL to send to user matching the specified
     */
    static public function getResetPasswordConfirmationUrl($email) {
        self::checkEmailForPasswordReset($email);
        $dao = new SimpleDAO('zdk_user_pwd_resets');
        $rows = $dao->getRowsForCondition('email = ?', $email);
        if (count($rows) > 0) {
            $requestDateTime = new \DateTime($rows[0]['request_date_time']);
            $requestDateTime->add(new \DateInterval('PT10M'));
            $nowDateTime = new \DateTime();
            if ($nowDateTime < $requestDateTime) {
                throw new Exception('A request already exists, wait and try again', 200);
            }
        }
        try {
            $resetKey = \MainController::execute('Users', 'getAutoGeneratedPassword', 16);
        } catch (\Exception $ex) {
            throw new Exception('Unable to generate confirmation key', 201, $ex);
        }
        $dao->beginTransaction();
        self::removeResetPasswordKey($email, FALSE);
        try {
            $dao->store(['email' => $email,
                'request_date_time' => General::getCurrentW3CDate(TRUE),
                'reset_key' => $resetKey
                ], FALSE);
            $dao->commit();
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-021: unable to insert row for email='{$email}'", $e, TRUE);
        }
        $appUrlWithCtrl = General::addGetParameterToURI(General::getApplicationURI(), 'control', 'resetpwd');
        $appUrlWithCtrlEmail = General::addGetParameterToURI($appUrlWithCtrl, 'email', rawurlencode($email));
        return General::addGetParameterToURI($appUrlWithCtrlEmail, 'key', $resetKey);
    }

    /**
     * Removes the reset password key in database for the specified email address
     * @param string $email Email address
     * @param boolean $autocommit Specifies if the SQL transaction is
     *  automatically commited
     */
    static private function removeResetPasswordKey($email, $autocommit = TRUE) {
        $dao = new SimpleDAO('zdk_user_pwd_resets');
        $dao->getRowsForCondition('email = ?', $email);
        try {
            $dao->remove(NULL, $autocommit);
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("USR-022: unable to remove row for email='{$email}'", $e, TRUE);
        }
    }

    /**
     * Changes the user's password to an auto-generated password and its
     * expiration date to today.
     * This method is usually called when a user has forgotten their password
     * @param string $email User's email address
     * @param string $key Password reset key that authorizes password reset
     * @throws Exception Password reset has failed
     */
    static public function resetPassword($email, $key) {
        $userInfos = self::checkEmailForPasswordReset($email);
        if (!self::isResetPasswordKeyValid($email, $key)) {
            throw new \Exception('Password reset key is invalid', 300);
        }
        $newTemporaryPwd = \MainController::execute('Users', 'getAutoGeneratedPassword');
        if (empty($newTemporaryPwd)) {
            throw new \Exception('Error on password generation!', 301);
        }
        $hashedPassword = \MainController::execute('Users', 'hashPassword', $newTemporaryPwd);
        if (empty($hashedPassword)) {
            throw new \Exception('Error on password hashing!', 302);
        }
        self::changeUserPassword($userInfos['login_name'], $hashedPassword, TRUE);
        self::removeResetPasswordKey($email);
        return $newTemporaryPwd;
    }

    /**
     * Check if password reset is allowed.
     * @param string $email Email address
     * @return array User informations
     * @throws \Exception Password reset disabled (100), unknown email address (
     * 101) or email address not authorized (102).
     */
    static private function checkEmailForPasswordReset($email) {
        if (CFG_FORGOT_PASSWORD_ENABLED == FALSE) {
            throw new \Exception('Password reset not allowed', 100);
        }
        $userInfos = \UserManager::getUserInfosByEmail($email);
        if ($userInfos === FALSE) {
            throw new \Exception('Unknown email address!', 101);
        }
        if (\AutoExec::getLoginName() === $userInfos['login_name']
                || $userInfos['user_enabled'] === '-1') {
            throw new \Exception('Password reset not allowed for this email address', 102);
        }
        return $userInfos;
    }

    /**
     * Checks if a password request exists for the specified email, if the
     * specified key is valid and has not expired (only valid for 1 hour max.)
     * @param string $email email address
     * @param string $key Reset password confirmation key
     * @return boolean True if reset password key is valid and has not expired
     */
    static private function isResetPasswordKeyValid($email, $key) {
        $dao = new SimpleDAO('zdk_user_pwd_resets');
        $rows = $dao->getRowsForCondition('email = ?', $email);
        if (count($rows) === 0 || $rows[0]['reset_key'] !== $key) {
            return FALSE;
        }
        $requestDateTime = new \DateTime($rows[0]['request_date_time']);
        $requestDateTime->add(new \DateInterval('PT1H'));
        $nowDateTime = new \DateTime();
        return $nowDateTime < $requestDateTime;
    }

}
