<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2024 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL https://www.gnu.org/licenses/gpl-3.0.html GNU GPL
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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK User API module class
 *
 * File version: 1.0
 * Last update: 08/14/2024
 */

/**
 * ZnetDK User class to add, update and remove users.
 * This class can be useful for example to add a user after submitting a
 * registration form.
 * - User's password auto-generated on demand,
 * - User enabled by default and expiration date automatically calculated,
 * - User infos validation before storage (implicit or explicit),
 * - Profiles can be granted to user,
 * - Custom database selection if required,
 * - Database transaction cancelling supported.
 *
 * USE CASE 1: add a user with minimal infos with two granted profiles.
 * 1) $newUser = new \User();
 * 2) $newUser->login_name = 'john_doe';
 *    $newUser->user_name = 'John DOE';
 *    $newUser->user_email = 'johndoe@myemail.xyz';
 * 3) $userId = $newUser->add();
 * 4) $userPwd = $newUser->getPasswordInClear();
 * 5) $newUser->grantProfiles(['Guest', 'Invoices']);
 *
 * USE CASE 2: update user infos (email has changed)
 * 1) $user = new \User(43);
 * 2) $user->user_email = 'johndoe@mynewemail.xyz';
 * 3) $user->update();
 *
 * USE CASE 3: update user's profiles
 * 1) $user = new \User(43);
 * 2) $user->addProfile('Customers');
 * 3) $user->removeProfile('Invoices');
 *
 * USE CASE 4: change user's password (auto-generated)
 * 1) $user = new \User(43);
 * 2) $newPassword = $user->generateNewPassword();
 * 3) $user->user_enabled = 1; // if user were disabled
 * 4) $user->update();
 *
 * USE CASE 5: get user infos
 * 1) $user = new \User(43);
 * 2) $userName = $user->user_name;
 * 3) $userEmail = $user->user_email;
 * 4) $userProfiles = $user->getProfiles();
 *
 * USE CASE 6: remove existing user
 * 1) $user = new \User(43);
 * 2) $user->remove();
 */
class User {
    protected $mandatoryUserTableColumns = ['login_name', 'user_name',
        'user_email'];
    protected $optionalUserTableColumns = ['user_id', 'login_password',
        'expiration_date', 'user_phone', 'notes', 'full_menu_access', 'user_enabled'];
    protected $notStoredUserTableColumns = ['login_password2'];
    protected $databaseConnection = NULL;
    protected $userData = NULL;
    protected $grantedProfiles = NULL;
    protected $passwordInClear = NULL;
    protected $isUserNotified = TRUE;

