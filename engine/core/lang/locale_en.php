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
* Core english translations of the application
*
* File version: 1.22
* Last update: 12/15/2024
*/

/* General PHP localization settings (used by the PHP 'setlocale' function) */
define ('LC_LOCALE_ALL', serialize(array('en_US.UTF-8', 'English_United States.1252', 'en_US', 'english')));

/* Overriden localization settings (instead of the 'setlocale' settings) */
define('LC_LOCALE_DECIMAL_SEPARATOR', NULL);
define('LC_LOCALE_THOUSANDS_SEPARATOR', NULL);
define('LC_LOCALE_NUMBER_OF_DECIMALS', NULL);
define('LC_LOCALE_CURRENCY_SYMBOL', NULL);
define('LC_LOCALE_CURRENCY_SYMBOL_PRECEDE', NULL);
define('LC_LOCALE_CURRENCY_SYMBOL_SEPARATE', NULL);
define('LC_LOCALE_DATE_FORMAT', NULL);
define('LC_LOCALE_CSV_SEPARATOR', ',');

/* jQueryUI datePicker language ISO code */
define('LC_LANG_ISO_CODE','en');

/* General labels */
define('LC_PAGE_TITLE','ZnetDK application');

/* Header labels */
define('LC_HEAD_TITLE','ZnetDK core application');
define('LC_HEAD_SUBTITLE','Ready for development...');
define('LC_HEAD_LNK_LOGOUT','Logout');
define('LC_HEAD_LNK_HELP','Help');
define('LC_HEAD_USERPANEL_MY_USER_RIGHTS','My user rights');
define('LC_HEAD_USERPANEL_INSTALL','Installation');
define('LC_HEAD_USERPANEL_UNINSTALL','Uninstallation');

/* Header images */
define('LC_HEAD_IMG_LOGO_LINK_TITLE', 'Back to Home');
define('LC_HEAD_IMG_LOGO',ZNETDK_ROOT_URI . CFG_ZNETDK_IMG_DIR . '/logoznetdk.svg?v=1');

/* Footer labels */
define('LC_FOOTER_LEFT',"Version ".ZNETDK_VERSION);
define('LC_FOOTER_CENTER','Copyright 2014-2025 Pascal MARTINEZ');
define('LC_FOOTER_RIGHT','Realized with <a href="https://www.znetdk.fr" target="_blank">ZnetDK</a>');

/* User Panel Installation labels */
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL', 'Install the app...');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS', 'Helpful infos');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_IS_INSTALLED', 'Your application is already installed.');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLED', 'Your application is not yet installed. Tap the <b>'
        . LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL . '</b> button below to install it.');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLABLE', 'Your application must be installed manually. See <b>'
        . LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS . '</b> below.');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_INTERNET_ADDRESS', 'Internet address');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_INTERNET_ADDRESS', 'The <i>internet address</i> to enter in the <b>address bar</b> of your web browser is: %1');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_COPY_CLIPBOARD', 'Tap the button below to copy the <i>internet address</i> to the <b>clipboard</b>.');
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_COPY_CLIPBOARD', 'Copy to the clipboard');
define('LC_HEAD_USERPANEL_INSTALL_SUCCESS_COPY_CLIPBOARD', 'Address copied to the clipboard.');
define('LC_HEAD_USERPANEL_INSTALL_FAILED_COPY_CLIPBOARD', 'Copy to clipboard failed!');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_SEND_SMS', 'Tap the button below to send the <i>internet address</i> by SMS.');
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_SEND_SMS', 'Send by SMS...');
define('LC_HEAD_USERPANEL_INSTALL_MSG_SEND_SMS', 'Here is the web address of the [%1] application: %2');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_INSTALL_APPLE', 'Install on Apple iOS');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_INSTALL_APPLE', 'To install your App on <b>iPhone</b> or <b>iPad</b>, open your <b>Safari</b> browser and enter the <i>internet address</i> of the application in the <b>address bar</b>.<br>Once the application is loaded, tap the %1 button and choose <b>Add to Home Screen</b> in the menu.');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_COMPATIBILITY', 'Compatibility');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_COMPATIBILITY', 'Your app can only be installed on the following <b>platforms</b> and <b>web browsers</b>.');
define('LC_HEAD_USERPANEL_INSTALL_SEE_COMPATIBILITY', 'See');

