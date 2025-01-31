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
 * Core application controller for authentication
 *
 * File version: 1.11
 * Last update: 09/17/2024
 */

namespace controller;

/**
 * User authentication APP controller class: login and logout
 */
class Security extends \AppController {


    /**
     * Access to this controller'actions are restricted to POST requests with
     * valid UI token.
     * @param String $action Controller action
     * @return boolean TRUE if action can be executed, FALSE otherwise.
     */
    static public function isActionAllowed($action) {
        if (!parent::isActionAllowed($action)) {
            return FALSE;
        }
        if ($action !== 'login') {
            return TRUE;
        }
        if (\Request::getMethod() !== 'POST') {
            \General::writeErrorLog(__METHOD__, 'Not POST method.');
            return FALSE; // Only POST method allowed
        }
        $sessionTk = \UserSession::getUIToken();
        if (is_null($sessionTk)) {
            \UserSession::isAuthenticated(); // HTTP error 401 if user's session has expired
            return FALSE; // No token in session
        }
        $requestTk = \Request::getUIToken();
        if (is_null($requestTk)) {
            \General::writeErrorLog(__METHOD__, 'No token in request.');
            return FALSE; // Not token in request
        }
        if ($sessionTk !== $requestTk) {
            \General::writeErrorLog(__METHOD__, 'UI token mismatch.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Action to check if the user is currently connected and his session has
     * not expired
     * @return \Response success JSON property set to true if user is connected,
     * otherwise an error HTTP 401 is returned
     */
    static protected function action_isconnected() {
        $response = new \Response();
        $response->success = true;
        return $response;
    }

    /**
     * Action called to cancel the login process of the user trying to connect
     * @return \Response Response returned to the main controller
     */
    static protected function action_cancellogin() {
        $response = new \Response(FALSE);
        \UserSession::clearUserSession();
        $response->success = TRUE;
        $response->msg = LC_MSG_INF_CANCEL_LOGIN;
        return $response;
    }

    /**
     * Action called to authenticate the user attempting to log in
     * @param array $credentials The login name, password and access values
     * for direct authentication throw HTTP Basic authentication
     * @return \Response Response returned to the main controller
     */
    static protected function action_login($credentials = NULL) {
        $response = new \Response(FALSE);
        $loginHelper = new \LoginHelper($credentials);
        try {
            $loginHelper->check();
            $summaryLabel = CFG_PAGE_LAYOUT !== 'mobile' ? LC_FORM_TITLE_LOGIN : NULL; // shown as Snackbar
            $successMsg = LC_MSG_INF_LOGIN;
            if ($loginHelper->changePasswordIfRequested()) {
                $summaryLabel = LC_FORM_TITLE_CHANGE_PASSWORD; $successMsg = LC_MSG_INF_PWDCHANGED;
            }
            $loginHelper->setUserAuthenticatedInSession();
            $response->setSuccessMessage($summaryLabel, $successMsg);
            $response->login_with_email = $loginHelper->isLoggedInWithEmailAddress() ? '1' : '0';
        } catch (\Exception $ex) {
            $msg = $ex->getMessage(); $varName = $loginHelper->getLastErrorVariable();
            if ($loginHelper->disableUserIfTooMuchAttempts()) {
                $msg = LC_MSG_ERR_LOGIN_TOO_MUCH_ATTEMPTS; $varName = 'login_name';
                $response->toomuchattempts = TRUE;
            }
            if ($loginHelper->hasPasswordExpired()) { // Password must be changed
                $response->newpasswordrequired = TRUE;
            }
            $response->setFailedMessage(LC_FORM_TITLE_LOGIN, $msg, $varName);
        }
        $loginHelper->notify();
        return $response;
    }

    /**
     * Action called to logout the currently connected user
     * @return \Response Response returned to the main controller
     */
    static protected function action_logout() {
        $response = new \Response(FALSE);
        \UserSession::clearUserSession();
        $response->success = TRUE;
        $response->msg = LC_MSG_INF_LOGOUT;
        return $response;
    }

    /**
     * Returns the translated labels displayed on the connection dialog box
     * @return \Response Response returned to the main controller
     */
    static protected function action_getlogindialoglabels() {
        $response = new \Response(FALSE); // FALSE --> no authentication required
        $response->title = LC_FORM_TITLE_LOGIN;
        $response->loginFieldLabel = LC_FORM_LBL_LOGIN_ID;
        $response->passwordFieldLabel = LC_FORM_LBL_PASSWORD;
        $response->loginButtonLabel = LC_BTN_LOGIN;
        $response->cancelButtonLabel = LC_BTN_CANCEL;
        $response->accessLabel = LC_FORM_LBL_ACCESS;
        $response->publicAccessLabel = LC_FORM_LBL_PUBL_ACC;
        $response->privateAccessLabel = LC_FORM_LBL_PRIV_ACC;
        $response->fieldMandatory = LC_MSG_ERR_MISSING_VALUE;
        $response->defaultAccess = CFG_SESSION_DEFAULT_MODE;
        $response->selectAccess = CFG_SESSION_SELECT_MODE;
        $response->changePasswordTitle = LC_FORM_TITLE_CHANGE_PASSWORD;
        $response->changePasswordButton = LC_BTN_SAVE;
        $response->changePasswordOriginal = LC_FORM_LBL_ORIG_PASSWORD;
        $response->changePasswordNew = LC_FORM_LBL_NEW_PASSWORD;
        $response->changePasswordConfirm = LC_FORM_LBL_PASSWORD_CONFIRM;
        $response->forgotPasswordAnchor = CFG_FORGOT_PASSWORD_ENABLED
                ? LC_FORM_LBL_FORGOT_PASSWORD : NULL;
        return $response;
    }

    // Other security methods that can be overiden by the class named 'security'
    // in the /app/controller directory.

    /**
     * Indicates which are the granted menu items to the currently connected user
     * @return string|array Value "ALL" if the connected user has a full access
     *  to the navigation menu, otherwise the menu items which are granted to him
     *  thru his assigned profiles
     */
    static public function getAllowedMenuItems() {
        // Has user full access to the menu items?
        if (\UserSession::hasFullMenuAccess()) {
            // String "ALL" is returned because all menu items are allowed
            return "ALL";
        } else {
            // Get menu items authorized for the authenticated user
            return \UserManager::getGrantedMenuItemsToUser(\UserSession::getLoginName());
        }
    }

    /**
     * Checks whether the user password is valid
     * @param string $inputPassword Password typed in by the user
     * @param string $storedPassword Password stored in the database
     * @return boolean TRUE if the password is valid else FALSE.
     */
    static public function isPasswordValid($inputPassword, $storedPassword) {
        return password_verify($inputPassword, $storedPassword);
    }

    /**
     * Authenticates the user by the HTTP basic authentication method if the
     * credentials are set in the HTTP request.
     * @return boolean Value TRUE if the user has been authenticated successfully
     * by HTTP basic authentication method. Otherwise, returns FALSE if no
     * HTTP authentication is required or if basic authentication failed.
     */
    static public function loginIfHttpBasicAuth() {
        $request = new \Request(FALSE);
        $credentials = $request->getHttpBasicAuthCredentials();
        if ($credentials === FALSE) {
            return FALSE;
        }
        $credentials['access'] = 'public';
        $response = self::action_login($credentials);
        if ($response->success === FALSE) {
            \General::writeErrorLog('Service call with HTTP Basic authentication',
                "User '" . $credentials['login_name'] ."': " . $response->msg, TRUE);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Disconnects the current user if he has been authenticated by through
     * HTTP basic authentication method.
     * @return boolean Value TRUE if the user has been previously authenticated
     * with the credentials set into the HTTP request and then has been logged out.
     * Otherwise returns FALSE;
     */
    static public function logoutIfHttpBasicAuth() {
        $request = new \Request(FALSE);
        $credentials = $request->getHttpBasicAuthCredentials();
        if ($credentials === FALSE) {
            return FALSE;
        }
        self::action_logout();
        return TRUE;
    }
}
