<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr
 * (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Main entry point of the application
 * Page encoded in UTF8 without BOM to avoid the JQuery json.parse unexpected
 * character exception.
 *
 * File version: 1.7
 * Last update: 12/15/2023
 */

/** OS root absolute path of the directory where ZnetDK is installed */
define('ZNETDK_ROOT',getcwd().DIRECTORY_SEPARATOR);
/** OS absolute path of the ZnetDK core namespace */
define('ZNETDK_CORE_ROOT',ZNETDK_ROOT.'engine'.DIRECTORY_SEPARATOR.'core');
/** OS root absolute path of the directory where the modules are installed */
define('ZNETDK_MOD_ROOT',ZNETDK_ROOT.'engine'.DIRECTORY_SEPARATOR.'modules');

/** Try to add extra paths to the 'include_path' PHP configuration option */
$initialIncludePath = get_include_path();
set_include_path(ZNETDK_CORE_ROOT);
$isIncludePathModifiable = ZNETDK_CORE_ROOT === get_include_path();
if ($isIncludePathModifiable) { // 'include_path' is modifiable...
    // Extra 'module' absolute path is added to the include path
    set_include_path(get_include_path().PATH_SEPARATOR.ZNETDK_MOD_ROOT);
}
// Autoload from absolute path, capitalized and uppercase class names are supported
include ZNETDK_CORE_ROOT . DIRECTORY_SEPARATOR . 'autoload.php';

/** Muti-application parameter (ZDK_TOOLS_DISABLED) */
include ZNETDK_ROOT . 'applications' . DIRECTORY_SEPARATOR . 'globalconfig.php';

/** Current internal name of the application */
define('ZNETDK_APP_NAME', \General::getApplicationID());
/** OS absolute path of the application namespace */
define('ZNETDK_APP_ROOT',getcwd(). DIRECTORY_SEPARATOR . \General::getApplicationRelativePath(ZNETDK_APP_NAME));
if ($isIncludePathModifiable) {
    set_include_path(get_include_path().PATH_SEPARATOR.ZNETDK_APP_ROOT);
}

// Global configuration
include ZNETDK_CORE_ROOT . DIRECTORY_SEPARATOR . 'version.php'; // Current version of ZnetDK
@include(ZNETDK_APP_ROOT . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'config.php'); // Application configuration file is optional
\General::initModuleParameters();
@include(ZNETDK_CORE_ROOT . DIRECTORY_SEPARATOR . 'config.php'); // Core configuration file is mandatory

// Start user session if the script is not called from command line
if (!isset($argc)) {
    session_start();
}

// Error tracking enabled
\ErrorHandler::init();

/** ZnetDK absolute URI, for example "/znetdk/" */
define('ZNETDK_ROOT_URI', \General::getAbsoluteURI());

/** Current application absolute URI for accessing web ressources */
define('ZNETDK_APP_URI', ZNETDK_ROOT_URI
        . \General::getApplicationPublicDirRelativeURI(ZNETDK_APP_NAME));

/** Localized strings */
\api\Locale::setApplicationLanguage();

/** Original include path is applied and is prioritary to the ZnetDK packages */
if ($isIncludePathModifiable) {
    set_include_path($initialIncludePath . PATH_SEPARATOR . get_include_path());
}
/** .htaccess file is generated if missing */
\General::generateHtaccess();

/** Current time memorized before executing the controller action */
define('ZNETDK_TIME_BEFORE_DO_ACTION', microtime(true));

/** Call of the front controller */
\MainController::doAction();

/** The PHP script configured to be executed once the controller action is done */
if (CFG_EXEC_PHP_SCRIPT_AFTER_ACTION_DONE !== NULL 
        && file_exists(CFG_EXEC_PHP_SCRIPT_AFTER_ACTION_DONE)) {
    define('ZNETDK_TIME_AFTER_DO_ACTION', microtime(true));
    define('ZNETDK_TIME_ELAPSED_FOR_ACTION', 
        round(ZNETDK_TIME_AFTER_DO_ACTION - ZNETDK_TIME_BEFORE_DO_ACTION, 3));
    require CFG_EXEC_PHP_SCRIPT_AFTER_ACTION_DONE;
}
