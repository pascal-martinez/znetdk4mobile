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
* Core parameters of the applications
*
* File version: 1.17
* Last update: 10/19/2024
*/

/** Page layout chosen for the application.
 *  @return 'classic'|'office'|'custom'|'mobile' Name of the layout used by the
 *  application.
 */
define('CFG_PAGE_LAYOUT','classic');

/** Is online help enabled?
 * @return boolean TRUE when online help facility is enabled, FALSE when disabled.
 */
define('CFG_HELP_ENABLED',FALSE);

/** Relative path of the jQuery CSS file */
define('CFG_JQUERYUI_CSS','resources/jquery-ui-1.10.3/themes/base/minified/jquery-ui.min.css');

/** Relative path of the PrimeUI CSS file */
define('CFG_PRIMEUI_CSS','resources/primeui-1.1/production/primeui-1.1-min.css');

/** Relative path of the FontAwesome CSS file */
define('CFG_FONTAWESOME_CSS','resources/font-awesome-4.7.0/css/font-awesome.min.css');

/** Relative path of the W3CSS file (for mobile layout) */
define('CFG_MOBILE_W3_CSS','resources/w3css/w3.css');

/** Relative path of the ZnetDK CSS files */
define('CFG_ZNETDK_CSS','engine/public/css/minified/%1-min.css');

/** Relative path of the CSS file specially developed for the application
 * Extra CDN CSS libraries can also be included in the application by
 * specifying its URL (for example 'https://extracsslibrary.net/lib.css').
 * At last, several libraries can be set using a serialized array. For example:
 * <code>serialize(array(
 *      'applications/' . ZNETDK_APP_NAME . '/public/css/myscript.css',
 *      'https://extracsslibrary.net/lib.css'))</code>
 */
define('CFG_APPLICATION_CSS',NULL);

/** Relative path of the directory containing the pictures displayed by ZnetDK */
define('CFG_ZNETDK_IMG_DIR','engine/public/images');

/** Relative path of the animated GIF image displayed during AJAX requests */
define('CFG_AJAX_LOADING_IMG',CFG_ZNETDK_IMG_DIR.'/ajax-loader.gif');

/** The HTML element displayed during AJAX requests */
define('CFG_MOBILE_AJAX_LOADER_HTML_ELEMENT', '<div class="zdk-ajax-loader w3-border-theme"></div>');

/** Relative path of the mobile page layout favicon files directory */
define('CFG_MOBILE_FAVICON_DIR',CFG_ZNETDK_IMG_DIR.'/favicons');

/** Relative path of the favicon HTML code template to include in the mobile page layout */
define('CFG_MOBILE_FAVICON_CODE_FILENAME', 'engine/core/layout/mobile_favicons.php');

/** Relative path of the Service Worker JavaScript file to launch (NULL if execution is disabled) */
define('CFG_MOBILE_SERVICE_WORKER_URL', 'service-worker.js');

/** Enables automatic display of a message to install App when mobile page layout is configured */
define('CFG_MOBILE_INSTALL_MESSAGE_DISPLAY_AUTO', TRUE);

/** Enables PWA features (favicons and service worker) on non-mobile applications
 * (when CFG_PAGE_LAYOUT is set to 'classic', 'office' or 'custom')
 */
define('CFG_NON_MOBILE_PWA_ENABLED', FALSE);

/** Relative path of the ZnetDK errors log file */
define('CFG_ZNETDK_ERRLOG','engine'. DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'errors.log');

/** Relative path of the ZnetDK system log file */
define('CFG_ZNETDK_SYSLOG','engine'. DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'system.log');

/** Relative path of users directory connected to ZnetDK */
define('CFG_ZNETDK_LOGIN_LOG_DIR', 'engine'. DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'login');

/** Relative path of the jQuery Javascript file */
define('CFG_JQUERY_JS','resources/jquery/jquery-1.12.4.min.js');

