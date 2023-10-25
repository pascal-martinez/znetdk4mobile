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
 * Core DAO : menu items granted to a user through her/his profiles 
 *
 * File version: 1.1
 * Last update: 01/17/2017
 */

namespace model;

/**
 * Database access to the navigation menu items granted to a configured user
 *  thru his profiles
 */
class UserMenus extends \DAO {

    protected function initDaoProperties() {
        $this->useCoreDbConnection();
        $this->query = "select distinct zdk_profile_menus.menu_id from zdk_users ";
        $this->query .= "left join zdk_user_profiles using (user_id) ";
        $this->query .= "left join zdk_profile_menus using (profile_id) ";
        $this->filterClause = "where login_name = ?";
    }
    
    public function setLoginNameAndMenuItemAsFilter($loginName, $menuItem) {
        $this->filterClause = "where login_name = ? and menu_id = ?";
        $this->setFilterCriteria($loginName, $menuItem);
    }

}
