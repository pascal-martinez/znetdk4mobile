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
 * Core DAO : business table rows associated to a user profile 
 *
 * File version: 1.0
 * Last update: 09/18/2015
 */

namespace model;

/**
 * Database access to the table rows assigned to a profile
 */
class ProfileRows extends \DAO {

    protected function initDaoProperties() {
        $this->useCoreDbConnection();
        $this->table = "zdk_profile_rows";
        $this->IdColumnName = "profile_rows_id";
        $this->filterClause = "where row_id = ? and table_name = ?";
    }

    /**
     * Filters the rows from the specified profile identifier 
     * @param int $profileID Profile identifier to search
     */
    public function setProfileIdAsFilter($profileID) {
        $this->filterClause = "where profile_id = ?";
        $this->setFilterCriteria($profileID);
    }
}
