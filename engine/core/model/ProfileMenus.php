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
* Core DAO : menu items access rights granted to a profile 
*
* File version: 1.1
* Last update: 02/11/2017
*/
namespace model;
/**
 * Database access to the navigation menu items assigned to a profile
 */
class ProfileMenus extends \DAO
{
	protected function initDaoProperties() {
            $this->useCoreDbConnection();
            $this->table = "zdk_profile_menus";
            $this->IdColumnName = "profile_menus_id";
		$this->query = "select * from zdk_profile_menus ";
		$this->filterClause = "where zdk_profile_menus.profile_id = ?";
	}
        
        public function setProfileAndMenuAsFilter($profileName, $menuItemId) {
            $this->query = "SELECT pme.profile_menus_id FROM " . $this->table . " AS pme "
                . "INNER JOIN zdk_profiles AS pro USING (profile_id)";
            $this->filterClause = "WHERE pro.profile_name = ? AND pme.menu_id = ?";
            $this->setFilterCriteria($profileName, $menuItemId);
        }
}