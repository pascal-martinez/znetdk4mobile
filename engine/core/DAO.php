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
 * Core Data Access Object API
 *
 * File version: 1.15
 * Last update: 11/06/2024
 */
abstract class DAO {

    // properties declaration
    /** Name of the table to map in the DAO */
    protected $table;
    /** Alias of the table used to prefix the identifier column name */
    protected $tableAlias = FALSE;
    /** SQL query to be executed by the DAO */
    protected $query;
    /** SQL condition to apply to the DAO to filter data row returned */
    protected $filterClause = FALSE;
    /** Grouping SQL clause */
    protected $groupByClause = FALSE;
    /** Filter values */
    protected $filterValues = array();
    /** Column name in which the identifier of the data row is stored */
    protected $IdColumnName = 'id';
    /** Columns containing values to display as a money */
    protected $moneyColumns = FALSE;
    /** Columns containing a date to format according locale settings */
    protected $dateColumns = FALSE;
    /** Columns containing values to display as amount */
    protected $amountColumns = FALSE;
    /** Columns for which values are returned by the query */
    protected $selectedColumns = FALSE;
    /** Sorting SQL clause */
    protected $sortClause = FALSE;
    /** Rows limit SQL clause */
    protected $limitClause = FALSE;
    /** The SQL FOR UPDATE clause */
    protected $isForUpdate = FALSE;
    /** The result set of the executed SQL statement */
    protected $result = FALSE;
    /* Private properties */
    private $coreDbConnectionToUse = FALSE;
    private $profileCriteria = array();
    private $profileCriteriaExclude = FALSE;
    private $storedProfiles = array();
    private $customDbConnection = NULL;

