<?php
/**
* ZnetDK, Starter Web Application for rapid & easy development
* See official website http://www.znetdk.fr 
* ------------------------------------------------------------
* Custom parameters of the application
* YOU CAN FREELY CUSTOMIZE THE CONTENT OF THIS FILE
*/

/** Default selected language when the browser language is not supported by the
 * application
 * @return string 2-character code in ISO 639-1, for example 'fr'
 */ 
define('CFG_DEFAULT_LANGUAGE','en');

/** Page layout chosen for the application.
 *  @return 'classic'|'office'|'custom'|'mobile' Name of the layout used by the
 *  application.
 */
define('CFG_PAGE_LAYOUT', 'mobile');

/** Relative path or URL of the W3CSS theme file */
//define('CFG_MOBILE_W3CSS_THEME','https://www.w3schools.com/lib/w3-theme-blue-grey.css');

/**
 * Relative path or URL of the CSS font file to include into the header of the
 * mobile page layout
 */
//define('CFG_MOBILE_CSS_FONT', 'https://fonts.googleapis.com/css?family=Raleway&display=swap');

/**
 * The CSS font family to apply to the '.znetdk-mobile-font' CSS class for the
 * mobile page layout
 */
//define('CFG_MOBILE_CSS_FONT_FAMILY', "'Raleway', sans-serif");

/** Relative path of the mobile page layout favicon files directory */
//define('CFG_MOBILE_FAVICON_DIR', 'applications/' . ZNETDK_APP_NAME .'/public/images/favicons');

/** Relative path of the favicon HTML code template to include in the mobile page layout */
//define('CFG_MOBILE_FAVICON_CODE_FILENAME', 'applications/' . ZNETDK_APP_NAME . '/app/layout/mobile_favicons.php');

/** Is authentication required?
 * @return boolean Value true if the user must authenticate to access to the
 *  application
 */
define('CFG_AUTHENT_REQUIRED',FALSE);

/** Specifies whether the user session expires or not
 * @return 'public'|'private' When set to 'public', the user session expires.
 * <br>When set to 'private', the user session never expires.    
 */
define('CFG_SESSION_DEFAULT_MODE','public');

/** Session Time out in minutes
 * @return integer Number of minutes without user activity before his session expires
 */
define('CFG_SESSION_TIMEOUT', 10);

/** Host name of the machine where the database MySQL is installed.
 * @return string For example, '127.0.0.1' or 'mysql78.perso'
 */
//define('CFG_SQL_HOST', '127.0.0.1');

/** TCP/IP port number on which the SQL Server listens.
 * @return string For example, '35105'
 */
//define('CFG_SQL_PORT',NULL);

/** Database which contains the tables specially created for the application.
 * @return string For example 'znetdk-db'
 */
//define('CFG_SQL_APPL_DB', 'znetdk-db');

/** User declared in the database of the application to access to the tables
 *  specially created for business needs
 * @return string For example 'app'
 */
//define('CFG_SQL_APPL_USR', 'znetdk');

/** User's password declared in the database of the application.
 * @return string For example 'password'
 */
//define('CFG_SQL_APPL_PWD', 'password');
