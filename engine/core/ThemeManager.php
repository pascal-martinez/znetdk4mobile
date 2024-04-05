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
 * Core Theme API  
 *
 * File version: 1.2
 * Last update: 02/18/2024
 */

/**
 * ZnetDK core theme management API
 */

class ThemeManager {
    /**
     * Returns all the widget themes available in standard in ZnetDK
     * @return array All the widget themes
     */
    static public function getAllThemes($filenameWithExtension = TRUE, $includePath = FALSE) {
        $themes = array();
        $files = scandir(ZNETDK_ROOT . DIRECTORY_SEPARATOR . 'resources'
                . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'themes');
        if ($files) {
            foreach ($files as $fileName) {
                if (strpos($fileName,'.png') !== FALSE) {
                    $theme = array();
                    $theme['label'] = substr($fileName,0,-4);
                    $theme['value'] = $filenameWithExtension ? $fileName : $theme['label'];
                    if ($includePath) {
                        $themePath = self::getThemeCssFilePath($theme['label']);
                        $theme['cssPath'] = $themePath['cssPath'];
                    }
                    $themes[] = $theme;
                }
            }
        }
        return $themes;
    }

    /**
     * Returns the full CSS path of the active theme
     * @return string The full CSS path
     */
    static public function getActiveThemeCssFilePath() {
        $userTheme = CFG_AUTHENT_REQUIRED === FALSE 
                || !UserSession::isAuthenticated(TRUE) ? FALSE 
                : \MainController::execute('Users', 'getUserTheme');
        if (CFG_PAGE_LAYOUT === 'mobile') {
            return $userTheme === FALSE ? CFG_MOBILE_W3CSS_THEME : $userTheme;
        } else {
            $themeName = $userTheme === FALSE ? CFG_THEME : $userTheme;
            return self::getThemeCssFilePath($themeName);
        }
    }
    
    /**
     * Indicates whether the specified theme exists or not
     * @param string $themeName
     * @return boolean TRUE if theme exists
     */
    static public function doesThemeExist($themeName) {
        return self::getThemeLevel($themeName) !== 'unknown';
    }
    
    /**
     * Returns the The full CSS path of the specified theme
     * @param string $themeName The full CSS path
     */
    static private function getThemeCssFilePath($themeName) {
        $themeLevel = self::getThemeLevel($themeName);
        switch ($themeLevel) {
            case 'primeui' : $themeDir = CFG_THEME_PRIMEUI_DIR; break;
            case 'application' : $themeDir = CFG_THEME_DIR; break;
            case 'unknown' : $themeName = 'znetdk';
            case 'core' : $themeDir = CFG_THEME_ZNETDK_DIR;
        }
        return array(
            'cssPath' => $themeDir . '/' . $themeName.'/theme.css',
            'level' => $themeLevel);
    } 
    
    /**
     * Returns the origin of the widget's theme choosen for the application.
     * @param String $themeName Name of the theme
     * @return string Value 'application', 'core', 'primeui' or 'unknown'
     */
    static private function getThemeLevel($themeName) {
        if (file_exists(ZNETDK_ROOT . CFG_THEME_DIR.'/'.$themeName)) {
            return 'application';
        } elseif (file_exists(ZNETDK_ROOT . CFG_THEME_ZNETDK_DIR.'/'.$themeName)) {
            return 'core';
        } else {
            $themeDir = ZNETDK_ROOT . CFG_THEME_PRIMEUI_DIR . '/' . $themeName;
            $themeLevel = file_exists($themeDir) ? 'primeui' : 'unknown';
            if ($themeLevel === 'unknown') {
                $textError = "LAY-007: the theme named '$themeName' does not exist!";
                \General::writeErrorLog("ZNETDK ERROR", $textError, TRUE);
            }
            return $themeLevel;
        }
    }
    
}