define('LC_HEAD_USERPANEL_UNINSTALL_TEXT_GENERAL', 'To <b>uninstall your App</b>, from the <b>home screen</b>, hold your finger on the <b>App icon</b> for a few seconds until a menu appears. Then choose <b>uninstall</b> or <b>remove</b>.');
define('LC_HEAD_USERPANEL_UNINSTALL_TEXT_SPECIFIC', 'On some web browsers, Apps can be uninstalled from a <b>dedicated page</b> (<i>copy and paste the link below in the address bar of the given browser</i>):');

/* Home page labels */
define('LC_HOME_WELCOME','Welcome to ZnetDK');
define('LC_HOME_LEGEND_DBSTATUS','Status of the application database');
define('LC_HOME_TXT_DB_SETTINGS1','Settings');
define('LC_HOME_TXT_DB_SETTINGS2','user = <strong>'.CFG_SQL_APPL_USR.'@'.CFG_SQL_HOST
        .'</strong>, database = <strong>'. CFG_SQL_APPL_DB .'</strong>');
define('LC_HOME_TXT_DB_CONNECT1','Connection to the database');
define('LC_HOME_TXT_DB_CONNECT2_OK','<span class="success">tested successfully</span>');
define('LC_HOME_TXT_DB_CONNECT2_KO','<span class="failed">failed to connect</span>');
define('LC_HOME_TXT_DB_TABLES1','Security tables');
define('LC_HOME_TXT_DB_TABLES2_OK','<span class="success">properly installed</span>');
define('LC_HOME_TXT_DB_TABLES2_KO','<span class="failed">error detected</span>');
define('LC_HOME_DATABASE_ERROR','Error: ');

define('LC_HOME_LEGEND_START','Start your development with ZnetDK');
define('LC_HOME_TXT_START_MENU1',"Menu definition");
define('LC_HOME_TXT_START_MENU2',"the application's menu currently displayed is configured into the <strong>"
        . ZNETDK_APP_ROOT . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "menu.php</strong>"
        . " and can be totally customized to display your new developed views.");
define('LC_HOME_TXT_START_CONCEPTS1','Concepts, Tutorial & Demos');
define('LC_HOME_TXT_START_CONCEPTS2','you will find on the official website '
        . 'a presentation of the <a href="http://www.znetdk.fr/concepts" target="_blank">ZnetDK concepts</a>, '
        . 'a <a href="http://www.znetdk.fr/tutoriel" target="_blank">tutorial</a> '
        . 'and several <a href="http://www.znetdk.fr/demonstration" target="_blank">demonstrations</a>.');
define('LC_HOME_TXT_START_API1','API reference');
define('LC_HOME_TXT_START_API2','the full development API in <a href="http://www.znetdk.fr/api" target="_blank">PHP</a> '
        . 'and <a href="http://www.znetdk.fr/api#local_api" target="_blank">JavaScript</a> is also available on the website, '
        . 'including the documentation about the <a href="http://www.znetdk.fr/composants_graphiques" target="_blank">ZnetDK widgets</a>.');

/* Theme page label */
define('LC_THEME_MESSAGE','Click on a <strong>theme thumbnail</strong> below to see its appearance into your application.'
	.'<br/>You can also edit one of these themes or <strong>create your own theme</strong> from the jQuery UI page <a href="http://jqueryui.com/themeroller/" target="_blank">ThemeRoller</a>...');

