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
 * Core Application controller class  
 *
 * File version: 1.6
 * Last update: 09/15/2023
 */

use controller\Users;

/**
 * Mother class of the application controllers to derive from 
 */
abstract class AppController {
    // Properties
    static private $setAllowedActionsMethodName = 'setAllowedActions';
    static private $setAsynchronousActionsMethodName = 'setAsynchronousActions';
    static private $requiredProfilesbyAction = array();
    static private $forbiddenProfilesByAction = array();
    static private $requiredMenuItemsbyAction = array();
    
    // Methods
    /**
     * Executes the specified action of the controller
     * @param string $action Action name
     * @return boolean|Response Object of type \Response returned by the action
     * or FALSE if the action does not exist in the controller. 
     */
    static public function doAction($action) {
        if (self::isAction($action)) {
            if (static::isActionAllowed($action)) {
                $response = self::executeAction($action);
                return self::getValidatedResponse($response, $action);
            } else {
                // The user is not allowed to execute the action
                $response = new \Response(FALSE);
                $summary = LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY;
                $message = LC_MSG_ERR_FORBIDDEN_ACTION_MESSAGE;
                $response->doHttpError(403, $summary, $message);
            }
        } else {
            return FALSE; // the action is not managed by the controller
        }
    }
    
    /**
     * Executes the specified asynchronous action of the controller
     * @param string $processId The identifier of the asynchronous process
     * @param string $action The name of the action without its 'async' prefix
     * @param string $stringParameters
     * @return boolean|string The returned value/code of the controller action
     * when execution succeeded, otherwise FALSE if the specified action not
     * exists in the controller or is not set as asynchronous (method name 
     * prefixed by 'async_' instead of 'action_') 
     */
    static public function doAsynchronousAction($processId, $action, $stringParameters) {
        if (!self::isAsynchronousAction($action)) {
            General::writeErrorLog('ZNETDK ERROR',
                "The '$action' action is not declared as asynchronous action!", TRUE);
            return FALSE;
        }
        $method = self::getMethodName($action);
        return static::$method($processId, $stringParameters);
    }
    