/** Relative path of the jQuery Javascript file for Mobile page layout */
define('CFG_MOBILE_JQUERY_JS', 'resources/jquery/jquery-3.7.1.min.js');

/** Relative path of the jQueryUI Javascript file */
define('CFG_JQUERYUI_JS','resources/jquery-ui-1.10.3/ui/minified/jquery-ui.min.js');

/** Relative path of the jQueryUI date picker calendar */
define('CFG_JQUERYUI_DATE_JS','resources/jquery-ui-1.10.3/ui/minified/i18n/jquery.ui.datepicker-%1.min.js');

/** Relative path of the PrimeUI directory */
define('CFG_PRIMEUI_DIR','resources/primeui-1.1');

/** Relative path of the PrimeUI Javascript file */
define('CFG_PRIMEUI_JS',CFG_PRIMEUI_DIR.'/production/primeui-1.1-min.js');

/** Relative path of the PrimeUI Javascript development directory */
define('CFG_PRIMEUI_JS_DEV_DIR',CFG_PRIMEUI_DIR.'/development/js');

/** Relative path of the BlockUI Javascript file */
define('CFG_BLOCKUI_JS','resources/blockui-2.66/blockui.js');

/** Relative path of the ZnetDK Javascript directory */
define('CFG_ZNETDK_JS_DIR','engine/public/js');

/** Relative path of the ZnetDK Javascript file */
define('CFG_ZNETDK_JS',CFG_ZNETDK_JS_DIR.'/minified/znetdk-min.js');

/** Relative path of the JavaScript file specially developed for the application
 * Extra CDN JavaScript libraries can also be included in the application by
 * specifying its URL (for example 'https://extrajslibrary.net/lib.js').
 * At last, several libraries can be set using a serialized array. For example:
 * <code>serialize(array(
 *      'applications/' . ZNETDK_APP_NAME . '/public/js/myscript.js',
 *      'https://extrajslibrary.net/lib.js'))</code>
 */
define('CFG_APP_JS',NULL);

/** Load Development version of the PrimeUI & ZnetDK widgets for debug purpose */
define('CFG_DEV_JS_ENABLED',FALSE);

/**
 * Show technical error details from the end user.
 * @return Boolean This parameter is FALSE by default (technical error details
 * are hidden).
 */
define('CFG_DISPLAY_ERROR_DETAIL', FALSE);

/** Class and method to call for minifying the CSS and JS libraries before
 *  rendering the dependencies.
 * @return string The minification PHP method to call or NULL (the default value)
 * if no minification is required.
 * Example: 'zdkminify\mod\MinifyManager::minifyModuleDependencies'
 */
define('CFG_AUTO_MINIFICATION_METHOD', NULL);

/** Is multilingual translation enabled for your application?
 * @return boolean Value TRUE if multilingual is enabled
 */
define('CFG_MULTI_LANG_ENABLED',FALSE);

/** Default selected language when the browser language is not supported by the
 * application
 * @return string 2-character code in ISO 639-1, for example 'fr'
 */
define('CFG_DEFAULT_LANGUAGE','en');

/** Labels displayed for selecting a translation language of the application
 * @return array Serialized array of language labels where each key is a
 *  2-character code in ISO 639-1.<br>For example:
 * <code>serialize(array('fr'=>'Français','en'=>'English',
 * 'es'=>'Español'))</code>
 */
define('CFG_COUNTRY_LABELS', serialize(array('fr'=>'Français','en'=>'English','es'=>'Español')));

/** Relative path of the directory where country icons are located
 * @return array Serialized array of paths where each key is a
 *  2-character code in ISO 639-1.<br>For example:
 * <code>serialize(array(
 * 'fr'=>CFG_ZNETDK_IMG_DIR.'/lang_flag_fr.png',
 * 'en'=>CFG_ZNETDK_IMG_DIR.'/lang_flag_en.png',
 * 'es'=>CFG_ZNETDK_IMG_DIR.'/lang_flag_es.png'))</code>
 */