/* Widgets page label */
define('LC_WIDGETS_MESSAGE',"Find here a sample of the <strong>PrimeUI widgets</strong> with which you can develop your client-side applications' views."
        . '<br>See a demonstration of all the <strong>available widgets</strong> on the official <a href="http://www.primefaces.org/primeui/" target="_blank">PrimeUI website</a>.');

/* Windows manager labels */
define('LC_WINMGR_TITLE',"Windows");
define('LC_WINMGR_AUTOCLOSE',"Auto-closing");
define('LC_WINMGR_ADJUST_HORIZ',"Adjust horizontally");
define('LC_WINMGR_ADJUST_VERTI',"Adjust vertically");
define('LC_WINMGR_CLOSE_ALL',"Close all");

/* FORM titles */
define('LC_FORM_TITLE_LOGIN','Authentication');
define('LC_FORM_TITLE_CHANGE_PASSWORD','Change password');
define('LC_FORM_TITLE_MY_ACCOUNT','My account');
define('LC_FORM_TITLE_NEW_PASSWORD_REQUEST','Request a new password');
define('LC_FORM_TITLE_SEARCH', 'Search');
define('LC_FORM_TITLE_HELP','Online help - ');
define('LC_FORM_TITLE_USER_NEW','New user');
define('LC_FORM_TITLE_USER_MODIFY',"Edit a user");
define('LC_FORM_TITLE_USER_REMOVE',"Remove a user");
define('LC_ACTION_SEARCH_USER_INPUT',"Search users...");
define('LC_FORM_TITLE_PROFILE_NEW','New profile');
define('LC_FORM_TITLE_PROFILE_MODIFY',"Edit a profile");
define('LC_FORM_TITLE_PROFILE_REMOVE',"Remove a profile");

/* Authorizations menu label */
define('LC_MENU_AUTHORIZATION','Authorizations');
define('LC_MENU_AUTHORIZ_USERS','Users');
define('LC_MENU_AUTHORIZ_PROFILES','Profiles');

/* Authorizations Datatable labels */
define('LC_TABLE_AUTHORIZ_USERS_CAPTION','authorized users');
define('LC_TABLE_AUTHORIZ_PROFILES_CAPTION','user profiles');
define('LC_TABLE_COL_LOGIN_ID','Login ID');
define('LC_TABLE_COL_USER','User');
define('LC_TABLE_COL_USER_NAME','User name');
define('LC_TABLE_COL_USER_EMAIL','Email');
define('LC_TABLE_COL_USER_STATUS','Status');
define('LC_TABLE_COL_MENU_ACCESS','Menu access');
define('LC_TABLE_COL_USER_PROFILES','Profiles');
define('LC_TABLE_COL_PROFILE_NAME','Profile');
define('LC_TABLE_COL_PROFILE_DESC','Description');
define('LC_TABLE_COL_MENU_ITEMS','Menu Items');

/* Login Form labels */
define('LC_FORM_LBL_LOGIN_ID','Login ID');
define('LC_FORM_LBL_PASSWORD','Password');
define('LC_FORM_LBL_ORIG_PASSWORD','Original password');
define('LC_FORM_LBL_NEW_PASSWORD','New passowrd');
define('LC_FORM_LBL_PASSWORD_CONFIRM','Confirmation');
define('LC_FORM_LBL_ACCESS','Access is');
define('LC_FORM_LBL_PUBL_ACC','public (session timeout)');
define('LC_FORM_LBL_PRIV_ACC','private');
define('LC_FORM_LBL_REMEMBER_ME', 'Remember me');
define('LC_FORM_LBL_TOGGLE_PASSWORD', 'Show / hide password');
define('LC_FORM_LBL_FORGOT_PASSWORD', 'Forgot password?');
define('LC_FORM_LBL_PASSWORD_EXPECTED_LENGTH', 'Minimum 8 characters');
define('LC_FORM_LBL_PASSWORD_EXPECTED_LOWERCASE', 'At least one lowercase letter');
define('LC_FORM_LBL_PASSWORD_EXPECTED_UPPERCASE', 'At least one uppercase letter');
define('LC_FORM_LBL_PASSWORD_EXPECTED_NUMBER', 'At least one number');
define('LC_FORM_LBL_PASSWORD_EXPECTED_SPECIAL', 'At least one special character: !*+-/=.,;:_@#?%"\'$&');
define('LC_FORM_LBL_PASSWORDS_MUST_MATCH', 'Passwords must match');