    /**
     * Instantiates a user object.
     * @param int $id Database user ID.
     */
    public function __construct($id = NULL) {
        if (!is_null($id)) {
            $this->fetchData($id);
        } else {
            $this->userData = [];
        }
    }
    /**
     * Set a Custom database connection to manage user.
     * @param \PDO $databaseConnection Database connection obtained by calling
     * the \Database::getCustomDbConnection() method.
     */
    public function setCustomDatabaseConnexion($databaseConnection) {
        $this->databaseConnection = $databaseConnection;
    }
    /**
     * Fetches user data in database.
     * @param int $userId Database User ID.
     * @throws \ZDKException No user found for the specified user.
     */
    protected function fetchData($userId) {
        $allProperties = array_merge($this->mandatoryUserTableColumns,
                $this->optionalUserTableColumns);
        $usersDAO = new \model\Users($this->databaseConnection);
        $usersDAO->setSelectedColumns($allProperties);
        $userInfos = $usersDAO->getById($userId);
        if (is_array($userInfos)) {
            // hashed password is replaced by dummy password
            $userInfos['login_password'] = \General::getDummyPassword();
            // 'login_password2' added for validation purpose
            $userInfos['login_password2'] = $userInfos['login_password'];
            $this->userData = $userInfos;
        } else {
            throw new \ZDKException("URA-003: no user found for ID={$userId}.");
        }
    }
    /**
     * Checks if the user identifier is set.
     * @throws Exception User identifier is not set.
     */
    protected function checkIdSet() {
        if (!is_array($this->userData) || !key_exists('user_id', $this->userData)) {
            throw new \ZDKException('URA-004: user identifier is not set.');
        }
    }
    /**
     * Checks if the user login is set
     * @throws Exception The user login is not set.
     */
    protected function checkLoginNameSet() {
        if (!is_array($this->userData) || !key_exists('login_name', $this->userData)) {
            throw new \ZDKException('URA-005: user login name is not set.');
        }
    }
    /**
     * Checks if properties set for the user are properly named.
     * @param boolean $checkMandatory If TRUE, checks if mandatory properties
     * are set.
     * @throws \ZDKException User's data are invalid, a property is unknown and
     * a mandatory property is missing.
     */
    protected function checkProperties($checkMandatory = FALSE) {
        if (!is_array($this->userData) || count($this->userData) === 0) {
            throw new \ZDKException('URA-006: invalid user informations.');
        }
        foreach (array_keys($this->userData) as $property) {
            $this->checkProperty($property);
        }
        if ($checkMandatory) {
            foreach ($this->mandatoryUserTableColumns as $mandatoryCol) {
                if (!key_exists($mandatoryCol, $this->userData)) {
                    throw new \ZDKException("URA-007: mandatory column '{$mandatoryCol}' is missing.");
                }
            }
        }
    }
    /**
     * Checks if the specified property is a known user property.
     * @param string $property Name of the property to check.
     * @throws \ZDKException Unknown property.
     */
    protected function checkProperty($property) {
        $allProperties = array_merge($this->mandatoryUserTableColumns,
            $this->optionalUserTableColumns, $this->notStoredUserTableColumns);
        if (!in_array($property, $allProperties)) {
            throw new \ZDKException("URA-008: property '{$property}' is unknown.");
        }
    }
    /**
     * Transforms the login password to a hashed password.
     */
    protected function hashPassword() {
        $this->passwordInClear = $this->userData['login_password'];
        $this->login_password = \MainController::execute('Users', 'hashPassword',
            $this->login_password);
    }
    /**
     * Begins a SQL transaction.
     */
    protected function beginTransaction() {
        if ($this->databaseConnection === NULL) {
            \Database::beginTransaction();
        } else {
            $this->databaseConnection->beginTransaction();
        }
    }
    /**
     * Commits the SQL transaction
     */
    protected function commit() {
        if ($this->databaseConnection === NULL) {
            \Database::commit();
        } else {
            $this->databaseConnection->commit();
        }
    }
    /**
     * Sets the expiration date of the user's password.
     * This date is calculated from the CFG_DEFAULT_PWD_VALIDITY_PERIOD constant
     * value set for the application
     */
    public function setExpirationDate() {
        $dateTime = new \DateTime('now');
        $dateTime->add(new \DateInterval('P' . CFG_DEFAULT_PWD_VALIDITY_PERIOD . 'M'));
        if (!is_array($this->userData)) {
            $this->userData = [];
        }
        $this->userData['expiration_date'] = \Convert::toW3CDate($dateTime);
    }
    /**
     * Validates user data.
     * @param boolean $throwException If TRUE, an exception is triggered if
     * validation failed.
     * @return TRUE|array TRUE if validation has succeeded otherwise
     * informations about failed validation (keys are 'message' and 'property').
     * @throws ZDKException No data to validate. Validation error if 
     * $throwException is TRUE.
     */
    public function validate($throwException = FALSE) {
        if (!is_array($this->userData)) {
            throw new \Exception('URA-015: no data to validate.');
        }
        $validator = new \validator\User();
        $validator->setValues($this->userData);
        if (!$validator->validate()) {
            $property = $validator->getErrorVariable();
            $error = $validator->getErrorMessage();
            if ($throwException) {
                throw new \ZDKException("URA-009: [{$property}] {$error}");
            }
            return ['message' => $error, 'property' => $property];
        }
        return TRUE;
    }
    /**
     * Stores user informations
     * @param boolean $autocommit If FALSE, user is stored within the database
     * transaction started before calling this method.
     * @return int User identifier
     */
    protected function store($autocommit) {
        // Password 2 is removed for it is not stored.
        unset($this->userData['login_password2']);
        // Storage
        $userDAO = new \model\Users($this->databaseConnection);
        $this->userData['user_id'] = $userDAO->store($this->userData, $autocommit);
        return $this->userData['user_id'];
    }