    static public function isAsynchronousAction($action) {
        if (!self::isAction($action)) {
            return FALSE;
        }
        $declarationMethod = self::$setAsynchronousActionsMethodName;
        if (method_exists(get_called_class(), $declarationMethod)) {
            $asyncActions = static::$declarationMethod();
            if (!is_array($asyncActions) || !in_array($action, $asyncActions)) {
                return FALSE;
            }
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Checks whether the specified action exists in the controller
     * @param string $action Action name
     * @return boolean TRUE if action exists, FALSE otherwise.
     */
    static public function isAction($action) {
        $method = self::getMethodName($action);
        if (method_exists(get_called_class(), $method)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    /**
     * Checks whether the specified action is allowed for the connected user
     * according to the profile definition of the controller set through the 
     * 'setAllowedActions' method.
     * @param string $action Name of the action
     * @return boolean Value TRUE if the connected user is allowed to execute
     * the specified action. Otherwise returns FALSE.
     */
    static public function isActionAllowed($action) {
        self::doErrorIfActionUnknown($action); // Unknown action !
        if (!self::isActionAllowedForWebservice($action)) {
            return FALSE; // This is webservice call and the action is not allowed!
        }
        if (CFG_AUTHENT_REQUIRED === FALSE) {
            // No authentication required...
            return TRUE; // So the action is allowed
        }
        if (!self::doesAllowedActionMethodExist()) { //No profile access definition exists 
            return TRUE; // So the action is allowed
        }
        if (key_exists($action, self::$requiredMenuItemsbyAction)
                && !Users::hasMenuItem(self::$requiredMenuItemsbyAction[$action])) {
            return FALSE; // User has no right on the specified menu item for the action 
        }
        $profileName = NULL;
        $menuItem = NULL;
        $profileType = NULL;
        if (key_exists($action, self::$requiredProfilesbyAction)) {
            $profileName = self::$requiredProfilesbyAction[$action]['profileName'];
            $menuItem = self::$requiredProfilesbyAction[$action]['menuItem'];
            $profileType = 'required';
        } elseif (key_exists($action, self::$forbiddenProfilesByAction)) {
            $profileName = self::$forbiddenProfilesByAction[$action]['profileName'];
            $menuItem = self::$forbiddenProfilesByAction[$action]['menuItem'];
            $profileType = 'forbidden';
        }
        if (is_null($profileName)) {
            return TRUE; // No definition found for the action, so the action is allowed
        }
        $doesUserHasProfile = MainController::execute('users', 'hasProfile', $profileName);
        if ($profileType === 'required') {
            // The user must have the required profile
            if (is_null($menuItem)) {
                // No menu item restriction is set.
                return $doesUserHasProfile;
            } elseif ($doesUserHasProfile) { // The specified menu item must be set for the profile
                $isMenuItemSetForProfile = ProfileManager::isMenuItemSetForProfile($profileName, $menuItem);
                return $isMenuItemSetForProfile;
            } else {
                return FALSE; // The user does not have the required profile.
            }
        } else {
            // The user must not have the specified profile
            if (is_null($menuItem)) {
                // No menu item restriction is set.
                return $doesUserHasProfile === FALSE;
            } elseif ($doesUserHasProfile) {
                $isMenuItemSetForProfile = ProfileManager::isMenuItemSetForProfile($profileName, $menuItem);
                return $isMenuItemSetForProfile === FALSE;
            } else {
                return TRUE;
            }
        }

    }
    
    /**
     * Specifies the user profiles allowed to execute the controller's action.
     * If menu item ID is set, it must be selected for the specified profile
     * This method must be called from the 'setAllowedActions' controller's 
     * method
     * @param string $action Name of the action
     * @param string $profileName Name of the user profile
     * @param string $menuItem Identifier of the menu item which must be 
     * selected for the specified user profile.
     */
    static protected function setRequiredProfileForAction($action, $profileName, $menuItem = NULL) {
        self::doErrorIfActionUnknown($action);
        self::doErrorIfActionSetSeveralTimes($action);
        self::$requiredProfilesbyAction[$action] = array(
            'profileName' => $profileName,
            'menuItem' => $menuItem);
    }
    
    /**
     * Specifies the user profiles NOT allowed to execute the controller's action.
     * This method must be called from the 'setAllowedActions' controller's 
     * method
     * @param string $action Name of the action
     * @param string $profileName Name of the user profile
     * @param string $menuItem Identifier of the menu item which must not be set
     * for the specified user profile.
     */
    static protected function setForbiddenProfileForAction($action, $profileName, $menuItem = NULL) {
        self::doErrorIfActionUnknown($action);
        self::doErrorIfActionSetSeveralTimes($action);
        self::$forbiddenProfilesByAction[$action] = array(
            'profileName' => $profileName,
            'menuItem' => $menuItem);
    }
    
    /**
     * Sets the menu item ID which must be assigned to the connected user
     * to allow them to execute the specified controller action
     * @param string $action Name of the action
     * @param string $menuItem Identifier of the menu item
     */
    static protected function setRequiredMenuItemForAction($action, $menuItem) {
        self::doErrorIfActionUnknown($action);
        if (key_exists($action, self::$requiredMenuItemsbyAction)) {
            self::doHttpError("CTL-011: the '$action' action specified within the "
                . "'setAllowedActions' method is specified several times for the '"
                . get_called_class() . "' controller!");
        }
        self::$requiredMenuItemsbyAction[$action] = $menuItem;
    }
    
    /**
     * Checks whether the specified action is allowed when it is executed by
     * a web service with HTTP basic authentication.
     * @param string $action Name of the action to execute
     * @return boolean TRUE if this is not a web service call or if it is 
     * a web service call and the action is allowed for the current authenticated
     * user (see the CFG_HTTP_BASIC_AUTHENTICATION_ENABLED and 
     * CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS parameters). Otherwise returns
     * FALSE. 
     */
    static private function isActionAllowedForWebservice($action) {
        $request = new \Request(FALSE);
        $credentials = $request->getHttpBasicAuthCredentials();
        if ($credentials === FALSE) { // This is not a webservice call...
            return TRUE; // ...No credentials passed to the HTTP request
        }
        if (CFG_HTTP_BASIC_AUTHENTICATION_ENABLED === FALSE) {
            General::writeErrorLog('ZNETDK ERROR',
                'Web service calls are disabled!' ,TRUE);
            return FALSE; // Webservice calls are disabled
        }
        $allowedActions = CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS === NULL ?
                NULL : unserialize(CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS);
        if (!is_array($allowedActions)) {
             // No allowed actions are defined or the parameter value is wrong
             General::writeErrorLog('ZNETDK ERROR',
                'Allowed webservice actions are not properly defined!' ,TRUE);
            return FALSE;
        }
        $isActionAllowed = FALSE;
        $controllerName = (new \ReflectionClass(get_called_class()))->getShortName();
        $userLogin = \UserSession::getLoginName();
        foreach ($allowedActions as $allowedUserAction) {
            $allowedUserActionAsArray = explode('|', $allowedUserAction);
            $user = $allowedUserActionAsArray[0];
            $controllerAction = $allowedUserActionAsArray[1];
            if ($user !== $userLogin) {
                continue;
            }
            if (strtolower($controllerAction) === strtolower($controllerName . ':' . $action)) {
                $isActionAllowed = TRUE;
                break;
            }
        }
        if ($isActionAllowed === FALSE) {
            General::writeErrorLog('ZNETDK ERROR',
                "The action '$action' of the controller '$controllerName' is not allowed for the user '$userLogin'!" ,TRUE);
        }
        return $isActionAllowed;
    }
    
    static private function doesAllowedActionMethodExist() {
        $method = self::$setAllowedActionsMethodName;
        if (method_exists(get_called_class(), $method)) {
            // The static properties are reset
            self::$requiredProfilesbyAction = array();
            self::$forbiddenProfilesByAction = array();
            self::$requiredMenuItemsbyAction = array();
            // The 'setAllowedActions' method is called
            static::$method();
            return TRUE;
        } else {
            return FALSE; // The 'setAllowedActions' method is not declared
        }
    }

    static private function getMethodName($action) {
        return 'action_'.$action;
    }

    static private function executeAction($action) {
        $method = self::getMethodName($action);
        return static::$method();
    }

    static private function getValidatedResponse($response, $action) {
        $objectType = '\Response';
        if ($response instanceof $objectType) {
            return $response;
        } else {
            $message = "CTL-006: the response returned by the action '".$action.
                    "' of the controller '".  get_called_class() .
                    "' is not an object of type ".$objectType."!";
            self::doHttpError($message);
        }
    }
    
    static private function doHttpError($message) {
        \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
        $response = new \Response(FALSE);
        $response->doHttpError(500,LC_MSG_CRI_ERR_SUMMARY,
                \General::getFilledMessage(LC_MSG_CRI_ERR_DETAIL, $message));
    }
    
    static private function doErrorIfActionUnknown($action) {
        if (!self::isAction($action)) {
            // EXCEPTION - the action definition does not exist within the controller
            self::doHttpError("CTL-008: the '$action' action specified within the "
                . "'setAllowedActions' method does not exist for the '"
                . get_called_class() . "' controller!");
        }
    }
    
    static private function doErrorIfActionSetSeveralTimes($action) {
        if (key_exists($action, self::$requiredProfilesbyAction)
                || key_exists($action, self::$forbiddenProfilesByAction)) {
            self::doHttpError("CTL-009: the '$action' action specified within the "
                . "'setAllowedActions' method is specified several times for the '"
                . get_called_class() . "' controller!");
        }
    }
}