define('CFG_COUNTRY_ICONS', serialize(array('fr'=>CFG_ZNETDK_IMG_DIR.'/lang_flag_fr.png','en'=>CFG_ZNETDK_IMG_DIR.'/lang_flag_en.png','es'=>CFG_ZNETDK_IMG_DIR.'/lang_flag_es.png')));

/** Set a version number for the application
 * This version is used to force application reloading in the web browser if the
 * current application's version in the web browser is not the latest.
 * This parameter is ignored if CFG_VIEW_PAGE_RELOAD is TRUE.
 * @return integer Version of the application
 */
define('CFG_APPLICATION_VERSION', 1);

/** Specify if the application is in maintenance mode or not.
 * In maintnenance mode, access to the application is unavailable and the
 * 'engine/core/view/maintenance.php' core view is displayed to inform users
 * that they have to wait until the end of the maintenance work.
 * The displayed message can be customized by setting the LC_MSG_ERR_MAINTENANCE
 * PHP constant in the 'locale.php' script of the application.
 * @return boolean Value TRUE to enable maintenance mode.
 */
define('CFG_IS_IN_MAINTENANCE', FALSE);

/** Session Time out in minutes
 * @return integer Number of minutes without user activity before his session expires
 */
define('CFG_SESSION_TIMEOUT',10);

/** Specifies whether the user session expires or not
 * @return 'public'|'private' When set to 'public', the user session expires.
 * <br>When set to 'private', the user session never expires.
 */
define('CFG_SESSION_DEFAULT_MODE','public');

/** Specifies if the user can change the session expiration mode
 * @return boolean Value TRUE if the user is authorized to change the way his
 *  session expires when the login dialog is displayed.<br>Value FALSE if the
 *  user can't do it. In this last case, the session expiration mode imposed to
 *  the user is the one specified for the parameter CFG_SESSION_DEFAULT_MODE
 */
define('CFG_SESSION_SELECT_MODE',TRUE);

/**
 * Specifies whether the user can open one or more sessions with their personal
 * login ID.
 * @return boolean value TRUE (by default) to enforce a single user session per
 * login ID.
 */
define('CFG_SESSION_ONLY_ONE_PER_USER', TRUE);

/** Is authentication required?
 * @return boolean Value TRUE if the user must authenticate to access to the
 *  application
 */
define('CFG_AUTHENT_REQUIRED',FALSE);

/** Validity period in months of the password before its expiration
 * @return integer Number of months before the password expires
 */
define('CFG_DEFAULT_PWD_VALIDITY_PERIOD',6);

/** Regular expression used to check globally if a new entered password is valid
 * @return string|NULL Regular expression for new password checking.
 * If NULL, no global checking is carried out (see indivual checking PHP
 * constants starting by CFG_CHECK_PWD_*).
 * For example:
 * '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d!*+.\-_\/;@#\?%\$&\'"=,:]{8,}$/'
 * - Minimum 8 characters, at least 1 uppercase letter, 1 lowercase letter
 * and 1 number.
 * - The following special characters are allowed: !*+-/=.,;:_@#?%"'$&
 */
define('CFG_CHECK_PWD_VALIDITY', NULL);

/**
 * Checks the password length via Regular Expression
 * @return string|NULL The regular expression as string. If NULL, password
 * length is not checked.
 * For example: '.{8,}' for a minimum length of 8 characters.
 */
define('CFG_CHECK_PWD_LENGTH_REGEXP', '.{8,}');

/**
 * Checks lowercase letter existence in the password via Regular Expression
 * @return string|NULL The regular expression as string. If NULL, no checking is
 * carried out.
 * For example: '[a-z]' for at least one lowercase letter.
 */
define('CFG_CHECK_PWD_LOWERCASE_REGEXP', '[a-z]');

/**
 * Checks uppercase letter existence in the password via Regular Expression
 * @return string|NULL The regular expression as string. If NULL, no checking is
 * carried out.
 * For example: '[A-Z]' for at least one uppercase letter.
 */