/* User Form labels */
define('LC_FORM_FLD_USER_IDENTITY','Identity');
define('LC_FORM_FLD_USER_CONNECTION','Login');
define('LC_FORM_FLD_USER_RIGHTS','Rights');
define('LC_FORM_LBL_USER_NAME','User name');
define('LC_FORM_LBL_USER_EMAIL','Email');
define('LC_FORM_LBL_USER_PHONE','Phone');
define('LC_FORM_LBL_USER_NOTES','Notes');
define('LC_FORM_LBL_USER_EXPIRATION_DATE','Expire on');
define('LC_FORM_LBL_USER_STATUS','Status');
define('LC_FORM_LBL_USER_STATUS_ENABLED','Enabled');
define('LC_FORM_LBL_USER_STATUS_DISABLED','Disabled');
define('LC_FORM_LBL_USER_STATUS_ARCHIVED','Archived');
define('LC_FORM_LBL_USER_MENU_ACCESS','Menu access');
define('LC_FORM_LBL_USER_MENU_ACCESS_FULL','Full');
define('LC_FORM_LBL_USER_PROFILES','Profiles');

/* Other Form labels */
define('LC_FORM_LBL_NO_FILE_SELECTED','&lt; No file selected! &gt;');
define('LC_ACTION_ROWS_LABEL','Rows per page');
define('LC_FORM_SEARCH_KEYWORD_LABEL', 'Searched keyword');
define('LC_FORM_SEARCH_KEYWORD_CAPTION', 'The searched keyword is for the login ID, user name, or profile assigned to the user.');
define('LC_FORM_SEARCH_KEYWORD_PLACEHOLDER', 'Enter the keyword to search for...');
define('LC_FORM_SEARCH_SORT_FIELD_LABEL', 'Sort result by');
define('LC_FORM_SEARCH_SORT_ORDER_LABEL', 'Sort order');
define('LC_FORM_SEARCH_SORT_ORDER_ASCENDING_LABEL', 'Ascending');
define('LC_FORM_SEARCH_SORT_ORDER_DESCENDING_LABEL', 'Descending');
define('LC_FORM_NEW_PASSWORD_REQUEST_PLACEHOLDER', 'Email of the user account concerned...');

/* BUTTON labels */
define('LC_BTN_LOGIN','Login');
define('LC_BTN_CANCEL','Cancel');
define('LC_BTN_CLOSE','Close');
define('LC_BTN_SHOW_MENU', 'Show menu');
define('LC_BTN_SHOW_USERPANEL', 'User panel');
define('LC_BTN_SAVE','Save');
define('LC_BTN_APPLY', 'Apply');
define('LC_BTN_VALIDATE', 'Validate');
define('LC_BTN_REFRESH','Refresh');
define('LC_BTN_SEARCH','Search...');
define('LC_BTN_SCROLL_TO_TOP','Scroll to top');
define('LC_BTN_NEW','New');
define('LC_BTN_MODIFY','Edit');
define('LC_BTN_OPEN','Open');
define('LC_BTN_OK','Ok');
define('LC_BTN_REMOVE','Remove');
define('LC_BTN_MANAGE','Manage');
define('LC_BTN_YES','Yes');
define('LC_BTN_NO','No');
define('LC_BTN_SELECTFILE','Choose...');
define('LC_BTN_EXPORT','Export...');
define('LC_BTN_IMPORT','Import...');
define('LC_BTN_ARCHIVE','Archive...');
define('LC_BTN_RESET_SORT', 'Default sort');
define('LC_ACTION_SEARCH_KEYWORD_BTN_RUN','Launch the search');
define('LC_ACTION_SEARCH_KEYWORD_BTN_CLEAR','Clear the search keyword');

