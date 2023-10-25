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
 * Core DAO : profiles granted to a user 
 *
 * File version: 1.4
 * Last update: 05/19/2023
 */

namespace model;

/**
 * Database access to the profiles assigned to a configured user
 */
class UserProfiles extends \DAO {

    protected function initDaoProperties() {
        $this->useCoreDbConnection();
        $this->table = "zdk_user_profiles";
        $this->IdColumnName = "user_profile_id";
        $this->query = "select zdk_user_profiles.*, zdk_profiles.profile_name, "
            . "zdk_users.user_name, zdk_users.login_name, zdk_users.expiration_date, "
            . "zdk_users.user_email, zdk_users.full_menu_access, zdk_users.user_enabled, "
            . "zdk_users.user_phone, zdk_users.notes "
            . "from zdk_user_profiles ";
        $this->query .= "left join zdk_profiles using (profile_id) ";
        $this->query .= "left join zdk_users using (user_id) ";
        $this->filterClause = "where zdk_user_profiles.user_id = ?";
    }
    /**
     * Filters the assigned profile to a user from its profile identifier 
     * @param int $profileID Profile identifier to search
     * @param boolean $includeArchived When set to FALSE, archived users are
     * excluded
     */
    public function setProfileIdAsFilter($profileID, $includeArchived = TRUE) {
        $this->filterClause = "WHERE zdk_profiles.profile_id = ?";
        if ($includeArchived === FALSE) {
            $this->filterClause .= " AND zdk_users.user_enabled > -1"; 
        }
        $this->setFilterCriteria($profileID);
    }
    /**
     * Filters the assigned profile to a user from the specified login name and
     * profile name 
     * @param string $loginName Login name to search
     * @param string $profileName Profile name to search
     */
    public function setLoginNameAndProfileNameAsFilters($loginName, $profileName) {
        $this->filterClause = "where zdk_users.login_name = ? and zdk_profiles.profile_name = ?";
        $this->setFilterCriteria($loginName, $profileName);
    }
    
    public function setUsersAsFilter($userIds) {
        $placeHolders = implode(',', array_fill(0, count($userIds), '?'));
        $this->filterClause = "WHERE zdk_user_profiles.user_id IN ({$placeHolders})";
        $this->filterValues = $userIds;
    }
}