define('CFG_CHECK_PWD_UPPERCASE_REGEXP', '[A-Z]');

/**
 * Checks number existence in the password via Regular Expression
 * @return string|NULL The regular expression as string. If NULL, no checking is
 * carried out.
 * For example: '[0-9]' for at least one number.
 */
define('CFG_CHECK_PWD_NUMBER_REGEXP', '[0-9]');

/**
 * Checks special character existence in the password via Regular Expression
 * @return string|NULL The regular expression as string. If NULL, no checking is
 * carried out.
 * For example: '[#.?!@$%^&*-]' for at least one special character.
 */
define('CFG_CHECK_PWD_SPECIAL_REGEXP', NULL);

/** Number of attempts allowed to user to type in his password successfully
 * before their account being disabled.
 * @return integer Number of login attempts allowed to user. If is 0, account is
 * never disabled.
 */
define('CFG_NBR_FAILED_AUTHENT', 0);

/**
 * Number of login attempts before login lockout
 * @return integer Positive number of login attempts.
 */
define('CFG_LOGIN_THROTTLING_ATTEMPTS_BEFORE_LOCKOUT', 5);

/**
 * Duration in seconds of the login lockout.
 * @return integer Number of seconds.
 */
define('CFG_LOGIN_THROTTLING_LOCKOUT_DELAY', 60);

/**
 * Time window during which the number of failed connections must not exceed the
 * maximum number set through the CFG_LOGIN_THROTTLING_ATTEMPTS_BEFORE_LOCKOUT
 * parameter.
 * @return integer Number of seconds.
 */
define('CFG_LOGIN_THROTTLING_ATTEMPTS_WINDOW_TIME', 30);

/** Displays a 'Forgot your password?' anchor on the login form
 * @return boolean Anchor visible when set to TRUE (FALSE by default)
 */
define('CFG_FORGOT_PASSWORD_ENABLED', FALSE);

/** Traces in ZnetDK system log file the requests for a new password in the
 *  event of a forgotten password
 * @return boolean Requests are traced when set to TRUE (FALSE by default)
 */
define('CFG_FORGOT_PASSWORD_REQUEST_TRACE_ENABLED', FALSE);

/** Is view content preloaded before access?
 * @return boolean Value TRUE if all the views of the application are to be
 * preloaded as soon as the application is loaded in the user's browser.
 */
define('CFG_VIEW_PRELOAD',FALSE);

/** Is page reloaded each time a view is opened from the navigation menu?
 * @return boolean Value TRUE if the page of the application is to be reloaded
 * when the user click on a menu item. This case is suitable for content
 *  publishing.
 */
define('CFG_VIEW_PAGE_RELOAD',FALSE);

/** SQL engine of the databases used by ZnetDK */
define('CFG_SQL_ENGINE','mysql');

/** Host name of the machine where the database MySQL is installed.
 * @return string For example, '127.0.0.1' or 'mysql78.perso'
 */
define('CFG_SQL_HOST',NULL);

/** TCP/IP port number on which the SQL Server listens.
 * @return string For example, '35105'
 */
define('CFG_SQL_PORT',NULL);

/** Database which contains the core tables of ZnetDK.
 * @return string For example 'znetdk-core'
 */
define('CFG_SQL_CORE_DB',NULL);

/** Prefixes to replace from the ZnetDK core and application tables (for hosting
 * multiple applications in a unique database).
 * Multiple prefix replacements can be set through the serialized array.
 * @return string For example: serialize(array('zdk_'=>'new_', 'app_'=>'new_'))
 */
define('CFG_SQL_TABLE_REPLACE_PREFIXES',NULL);

/** User declared in the core database to access to the tables dedicated to
 *  ZnetDK
 * @return string For example 'core'
 */
define('CFG_SQL_CORE_USR',NULL);

/** User's password declared in the core database
 * @return string For example 'password'
 */
define('CFG_SQL_CORE_PWD',NULL);

