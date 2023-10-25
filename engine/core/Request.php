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
 * Core API for retrieving HTTP request data
 *
 * File version: 1.13
 * Last update: 09/01/2023
 */

/**
 * Get the values from the HTTP request.
 */
class Request {

    private $filteringLevel = 'HIGH';
    private $defaultTrimedCharacters = " \n\r\t\v\x00";
    private $trimedCharacters = '';
    public static $toolGetParamName = 'tool';
    public static $applGetParamName = 'appl';

    /**
     * When a \Request object is instanciated, the authentication is checked
     * for the current user.
     * @param boolean $checkAuthentication Indicates whether the authentication
     * of the current user must be checked. By default, authentication is checked.
     */
    public function __construct($checkAuthentication = TRUE) {
        if ($checkAuthentication) {
            // HTTP error 401 sent if user is not authenticated
            \UserSession::isAuthenticated();
        }
        if (defined('CFG_REQUEST_VARIABLE_FILTERING_LEVEL') && (
                CFG_REQUEST_VARIABLE_FILTERING_LEVEL === 'NONE' ||
                CFG_REQUEST_VARIABLE_FILTERING_LEVEL === 'LOW')) {
            $this->filteringLevel = CFG_REQUEST_VARIABLE_FILTERING_LEVEL;
        }
        $this->trimedCharacters = $this->defaultTrimedCharacters;
    }

    /**
     * Sets the variable filtering level
     * @param string $level 'HIGH' (remove content between 'lower than' and
     * 'greater than' characters, NUL characters but preserves quotes) or 'LOW'
     * (PHP strip_tags() function is applied). If 'NONE', no filtering is
     * applied.
     */
    public function setVariableFilteringLevel($level) {
        if ($level === 'NONE' || $level === 'LOW' || $level === 'HIGH') {
            $this->filteringLevel = $level;
        }
    }

