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
 * Core renderer of the ressource dependencies
 *
 * File version: 1.12
 * Last update: 06/11/2024
 */

/**
 * Adds the HTML dependencies to the page layout that are required by ZnetDK
 */
class Dependencies {

    /**
     * Main public method called by the Layout controller to insert the
     * HTML dependencies to the main page of the application.
     * @param string $type Optional, value 'css' or 'js'
     */
    public static function render($type = NULL) {
        $layout = \Parameters::getPageLayoutName();
        if ($layout === 'mobile') {
            // CSS rendering
            if (is_null($type) || $type === 'css') {
                self::renderCSSforMobile();
            }
            // JS rendering
            if (is_null($type) || $type === 'js') {
                self::renderJSforMobile();
            }
        } elseif (in_array($layout, ['classic', 'office', 'custom'])) {
            if (is_null($type) || $type === 'css') {
                if (CFG_NON_MOBILE_PWA_ENABLED === FALSE) {
                    $icon = defined('LC_HEAD_ICO_LOGO') ? LC_HEAD_ICO_LOGO : LC_HEAD_IMG_LOGO;
                    echo "\t\t" . '<link rel="icon" type="image/png" href="'.$icon.'">'.PHP_EOL;
                }
                self::renderCSS();
            }
            if (is_null($type) || $type === 'js') {
                self::renderJS();
            }
        } else {
            if (is_null($type) || $type === 'css') {
                $cssDependencies = [];
                echo "\t\t<!-- CSS Dependencies -->" . PHP_EOL;
                self::addModulesDependencies('css', $cssDependencies);
                self::addApplicationDependencies('css', $cssDependencies);
                self::renderDependencies('CSS', "\t\t", $cssDependencies);
            }
            if (is_null($type) || $type === 'js') {
                $jsDependencies = [];
                echo "\t\t<!-- JS Dependencies -->" . PHP_EOL;
                self::addModulesDependencies('js', $jsDependencies);
                self::addApplicationDependencies('js', $jsDependencies);
                self::renderDependencies('JS', "\t\t", $jsDependencies);
            }
        }
    }

    /**
     * Renders the specified dependencies
     * @param string $type Type of dependency: 'JS' or 'CSS'
     * @param string $leadingTabs Leading tabs: "\t" or "\t\t"
     * @param array $dependencies An array of relative file paths
     */
    static private function renderDependencies($type, $leadingTabs, $dependencies) {
        $startTag = $type === 'CSS' ? '<link rel="stylesheet" type="text/css" href="' : '<script src="';
        $endTag = $type === 'CSS' ? '">' : '"></script>';
        foreach ($dependencies as $filePath) {
            if (!self::isExternalFile($filePath) && !file_exists(ZNETDK_ROOT . $filePath)) {
                General::writeErrorLog('ZNETDK ERROR', "DEP-001: dependency missing: '{$filePath}'", TRUE);
                continue;
            }
            echo $leadingTabs . $startTag . (self::isExternalFile($filePath) ? '' : ZNETDK_ROOT_URI)
                    . $filePath . self::getFileVersion($filePath) . $endTag . PHP_EOL;
        }
    }

    /**
     * Renders the CSS dependencies
     */
    static private function renderCSS() {
        $activeTheme = ThemeManager::getActiveThemeCssFilePath();
        $cssDependencies = array(CFG_JQUERYUI_CSS, $activeTheme['cssPath'],
            CFG_PRIMEUI_CSS, CFG_FONTAWESOME_CSS, \General::getFilledMessage(CFG_ZNETDK_CSS,'primeui'),
            \General::getFilledMessage(CFG_ZNETDK_CSS,'form'));
        if (\Parameters::getPageLayoutName() !== 'custom') {
            $cssDependencies[] = \General::getFilledMessage(CFG_ZNETDK_CSS,'layout');
            $cssDependencies[] = \General::getFilledMessage(CFG_ZNETDK_CSS,'layout-'.\Parameters::getPageLayoutName());
        }
        self::addModulesDependencies('css', $cssDependencies);
        self::addApplicationDependencies('css', $cssDependencies);
        if ($activeTheme['level'] === 'application') {
            $cssDependencies[] = \General::getFilledMessage(CFG_ZNETDK_CSS,'custom-theme');
        }
        self::renderDependencies('CSS', "\t\t", $cssDependencies);
    }