/* Link labels */
define('LC_LNK_SHOW_NEXT_RESULTS', 'Show next results');

/* CRITICAL ERROR messages */
define('LC_MSG_CRI_ERR_SUMMARY','Technical hitch');
define('LC_MSG_CRI_ERR_DETAIL',"A technical problem has occurred while processing the last requested action. Please contact your administrator to report the error details below:<br><span class='zdk-err-detail'>\"%1\"</span>");
define('LC_MSG_CRI_ERR_GENERIC',"A technical problem has occurred while processing the last requested action. Please retry later.");

/* ERROR messages */
define('LC_MSG_ERR_EXCEPTION','Technical problem');
define('LC_MSG_ERR_LOGIN','Login ID or password is invalid!');
define('LC_MSG_ERR_DIFF_LOGIN','You must use the same login ID to renew the session!');
define('LC_MSG_ERR_LOGIN_EXPIRATION','Please enter a <b>new password</b> (<i>2 times</i> with confirmation) as your current password is <i>no longer valid</i>.');
define('LC_MSG_ERR_LOGIN_TOO_MUCH_ATTEMPTS','The maximum number of attempts allowed has been achieved!<br>Your account has been disabled.');
define('LC_MSG_ERR_LOGIN_THROTTLING_TOO_MUCH_ATTEMPTS', 'Due to too many login failures, please wait %1 seconds before logging in again.');
define('LC_MSG_ERR_HTTP','<h3>HTTP Error %1!</h3><p><a href="%2">Click here</a> to return to the home page.</p>');
define('LC_MSG_ERR_OFFLINE','<h3>NO INTERNET CONNECTION!</h3><p>You need an internet connection to use your application.<br><a href="%1">Try again</a>.</p>');
define('LC_MSG_ERR_MAINTENANCE','<h3>MAINTENANCE IN PROGRESS</h3><p>Your application is temporarily unvailable due to maintenance work. Please try again later.<br><a href="%1">Try again</a>.</p>');
define('LC_MSG_ERR_SELECT_RECORD',"A database error occured! Unable to select the data!");
define('LC_MSG_ERR_SAVE_RECORD',"A database error occured! The record can't be saved!");
define('LC_MSG_ERR_REMOVE_RECORD',"A database error occured! The record can't be removed!");
define('LC_MSG_ERR_MISSING_VALUE',"Please enter a value!");
define('LC_MSG_ERR_MISSING_VALUE_FOR',"Please enter a value for '%1'!");
define('LC_MSG_ERR_PWD_MISMATCH','The first password does not match the second password for confirmation!');
define('LC_MSG_ERR_PWD_IDENTICAL','The new password must be different than the current password!');
define('LC_MSG_ERR_PASSWORD_INVALID','Password invalid.');
define('LC_MSG_ERR_PASSWORD_BADLENGTH','The password must contain a minimum of 8 characters with at least 1 uppercase letter, 1 lowercase letter and 1 number!'
            . '<br>The following special characters are also accepted: ! * + - / = . , ; : _ @ # ? % " \' $ &');
