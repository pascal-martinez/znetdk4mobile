<?php

/* 
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://www.znetdk.fr
 * Copyright (C) 2022 Pascal MARTINEZ (contact@znetdk.fr)
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
 * SPL Autoload function registration
 * 
 * File version: 1.0
 * Last update: 12/03/2022
 */
/**
 * Registers the SPL autoload function.
 * This script is called from the index.php script.
 */
spl_autoload_register(
    /**
     * Automatic loading of classes located within ZNETDK_CORE_ROOT,
     * ZNETDK_APP_ROOT and ZNETDK_MOD_ROOT directories.
     * This function resolves mismatch between class name and PHP script name
     * when the script is fully named in lower case, in particular on Linux 
     * systems (case sensitive filenames).
     * For optimization purpose, scripts to include are searched in the path
     * matching their namespace.
     * For example, classes prefixed by 'app\' are searched in ZNETDK_APP_ROOT.
     * Classes having '\mod\' in their namespace are searched in ZNETDK_MOD_ROOT.
     * In case of controllers called from HTTP requests and specified in lower
     * case, if the corresponding PHP script is not resolved (for example if the
     * the specified class name is 'myclass' instead of 'MyClass'), the content 
     * of the expected directory is fetched and the script is found by lower 
     * case comparisaon.
     * @param string $class Name of the class for which the corresponding PHP script 
     * must be loaded via the 'include' statement.
     * @return boolean Returns TRUE if the PHP script is included successfully,
     * FALSE otherwise.
     */
    function ($class) {
        $getSearchPath = function($className) {
            $pathPieces = explode('\\', $className);
            return count($pathPieces) === 1 ? ZNETDK_CORE_ROOT : (
                $pathPieces[0] === 'app' ? ZNETDK_APP_ROOT : (
                count($pathPieces) > 2 && $pathPieces[1] === 'mod' ? ZNETDK_MOD_ROOT : ZNETDK_CORE_ROOT)) ;
        };
        $getFilePath = function($path, $className, $caseSensitivity) {
            if ($caseSensitivity === 'none') {
                $newClassName = $className;
            } else {
                $pathInfos = explode('\\', $className);
                $initialFileName = end($pathInfos);
                $newFileName = $caseSensitivity === 'lower' ? strtolower($initialFileName)
                        : ($caseSensitivity === 'ucfirst' ? ucfirst($initialFileName) : $initialFileName);
                $newClassName = str_replace($initialFileName, $newFileName, $className);
            }        
            return $path . DIRECTORY_SEPARATOR
                . str_replace('\\', DIRECTORY_SEPARATOR, $newClassName) . '.php';
        };
        $searchPath = $getSearchPath($class);
        $isLowerCaseClass = $class === strtolower($class);
        $caseSearch = $isLowerCaseClass ? ['none', 'ucfirst'] : ['none', 'lower', 'ucfirst'];
        foreach ($caseSearch as $isLowerCase) {
            $currentFilePath = $getFilePath($searchPath, $class, $isLowerCase);
            if (file_exists($currentFilePath)) {
                $includeStatus = include ($currentFilePath);
                return $includeStatus;
            }
        }
        // Search within directory in lower case comparison
        $otherPathInfos = pathinfo($getFilePath($searchPath, $class, 'none'));
        if ($isLowerCaseClass && is_dir($otherPathInfos['dirname'])) {
            $filesFound = array_diff(scandir($otherPathInfos['dirname']),['..', '.']);
            foreach ($filesFound as $fileFound) {
                if (strtolower($fileFound) === $otherPathInfos['basename']) {
                    $foundFilePath = $otherPathInfos['dirname'] . DIRECTORY_SEPARATOR . $fileFound;
                    $includeStatus = include ($foundFilePath);
                    return $includeStatus;
                }
            }
        }
        return FALSE;
    }
);
