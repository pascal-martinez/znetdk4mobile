<?php
/**
* ZnetDK, Starter Web Application for rapid & easy development
* See official website http://www.znetdk.fr 
* Copyright (C) 2018 Pascal MARTINEZ (contact@znetdk.fr)
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
* Core DAO : suggestions of keywords for searching users 
*
* File version: 1.0
* Last update: 12/15/2024
*/
namespace model;

/**
 * Database access to the keywords matching the specified letters for 
 * searching users
 */
class UserSuggestions extends \DAO
{
    protected function initDaoProperties() {
        $this->useCoreDbConnection();
        $this->query = "SELECT DISTINCT suggestion FROM (
            SELECT login_name AS suggestion FROM zdk_users
            WHERE login_name LIKE ?
            UNION SELECT user_name AS suggestion FROM zdk_users
            WHERE user_name LIKE ?
            UNION SELECT profile_name AS suggestion FROM zdk_profiles
            WHERE profile_name LIKE ?
            ) AS suggestions";
        $this->setSortCriteria('suggestion');
    }

    public function setKeywordAsFilter($keyword) {
        $sqlKeyword = '%' . $keyword . '%';
        $this->setFilterCriteria($sqlKeyword, $sqlKeyword, $sqlKeyword);
    }
}