    /**
     * Notify user when added or when their password has changed.
     * @param boolean $isNewUser TRUE if a new user has been created.
     */
    public function notify($isNewUser) {
        \MainController::executeAll('Users', 'notify', $isNewUser,
                $this->passwordInClear,
                $this->userData);
    }
    /**
     * Disables user notification when user is added or when their password
     * has been changed.
     */
    public function disableNotification() {
        $this->isUserNotified = FALSE;
    }
    /**
     * Generates a unique login name from the specified string
     * @param string $string String used to generate a new login name.
     * @return string The new login name with only alphabetic characters in 
     * lower case. Whitespaces are replaced by '_'.
     * The minimum length of the new login name is 8 characters (padded on the 
     * right with '0' characters) and the maximum length is 20 characters.
     * If the same login name already exists, a number from 1 is added as 
     * suffix on the right.
     */
    public function generateLoginName($string) {
        $minLength = 8;
        $maxLength = 20;
        $minLoginName = '';
        $withoutAccents = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        for ($i = 0; $i < strlen($withoutAccents); $i++) {
            if (ctype_alpha($withoutAccents[$i])) {
                 $minLoginName .= $withoutAccents[$i];
            } elseif ($withoutAccents[$i] === ' ') {
                $minLoginName .= '_';
            }  
        }
        $newLoginName = strtolower(substr(
            str_pad($minLoginName, $minLength, '0', STR_PAD_RIGHT), 0, $maxLength));
        $baseLoginLen = strlen($newLoginName);
        $suffix = 1;
        $usersDAO = new \model\Users($this->databaseConnection);
        $usersDAO->setFilterCriteria($newLoginName);
        
        while ($existingUser = $usersDAO->getResult()) {
            $maxLoginLen = $maxLength - strlen(strval($suffix));
            $newLoginName = substr($newLoginName, 0, min($maxLoginLen, $baseLoginLen))
                    . strval($suffix); 
            $usersDAO->setFilterCriteria($newLoginName);
            $suffix++;
        }
        return $newLoginName;
    }
    /**
     * Adds a new user.
     * - Mandatory properties: 'login_name', 'user_name', 'user_email'
     * - Optional properties: 'login_password', 'expiration_date', 'user_phone',
     *  'notes', 'full_menu_access', 'user_enabled'
     * - if 'login_password' is not set: it is automatically generated.
     * - if 'expiration_date' is not set: its default value is today.
     * - if 'user_enabled' is not set: it is enabled by default.
     * @param Boolean $autocommit If FALSE, user is stored within the database
     * transaction started before calling this method.
     * @return int New internal identifier assigned to the user.
     */
    public function add($autocommit = TRUE) {
        $this->checkProperties(TRUE);
        if (!key_exists('login_password', $this->userData)) {
            $this->generateNewPassword();
        }
        if (!key_exists('expiration_date', $this->userData)) {
            $dateTime = new \DateTime('now');
            $this->userData['expiration_date'] = \Convert::toW3CDate($dateTime);
        }
        if (!key_exists('user_enabled', $this->userData)) {
            $this->userData['user_enabled'] = 1;
        }
        if (!key_exists('full_menu_access', $this->userData)) {
            $this->userData['full_menu_access'] = 0;
        }
        $this->validate(TRUE);
        // Password is hashed
        $this->HashPassword();
        // Storage
        $this->store($autocommit);
        // User notification
        if ($this->isUserNotified) {
            $this->notify(TRUE);
        }
        // User ID returned
        return $this->userData['user_id'];
    }
    /**
     * Updates user information.
     * @param boolean $autocommit If FALSE, user is stored within the database
     * transaction started before calling this method.
     * @return int Internal identifier of the updated user.
     */
    public function update($autocommit = TRUE) {
        $this->checkIdSet();
        $this->checkProperties();
        $this->validate(TRUE);
        $hasPasswordChanged = FALSE;
        if ($this->login_password === \General::getDummyPassword()) {
            // Password is not saved as it is unchanged
            unset($this->userData['login_password']);
        } else {
            // Password has changed so it is hashed before storage
            $this->hashPassword();
            $hasPasswordChanged = TRUE;
        }
        $this->store($autocommit);
        if ($this->isUserNotified && $hasPasswordChanged) {
            // User notification
            $this->notify(FALSE);
        }
        // User ID returned
        return $this->userData['user_id'];
    }
    /**
     * Removes the user.
     * The controller\Users::onRemove() hook methods are called if exist in the
     * application and in the modules in order to remove custom user's data. 
     * If profiles are granted to user, they are removed before the user.
     * @param boolean $autocommit If FALSE, user is removed within the database
     * transaction started before calling this method.
     */
    public function remove($autocommit = TRUE) {
        $this->checkIdSet();
        $userProfiles = $this->getProfiles();
        if ($autocommit) {
            $this->beginTransaction();
        }
        // Removal hooks are called to remove custom user data
        MainController::executeAll('Users', 'onRemove', $this->userData['user_id']);
        // Granted profiles are removed
        foreach ($userProfiles as $profile) {
            $this->removeProfile($profile, FALSE);
        }
        // User is finally removed
        $userDAO = new \model\Users($this->databaseConnection);
        $userDAO->remove($this->userData['user_id'], FALSE);
        if ($autocommit) {
            $this->commit();
        }
    }
    /**
     * Returns the value of the specified property.
     * @param string $property The property name
     * @return mixed The value of the specified property
     */
    public function __get($property) {
        $this->checkProperty($property);
        if (!is_array($this->userData) || !key_exists($property, $this->userData)) {
            throw new \ZDKException('URA-010: requested value is missing.');
        }
        return $this->userData[$property];
    }
    /**
     * Sets a value for the specified property.
     * @param string $property Property name (for example 'user_email').
     * @param mixed $value The value to set to the property
     */
    public function __set($property, $value) {
        $this->checkProperty($property);
        $this->userData[$property] = $value;
        // If password has changed, its value is duplicated
        // in the 'login_password2' property.
        if ($property === 'login_password') {
            $this->userData['login_password2'] = $value;
        }
    }
    /**
     * Returns the password in clear.
     * @return string|NULL The password or NULL if no password has been hashed.
     */
    public function getPasswordInClear() {
        return $this->passwordInClear;
    }
    /**
     * Generates a new password for the user.
     * @return string The auto generated password in clear.
     */
    public function generateNewPassword() {
        $generatedPwd = \controller\Users::getAutoGeneratedPassword(20);
        $pwdParts = str_split($generatedPwd, 2);
        $passwordInClear = '';
        foreach ($pwdParts as $key => $part) {
            $decVal = hexdec($part);
            $baseAscii = $key%9 === 0 ? 65 : 97;
            if ($key%10 === 0) {
                $passwordInClear .= strval($decVal%10);
            } else {
                $passwordInClear .= chr($baseAscii + $decVal%24);
            }
        }
        $this->login_password = $passwordInClear;
        $this->passwordInClear = $passwordInClear;
        return $passwordInClear;
    }
    /**
     * Grants the specified profiles to user.
     * @param Array $profiles The profiles to grant.
     * @param Boolean $autocommit If FALSE, profiles are stored within the
     *  database transaction started before calling this method.
     * @throws \ZDKException specified profiles are invalid.
     */
    public function grantProfiles($profiles, $autocommit = TRUE) {
        if (!is_array($profiles) || count($profiles) === 0) {
            throw new \ZDKException('URA-011: invalid user profiles.');
        }
        if ($autocommit) {
            $this->beginTransaction();
        }
        foreach ($profiles as $profileName) {
            $this->addProfile($profileName, FALSE);
        }
        if ($autocommit) {
            $this->commit();
        }
        $this->grantedProfiles = $profiles;
    }
    /**
     * Grants the specified profile to user.
     * @param string $profileName Name of the profile to grant
     * @param boolean $autocommit If FALSE, the statement is executed within the
     *  database transaction started before calling this method.
     * @throws \Exception Unknown profile, profile already granted and PDO
     * exception.
     */
    public function addProfile($profileName, $autocommit = TRUE) {
        $this->checkIdSet();
        $profilesDAO = new \model\Profiles($this->databaseConnection);
        $profilesDAO->setFilterCriteria($profileName);
        $profile = $profilesDAO->getResult();
        if ($profile === FALSE) {
            throw new \ZDKException("URA-012: profile {$profileName} is unknown.");
        }
        if ($this->hasProfile($profileName)) {
            throw new \ZDKException("URA-013: profile {$profileName} already granted to user.");
        }
        $userProfilesDAO = new \model\UserProfiles($this->databaseConnection);
        $userProfilesDAO->store(['user_id' => $this->userData['user_id'],
            'profile_id' => $profile['profile_id']], $autocommit);
    }
    /**
     * Remove the specified granted profile name to the user.
     * @param string $profileName Profile name.
     * @param boolean $autocommit If FALSE, the statement is executed within the
     *  database transaction started before calling this method.
     */
    public function removeProfile($profileName, $autocommit = TRUE) {
        $this->checkLoginNameSet();
        $userProfilesDAO = new \model\UserProfiles($this->databaseConnection);
        $userProfilesDAO->setLoginNameAndProfileNameAsFilters($this->login_name,
            $profileName);
        $userProfileFound = $userProfilesDAO->getResult();
        if ($userProfileFound === FALSE) {
            throw new \ZDKException("URA-014: profile {$profileName} is not granted to the user.");
        }
        $userProfilesDAO->remove($userProfileFound['user_profile_id'], $autocommit);
    }
    /**
     * Get the granted profiles to user.
     * @return array The profiles granted to user.
     */
    public function getProfiles() {
        $this->checkIdSet();
        $userProfilesDAO = new \model\UserProfiles($this->databaseConnection);
        $userProfilesDAO->setFilterCriteria($this->userData['user_id']);
        $userProfilesDAO->setSortCriteria('profile_name');
        $profiles = [];
        while ($profileRow = $userProfilesDAO->getResult()) {
            $profiles[] = $profileRow['profile_name'];
        }
        return $profiles;
    }
    /**
     * Checks whether the specified profile is granted or not to user.
     * @param string $profileName Name of the profile to check.
     * @return boolean TRUE if user has the specified profile, FALSE otherwise.
     */
    public function hasProfile($profileName) {
        $this->checkLoginNameSet();
        $userProfilesDAO = new \model\UserProfiles($this->databaseConnection);
        $userProfilesDAO->setLoginNameAndProfileNameAsFilters($this->login_name,
                $profileName);
        return $userProfilesDAO->getResult() !== FALSE ? TRUE : FALSE;
    }
}
