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
 * Core Database API
 *
 * File version: 1.3
 * Last update: 08/31/2022
 */
/**
 * ZnetDK database access tools
 */
Class Database {
    /* Properties */

    static private $coreDbConnection;
    static private $applDbConnection;

    /**
     * Returns a database connection from the specified parameters 
     * @param string $host Hostname of the MySQL server 
     * @param string $database Database name (can be NULL)
     * @param string $user User account
     * @param string $password User's password
     * @param string $port The port number where the database server is listening
     * @return \PDO PDO object of the connection
     */
    static private function connectToDb($host, $database, $user, $password, $port = NULL) {
        $dsn = CFG_SQL_ENGINE . ':host=' . $host . ';charset=UTF8';
        if (!is_null($database)) {
            $dsn .= ';dbname=' . $database;
        }
        if (!is_null($port)) {
            $dsn .= ';port=' . $port;
        }
        $dbConnection = new \PDO($dsn, $user, $password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
        $dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $dbConnection->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, TRUE);
        return $dbConnection;
    }
    
    static private function getDbConnection($level = 'appl') {
        \Parameters::checkConfigParameter('CFG_SQL_HOST');
        switch ($level) {
            case 'core':
                $dbConnection = self::$coreDbConnection;
                \Parameters::checkConfigParameter('CFG_SQL_CORE_DB');
                $dbName = CFG_SQL_CORE_DB;
                \Parameters::checkConfigParameter('CFG_SQL_CORE_USR');
                $user = CFG_SQL_CORE_USR;
                $password = CFG_SQL_CORE_PWD;
                break;
            case 'appl':
                $dbConnection = self::$applDbConnection;
                \Parameters::checkConfigParameter('CFG_SQL_APPL_DB');
                $dbName = CFG_SQL_APPL_DB;
                \Parameters::checkConfigParameter('CFG_SQL_APPL_USR');
                $user = CFG_SQL_APPL_USR;
                $password = CFG_SQL_APPL_PWD;
                break;
        }
        if (!$dbConnection) {
            $dbConnection = self::connectToDb(CFG_SQL_HOST, $dbName, $user, $password, CFG_SQL_PORT);
            self::$coreDbConnection = $level === 'core' ? $dbConnection : self::$coreDbConnection;
            self::$applDbConnection = $level === 'appl' ? $dbConnection : self::$applDbConnection;
        }
        return $dbConnection;
    }

    /**
     * Returns the PDO connection object to the core database once authenticated
     * from the parameters CFG_SQL_CORE_DB, CFG_SQL_CORE_USR and CFG_SQL_CORE_PWD
     * which are set in the file 'config.php'.
     * if the parameter CFG_SQL_CORE_DB is not set, the connection is made from
     * the parameters CFG_SQL_APPL_DB, CFG_SQL_APPL_USR and CFG_SQL_APPL_PWD. 
     * @return \PDO Object allowing to access to the core database resources 
     * if authentication is OK. Else, the connection object is returned for 
     * access to the application database resources. Finally, a PDO Exception
     * is raised if connection settings are wrong for both core and application 
     * levels.  
     */
    static public function getCoreDbConnection() {
        $level = defined('CFG_SQL_CORE_DB') && CFG_SQL_CORE_DB != '' ? 'core' : 'appl';
        return self::getDbConnection($level);
    }
    
    /**
     * Returns the PDO connection object to the application database once authenticated
     * from the parameters CFG_SQL_APPL_DB, CFG_SQL_APPL_USR and CFG_SQL_APPL_PWD
     * which are set in the file 'config.php'.
     * if the parameter CFG_SQL_APPL_DB is not set, the connection is made from
     * the parameters CFG_SQL_CORE_DB, CFG_SQL_CORE_USR and CFG_SQL_CORE_PWD. 
     * @return \PDO Object allowing to access to the application database resources 
     * if authentication is OK. Else, the connection object is returned for 
     * access to the core database resources. Finally, a PDO Exception
     * is raised if connection settings are wrong for both core and application 
     * levels.  
     */
    static public function getApplDbConnection() {
        $level = defined('CFG_SQL_APPL_DB') && CFG_SQL_APPL_DB != '' ? 'appl' : 'core';
        return self::getDbConnection($level);
    }
    
    /**
     * Returns a custom database connection from the specified parameters 
     * @param string $host Hostname of the MySQL server 
     * @param string $database Database name (can be NULL)
     * @param string $user User account
     * @param string $password User's password
     * @param string $port The port number where the database server is listening
     * @return \PDO PDO object of the connection
     */
    static public function getCustomDbConnection($host, $database, $user, $password, $port = NULL) {
        return self::connectToDb($host, $database, $user, $password, $port);
    }

    /**
     * Checks if the security tables are properly installed
     * @param string $errorMessage Error message returned by the PDO object
     * @return boolean TRUE if all tables exist, FALSE otherwise.
     */
    static public function areCoreTablesProperlyInstalled(&$errorMessage) {
        try {
            $dbConnection = self::getApplDbConnection();
            $dbConnection->exec('SELECT 1 FROM zdk_users, zdk_profiles,zdk_profile_menus,zdk_user_profiles,zdk_profile_rows LIMIT 1');

        } catch (\PDOException $ex) {
            $errorMessage = $ex->getMessage();
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Begins a database transaction
     */
    static public function beginTransaction() {
        $connection = self::getApplDbConnection();
        $connection->beginTransaction();
    }
    
    /**
     * Checks if a database transaction is active
     * @return boolean TRUE if a transaction is active, FALSE otherwise
     */
    static public function inTransaction() {
        $connection = self::getApplDbConnection();
        return $connection->inTransaction();
    }
    
    /**
     * Commits the changes made within the current transaction 
     */
    static public function commit() {
        $connection = self::getApplDbConnection();
        $connection->commit();
    }
    
    /**
     * Cancels the changes made within the current transaction
     */
    static public function rollback() {
        $connection = self::getApplDbConnection();
        $connection->rollback();
    }
}