define('LC_MSG_ERR_EMAIL_INVALID','The email address is not a valid email!');
define('LC_MSG_ERR_LOGIN_BADLENGTH','The login ID must contain between 6 and 20 characters!');
define('LC_MSG_ERR_VALUE_BADLENGTH','Bad length for this value!');
define('LC_MSG_ERR_LOGIN_EXISTS','A user already exists with the same login ID!');
define('LC_MSG_ERR_PROFILE_EXISTS',"The profile '%1' already exists with the same name!");
define('LC_MSG_ERR_EMAIL_EXISTS','A user already exists with the same email!');
define('LC_MSG_ERR_DATE_INVALID','Date format is invalid!');
define('LC_MSG_ERR_VALUE_INVALID','Value not expected!');
define('LC_MSG_ERR_REMOVE_PROFILE','Can not delete! The profile is currently assigned to one or more users.');
define('LC_MSG_ERR_NETWORK','Network error|Check your network connection and try again.');
define('LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY','Operation not allowed');
define('LC_MSG_ERR_FORBIDDEN_ACTION_MESSAGE',"You're not allowed to do the requested operation.");
define('LC_MSG_ERR_PWD_RESET_REQUEST_FAILED', 'A password change request is in progress. Please wait and try again later.');
define('LC_MSG_ERR_PWD_RESET_FAILED', 'Your change password request is not longer valid.<br><a href="%1">Try again</a>.');

/* WARNING messages */
define('LC_MSG_WARN_NO_AUTH',"You're not authenticated, please log in first.");
define('LC_MSG_WARN_SESS_TIMOUT',"Your session has timed out, please log in again.");
define('LC_MSG_WARN_HELP_NOTFOUND',"No help is available for the current view.");
define('LC_MSG_WARN_ROW_NOTSELECTED',"Please, select a row in the data table first!");
define('LC_MSG_WARN_PROFILE_ROWS_EXIST',"<p><strong><span style='color:red;'>Attention</span></strong>: "
    . "<span style='font-style:italic;'>this profile is associated to data rows of the application which also will be removed!</span></p>");
define('LC_MSG_WARN_SEARCH_NO_VALUE','Please enter a keyword first!');
define('LC_MSG_WARN_NEW_VERSION_SUMMARY', 'New version available');
define('LC_MSG_WARN_NEW_VERSION_MSG', 'Your application will be reloaded in you web browser.');
define('LC_MSG_WARN_LOGGED_OUT_SUMMARY', 'Connection interrupted');
define('LC_MSG_WARN_LOGGED_OUT_MSG', 'You will be redirected to the login page.');

/* INFO messages */
define('LC_MSG_INF_LOGIN',"You have logged in successfully.");
define('LC_MSG_INF_PWDCHANGED',"Your password has been changed successfully.");
define('LC_MSG_INF_USERSTORED',"User saved.");
define('LC_MSG_INF_USERREMOVED',"User removed.");
define('LC_MSG_INF_USER_PROFILE_STORED',"Profile saved.");
define('LC_MSG_INF_USER_PROFILE_REMOVED',"Profile removed.");
define('LC_MSG_INF_REQUEST_PWD_RESET_PROCESSED', 'If that email address is in our database, we will send you an email to reset your password.');
define('LC_MSG_INF_PWD_RESET_PROCESSED', 'Your temporary password has been sent to you by email.<br><a href="%1">Clic here</a> to login.');
define('LC_MSG_INF_LOGOUT','<h3>Logout succeed.</h3><p><a href="">Clic here</a> to login again.</p>');
define('LC_MSG_INF_CANCEL_LOGIN','<h3>Login canceled.</h3><p><a href="">Clic here</a> to login.</p>');
define('LC_MSG_INF_SAVE_RECORD','The record has been saved successfully.');
define('LC_MSG_INF_REMOVE_RECORD','The record has been removed successfully.');
define('LC_MSG_INF_SELECT_LIST_ITEM','For multiple selection, hold the <Control> key pressed while clicking on an item of the list.');
define('LC_MSG_INF_SELECT_TREE_NODE','For multiple selection, hold the <Control> key pressed while clicking on a tree node.');
define('LC_MSG_INF_NO_RESULT_FOUND', 'No results found.');

/* QUESTION messages */
define('LC_MSG_ASK_REMOVE','Do you really want to remove this record?');
define('LC_MSG_ASK_CANCEL_CHANGES','The form data have been modified.'
        . '<br><br>Quit without saving?');
define('LC_MSG_ASK_INSTALL', 'Install the App?');