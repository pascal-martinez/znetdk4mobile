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
 * File version: 1.9
 * Last update: 03/20/2024
 */

namespace controller;

class Security extends \AppController {

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
     * Action called to authenticate the user attempting to connect
     * @param array $credentials The login name, password and access values
     * for direct authentication throw HTTP Basic authentication
     * @return \Response Response returned to the main controller
     */
    static protected function action_login($credentials = NULL) {
        $loginOk = TRUE;
        $errorMsg = '';
        $response = new \Response(FALSE);
        $validator = new \validator\Authentication(FALSE);
        if (!is_null($credentials)) {
            $validator->setValues($credentials);
        }
        $changePasswordRequested = !($validator->getValue('login_password') === null && $validator->getValue('login_password2') === null);
        if (!$validator->validate()) {
            //Data validation failed...
            $response->setFailedMessage(LC_FORM_TITLE_LOGIN, $validator->getErrorMessage(), $validator->getErrorVariable());
            $loginOk = FALSE;
            $errorMsg = $validator->getErrorMessage();
        } else { // Data validation is OK
            // Get user infos from the DB security tables
            $user = \UserManager::getUserInfosByCredential($validator->getValue('login_name'));
            // Check user credential: log in with login name or email address
            if ($user && $user['login_name'] !== $validator->getValue('login_name')
                    && $user['user_email'] !== $validator->getValue('login_name')) {
                // Case sensitive mismatch
                $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN, 'login_name');
                $loginOk = FALSE;
                $errorMsg = LC_MSG_ERR_LOGIN;
            } elseif ($user && \MainController::execute('Security', 'isPasswordValid', $validator->getValue('password'), $user['login_password'])) {
                // Authentication has succeed
                \UserSession::resetAuthentHasFailed();
                if ($user['user_enabled'] === '0') { // But user account is disabled
                    $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN_DISABLED, 'login_name');
                    $loginOk = FALSE;
                    $errorMsg = LC_MSG_ERR_LOGIN_DISABLED;
                } elseif ($user['user_enabled'] === '-1') { // But user account is archived
                    $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN, 'login_name');
                    $loginOk = FALSE;
                    $errorMsg = LC_MSG_ERR_LOGIN;
                } elseif (new \DateTime($user['expiration_date']) < new \DateTime('now') && !$changePasswordRequested) {
                    // But password has expired
                    $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN_EXPIRATION, 'login_name');
                    $response->newpasswordrequired = TRUE;
                } else { // Authentication has succeeded
                    $result = TRUE;
                    if ($changePasswordRequested) {
                        $response->setSuccessMessage(LC_FORM_TITLE_CHANGE_PASSWORD, LC_MSG_INF_PWDCHANGED);
                        $result = \MainController::execute('Users', 'changePassword');
                    } else {
                        $summaryLabel = CFG_PAGE_LAYOUT === 'mobile'
                                ? NULL // Summary is NULL for 'mobile' template so the message is shown as Snackbar
                                : LC_FORM_TITLE_LOGIN;
                        $response->setSuccessMessage($summaryLabel, LC_MSG_INF_LOGIN);
                    }
                    if ($result === TRUE) {
                        \UserSession::setLoginName($user['login_name']);
                        \UserSession::setUserId($user['user_id']);
                        \UserSession::setUserName($user['user_name']);
                        \UserSession::setUserEmail($user['user_email']);
                        \UserSession::setFullMenuAccess($user['full_menu_access']);
                        \UserSession::setUserProfiles(\UserManager::getUserProfilesAsArray($user['user_id']));
                        \UserSession::setAccessMode($validator->getValue('access'));
                    } else {
                        $response->setFailedMessage(LC_FORM_TITLE_LOGIN, $result, 'login_password');
                        $loginOk = FALSE;
                        $errorMsg = $result;
                    }
                }
            } elseif ($user && $user['user_enabled'] === '1') { // Password is invalid but user exists and they account is enabled...
                // The counter of allowed login attempts is incremented
                \UserSession::setAuthentHasFailed($user['login_name']);
                if (\UserSession::isMaxNbrOfFailedAuthentReached() && \MainController::execute('Users', 'disableUser', $user['login_name'])) {
                    // The max number of authentications allowed has been reached
                    // User account has been disabled
                    $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN_TOO_MUCH_ATTEMPTS,'login_name');
                    $response->toomuchattempts = TRUE;
                    $loginOk = FALSE;
                    $errorMsg = LC_MSG_ERR_LOGIN_TOO_MUCH_ATTEMPTS;
                } else { // Number of login attempts not yet exceeded
                    $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN, $changePasswordRequested ? 'password' : 'login_name');
                    $loginOk = FALSE;
                    $errorMsg = LC_MSG_ERR_LOGIN;
                }
            } else { // User unknown or user exists but he's disabled and his password is invalid.
                $response->setFailedMessage(LC_FORM_TITLE_LOGIN, LC_MSG_ERR_LOGIN, $changePasswordRequested ? 'password' : 'login_name');
                $loginOk = FALSE;
                $errorMsg = LC_MSG_ERR_LOGIN;
            }
        }
        // For tracking connections purpose (just declare a 'Security::loginResult'
        // public static method in your application or module controller class).
        \MainController::execute('Security', 'loginResult', array(
            'login_date' => \General::getCurrentW3CDate(TRUE),
            'login_name' => $loginOk ? $user['login_name'] : $validator->getValue('login_name'),
            'ip_address' => \Request::getRemoteAddress(),
            'status' => $loginOk,
            'message' => $changePasswordRequested && $loginOk ? LC_MSG_INF_PWDCHANGED : $errorMsg
        ));
        if ($loginOk) {
            $response->login_with_email = $validator->getValue('login_name') === $user['user_email'] ? '1' : '0'; 
        }
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
