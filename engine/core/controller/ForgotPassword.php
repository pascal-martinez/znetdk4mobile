<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr
 * Copyright (C) 2021 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Core application controller dedicated to forgotten password
 *
 * File version: 1.2
 * Last update: 08/29/2023
 */

namespace controller;

/**
 * ZnetDK Core controller for processing Forgotten password requests.
 * This controller can be overloaded by declaring in the application or in a
 * module, a controller with the same Class name.
 */
class ForgotPassword extends \AppController {

    /**
     * Returns the code of the view dedicated to forgotten password.
     * @return \Response The HTML code of the 'forgotpassword' view or HTTP
     * error 403 if CFG_FORGOT_PASSWORD_ENABLED is set to FALSE
     */
    static protected function action_show() {
        $response = new \Response(FALSE);
        if (CFG_FORGOT_PASSWORD_ENABLED === FALSE) {
            $response->doHttpError(403, 'ERROR', LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY);
        }
        $response->setView('forgotpassword', 'view');
        return $response;
    }

    /**
     * Processes the new password request.
     * POST request parameter:
     * [email]: email address of the user who forgot their password.
     * If the email address matches an existing user, the custom
     * ForgotPassword::sendConfirmation($email) static public method is
     * called to send by email a confimation link to the concerned user.
     * If CFG_FORGOT_PASSWORD_REQUEST_TRACE_ENABLED is set to TRUE, the new
     * password request is traced into the system log file.
     * @return \Response A message to confirm that the user request has been
     * processed.
     */
    static protected function action_requestpassword() {
        $request = new \Request(FALSE);
        $response = new \Response(FALSE);
        if ($request->email === NULL) {
            $response->doHttpError(403, 'ERROR', LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY);
        }        
        $error = 'NONE';
        $response->setSuccessMessage(LC_FORM_TITLE_NEW_PASSWORD_REQUEST, LC_MSG_INF_REQUEST_PWD_RESET_PROCESSED);
        try {
            $confirmationUrl = \UserManager::getResetPasswordConfirmationUrl($request->email);
            if (!\MainController::execute('ForgotPassword', 'sendConfirmation', $request->email, $confirmationUrl)) {
                \General::writeErrorLog(__METHOD__, 'ForgotPassword::sendConfirmation() method not found!');
                throw new \Exception('Unable to send email!', 99);
            }            
        } catch (\Exception $ex) {
            if ($ex->getCode() === 200) { // SPAM prevention...
                $response->setFailedMessage(LC_FORM_TITLE_NEW_PASSWORD_REQUEST,
                        LC_MSG_ERR_PWD_RESET_REQUEST_FAILED);
            } elseif ($ex->getCode() === 201 || $ex->getCode() < 100) {                
                $response->setCriticalMessage("{$ex->getMessage()} ({$ex->getCode()})", $ex, TRUE);
            }
            $error = $ex->getMessage();
        }
        if (CFG_FORGOT_PASSWORD_REQUEST_TRACE_ENABLED === TRUE) {
            \General::writeSystemLog(__METHOD__,
                "New password request for email address='{$request->email}'. Error: {$error}");
        }
        return $response;
    }

    /**
     * Resets password after user confirmation via confirmation URL
     * @return \Response
     */
    static protected function action_resetpassword() {
        $request = new \Request(FALSE);
        $response = new \Response(FALSE);
        if ($request->email === NULL || $request->key === NULL) {
            $response->doHttpError(403, 'ERROR', LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY);
        }
        $error = 'NONE';
        try {
            $tempPassword = \UserManager::resetPassword($request->email, $request->key);
            if (!\MainController::execute('ForgotPassword', 'sendNewEmail', $request->email, $tempPassword)) {
                \General::writeErrorLog(__METHOD__, 'ForgotPassword::sendNewEmail() method not found!');
                throw new \Exception('Unable to send email!', 99);
            }
            $response->setSuccessMessage(LC_FORM_TITLE_NEW_PASSWORD_REQUEST,
                \General::getFilledMessage(LC_MSG_INF_PWD_RESET_PROCESSED, \General::getAbsoluteURI(TRUE)));
        } catch (\Exception $ex) {
            if ($ex->getCode() === 300) { // Reset Password Key invalid...
                $response->setFailedMessage(LC_FORM_TITLE_NEW_PASSWORD_REQUEST,
                    \General::getFilledMessage(LC_MSG_ERR_PWD_RESET_FAILED, \General::getAbsoluteURI(TRUE)));
            } else {
                $response->setFailedMessage(LC_FORM_TITLE_NEW_PASSWORD_REQUEST,
                    \General::getFilledMessage(LC_MSG_CRI_ERR_DETAIL, $ex->getCode()));
                \General::writeErrorLog(__METHOD__, $ex->getMessage(), TRUE);
            }
            $error = $ex->getMessage();
        }
        if (CFG_FORGOT_PASSWORD_REQUEST_TRACE_ENABLED === TRUE) {
            \General::writeSystemLog(__METHOD__,
                "Password reset confirmation for email address='{$request->email}'. Error: {$error}");
        }
        return $response;
    }

}