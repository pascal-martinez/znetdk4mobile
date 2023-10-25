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
* Core DAO : users declared in the application 
*
* File version: 1.4
* Last update: 09/01/2021
*/
namespace model;

/**
 * Database access to the users configured for the application
 */
class Users extends \DAO
{
    protected function initDaoProperties() {
        $this->useCoreDbConnection();
        $this->table = "zdk_users";
        $this->IdColumnName = "user_id";
        $fullMenuAccessLabel = LC_FORM_LBL_USER_MENU_ACCESS_FULL;
        $disabledLabel = LC_FORM_LBL_USER_STATUS_DISABLED;
        $archivedLabel = LC_FORM_LBL_USER_STATUS_ARCHIVED;
        $this->query = "SELECT *,
            IF(full_menu_access,'{$fullMenuAccessLabel}','') AS menu_access,
            IF(user_enabled = 0,'{$disabledLabel}',IF(user_enabled = -1,'{$archivedLabel}','')) AS status
            FROM {$this->table}";
        $this->filterClause = "WHERE login_name = ?";
        $this->dateColumns = array('expiration_date');
    }

    /**
     * Sets the email address as the filter criteria to retrieve a user 
     * @param string $email User's email address to search
     */
    public function setEmailAsFilter($email) {
        $this->filterClause = "WHERE user_email = ?";
        $this->setFilterCriteria($email);    
    }

    /**
     * Excludes the 'autoexec' user from the user list
     */
    public function excludeAutoexecUser() {
        $this->filterClause = "WHERE login_name != ?";
        $this->setFilterCriteria('autoexec'); 
    }

    /**
     * Sets the user name as filter
     * @param string $name Name of the user
     */
    public function setNameAsFilter($name) {
        $this->filterClause = "WHERE user_name = ?";
        $this->setFilterCriteria($name);
    }

    /**
     * Sets a keyword as filter
     * @param string $searchKeyword
     */
    protected function setKeywordAsFilter($searchKeyword) {
        $sqlKeyword = '%' . $searchKeyword . '%';
        $this->filterClause .= " AND (LOWER(user_name) LIKE LOWER(?) OR "
            . "LOWER(login_name) LIKE LOWER(?) OR "
            . "EXISTS (SELECT 1 FROM zdk_user_profiles"
            . " INNER JOIN zdk_profiles USING (profile_id)"
            . " WHERE zdk_users.user_id = zdk_user_profiles.user_id "
            . " AND LOWER(zdk_profiles.profile_name) LIKE LOWER(?)))";
        $this->filterValues[] = $sqlKeyword;
        $this->filterValues[] = $sqlKeyword;
        $this->filterValues[] = $sqlKeyword;
    }
    
    protected function setStatusAsFilter($statusCode) {
        $this->filterClause .= " AND user_enabled = ?";
        $this->filterValues[] = $statusCode;
    }
    
    public function setSearchCriteriaAsFilter($criteria) {
        if (is_array($criteria)) {
            if (key_exists('keyword', $criteria) && $criteria['keyword'] !== '') {
                $this->setKeywordAsFilter($criteria['keyword']);
            }
            if (key_exists('status', $criteria) && is_numeric($criteria['status'])) {
                $this->setStatusAsFilter($criteria['status']);
            }
        } else {
            $this->setStatusAsFilter(1); // User enabled by default
        }
    }
        
}