/** Database which contains the tables specially created for the application.
 * @return string For example 'znetdk-app'
 */
define('CFG_SQL_APPL_DB',NULL);

/** User declared in the database of the application to access to the tables
 *  specially created for business needs
 * @return string For example 'app'
 */
define('CFG_SQL_APPL_USR',NULL);

/** User's password declared in the database of the application.
 * @return string For example 'password'
 */
define('CFG_SQL_APPL_PWD',NULL);

/** When set to TRUE, all SQL requests executed by the \DAO class are traced
 * into the system log file (see CFG_ZNETDK_SYSLOG parameter).
 * @return boolean Disabled by default (value FALSE)
 */
define('CFG_SQL_TRACE_ENABLED', FALSE);

/** Relative path of the directory where are installed the PrimeUI themes */
define('CFG_THEME_PRIMEUI_DIR',CFG_PRIMEUI_DIR.'/themes');

/** Relative path of the directory where are installed the ZnetDK themes */
define('CFG_THEME_ZNETDK_DIR','engine/public/themes');

/** Relative path of the directory where is installed the custom theme specified
 *  for the parameter CFG_THEME_DIR
 *  @return string For example 'applications/default/public/themes'
 */
define('CFG_THEME_DIR','applications/'.ZNETDK_APP_NAME.'/public/themes');

/** Relative path of the directory where are stored the electronic documents
 *  @return string For example '/home/www/znetdk/applications/default/documents'
 */
define('CFG_DOCUMENTS_DIR',ZNETDK_APP_ROOT . DIRECTORY_SEPARATOR . 'documents');

/** Theme enabled for the application ('znetdk' in standard)
 * @return string Name of the theme chosen for the application.<br>
 * For example: 'znetdk', 'flat-blue', 'aristo', 'south-street' ...
 */
define('CFG_THEME','znetdk');

/** Relative path or URL of the W3CSS theme file
 * @return string Set by default to the 'w3-theme-blue.css' W3.CSS blue theme
 */
define('CFG_MOBILE_W3CSS_THEME','resources/w3css/themes/z4m-theme.css');

/**
 * Is dark theme enabled?
 * @return boolean If TRUE, dark theme is enabled
 */
define('CFG_MOBILE_W3CSS_THEME_IS_DARK', FALSE);

/** W3CSS theme color scheme
 * @return array W3CSS color classes applied to UI areas and components
 */
define('CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME', [
    'banner' => 'w3-theme-d2', 'footer' => 'w3-theme',
    'footer_border_top' => 'w3-border-theme',
    'content' => 'w3-theme-light',
    'vertical_nav_menu' => 'w3-theme-l4','horizontal_nav_menu' => 'w3-theme-l4',
    'nav_menu_hover' => 'w3-hover-theme',
    'nav_menu_select' => 'w3-theme-l3', 'nav_menu_close' => 'w3-text-theme',
    'nav_menu_bar_select' => 'w3-border-theme',
    'install' => 'w3-light-gray', 'install_border' => 'w3-border-dark-gray',
    'install_txt' => 'w3-text-dark-gray',
    'btn_action' => 'w3-theme-action', 'btn_refresh' => 'w3-green',
    'btn_search' => 'w3-blue', 'btn_yes' => 'w3-green', 'btn_no' => 'w3-red',
    'btn_scrollup' => 'w3-light-grey', 'btn_next_rows' => 'w3-theme-action',
    'btn_hover' => 'w3-hover-theme',
    'btn_submit' => 'w3-green', 'btn_cancel' => 'w3-red',
    'btn_logout' => 'w3-orange', 'search_criterium' => 'w3-blue',
    'search_sort' => 'w3-yellow',
    'msg_critical' => 'w3-blue-grey', 'msg_error' => 'w3-red',
    'msg_warn' => 'w3-yellow', 'msg_info' => 'w3-blue',
    'msg_success' => 'w3-green',
    'modal_header' => 'w3-theme-dark',
    'modal_content' => 'w3-theme-light',
    'modal_footer' => 'w3-theme-l4',
    'modal_footer_border_top' => 'w3-border-theme',
    'autocomplete_hover' => 'w3-hover-theme',
    'autocomplete_select' => 'w3-theme-dark',
    'list_row_hover' => 'w3-hover-light-grey', 'filter_bar' => 'w3-theme',
    'list_border_bottom' => 'w3-border-theme',
    'tag' => 'w3-theme', 'icon' => 'w3-text-theme',
    'form_title' => 'w3-text-theme',
    'form_title_border_bottom' => 'w3-border-theme'
]);