    /**
     * Set the characters to trim from request variables
     * @param string $trimedCharacters The characters to trim. If NULL, the
     * default characters are set (see defaultTrimedCharacters property)
     * @return boolean Returns TRUE on success, otherwise FALSE if 
     * $trimedCharacters is not NULL or is not a string.
     */
    public function setTrimedCharacters($trimedCharacters = NULL) {
        if (is_null($trimedCharacters)) {
            $this->trimedCharacters = $this->defaultTrimedCharacters;
        } elseif (is_string($trimedCharacters)) {
            $this->trimedCharacters = $trimedCharacters;
        } else {
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Returns the value for the POST parameter specified in parameter.
     * @param string $name Name of the parameter for which the value is
     * to be returned.
     * @return mixed Value of the specified parameter.
     */
    public function __get($name) {
        if (isset($_REQUEST[$name])) {
            if (is_array($_REQUEST[$name])) {
                $paramTab = array();
                foreach ($_REQUEST[$name] as $value) {
                    $paramTab[] = $this->getCleanValue($value);
                }
                return $paramTab;
            } elseif ($_REQUEST[$name] !== '') {
                return $this->getCleanValue($_REQUEST[$name]);
            } else {
                return NULL;
            }
        } else {
            return NULL;
        }
    }

    /**
     * Cleans value according to the filtering level set for the \Request object.
     * If the filtering level is 'HIGH', PHP filter_var() method is applied.
     * Else if the filtering level is 'LOW', strip_tags() is applied and the
     * '<=' string is preserved if exists in the text to clean.
     * Otherwise if filtering level is 'NONE', no filtering is applied
     * In all cases, value is trimmed for the specific characters
     * @param string $value Text to clean
     * @return string The cleaned text
     */
    private function getCleanValue($value) {
        if (is_null($value)) {
            return NULL;
        }
        if ($this->filteringLevel === 'NONE') {
            return trim($value, $this->trimedCharacters);
        }
        if ($this->filteringLevel === 'HIGH') {
            // Remove content between '<' and '>' characters, NUL characters but preserves quotes
            return \General::sanitize(trim($value, $this->trimedCharacters));            
        }
        $search = '<=';
        $replace = '&lowerorequalto;';
        $cleanValue = \General::sanitize(trim(str_replace('<=', $replace, $value), $this->trimedCharacters), 'stripTags');
        return str_replace($replace, $search, $cleanValue);
    }

    /**
     * Returns the current HTTP request method 'POST' or 'GET'
     * @return string Sanitized request method name.
     */
    public static function getMethod() {
        return key_exists('REQUEST_METHOD', $_SERVER)
                && ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') 
                ? $_SERVER['REQUEST_METHOD'] : NULL;
    }

    /**
     * Returns the controller name sent as GET or POST parameter in the HTTP request.
     * @return string Sanitized controller name
     */
    public static function getController() {
        $controller = key_exists('control', $_REQUEST) ? $_REQUEST['control'] : NULL;
        return \General::sanitize($controller, 'controller');
    }
    
    /**
     * Indicates whether the current controller name specified as GET parameter
     * is a reserved name.
     * @return boolean TRUE if it is a reserved name, FALSE otherwise.
     */
    public static function isControllerReservedNameForGetMethod() {
        $reservedName = ['httperror', 'offline', 'resetpwd'];
        if (self::getMethod() === 'GET' 
                && in_array(self::getController(), $reservedName)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Returns the action name sent as GET or POST parameter in the HTTP request.
     * @return string Sanitized action name
     */
    public static function getAction() {
        $action = key_exists('action', $_REQUEST) ? $_REQUEST['action'] : NULL;
        return \General::sanitize($action, 'action');
    }

    /**
     * Returns the other application specified as GET or POST parameter
     * @return string Name of the other application. NULL is returned if no
     * other application is specified as POST or GET parameter or if the
     * ZDK_TOOLS_DISABLED constant is set to TRUE in 'globalconfig.php'
     */
    public static function getOtherApplication($parameterNameOnly = FALSE) {
        $method = self::getMethod();
        if (is_null($method)) { // The request comes from the command line (CLI)
            return self::getApplicationFromArguments();
        }
        $filterType = $method === 'POST' ? INPUT_POST : INPUT_GET;
        $toolApp = filter_input($filterType, self::$toolGetParamName);
        if (!is_null($toolApp) && (!defined('ZDK_TOOLS_DISABLED') ||
                (defined('ZDK_TOOLS_DISABLED') && ZDK_TOOLS_DISABLED !== TRUE))) {
            return $parameterNameOnly ? self::$toolGetParamName : \General::sanitize($toolApp, 'appId');
        }
        $otherApp = filter_input($filterType, self::$applGetParamName);
        if (is_null($otherApp) && $method === 'POST' && self::getHttpBasicAuthCredentials() !== FALSE) {
            // The application parameter is accepted as GET parameter for web service calls.
            $otherApp = filter_input(INPUT_GET, self::$applGetParamName);
        }
        if (!is_null($otherApp)) {
            return $parameterNameOnly ? self::$applGetParamName : \General::sanitize($otherApp, 'appId');
        }
        return NULL;
    }

    /**
     * Returns the application ID set as an argument of the command line.
     * The command line arguments expected in the $_SERVER variable are :
     * 1) $argv[0]: the 'index.php' script name,
     * 2) $argv[1]: the value 'autoexec'
     * 3) $argv[2]: the application ID (for example 'default')
     * @return string The application ID passed to the script in command line
     * or NULL if no argument is set for the application ID.
     */
    private static function getApplicationFromArguments() {
        if (key_exists('argc', $_SERVER) && $_SERVER['argc'] >= 3) {
            $applicationId = $_SERVER['argv'][2];
            return \General::sanitize($applicationId, 'appId');
        }
        // No application set in the command line arguments at the third position
        return NULL;
    }

    /**
     * Returns the HTTP error code.
     * @return string value "403", "404" or "500"
     */
    public static function getHttpErrorCode() {        
        return http_response_code();
    }

    /**
     * Returns the language code sent in the HTTP request for the GET parameter 'lang'
     * @return string Language code
     */
    public static function getLanguage() {
        return \General::sanitize(filter_input(INPUT_GET, 'lang'), 'lang');
    }

    /**
     * Get the sanitized value from the $_SERVER array
     * @param string $serverKey Name of the key into the $_SERVER array
     * @param int $sanitizeFilter The filter to apply for sanitizing
     * @return boolean|mixed FALSE if the specified server key does not exist
     * otherwise the value into the $_SERVER matching the specified key.
     */
    public static function getFilteredServerValue($serverKey, $sanitizeFilter) {
        if (!key_exists($serverKey, $_SERVER)) {
            return FALSE;
        }
        $filteredValue = filter_input(INPUT_SERVER, $serverKey, $sanitizeFilter);
        if (is_null($filteredValue)) {
            $filteredValue = filter_var($_SERVER[$serverKey], $sanitizeFilter);
        }
        return $filteredValue;
    }

    /**
     * Returns the language code sent in the HTTP request header 'Accept-Language'.
     * This language is the one set for the web browser which has sent the request.
     * @return string Language code or NULL if the language is not set.
     */
    public static function getAcceptLanguage() {
        $language = key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) 
                ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : NULL;
        return \General::sanitize($language, 'acceptLang');
    }

    /**
     * Returns the sanitized IP address of the user sending the HTTP request
     * including when the user is behind a reverse proxy.
     * If the 'filter_input' fails, the 'filter_var' is used instead.
     * @return string IP address of the user or 'UNKNOWN!' if the IP address
     * can't be read.
     */
    public static function getRemoteAddress() {
        $ipAddress = 'UNKNOWN!';
        if (key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && is_string($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $addresses = filter_input(INPUT_SERVER,'HTTP_X_FORWARDED_FOR', FILTER_SANITIZE_URL);
            if (is_null($addresses)) {
                $addresses = filter_var($_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_SANITIZE_URL);
            }
            $addressesAsArray = explode(',', $addresses);
            $ipAddress = stristr($addresses, ',') ? trim($addressesAsArray[0]) : $addresses;
        } elseif (key_exists('REMOTE_ADDR', $_SERVER) && is_string($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = filter_input(INPUT_SERVER,'REMOTE_ADDR', FILTER_SANITIZE_URL);
            if (is_null($ipAddress)) {
                $ipAddress = filter_var($_SERVER['REMOTE_ADDR'], FILTER_SANITIZE_URL);
            }
        } else {
            \General::writeErrorLog('ZNETDK ERROR', "REQ-002: the user remote address is unknown", TRUE);
        }
        return $ipAddress;
    }

    /**
     * Returns the credentials specified in the HTTP request according to the
     * basic authentication method.
     * @return mixed The username and password as an indexed array if the
     * credentials are specified in the HTTP request using the basic
     * authentication method. Otherwise returns FALSE;
     */
    public static function getHttpBasicAuthCredentials() {
        $user = isset($_SERVER['PHP_AUTH_USER']) ? filter_var($_SERVER['PHP_AUTH_USER'], FILTER_DEFAULT) : NULL;
        $password = isset($_SERVER['PHP_AUTH_PW']) ? filter_var($_SERVER['PHP_AUTH_PW'], FILTER_DEFAULT) : NULL;
        if (is_null($user) && is_null($password) && isset($_SERVER['HTTP_AUTHORIZATION']) 
                && !empty($_SERVER['HTTP_AUTHORIZATION'])) {
            list($user, $password) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
        } elseif (is_null($user) && is_null($password) && isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])
                && !empty($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
            list($user, $password) = explode(':', base64_decode(substr($_SERVER['REDIRECT_HTTP_AUTHORIZATION'], 6)));
        } elseif (is_null($user) && is_null($password)) {
            return FALSE;
        }
        return array('login_name' => $user, 'password' => $password);
    }
    
    /**
     * Returns the UI token sent to HTTP request as GET or POST parameter
     * @return string The sanitized token
     */
    public static function getUIToken() {
        $token = key_exists('uitk', $_REQUEST) ? $_REQUEST['uitk'] : NULL;
        return \General::sanitize($token, 'lang');
    }

    /**
     * Returns an array of the POST values matching the POST parameters specified in
     * input of the method. Each value returned in the array is indexed with the
     * name of the POST parameter.
     * @param string $postParameter1 First POST parameter name for which the value is
     * to be returned in the array.
     * @param string $postParameter2 Second POST parameter name for which the value is
     * to be returned in the array.
     * @param string $postParameterN Nth POST parameter name for which the value is
     * to be returned in the array.
     * @return array Values of the POST parameters specified in parameters
     */
    public function getValuesAsMap() {
        $map = array();
        foreach (func_get_args() as $key) {
            $map[$key] = $this->__get($key);
        }
        return $map;
    }

    /**
     * Returns an array of the POST values matching the POST parameters specified in
     * input of the method. Each value returned in the array is indexed with the
     * name of the POST parameter.
     * @param array $arrayOfKeys POST parameter names for which values have to be
     * returned.
     * @return array Values of the POST parameters specified in the array passed
     * in parameter.
     */
    public function getArrayAsMap($arrayOfKeys) {
        $map = array();
        foreach ($arrayOfKeys as $key) {
            $map[$key] = $this->__get($key);
        }
        return $map;
    }

    /**
     * Checks whether the specified file has been uploaded or not.
     * @param String $name Name of a POST parameter matching an uploaded file.
     * @return Boolean TRUE if the specified file has been uploaded.
     */
    public function isUploadedFile($name) {
        return (!empty($_FILES[$name]));
    }

    /**
     * Returns informations about the specified uploaded file
     * @param String $name Name of the POST parameter matching the uploaded file.
     * @return Array The file informations for the foloowing array keys: 'basename',
     * 'extension', 'filename', 'dirname', 'size', 'type', and 'tmp_name'.
     * @throws \Exception Triggered when an error is detected.
     */
    public function getUploadedFileInfos($name) {
        if (empty($_FILES[$name])) {
            $message = "UPL-001: the specified POST parameter named '$name' does not"
                    . " match any uploaded file!";
        } elseif (is_array($_FILES[$name]['name'])) {
            $message = "UPL-002: only one file can be uploaded at the same time!";
        } elseif ($_FILES[$name]['error'] !== UPLOAD_ERR_OK) {
            $errorNumber = $_FILES[$name]['error'];
            $message = "UPL-003: the error number '$errorNumber' occurred during the"
                    . " upload process!";
        }
        if (!isset($message)) {
            $fileInfos = pathinfo($_FILES[$name]['name']);
            $fileInfos['size'] = $_FILES[$name]['size'];
            $fileInfos['type'] = $_FILES[$name]['type'];
            $fileInfos['tmp_name'] = $_FILES[$name]["tmp_name"];
            return $fileInfos;
        } else {
            \General::writeErrorLog('ZNETDK ERROR', $message, true);
            throw new \ZDKException($message);
        }
    }

    /**
     * Moves the specified uploaded image file into the target directory.
     * @param String $name Name of the POST parameter matching the uploaded file.
     * @param String $targetFileName Full path and name of the definitive file.
     * @param Integer $fileMaxSize Maximum size in bytes of the image file.
     * @throws \Exception Triggered when an error is detected.
     */
    public function moveImageFile($name, $targetFileName, $fileMaxSize) {
        $message = NULL;

        $fileInfos = $this->getUploadedFileInfos($name);
        $uploadedFileName = $fileInfos['basename'];

        if (getimagesize($fileInfos["tmp_name"]) === FALSE) {
            $message = "UPL-004: the uploaded file '$uploadedFileName' is not a valid image!";
        } elseif (file_exists($targetFileName)) {
            $message = "UPL-005: the target file name '$targetFileName' already exists!";
        } elseif ($fileInfos['size'] > $fileMaxSize) {
            $message = "UPL-006: the size of the uploaded file '$uploadedFileName' is greater than the allowed"
                    . " maximum size of '$fileMaxSize' bytes!";
        } elseif (move_uploaded_file($fileInfos["tmp_name"], $targetFileName) === FALSE) {
            $message = "UPL-007: unable to move the temporary uploaded file to the "
                    . "specified target directory '$targetFileName'!";
        } elseif (chmod($targetFileName, 0644) === FALSE) {
            $message = "UPL-008: unable to change the file mode for the uploaded file!";
        }

        if (!is_null($message)) {
            throw new \ZDKException($message);
        }
    }

}