    /**
     * Render the JavaScript dependencies in their minified version
     */
    static private function renderJS() {
        $jsDependencies = array(CFG_JQUERY_JS,CFG_JQUERYUI_JS,CFG_BLOCKUI_JS);
        $datePickerJS = \General::getFilledMessage(CFG_JQUERYUI_DATE_JS,LC_LANG_ISO_CODE);
        if (file_exists(ZNETDK_ROOT.$datePickerJS)) {
            $jsDependencies[] = $datePickerJS;
        }
        if (CFG_DEV_JS_ENABLED) {
            self::renderDevelopmentJS($jsDependencies);
        } else {
            $jsDependencies[] = CFG_PRIMEUI_JS;
            $jsDependencies[] = CFG_ZNETDK_JS;
        }
        self::addModulesDependencies('js', $jsDependencies);
        self::addApplicationDependencies('js', $jsDependencies);
        echo "\t\t".'<script>var znetdkAjaxURL = "'.\General::getMainScript(TRUE).'";</script>'.PHP_EOL;
        self::renderDependencies('JS', "\t\t", $jsDependencies);
    }

    /**
     * Renders the JavaScript dependencies in their extended version for
     * development purpose
     * @param array $jsDependencies Array filled with the relative path of the
     * scripts to include in the application page.
     */
    static private function renderDevelopmentJS(&$jsDependencies) {
        $extraDir = array('..', '.');
        $jsPrimeUiFiles = array_diff(scandir(ZNETDK_ROOT.CFG_PRIMEUI_JS_DEV_DIR),$extraDir);
        foreach ($jsPrimeUiFiles as $value) {
            $jsDependencies[] = CFG_PRIMEUI_JS_DEV_DIR."/".$value.'/'.$value.'.js';
        }
        $jsZnetDkFiles = array_diff(scandir(ZNETDK_ROOT.CFG_ZNETDK_JS_DIR.'/ui'),$extraDir);
        foreach ($jsZnetDkFiles as $value) {
            $jsDependencies[] = CFG_ZNETDK_JS_DIR."/ui/".$value;
        }
        $jsDependencies[] = CFG_ZNETDK_JS_DIR.'/api.js';
        $jsDependencies[] = CFG_ZNETDK_JS_DIR.'/init.js';
    }
    /**
     * Add module specific dependencies to the CSS or JS dependencies renderer.
     * @param string $subdir Subdirectory containing the files to add
     * @param array $dependencies Array containing all the dependencies to
     * render and that is to be filled in.
     */
    static private function addModulesDependencies($subdir, &$dependencies) {
        $modules = \General::getModules();
        if ($modules === FALSE) {
            return;
        }
        $extraDir = array('..', '.','minified');
        $isMinified = FALSE;
        if ($subdir === 'css') {
            $isMinified = strstr(CFG_ZNETDK_CSS,'-min.') !== FALSE;
            $subdirectory = $isMinified ? $subdir . '/minified' : $subdir;
        } else {
            $isMinified = CFG_DEV_JS_ENABLED === FALSE;
            $subdirectory = $isMinified ? $subdir . '/minified' : $subdir;
        }
        if ($isMinified) {
            self::minifyModuleDependencies($subdir);
        }
        foreach ($modules as $moduleName) {
            $directory = ZNETDK_MOD_ROOT . DIRECTORY_SEPARATOR . $moduleName
                    . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR
                    . $subdirectory;
            if (!file_exists($directory)) {
                continue;
            }
            $filesFound = array_diff(scandir($directory, SCANDIR_SORT_ASCENDING), $extraDir);
            foreach ($filesFound as $file) {
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                if ($fileExtension === $subdir && $file !== 'gulpfile.js') {
                    $dependencies[] = 'engine/modules/' . $moduleName . '/public/'
                        . $subdirectory . '/' . $file;
                }
            }
        }
    }

