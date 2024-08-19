<?php

/*
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
 * Core parameters access
 *
 * File version: 1.3
 * Last update: 06/09/2024
 */

/**
 * ZnetDK configuration parameters API
 */
class Parameters {
    /**
     * Checks whether the parameter in the 'config.php' file is properly set.
     * @param string $name Parameter name to check.
     * @throws \Exception Thrown is parameter is not supported (PRM-001), is null
     * (PRM-002) or is empty (PRM-003).
     */
    static public function checkConfigParameter($name) {
        $message = NULL;
        if (!defined($name)) {
            $message = "PRM-001: parameter '$name' is not supported by ZnetDK!";
        } elseif (constant($name) === NULL) {
            $message = "PRM-002: parameter '$name' is not defined in the 'config.php' file of the application!";
        } elseif (constant($name) === '') {
            $message = "PRM-003: parameter '$name' is empty in the 'config.php' file of the application!";
        }
        if (!is_null($message)) {
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        }
    }

    /**
     * Returns the configured page layout name
     * @return string Page layout name
     */
    static public function getPageLayoutName() {
        return CFG_PAGE_LAYOUT;
    }

    /**
     * Checks if the configured page layout is valid
     */
    static public function checkIfPageLayoutNameIsValid() {
        $currentPageLayout = self::getPageLayoutName();
        if ($currentPageLayout !== CFG_PAGE_LAYOUT) {
            \General::writeErrorLog('ZNETDK ERROR', "LAY-001: the page layout '" . CFG_PAGE_LAYOUT .
                "' set for the parameter 'CFG_PAGE_LAYOUT' is not allowed! " .
                "The page layout '".$currentPageLayout."' has been loaded instead.", TRUE);
        }
    }

    /**
     * Checks whether the application is configured for page reloading
     * @return boolean TRUE if the application main page is to be reloaded for
     * displaying a new view.
     */
    static public function isSetPageReload($silent = TRUE) {
        if (!$silent) {
            if (CFG_VIEW_PAGE_RELOAD && CFG_AUTHENT_REQUIRED) { // Not supported if authentication is enabled
                $msg = "PRM-004: the 'CFG_VIEW_PAGE_RELOAD' parameter can't be set to TRUE while "
                        . "the 'CFG_AUTHENT_REQUIRED' parameter is set to TRUE! Please, review the application settings.";
            } elseif (CFG_VIEW_PAGE_RELOAD && CFG_VIEW_PRELOAD) {
                $msg = "PRM-005: the 'CFG_VIEW_PAGE_RELOAD' parameter can't be set to TRUE while "
                        . "the 'CFG_VIEW_PRELOAD' parameter is set to TRUE! Please, review the application settings.";
            } elseif (CFG_VIEW_PAGE_RELOAD && CFG_PAGE_LAYOUT === 'office') {
                $msg = "PRM-006: the 'CFG_VIEW_PAGE_RELOAD' parameter can't be set to TRUE while "
                        . "the 'CFG_PAGE_LAYOUT' parameter is set to 'office'! Please, review the application settings.";
            }
            if (isset($msg)) {
                throw new \ZDKException($msg);
            }
        }
        return CFG_VIEW_PAGE_RELOAD && !CFG_AUTHENT_REQUIRED;
    }

    /**
     * Checks whether the user is to be authenticated to use the application
     * @return TRUE if authentication is required, FALSE otherwise
     */
    static public function isAuthenticationRequired() {
        return CFG_AUTHENT_REQUIRED === TRUE;
    }

}
