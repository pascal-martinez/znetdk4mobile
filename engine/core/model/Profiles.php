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
 * Core DAO : profiles for authorization of the users 
 *
 * File version: 1.1
 * Last update: 03/14/2023
 */

namespace model;

/**
 * Database access to the profiles configured for the application
 */
class Profiles extends \DAO {

    protected function initDaoProperties() {
        $this->useCoreDbConnection();
        $this->table = "zdk_profiles";
        $this->IdColumnName = "profile_id";
        $this->filterClause = "where profile_name = ?";
    }
    
    public function setWithMenuIdListAsQuery() {
        $this->tableAlias = 'pro';
        $this->query = "SELECT pro.*, GROUP_CONCAT(menu_id) AS menu_id_list 
            FROM zdk_profiles AS pro
            LEFT JOIN zdk_profile_menus AS men ON men.profile_id = pro.profile_id";
        $this->groupByClause = "GROUP BY pro.profile_id";
    }

}