    static private function minifyModuleDependencies($subdir) {
        if (CFG_AUTO_MINIFICATION_METHOD === NULL) {
            return FALSE;
        }
        $method = explode('::', CFG_AUTO_MINIFICATION_METHOD);
        if (count($method) === 2 && method_exists($method[0], $method[1])) {
            $className = $method[0];
            $methodName = $method[1];
            return $className::$methodName($subdir);
        }
        return FALSE;
    }

    static private function addApplicationDependencies($type, &$dependencies) {
        if ($type === 'js' && CFG_APP_JS !== NULL && CFG_APP_JS !== '') {
            \ErrorHandler::suspend(); // Avoid E_NOTICE - unserialize(): Error at offset...
            $libraries = unserialize(CFG_APP_JS);
            \ErrorHandler::restart();
            if (!is_array($libraries)) {
                $libraries = array(CFG_APP_JS);
            }
            foreach ($libraries as $library) {
                $dependencies[] = $library;
            }
            return TRUE;
        } elseif ($type === 'css' && CFG_APPLICATION_CSS !== NULL && CFG_APPLICATION_CSS !== '') {
            \ErrorHandler::suspend(); // Avoid E_NOTICE - unserialize(): Error at offset...
            $libraries = unserialize(CFG_APPLICATION_CSS);
            \ErrorHandler::restart();
            if (!is_array($libraries)) {
                $libraries = array(CFG_APPLICATION_CSS);
            }
            foreach ($libraries as $library) {
                $dependencies[] = $library;
            }
            return TRUE;
        }
        return FALSE;
    }

    static private function isExternalFile($filePath) {
        return strpos($filePath, 'http') === 0;
    }

    static private function getFileVersion($filePath) {
        if (self::isExternalFile($filePath)) {
            return '';
        }
        $absoluteFilePath = ZNETDK_ROOT . $filePath;
        clearstatcache (TRUE, $absoluteFilePath);
        $fileTimestamp = filemtime($absoluteFilePath);
        return $fileTimestamp === FALSE ? '' : '?v=' . strval($fileTimestamp);
    }

    static private function renderCSSforMobile() {
        $cssDependencies = array(CFG_FONTAWESOME_CSS, CFG_MOBILE_W3_CSS);
        $cssDependencies[] = \General::getFilledMessage(CFG_ZNETDK_CSS, 'mobile');
        $themeCssPath = ThemeManager::getActiveThemeCssFilePath();
        if ($themeCssPath !== NULL) {
            $cssDependencies[] = $themeCssPath;
        }
        if (CFG_MOBILE_CSS_FONT !== NULL) {
            $cssDependencies[] = CFG_MOBILE_CSS_FONT;
        }
        echo "\t\t<!-- CSS Dependencies -->" . PHP_EOL;
        self::addModulesDependencies('css', $cssDependencies);
        self::addApplicationDependencies('css', $cssDependencies);
        self::renderDependencies('CSS', "\t\t", $cssDependencies);
    }

    static private function renderJSforMobile() {
        $jsDependencies = array(CFG_MOBILE_JQUERY_JS);
        if (CFG_DEV_JS_ENABLED) {
            $jsDependencies[] = CFG_ZNETDK_JS_DIR.'/mobile.js';
        } else {
            $jsDependencies[] = CFG_ZNETDK_JS_DIR.'/minified/mobile-min.js';
        }
        echo "\t\t<!-- JS Dependencies -->" . PHP_EOL;
        self::addModulesDependencies('js', $jsDependencies);
        self::addApplicationDependencies('js', $jsDependencies);
        self::renderDependencies('JS', "\t\t", $jsDependencies);
    }
}