/**
 * Relative path or URL of the CSS font file to include into the header of the
 * mobile page layout
 * @return string The relative file path of the Exo font.
 */
define('CFG_MOBILE_CSS_FONT', 'resources/googlefonts/exo-v7-latin-regular.css');

/**
 * The CSS font family to apply to the '.znetdk-mobile-font' CSS class for the
 * mobile page layout
 * @return string The font family as set for the 'font-family' CSS property.
 */
define('CFG_MOBILE_CSS_FONT_FAMILY', "'Exo', sans-serif");

/** The PHP binary full path with its arguments for the auto-execution of the
 * 'autoexec' controller action as a background process
 * Use %1 as placeholder of the absolute path of the application root directory
 * (value of ZNETDK_ROOT),
 * Use %2 as placeholder of the ZnetDK 'index.php' script,
 * Use %3 as placeholder of the 'autoexec' argument passed to the 'index.php'
 * script,
 * Use %4 as placeholder of the application ID argument (value of
 * ZNETDK_APP_NAME) passed to the 'index.php' script.
 * @return string The full path of the PHP interpreter binary<br>
 * For example on linux: '/usr/bin/php %1%2 %3 %4 >/dev/null 2>&1 &'<br>
 * For example on Windows: 'start "" /B "php" "%2" "%3" "%4" >NUL 2>&1'<br>
 * For debuging :
 * - On linux: 'XDEBUG_CONFIG="idekey=netbeans-xdebug" /usr/bin/php ...'
 * - On Windows: 'SET XDEBUG_CONFIG=idekey=netbeans-xdebug & start ...'
 */
define('CFG_AUTOEXEC_PHP_BINARY_PATH', NULL);

/** The time elapsed in seconds before the next auto-execution of the 'autoexec'
 *  controller action as a background process
 * @return integer Time elapsed in seconds before next execution<br>
 * For example : 3600 for one hour<br>
 */
define('CFG_AUTOEXEC_FREQUENCY', 3600);

/** The full path of the synchronization file where are stored the last date and
 * time when the the autoexec controller action has been launched
 * @return string Absolute file path of the synchronization autoexec file
 */
define('CFG_AUTOEXEC_SYNCHRO_FILE', ZNETDK_ROOT . 'engine'
        . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR . 'autoexec.sync');

/** Enables or Disables the tracking of the 'autoexec' process through the
 * system log file
 * @return boolean TRUE for tracking the execution of the 'autoexec' process,
 * otherwise FALSE.
 */
define('CFG_AUTOEXEC_LOG_ENABLED', FALSE);

/** The PHP binary full path with its arguments for executing asynchronously a
 * controller action as command line background process.
 * Use %1 as placeholder of the absolute path of the application root directory
 * (value of ZNETDK_ROOT),
 * Use %2 as placeholder of the ZnetDK 'index.php' script,
 * Use %3 as placeholder of the 'async' argument,
 * Use %4 as placeholder of the application ID argument (ZNETDK_APP_NAME),
 * Use %5 as placeholder of the user login name,
 * Use %6 as placeholder of the process key (for authentication),
 * Use %7 as placeholder of the controller name,
 * Use %8 as placeholder of the action name,
 * Use %9 as placeholder of the string parameters to pass to the controller
 *  action.
 * @return string The full path of the PHP interpreter binary<br>
 * For example on linux: '/usr/bin/php %1%2 %3 %4 %5 %6 %7 %8 "%9"
 * >/dev/null 2>&1 &'<br>
 * For example on Windows: 'start "" /B "php" "%2" "%3" "%4" "%5" "%6" "%7" "%8"
 * "%9" >NUL 2>&1'<br>
 * For debuging :
 * - On linux: 'XDEBUG_CONFIG="idekey=netbeans-xdebug" /usr/bin/php ...'
 * - On Windows: 'SET XDEBUG_CONFIG=idekey=netbeans-xdebug & start ...'
 */