    /**
     * Creates a new custom DAO object
     * @param \PDO $customDbConnection Optional database connection to use other
     * than the database connection set in the config.php file.
     * @throws \Exception Thrown when the custom DAO is not properly defined.
     */
    public function __construct($customDbConnection = NULL) {
        $this->initDaoProperties();
        if (!isset($this->query) && isset($this->table)) {
            $this->query = "SELECT * FROM `{$this->table}`";
        } elseif (!isset($this->query)) {
            $message = "DAO-001: the property 'table' or 'query' must be set for the class '" . get_class($this) .
                    "' to instanciate it!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        }
        if (!is_null($customDbConnection)) {
            $this->customDbConnection = $customDbConnection;
        }
    }

    private function addMoneyColumns(&$row) {
        if (is_array($row) && is_array($this->moneyColumns)) {
            foreach ($this->moneyColumns as $column) {
                $row[$column . '_money'] = \Convert::toMoney($row[$column]);
            }
        }
    }

    private function addAmountColumns(&$row) {
        if (is_array($row) && is_array($this->amountColumns)) {
            foreach ($this->amountColumns as $column) {
                $row[$column . '_amount'] = \Convert::toMoney($row[$column], FALSE);
            }
        }
    }

    private function addLocalizedDateColumns(&$row) {
        if (is_array($row) && is_array($this->dateColumns)) {
            foreach ($this->dateColumns as $column) {
                $row[$column . '_locale'] = \Convert::W3CtoLocaleDate($row[$column]);
            }
        }
    }

    private function getDbConnection() {
        if (!is_null($this->customDbConnection)) {
            return $this->customDbConnection;
        }
        try {
            if ($this->coreDbConnectionToUse) {
                return \Database::getCoreDbConnection();
            } else {
                return \Database::getApplDbConnection();
            }
        } catch (\Exception $e) {
            $message = "DAO-008: unable to connect to the database".
                    ": code='" . $e->getCode() . "', message='" . $e->getMessage();
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw $e;
        }
    }

    private function getProfileJoinClause() {
        $database = defined('CFG_SQL_CORE_DB') && CFG_SQL_CORE_DB != ''
                    ? "`".CFG_SQL_CORE_DB."`." : '';
        $profileSetOperator = $this->profileCriteriaExclude ? 'NOT IN' : 'IN';
        $joinClause = " INNER JOIN " . $database . "zdk_profile_rows ON"
        . " (" . $database . "zdk_profile_rows.row_id = " . $this->table
        . "." . $this->IdColumnName . " AND " . $database
        . "zdk_profile_rows.table_name = '" . $this->table . "')"
        . " INNER JOIN " . $database . "zdk_profiles ON (" . $database
        . "zdk_profile_rows.profile_id = " . $database
        . "zdk_profiles.profile_id AND " . $database
        . "zdk_profiles.profile_name " . $profileSetOperator . " ('"
        . implode("','",$this->profileCriteria) . "'))";
        return $joinClause;
    }

    private function storeProfiles($rowID) {
        // First, remove existing profiles
        $profileMenusDAO = new model\ProfileRows();
        $profileMenusDAO->setFilterCriteria($rowID,  $this->table);
        $profileMenusDAO->remove(NULL,FALSE);
        // Next, add the new profiles
        foreach($this->storedProfiles as $profileName) {
            $profileFound = ProfileManager::getProfileInfos($profileName);
            if ($profileFound === FALSE) {
                $message = "DAO-009: the profile named '$profileName' that has been"
                        . " specified thru a call to the 'DAO::setStoredProfiles()'"
                        . " method, does not exist!";
                \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
                throw new \ZDKException($message);
            } else {
                $row = array('profile_id'=>$profileFound['profile_id'],
                    'table_name'=>$this->table,'row_id'=>$rowID);
                $profileMenusDAO->store($row, FALSE);
            }
        }
    }

    private function getTablePrefixParameter() {
        if (is_null(CFG_SQL_TABLE_REPLACE_PREFIXES)) {
            return NULL;
        }
        $prefixes = unserialize(CFG_SQL_TABLE_REPLACE_PREFIXES);
        if (!is_array($prefixes)) {
            $message = "DAO-012: the value set for the 'CFG_SQL_TABLE_REPLACE_PREFIXES' "
                    . "is not a serialized array!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        }
        return $prefixes;
    }

    private function replaceTablePrefixesToQuery(&$fullQuery) {
        $prefixes = $this->getTablePrefixParameter();
        if (is_null($prefixes)) {
            return FALSE; // No replacement required
        }
        $search = array();
        $replace = array();
        foreach ($prefixes as $old => $new) {
            $search[] = $old;
            $replace[] = $new;
        }
        $count = 0;
        $fullQuery = str_ireplace($search, $replace, $fullQuery, $count);
        return $count > 0;
    }

    /**
     * Returns the table name set for the DAO.
     * If the CFG_SQL_TABLE_REPLACE_PREFIXES parameter is set, the table name
     * returned is the converted table name obtained after replacement of its
     * prefix to the one specified in the config.php parameter.
     * @return string The name of the table
     */
    protected function getTableName() {
        $prefixes = $this->getTablePrefixParameter();
        if (is_null($prefixes)) {
            return $this->table;
        }
        foreach ($prefixes as $oldPrefix => $newPrefix) {
            if (stripos($this->table, $oldPrefix) === 0) {
                $explodedTableName = explode($oldPrefix, $this->table, 2);
                return $newPrefix . $explodedTableName[1];
            }
        }
        return $this->table; // The table name does not match the prefixes to replace
    }

    private function executeQuery() {
        $fullQuery = $this->query;
        $dbConnection = $this->getDbConnection();

        if (count($this->profileCriteria) > 0 ) {
            $fullQuery .= $this->getProfileJoinClause();
        }
        if ($this->filterClause && count($this->filterValues) > 0) {
            $fullQuery .= ' ' . $this->filterClause;
        }
        if ($this->groupByClause) {
            $fullQuery .= ' ' . $this->groupByClause;
        }
        if ($this->sortClause) {
            $fullQuery .= ' ' . $this->sortClause;
        }
        if ($this->limitClause) {
            $fullQuery .= ' ' . $this->limitClause;
        }
        if ($this->isForUpdate) {
            $fullQuery .= ' FOR UPDATE';
        }
        $this->replaceTablePrefixesToQuery($fullQuery);
        $queryStartTime = microtime(TRUE);
        try {
            $statement = $dbConnection->prepare($fullQuery);
            $statement->execute($this->filterValues);
        } catch (\PDOException $e) {
            $message = "DAO-002: unable to execute the SQL query '" . $fullQuery .
                    "': code='" . $e->getCode() . "', message='" . $e->getMessage();
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw $e;
        }
        $this->traceSqlStatement($fullQuery, $this->filterValues, $queryStartTime);
        return $statement;
    }

    /**
     * Removes '_money', '_amount' and '_locale' suffixes in the specified
     * columns string
     * @param string $columns String containing columns description
     * @return string Columns description without '_money', '_local' and
     * '_amount' suffixes.
     */
    private function removeExtraSuffixes($columns) {
        $cleanString = $columns;
        if (is_array($this->moneyColumns)) {
            foreach ($this->moneyColumns as $value) {
                $cleanString = str_replace($value . '_money' , $value, $cleanString);
            }
        }
        if (is_array($this->dateColumns)) {
            foreach ($this->dateColumns as $value) {
                $cleanString = str_replace($value . '_locale' , $value, $cleanString);
            }
        }
        if (is_array($this->amountColumns)) {
            foreach ($this->amountColumns as $value) {
                $cleanString = str_replace($value . '_amount' , $value, $cleanString);
            }
        }
        return $cleanString;
    }

    /**
     * Returns only the values of the specified columns from the data row passed
     * in parameter
     * @param array $row All values of the row
     * @return array The values of the specified columns in the $selectedColumns
     * property
     */
    private function getSelectedColumnValues($row) {
        if (is_array($this->selectedColumns) && count($this->selectedColumns) > 0) {
            $selection = array();
            foreach ($this->selectedColumns as $key) {
                $selection [$key] = $row[$key];
            }
            return $selection;
        } else {
            return $row;
        }
    }

    /**
     * Method called when the inherited class is instanciated
     * The $query, $filterClause, $IdColumnName and $moneyColumns
     * protected properties can be set in this method.
     */
    abstract protected function initDaoProperties();

    protected function useCoreDbConnection() {
        $this->coreDbConnectionToUse = TRUE;
    }

    /**
     * Starts an explicit SQL transaction which requires a commit or a rollback
     * to end it.
     * @param boolean $silent If TRUE, the transaction is not started if it is
     * already active and no exception is thrown.
     */
    public function beginTransaction($silent = FALSE) {
        $dbConnection = $this->getDbConnection();
        if ($dbConnection->inTransaction()) {
            if (!$silent) {
                $message = "DAO-010: a transaction is already active!";
                \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
                throw new \ZDKException($message);
            }
        } else {
            $dbConnection->beginTransaction();
        }
    }
    /**
     * Commits the data changed in the table.
     */
    public function commit() {
        $dbConnection = $this->getDbConnection();
        $dbConnection->commit();
    }

    /**
     * Rollbacks the data changed in the table.
     */
    public function rollback() {
        $dbConnection = $this->getDbConnection();
        $dbConnection->rollBack();
    }

    /**
     * Sets one or several values as criteria for the filter defined for the DAO.
     * <br>The values are passed in parameters of the method.<br>
     * The order of the values passed to the method must be the same than
     * the one of the criteria defined for the $filterClause property.
     */
    public function setFilterCriteria() {
        $this->filterValues = array();
        foreach (func_get_args() as $value) {
            $this->filterValues[] = $value;
        }
        $this->result = FALSE;
    }

    /**
     * Sets the sort criteria to apply to the data returned by the method
     * getResult().
     * @param string $sortCriteria Column name of the table from which the data
     * have to be sorted.
     */
    public function setSortCriteria($sortCriteria) {
        if (is_string($sortCriteria) && $sortCriteria !== '') {
            $this->sortClause = 'ORDER BY ' . $this->removeExtraSuffixes($sortCriteria);
        }
        $this->result = FALSE;
    }

    /**
     * Limits the number of lines returned by the method getResult().
     * @param int $offset First data row to select starting to 0.
     * @param int $count Number of data rows to select.
     */
    public function setLimit($offset, $count) {
        $this->limitClause = 'LIMIT ' . $offset . ', ' . $count;
        $this->result = FALSE;
    }

    /**
     * Sets the profiles for limiting the rows returned by the 'getResults'
     * method to those matching them.
     * @param array $profiles Names of the profiles
     * @param boolean $exclude When set to TRUE, the profiles other than those
     * specified will be returned by the 'getResults' method.
     */
    public function setProfileCriteria($profiles, $exclude = FALSE) {
        $this->profileCriteria = $profiles;
        $this->profileCriteriaExclude = $exclude;
        $this->result = FALSE;
    }

    /**
     * Sets the profiles to store for each row inserted thru a call to the
     * 'store' method.
     * @param array $profiles Names of the profiles
     */
    public function setStoredProfiles($profiles) {
        $this->storedProfiles = $profiles;
        $this->result = FALSE;
    }

    /**
     * Limits the returned values on database selection to the specified columns
     * @param array $columns Columns to return on DAO selection
     */
    public function setSelectedColumns($columns) {
        $this->selectedColumns = $columns;
        $this->result = FALSE;
    }

    /**
     * Set columns to display as Amount according locale settings.
     * For example, if the column 'total' is specified, the column named
     * 'total_amount' is added to the row returned by the DAO::getById() and
     * DAO::getResult() methods and contains the formated value as amount.
     * See also LC_LOCALE_DECIMAL_SEPARATOR, LC_LOCALE_THOUSANDS_SEPARATOR,
     * LC_LOCALE_NUMBER_OF_DECIMALS ZnetDK constants.
     * @param string one or several column names
     */
    public function setAmountColumns() {
        $this->amountColumns = [];
        foreach (func_get_args() as $column) {
            $this->amountColumns[] = strval($column);
        }
    }

    /**
     * Set columns to display as Money according locale settings.
     * For example, if the column 'total' is specified, the column named
     * 'total_money' is added to the row returned by the DAO::getById() and
     * DAO::getResult() methods and contains the formated value as money.
     * See also LC_LOCALE_DECIMAL_SEPARATOR, LC_LOCALE_THOUSANDS_SEPARATOR,
     * LC_LOCALE_NUMBER_OF_DECIMALS, LC_LOCALE_CURRENCY_SYMBOL,
     * LC_LOCALE_CURRENCY_SYMBOL_PRECEDE, LC_LOCALE_CURRENCY_SYMBOL_SEPARATE
     * ZnetDK constants.
     * @param string one or several column names
     */
    public function setMoneyColumns() {
        $this->moneyColumns = [];
        foreach (func_get_args() as $column) {
            $this->moneyColumns[] = strval($column);
        }
    }

    /**
     * Set columns to display as Date according locale settings.
     * For example, if the column 'update_date' is specified, the column named
     * 'update_date_locale' is added to the row returned by the DAO::getById()
     * and DAO::getResult() methods and contains the formated value as money.
     * See also LC_LOCALE_DATE_FORMAT ZnetDK constant.
     * @param string one or several column names
     */
    public function setDateColumns() {
        $this->dateColumns = [];
        foreach (func_get_args() as $column) {
            $this->dateColumns[] = strval($column);
        }
    }

    /**
     * Enables or disables the locking of rows when they are selected by adding
     * the 'FOR UDATE' clause to the SQL query.
     * @param boolean $isForUpdate Value TRUE for enabling rows locking, FALSE
     * to disable it.
     * @throws \ZDKException Thrown if no transaction is started
     */
    public function setForUpdate($isForUpdate) {
        $dbConnection = $this->getDbConnection();
        if ($isForUpdate && !$dbConnection->inTransaction()) {
            $message = "DAO-011: a transaction must be started before selecting rows for update!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        }
        $this->isForUpdate = $isForUpdate;
    }

    /**
     * Returns the current 'for update' state set for the next SELECT statement
     * to execute.
     * @return boolean Value TRUE is the next select statement is to execute
     * with the for update clause.
     */
    public function isForUpdate() {
        return $this->isForUpdate;
    }

    /**
     * Returns the number of data rows.
     * For large tables, it is better to execute a specific SQL query with
     * COUNT(*) in column definition.
     * @return int Number of data rows.
     */
    public function getCount() {
        $this->result = $this->executeQuery();

        if ($this->result) {
            $rowCount = $this->result->rowCount();
                $this->result = FALSE;
            return $rowCount;
        } else {
            return 0;
        }
    }

    /**
     * Returns the current data row
     * @return array|boolean Characteristics of the current data row as an array
     * where the index value matches the column name. Returns null if no data
     * row exists or if the last data row has already been returned at the
     * previous call.
     */
    public function getResult() {
        if (!$this->result) { // First call, the SQL query is not yet executed
            $this->result = $this->executeQuery();
        }

        if ($this->result) { // At least 1 row exists
            $row = $this->result->fetch(\PDO::FETCH_ASSOC);
            if ($row) {
                $this->addMoneyColumns($row);
                $this->addAmountColumns($row);
                $this->addLocalizedDateColumns($row);
                // Transform NULL values in empty string
                foreach ($row as &$value) {
                    $value = $value === NULL ? "":$value;
                }
                return $this->getSelectedColumnValues($row);
            }
            return $row;
        } else { // No more row exists or the SQL query returns no row!
            return FALSE;
        }
    }

    /**
     * Returns the data row for the specified identifier.
     * @param int $id Identifier of the data row to select
     * @return array|boolean Array containing the characteristics of the data
     * row selected. Returns false if no data row exists for the specified
     * identifier.
     */
    public function getById($id) {
        $this->filterValues = array($id);
        $tableAlias = $this->tableAlias ? $this->tableAlias . '.' : '';
        $this->filterClause = 'WHERE ' . $tableAlias . $this->IdColumnName . ' = ?';
        $this->result = FALSE;
        return $this->getResult();
    }

    /**
     * Stores in the table of the DAO the specified data row.
     * @param array $row Data row as an array. If the identifier is specified in
     * the array, the data row is updated. Else, the data row is inserted in the
     * table.
     * @param boolean $autocommit Specifies whether the data must be commited
     * after its modification or insertion.
     * @param boolean $emptyValuesToNull If TRUE, converts the empty values
     * (ie '') to NULL.
     * @return integer Identifier of the row inserted or updated
     */
    public function store($row, $autocommit = TRUE, $emptyValuesToNull = FALSE) {
        if (!isset($this->table)) {
            $message = "DAO-003: the property 'table' must be set for the class '" . get_class($this) .
                    "' to store a data row!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        }
        $this->convertBooleanValuesToInt($row);
        if ($emptyValuesToNull) {
            $this->convertEmptyValuesToNull($row);
        }
        if (array_key_exists($this->IdColumnName, $row)) {
            $rowID = $row[$this->IdColumnName];
            // Row ID is removed from the array because is not udpated
            unset($row[$this->IdColumnName]);
        }
        if (isset($rowID) && $rowID !== '') {
            /* Row update */
            $sql = 'UPDATE `' . $this->getTableName() . '` SET `';
            $sql .= implode("` = ?, `", array_keys($row));
            $sql .= '` = ? WHERE `' . $this->IdColumnName . '` = ?';
            $row[] = $rowID;
        } else {
            /* Row insertion */
            $sql = 'INSERT INTO `' . $this->getTableName();
            $sql .= "` (`" . implode("`, `", array_keys($row)) . "`)";
            $markers = array_fill(0, count($row), '?');
            $sql .= " VALUES (" . implode(", ", $markers) . ")";
        }
        /* Execute SQL statement */
        $values = array_values($row);
        $dbConnection = $this->getDbConnection();
        if ($autocommit) {
            $dbConnection->beginTransaction();
        }
        $queryStartTime = microtime(TRUE);
        try {
            $statement = $dbConnection->prepare($sql);
            $statement->execute(array_values($values));
        } catch (\PDOException $e) {
            $message = "DAO-004: unable to execute the SQL statement '" . $sql .
                    "': code='" . $e->getCode() . "', message='" . $e->getMessage();
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            if ($autocommit) {
                $dbConnection->rollBack();
            }
            throw $e;
        }

        $returnedRowID = isset($rowID) ? $rowID : $dbConnection->lastInsertId();

        if (count($this->storedProfiles) > 0 ) {
            $this->storeProfiles($returnedRowID);
        }

        if ($autocommit) {
            $dbConnection->commit();
        }
        $this->traceSqlStatement($sql, $values, $queryStartTime);
        return $returnedRowID;
    }

    /**
     * Removes the table row matching the specified row identifier. If the row
     * identifier is not set in paramater, the filter criteria set for the DAO
     * object are used to remove the corresponding rows.
     * @param int $rowID Identifier of the row to remove.
     * @param boolean $autocommit Specifies whether the data once removed must
     * be commited or not.
     * @return int The number of rows removed
     */
    public function remove($rowID = NULL, $autocommit = TRUE) {
        if (!isset($this->table)) {
            $message = "DAO-005: the property 'table' must be set for the class '" . get_class($this) .
                    "' to remove data row!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        } elseif (!isset($rowID) && (count($this->filterValues) === 0 || !$this->filterClause)) {
            $message = "DAO-006: the parameter 'rowID' is absent when calling the method 'DAO::remove()' or the properties 'filterValues' and 'filterClause' are not properly set for the class '" .
                    get_class($this) . "' to remove data row!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        } elseif (isset($rowID)) {
            $filterClause = 'WHERE ' . $this->IdColumnName . ' = ?';
            $filterValues = array($rowID);
        } else {
            $filterClause = $this->filterClause;
            $this->replaceTablePrefixesToQuery($filterClause);
            $filterValues = $this->filterValues;
        }
        $sql = $this->isTableAliasRequired($filterClause)
            ? 'DELETE ' . $this->tableAlias . ' FROM `' . $this->getTableName() . '` AS ' . $this->tableAlias
            : 'DELETE FROM `' . $this->getTableName() . '`';
        $sql .= ' ' . $filterClause;
        /* Execute SQL statement */
        $dbConnection = $this->getDbConnection();
        if ($autocommit) {
            $dbConnection->beginTransaction();
        }
        $queryStartTime = microtime(TRUE);
        try {
            $statement = $dbConnection->prepare($sql);
            $statement->execute($filterValues);
        } catch (\PDOException $e) {
            $message = "DAO-007: unable to execute the SQL statement '" . $sql .
                    "': code='" . $e->getCode() . "', message='" . $e->getMessage();
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            if ($autocommit) {
                $dbConnection->rollBack();
            }
            throw $e;
        }
        $rowCount = $statement->rowCount();
        if (isset($rowID)) {
            \ProfileManager::removeProfilesRow($this->table, $rowID);
        }

        if ($autocommit) {
            $dbConnection->commit();
        }
        $this->traceSqlStatement($sql, $filterValues, $queryStartTime);
        return $rowCount;
    }

    /**
     * Check if the table name set for the 'table' property exists in the
     * current database
     * @return Boolean TRUE if table exists, FALSE if table does not exist or
     * if the 'table' property is not set.
     */
    public function doesTableExist() {
        if (!isset($this->table)) {
            return FALSE;
        }
        $connection = $this->getDbConnection();
        $dbQuery = "SELECT 1 FROM information_schema.tables
            WHERE table_name = ?
            AND table_schema = DATABASE()";
        try {
            $statement = $connection->prepare($dbQuery);
            $statement->execute([$this->table]);
        } catch (\PDOException $e) {
            $message = "DAO-013: unable to execute the SQL query '" . $dbQuery .
                    "': code='" . $e->getCode() . "', message='" . $e->getMessage();
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw $e;
        }
        return $statement !== FALSE && $statement->rowCount() === 1;
    }

    private function isTableAliasRequired($filterClause) {
        return $this->tableAlias && strpos($filterClause, $this->tableAlias . '.') !== FALSE;
    }

    private function convertEmptyValuesToNull(&$row) {
        foreach ($row as $key => &$value) {
            if ($value === '') {
                $row[$key] = NULL;
            }
        }
    }

    private function convertBooleanValuesToInt(&$row) {
        foreach ($row as $key => &$value) {
            if (is_bool($value)) {
                $row[$key] = $value ? 1 : 0;
            }
        }
    }

    private function traceSqlStatement($sqlStatement, $values, $queryStartTime) {
        if (CFG_SQL_TRACE_ENABLED === TRUE) {
            $timeElapsed = round(microtime(TRUE) - $queryStartTime, 3);
            $queryValuesAsString = implode(', ', $values);
            $callBackTrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
            $callingMethod = key_exists(2, $callBackTrace) && key_exists('function', $callBackTrace[1])
                    ? "::{$callBackTrace[2]['function']}()" : '';
            General::writeSystemLog(get_class($this).$callingMethod, "SQL QUERY: {$sqlStatement}\nVALUES: [{$queryValuesAsString}]\nTIME ELAPSED: {$timeElapsed} s", TRUE);
        }
    }
}
