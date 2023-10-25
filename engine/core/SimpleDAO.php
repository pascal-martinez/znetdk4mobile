<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr 
 * Copyright (C) 2019 Pascal MARTINEZ (contact@znetdk.fr)
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
 * File version: 1.2
 * Last update: 01/08/2023
 */
class SimpleDAO extends DAO {
    
    protected $keywordSearchColumn = NULL;
    
    /**
     * Instantiate a new SimpleDAO object
     * @param String $tableName The name of table in the database
     */
    public function __construct($tableName) {
        $this->table = $tableName;
        parent::__construct();
    }
    
    protected function initDaoProperties() {
        // The table name is directly set from the class constructor.
        // Nothing more to do.
    }
    
    /**
     * Set the name of the table column in database in which the keywords are
     * searched into
     * @param string $columnName Column name of the table set when calling the
     * class constructor
     */
    public function setKeywordSearchColumn($columnName) {
        $this->keywordSearchColumn = $columnName;
    }
    
    
    /**
     * Get the rows matching the POST following paramaters:
     *  'first': the first row to return
     *  'count' or 'rows': the number of rows to return
     *  'sortfield': the sorted column
     *  'sortorder': the sort order ('1' or '-1')
     *  'keyword': the keyword to search into the rows  
     * @param array $rowsFound The rows found returned by reference
     * @param String $defaultSortField The default sorted column (in option,
     *  NULL by default and so no sorting applied) 
     * @return Integer The total number of rows
     */
    public function getRows(&$rowsFound, $defaultSortField = NULL) {
        $request = new \Request();
        $first = $request->first;
        $rowCount = $request->rows === NULL ? $request->count : $request->rows;
        $sortField = $request->sortfield;
        $sortOrder = $request->sortorder;
        if (isset($sortField) && isset($sortOrder)) {
            $this->setSortCriteria($sortField . ' '
                    . ($sortOrder === '1' ? 'ASC' : 'DESC'));
        } elseif (!is_null($defaultSortField)) { // Default sort field
            $this->setSortCriteria($defaultSortField);
        }
        $this->setKeyWordsAsFilter($request->keyword);
        try {
            $total = $this->getCount();
            if (!is_null($first) && !is_null($rowCount)) {
                $this->setLimit($first, $rowCount);
            }
            while ($row = $this->getResult()) {
                $rowsFound[] = $row;
            }            
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("SDA-001: unable to request rows from the table named '{$this->table}' in database.", $e, TRUE);
        }
        return $total;
    }
    
    /**
     * Get the suggestions matching the keyword set through the POST 'query'
     *  parameter value
     * @param Integer $count Maximum number of suggestions to return
     * @return array|FALSE The suggestions as an array of arrays where each
     *  subarray has 'value' and 'label' keys. Returns FALSE if the 
     * keyword Search Column is not set.
     */
    public function getSuggestions($count = 10) {
        if (is_null($this->keywordSearchColumn)) {
            return FALSE;
        }
        $request = new \Request();
        $suggestions = array();
        $this->setStringAsFilter($request->query);
        $this->setSortCriteria($this->keywordSearchColumn);        
        $this->setLimit(0, $count);
        try {
            while ($row = $this->getResult()) {
                if (key_exists('id', $row)) {
                    $row['value'] = $row['id'];
                }
                if (key_exists($this->keywordSearchColumn, $row)) {
                    $row['label'] = $row[$this->keywordSearchColumn];
                    $suggestions[] = $row;
                }
            }
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("SDA-002: unable to request suggestions from the table named '{$this->table}' in database.", $e, TRUE);
        }
        return $suggestions;
    }
    
    /**
     * Set the filter clause from the list or keywords 
     * @param String $keywords The list of keywords separated by a comma
     * @return boolean Value TRUE when succeeded, FALSE otherwise
     */
    protected function setKeywordsAsFilter($keywords) {
        if (is_null($keywords) || is_null($this->keywordSearchColumn)) {
            return FALSE;
        }
        if ($this->filterClause === FALSE) {
            $this->filterClause = 'WHERE ';
        } else {
            $this->filterClause .= ' AND ';
        }
        $searchedKeywords = explode(',', $keywords);
        foreach ($searchedKeywords as $key => $value) {
            if ($key === 0) {
                $this->filterClause .= '(';
            } else {
                $this->filterClause .= ' OR ';
            }
            $this->filterClause .= "LOWER({$this->keywordSearchColumn}) LIKE LOWER(?)";
            $this->filterValues[] = "%{$value}%";
            if ($key+1 === count($searchedKeywords)) {
                $this->filterClause .= ')';
            }
        }
        return TRUE;
    }
    
    protected function setStringAsFilter($queryString) {
        if (is_null($queryString) || is_null($this->keywordSearchColumn)) {
            return FALSE;
        }
        $this->filterClause = "WHERE LOWER({$this->keywordSearchColumn}) LIKE LOWER(?)";
        $this->setFilterCriteria("%{$queryString}%");
        return TRUE;
    }
    
    /**
     * Get the rows matching the specified condition and values.
     * @param string $condition Condition to apply to select the data rows. It
     * is given as a standard SQL WHERE clause condition with a question mark as
     * placeholder of each value set as parameter.
     * For example: 'color = ? AND type = ?'
     * @param mixed $value1 Firt value (mandatory) in replacement of the first
     *  question mark placeholder found into the condition string.
     * @param mixed $value2 Second value (optional) to replace into the
     *  condition string. The number of values passed as parameter of this 
     * method depends on the number of existing question marks into the
     * condition string
     * @return array The rows found as an array of indexed arrays where the
     * keys match the table's column names.
     */
    public function getRowsForCondition($condition) {
        $this->filterClause = 'WHERE ' . $condition;
        $this->filterValues = array();
        foreach (func_get_args() as $key =>$value) {
            if ($key === 0) {
                continue;
            }
            $this->filterValues[] = $value;
        }
        $this->result = FALSE;
        $rowsFound = array();
        try {
            while ($row = $this->getResult()) {
                $rowsFound[] = $row;
            }            
        } catch (\PDOException $e) {
            $response = new \Response();
            $response->setCriticalMessage("SDA-003: unable to request rows from the table named '{$this->table}' in database.", $e, TRUE);
        }
        return $rowsFound;
    }

}