define('CFG_ASYNCEXEC_PHP_BINARY_PATH', NULL);

/** Directory where are written the asynchronous process authentication files
 * @return Set by default to the 'engine/log' directory
 */
define('CFG_ASYNCEXEC_AUTHENTICATION_PATH', ZNETDK_ROOT . 'engine'. DIRECTORY_SEPARATOR . 'log');

/** Enables or Disables the tracking of the asynchronous processes through the
 * system log file
 * @return boolean TRUE for tracking the execution of the asynchronous processes,
 * otherwise FALSE.
 */
define('CFG_ASYNCEXEC_LOG_ENABLED', FALSE);

/** Allows or prevents search engines to index and list the application
 * @return boolean TRUE for allowing indexing and listing (the default behavior)
 * or FALSE for disabling indexing and listing (default value).
 */
define('CFG_SEARCH_ENGINES_INDEXING_ENABLED', TRUE);

/**
 * Enables or disables the HTTP basic authentication method for executing a
 * controller action as a web service.
 * @return boolean TRUE for allowing the HTTP basic authentication, otherwise
 * FALSE (the default value).
 */
define('CFG_HTTP_BASIC_AUTHENTICATION_ENABLED', FALSE);

/**
 * Defines the controller actions that the users can execute when it is
 * authenticated by the HTTP basic authentication.
 * @return string A serialized indexed array where each key matches an allowed
 * user login name and the associated value is the allowed controller action
 * as a string separated by a colon character (i.e ':'). When set to NULL (the
 * default value), no action can be executed.
 * Value example: serialize(array('user1|controller1:doaction1',
 *                                'user2|controller2:otheraction'))
 */
define('CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS', NULL);

/**
 * Enables or disables the ability to download a file from a HTTP POST request.
 * @return boolean TRUE for allowing the download through POST method, otherwise
 * FALSE (default value).
 */
define('CFG_DOWNLOAD_AS_POST_REQUEST_ENABLED', FALSE);

/**
 * Defines the filtering level applied by default when reading HTTP request
 * variables by calling the \Request() getter method (i.e $request->my_var).
 * @return string 'HIGH' (remove content between 'lower than' and 'greater than'
 * characters, NUL characters but preserves quotes) or 'LOW' (PHP strip_tags()
 * function is applied). If 'NONE', no filter is applied.
 */
define('CFG_REQUEST_VARIABLE_FILTERING_LEVEL', 'HIGH');

/**
 * Defines the file path of the PHP script to run after a controller action has
 * been done.
 * This parameter can be useful to measure performance of a given controller
 * action (see ZNETDK_TIME_ELAPSED_FOR_ACTION PHP constant) or to track activity
 * of a given user.
 * @return string File path of the PHP script or NULL (by default) if no script
 * is to execute once the controller action is done.
 * For example: ZNETDK_APP_ROOT . '/app/myscript.php'
 */
define('CFG_EXEC_PHP_SCRIPT_AFTER_ACTION_DONE', NULL);

/**
 * Specifies whether to load the JS dependencies from the head tag or at the end
 * of the body tag.
 * @return boolean TRUE to load the JS dependencies from the head tag, otherwise
 * FALSE (by default) to load them at the end of the body tag.
 */
define('CFG_LOAD_JS_DEPENDENCIES_FROM_HTML_HEAD', FALSE);