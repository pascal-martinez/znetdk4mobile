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
 * Core General purpose API
 *
 * File version: 1.18
 * Last update: 08/03/2024
 */

/**
 * ZnetDK general purpose API
 */
Class General {

    static public $defaultApp = 'default';
    static private $applicationsDir = 'applications';
    static private $toolApp = array('appwiz','appwiz-preview');
    static private $ZnetDKToolsDir = 'engine/tools';

    /**
     * Returns the absolute URI where ZnetDK is installed.
     * @param boolean $includeGetParameter Specifies whether the GET parameter
     * with the application name should be included in the URI when the
     * application is not the default application
     * @return string Absolute URI of ZnetDK
     */
    static public function getAbsoluteURI($includeGetParameter = FALSE) {
        $script = dirname(self::getMainScript());
        $uri = $script === DIRECTORY_SEPARATOR ? '/' : str_replace('\\', '/', $script) . '/';
        if ($includeGetParameter && !self::isDefaultApplication()) {
            $uri = self::addGetParameterToURI($uri, \Request::getOtherApplication(TRUE), ZNETDK_APP_NAME);
        }
        return $uri;
    }

    /**
     * Returns the leaf extra part of the URI
     * On OVH hosting, the 'REDIRECT_URL' server variable does the job.
     * Unfortunately not on PHPNET, the 'REQUEST_URI' server variable must be
     * used instead (variable both OK on OVH and PHPNET).
     * 2019/09/14: did not work in PHP 7.2 with CGI (FastCGI required):
     * The filter_input function returned NULL when applied to 'REQUEST_URI'!
     * SOLVING: \Request::getFilteredServerValue() method that sanitize the
     * requested server parameter using both filter_input and filter_var as done
     * by the \Request::getRemoteAddress() method.
     * @param boolean $onlyTheLeaf If set to FALSE, an array of subpaths is
     * returned when the number of subpaths is greater than 1.
     * @return string|boolean|array FALSE if not found, otherwise the leaf extra
     * part as string or as array.
     */
    static public function getExtraPartOfURI($onlyTheLeaf = TRUE) {
        if (\Request::getController() !== 'httperror') {
            return FALSE;
        }
        $requestUri = \Request::getFilteredServerValue('REQUEST_URI', FILTER_SANITIZE_URL);
        $redirectURL = substr($requestUri, strlen(self::getAbsoluteURI())); // Base URI removed
        // Extra URL GET parameters are removed from the right side
        $questionMarkPos = strpos($redirectURL, '?');
        if ($questionMarkPos !==FALSE) {
            $redirectURL = substr($redirectURL, 0, $questionMarkPos);
        }
        $URLpieces = explode('/', $redirectURL);
        if (count($URLpieces) === 1) {
            return $URLpieces[0];
        } elseif ($onlyTheLeaf === FALSE && count($URLpieces) > 1) {
            return $URLpieces;
        } else {
            return FALSE;
        }
    }

    /**
     * Returns the main PHP script of ZnetDK (index.php)
     * @param boolean $includeGetParameter When set to TRUE, the GET parameter
     * for selecting another application is also returned.
     * @return string Main PHP script of ZnetDK
     */
    static public function getMainScript($includeGetParameter = FALSE) {
        $script = filter_var($_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_URL);
        if ($includeGetParameter && !self::isDefaultApplication()) {
            $script = self::addGetParameterToURI($script, \Request::getOtherApplication(TRUE), ZNETDK_APP_NAME);
        }
        return $script;
    }

    /**
     * Returns date and time in W3C format('Y-m-d').
     * @param boolean $withTime When set to TRUE, current time is added to the
     * returned date (format 'Y-m-d H:i:s').
     * @return DateTime Date and time.
     */
    static public function getCurrentW3CDate($withTime = FALSE) {
        $today = new \DateTime('now');
        $format = $withTime ? 'Y-m-d H:i:s' : 'Y-m-d';
        return $today->format($format);
    }

    /**
     * Checks if the specified W3C date is valid
     * @param string $w3cDate A date as string in W3C format ('Y-m-d')
     * @return boolean TRUE if the date is valid, FALSE otherwise
     */
    static public function isW3cDateValid($w3cDate) {
        if (!is_string($w3cDate)) {
            return FALSE;
        }
        $dateTimeObject = \DateTime::createFromFormat('Y-m-d', $w3cDate);
        if (!$dateTimeObject || $dateTimeObject->format('Y-m-d') !== $w3cDate) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Replace in the text of the message specified for the first parameter, the
     * placeholders %1, %2, ... by the text values specified in the same order
     * for the next paramaters.
     * @param string $message Original message in which the placeholders %1, %2,
     * ... are to be replaced by the values specified as other parameters.
     * @param string $text1 Text which replaces the placeholder %1.
     * @param string $text2 Text which replaces the placeholder %2 if exists.
     * @param string $textN Text which replaces the placeholder %N if exists.
     * @return string Message filled with the pieces of text specified in input
     * parameters.
     */
    static public function getFilledMessage() {
        $nbArgs = func_num_args();
        if ($nbArgs === 0) {
            return null;
        } elseif ($nbArgs === 1) {
            return func_get_arg(0);
        } else {
            $message = func_get_arg(0);
            $arg_list = func_get_args();
            for ($i = 1; $i < $nbArgs; $i++) {
                $placeHolder = "%" . $i;
                $newValue = $arg_list[$i];
                $message = str_replace($placeHolder, strval($newValue), $message);
            }
            return $message;
        }
    }

    /**
     * Returns the sanitized string with only letters and numbers.
     * @param string $inputString The string to clean.
     * @param string $extraAllowedCharacters Extra characters that are preserved.
     * @return string The new string with only letters and numbers. If input
     * string is NULL, a NULL value is returned;
     */
    static private function getOnlyLettersAndNumbers($inputString, $extraAllowedCharacters = '') {
        $filter = '/[^A-Za-z0-9' . $extraAllowedCharacters . ']/';
        return is_null($inputString)
            ? NULL : preg_replace($filter, '', $inputString);
    }

    /**
     * Sanitizes string value applying internal pre-defined filters
     * @param string $inputValue The value to sanitize
     * @param string $type Type of filter to apply: 'stripTags', 'default',
     * 'controller', 'action', 'appId', 'lang', 'acceptLang'.
     * @param int $filterFlags Optional filter flags to apply.
     * @return string The sanitized string
     * @throws Exception GEN-002: unknown type specified as parameter
     */
    static public function sanitize($inputValue, $type = 'default', $filterFlags = NULL) {
        if (is_null($inputValue)) {
            return NULL;
        }
        if (!is_null($filterFlags)) {
            $inputValue = filter_var($inputValue, FILTER_DEFAULT, $filterFlags);
        }
        switch ($type) {
            case 'default':
                // Remove content between '<' and '>' characters, NUL characters but preserves quotes
                return preg_replace('/\x00|<[^>]*>?/', '', $inputValue);
            case 'stripTags':
                return strip_tags($inputValue);
            case 'controller':
                return self::getOnlyLettersAndNumbers($inputValue, '_-');
            case 'action':
                return self::getOnlyLettersAndNumbers($inputValue, '_');
            case 'appId':
                return self::getOnlyLettersAndNumbers($inputValue, '_\-');
            case 'lang':
                return self::getOnlyLettersAndNumbers($inputValue);
            case 'acceptLang':
                return self::getOnlyLettersAndNumbers($inputValue, ' \-,=.;\*');
        }
        throw new Exception("GEN-002: the specified type '{$type}' is unknown!");
    }

    /**
     * Adds a GET parameter to the specified URI and returned the filled version
     * @param string $URI Originale URI
     * @param string $parameter GET parameter name
     * @param string $value Value of the GET parameter
     * @return string Specified URI filled with the GET parameter
     */
    static public function addGetParameterToURI($URI,$parameter,$value) {
        $paramAndValue = $parameter . '=' . $value;
        if (strpos($URI,'?') === FALSE) {
            $filledURI = $URI . '?' . $paramAndValue;
        } else {
            $filledURI = $URI . '&' . $paramAndValue;
        }
        return $filledURI;
    }

    /**
     * Returns the GET URI for downloading a file
     * @param string $controller Name of the controller taking in charge the
     * file download
     * @param string $parameters Extra parameters to send to the 'download'
     * controller action (NULL by default)
     * @return string Full URI for downloading a file
     */
    static public function getURIforDownload($controller, $parameters = NULL) {
        $baseURI = self::getAbsoluteURI(TRUE);
        $URIwithController = self::addGetParameterToURI($baseURI, 'control', $controller);
        $URIwithAction = self::addGetParameterToURI($URIwithController, 'action', 'download');
        return is_null($parameters) ? $URIwithAction : $URIwithAction . '&' . $parameters;
    }

    /**
     * Add an error entry in the ZnetDK error log
     * @param string $origin Text specifying the origin of the error.
     * @param string $textError Text of the error.
     * @param boolean $isCore Specify whether the error to write is a CORE error
     * or an application error.
     */
    static public function writeErrorLog($origin, $textError, $isCore = FALSE) {
        $level = $isCore ? 'CORE' : 'APPL';
        $logFile = ZNETDK_ROOT . CFG_ZNETDK_ERRLOG;
        $currentDate = '[' . date("Y-m-d H:i:s") . '] ';
        $logEntry = $currentDate . $level . ' - ' . $origin . ' - ' . $textError . PHP_EOL;
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Add an information entry in the ZnetDK system log
     * @param string $origin Text specifying the origin of the error.
     * @param string $information Informations to trace.
     * @param boolean $isCore Specify whether the information to write is a CORE error
     * or an application error.
     */
    static public function writeSystemLog($origin, $information, $isCore = FALSE) {
        $level = $isCore ? 'CORE' : 'APPL';
        $logFile = ZNETDK_ROOT . CFG_ZNETDK_SYSLOG;
        $currentDate = '[' . date("Y-m-d H:i:s") . '] ';
        $logEntry = $currentDate . $level . ' - ' . $origin . ' - ' . $information . PHP_EOL;
        file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Returns the current application identifier.
     * @return string Identifier of the current application.
     */
    static public function getApplicationID() {
        $otherAppl = \Request::getOtherApplication();
        $applicationID = is_null($otherAppl) ? self::$defaultApp : $otherAppl;
        if (defined('ZDK_REDIRECT_APPL_UNKNOWN') && ZDK_REDIRECT_APPL_UNKNOWN !== NULL
            && !file_exists(ZNETDK_ROOT . \General::getApplicationRelativePath($applicationID))) {
            header('Location: '. ZDK_REDIRECT_APPL_UNKNOWN);
            exit;
        }
        return $applicationID;
    }

    /**
     * Checks if the current application is the default application
     * @return boolean TRUE if the current application is the default application
     */
    static public function isDefaultApplication($applicationID = NULL) {
        return is_null($applicationID) ? ZNETDK_APP_NAME === self::$defaultApp
                : $applicationID === self::$defaultApp;
    }

    /**
     * Specifies whether an application is a tool application
     * @param string $applicationID Identifier of the application
     * @return boolean TRUE if the application is a ZnetDK tool
     */
    static public function isToolApplication($applicationID = NULL) {
        if (in_array(is_null($applicationID) ? ZNETDK_APP_NAME : $applicationID
                , self::$toolApp)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Returns the relative path of the applications's files
     * @param string $applicationID Identifier of the current application
     * @return string Relative path from the installation root path of ZnetDK
     */
    static public function getApplicationRelativePath($applicationID) {
        if (in_array($applicationID, self::$toolApp)) {
            $directory = str_replace('/', DIRECTORY_SEPARATOR, self::$ZnetDKToolsDir);
        } else {
            $directory = self::$applicationsDir;
        }
        return $directory . DIRECTORY_SEPARATOR . $applicationID;
    }

    /**
     * Returns the relative URI of the application public directory
     * @param string $applicationID Identifier of the application
     * @return string Relative URI of the application public directory
     */
    static public function getApplicationPublicDirRelativeURI($applicationID) {
        if (in_array($applicationID, self::$toolApp)) {
            $directory = self::$ZnetDKToolsDir;
        } else {
            $directory = self::$applicationsDir;
        }
        return $directory . '/' . $applicationID . '/public/';
    }

    /**
     * Returns URI of the current application
     * @return string URI of the application like
     * 'https://www.mydomain/index.php?appl=myapp'
     */
    static public function getApplicationURI() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
                ? 'https' : 'http';
        $server = filter_input(INPUT_SERVER, 'SERVER_NAME', FILTER_SANITIZE_URL);
        if (empty($server) && isset($_SERVER['SERVER_NAME'])) {
            // See https://bugs.php.net/bug.php?id=49184 bug on some
            // implementations of FCGI/PHP
            $server = filter_var($_SERVER['SERVER_NAME'], FILTER_SANITIZE_URL);
        }
        $tcpipPort = '';
        if ($_SERVER['HTTP_HOST'] !== $server) {
            $hostAndPort = explode(':', $_SERVER['HTTP_HOST']);
            $tcpipPort = count($hostAndPort) === 2
                    && $hostAndPort[0] === $server
                    && $hostAndPort[1] === $_SERVER['SERVER_PORT']
                    ? ":{$hostAndPort[1]}" : '';
        }
        return $protocol . '://' . $server . $tcpipPort . self::getMainScript(TRUE);
    }

    /**
     * Returns an array of the modules installed in ZnetDK
     * @param string $filter Filter limiting the returned modules to those
     * matching the specifed controller name or view name.
     * @param boolean $onlyFirstIfFilter When set to TRUE, only the first
     * module matching the specified filter is returned as string. When set to
     * FALSE, all the modules matching the specified filter are returned as
     * array.
     * @return mixed An array of module names if $filter is NULL, the module
     * name matching the specified filter or FALSE if no module is found.
     */
    static public function getModules($filter = NULL, $onlyFirstIfFilter = TRUE) {
        if (!is_dir(ZNETDK_MOD_ROOT)) {
            return FALSE; // Module directory is missing
        }
        $dirContent = scandir(ZNETDK_MOD_ROOT, SCANDIR_SORT_ASCENDING);
        if (!$dirContent) {
            return FALSE;
        }
        $modules = array_diff($dirContent, array('..', '.'));
        $returnedModules = [];
        foreach ($modules as $moduleName) {
            if (!is_dir(ZNETDK_MOD_ROOT . DIRECTORY_SEPARATOR . $moduleName)) {
                continue;
            }
            if (is_null($filter)) {
                $returnedModules[] = $moduleName;
                continue;
            }
            if (!file_exists(ZNETDK_MOD_ROOT . DIRECTORY_SEPARATOR . $moduleName
                    . DIRECTORY_SEPARATOR . $filter)
                    && !file_exists(ZNETDK_MOD_ROOT . DIRECTORY_SEPARATOR . $moduleName
                    . DIRECTORY_SEPARATOR . strtolower($filter))) {
                continue;
            }
            if ($onlyFirstIfFilter) {
                return $moduleName;
            }
            $returnedModules[] = $moduleName;
        }
        if (!is_null($filter) && $onlyFirstIfFilter === TRUE) {
            return FALSE;
        }
        if (count($returnedModules) > 0) {
            return $returnedModules;
        }
        return FALSE;
    }

    /**
     * Inits the modules' parameters
     */
    static public function initModuleParameters() {
        $modules = self::getModules();
        if ($modules) {
            foreach ($modules as $moduleName) {
                $path = ZNETDK_MOD_ROOT . DIRECTORY_SEPARATOR . $moduleName
                    . DIRECTORY_SEPARATOR . 'mod' . DIRECTORY_SEPARATOR . 'config.php';
                @include($path);
            }
        }
    }

    /**
     * Checks whether the specified module is installed or not
     * @param string $moduleName Name of the module
     * @return boolean TRUE if the module exists, FALSE otherwise
     */
    static public function isModule($moduleName) {
        $modules = self::getModules();
        if ($modules) {
            foreach ($modules as $foundModuleName) {
                if ($foundModuleName === $moduleName) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    /**
     * Returns a dummy password for security purpose.
     * @return string Dummy password.
     */
    static public function getDummyPassword() {
        return str_repeat("_", 20);
    }

    /**
     * Returns the mime type of the specified file
     * @param string $filename Full file path and name for which the mime type
     * is to evaluate
     * @return string Mime type of the specified file (for example 'image/gif')
     * @throws ZDKException GEN-001 'fileinfo' extension missing.
     */
    static public function getMimeType($filename) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimeType;
        } else {
            throw new \ZDKException("GEN-001: unable to determine the mime type of the '$filename' file!"
                        . ". 'fileinfo' extension is not loaded.");
        }
    }

    /**
     * Resizes pictures (JPG or PNG) to the specified maximum width and height
     * @param string $filePath Full file path
     * @param int $maxWidth Maximum width in pixels
     * @param int $maxHeight Maximum height in pixels
     * @param boolean $asBase64Url When set to TRUE (default value) the picture
     * is returned as URL format encoded in Base64. Otherwise, image content is
     * returned in binary.
     * @param float $tweakFactor Factor used to evaluate the memory required for
     * processing picture.
     * @return string The resized picture
     * @throws ZDKException 'gd' extension not loaded (GEN-003), file unknown
     * (GEN-004), file extension invalid (GEN-005), picture size too big
     * (GEN-006), picture file invalid (GEN-009).
     */
    static public function reducePictureSize($filePath, $maxWidth, $maxHeight,
            $asBase64Url = TRUE, $tweakFactor = 2) {
        if (!extension_loaded('gd')) {
            throw new ZDKException('GEN-003: method reducePictureSize requires \'gd\' extension.');
        }
        if (!file_exists($filePath)) {
            throw new ZDKException("GEN-004: no file found for the specified file path: '{$filePath}'.");
        }
        $fileExtension = strtolower(pathinfo(strval($filePath), PATHINFO_EXTENSION));
        if (array_search($fileExtension, ['jpg', 'jpeg', 'png']) === FALSE) {
            throw new ZDKException("GEN-005: file extension '{$fileExtension}' not supported.");
        }
        if (self::isPictureTooBig($filePath, $tweakFactor)) {
            throw new ZDKException("GEN-006: picture size is too big to be reduced.");
        }
        ErrorHandler::suspend();
        if ($fileExtension === 'jpg' || $fileExtension === 'jpeg') {
            $original = imagecreatefromjpeg($filePath);
        } elseif ($fileExtension === 'png') {
            $original = imagecreatefrompng($filePath);
        }
        ErrorHandler::restart();
        if (!$original) {
            throw new ZDKException("GEN-009: not a valid picture file.");
        }
        list($originalWidth, $orginalHeight) = getimagesize($filePath);
        $newWidth = $originalWidth;
        $newHeight = $orginalHeight;
        // Is taller
        if ($orginalHeight > $maxHeight) {
            $newWidth = ($maxHeight / $orginalHeight) * $originalWidth;
            $newHeight = $maxHeight;
        }
        // is wider
        if ($newWidth > $maxWidth) {
            $newHeight = ($maxWidth / $newWidth) * $newHeight;
            $newWidth = $maxWidth;
        }
        $thumbnail = imagecreatetruecolor(intval($newWidth), intval($newHeight));
        if ($fileExtension === 'png') {
            /* making the new image transparent */
            $background = imagecolorallocate($thumbnail, 0, 0, 0);
            ImageColorTransparent($thumbnail, $background); // make the new temp image all transparent
            imagealphablending($thumbnail, false); // turn off the alpha blending to keep the alpha channel
        }
        imagecopyresized($thumbnail, $original, 0, 0, 0, 0, intval($newWidth), intval($newHeight),
                $originalWidth, $orginalHeight);
        ob_start();
        if ($fileExtension === 'png') {
            imagepng($thumbnail);
        } else {
            imagejpeg($thumbnail);
        }
        $resizedPicture = ob_get_contents();
        ob_end_clean();
        imagedestroy($original);
        return $asBase64Url === FALSE ?  $resizedPicture
            : 'data:image/' . $fileExtension . ';base64,' . base64_encode($resizedPicture);
    }

    /**
     * Checks if the picture is too big to be processed in server-side memory
     * @param string $filePath Full file path of the picture to check
     * @param float $tweakFactor Factor used to evaluate the memory required for
     * processing picture.
     * @return boolean TRUE if the picture is too big to be processed, otherwise
     * FALSE
     */
    static public function isPictureTooBig($filePath, $tweakFactor = 2) {
        $imageInfo = getimagesize($filePath);
        $channels = key_exists('channel', $imageInfo) ? $imageInfo['channels'] : 1;
        $K64 = 65536;    // number of bytes in 64K
        $memoryRequired = round(
            ($imageInfo[0] * $imageInfo[1] * $imageInfo['bits'] * $channels
                / 8 + $K64) * $tweakFactor);
        $usedMemory = memory_get_usage();
        $memoryLimit = intval(ini_get('memory_limit'))*1048576;
        return $usedMemory + $memoryRequired > $memoryLimit;
    }

    /**
     * Compares two amounts and indicates in return if the amounts are equals or
     * if the first amount is lower or greater than the other one.
     * @param string $amount1 The first amount to compare with the other
     * @param string $amount2 The second amount to compare with the first one
     * @return char Value '=' if they are equals, '<' if the first amount is
     * lower than the second otherwise returns '>'.
     */
    static public function compareAmounts($amount1, $amount2) {
        $floatAmount1 = \Convert::toDecimal($amount1);
        $floatAmount2 = \Convert::toDecimal($amount2);
        $balanceAmount = round($floatAmount1 - $floatAmount2, \api\Locale::getNumberOfDecimals());
        if ($balanceAmount > 0) {
            return '>';
        } elseif ($balanceAmount < 0) {
            return '<';
        } else {
            return '=';
        }
    }

    /**
     * Encrypts plain text with the specified password
     * @param string $plainText The plain text to encrypt
     * @param string $password The password required for decrypting the plain text
     * @param boolean $isReturnedAsBase64 If TRUE (by default), the encrypted
     * text is returned encoded in base 64 for storage purpose.
     * @return string the encrypted text
     * @throws ZDKException GEN-007: 'openssl' extension is missing.
     */
    static public function encrypt($plainText, $password, $isReturnedAsBase64 = TRUE) {
        if (!extension_loaded('openssl')) {
            throw new ZDKException('GEN-007: \'openssl\' extension is not installed.');
        }
        $method = "AES-256-CBC";
        $key = hash('sha256', $password, true);
        $iv = openssl_random_pseudo_bytes(16);
        $ciphertext = openssl_encrypt($plainText, $method, $key, OPENSSL_RAW_DATA, $iv);
        $hash = hash_hmac('sha256', $ciphertext, $key, true);
        return $isReturnedAsBase64 ? base64_encode($iv . $hash . $ciphertext) : $iv . $hash . $ciphertext;
    }

    /**
     * Decrypts the crypted text using the specified password
     * @param string $cryptedText The crypted text
     * @param string $password The password used to encrypt the original plain text
     * @param boolean $isBase64encoded If TRUE (by default), the crypted text is
     * first decoded from base 64 encoding before being decrypted.
     * @return string the decrypted text or NULL if decryption failed
     * @throws ZDKException GEN-008: 'openssl' extension is missing.
     */
    static public function decrypt($cryptedText, $password, $isBase64encoded = TRUE) {
        if (!extension_loaded('openssl')) {
            throw new ZDKException('GEN-008: \'openssl\' extension is not installed.');
        }
        $ivHashCiphertext = $isBase64encoded ? base64_decode($cryptedText) : $cryptedText;
        $method = "AES-256-CBC";
        $iv = substr($ivHashCiphertext, 0, 16);
        $hash = substr($ivHashCiphertext, 16, 32);
        $ciphertext = substr($ivHashCiphertext, 48);
        $key = hash('sha256', $password, true);
        if (hash_hmac('sha256', $ciphertext, $key, true) !== $hash) {
            return NULL;
        }
        return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * Call a controller action of a remote ZnetDK application.
     * The remote controller action must be exposed as a Web Service (see
     * CFG_HTTP_BASIC_AUTHENTICATION_ENABLED and
     * CFG_ACTIONS_ALLOWED_FOR_WEBSERVICE_USERS parameters).
     * @param String $swUrl URL of the remote application. For example:
     * 1) https://usr:pwd@mydomain.com/
     * 2) https://usr:pwd@mydomain.com/mydir/?appl=myapp
     * @param String $method Value 'POST' or 'GET'
     * @param String $controller Controller name
     * @param String $action Action name
     * @param Array $extraParameters POST or GET parameters expected by the
     *  remote action. For example: [my_param1 => 'val1', my_param2 => 'val2']
     * @param Array $extraHeaders Extra header lines to add to the HTTP header
     * sent to the remote action.
     * @param Boolean $returnHeader If TRUE, the HTTP header is also returned.
     * @return Mixed Data returned by the remote action. If JSON data are
     * returned, they can be converted with the PHP json_decode function.
     * if $returnHeader is TRUE, an array is returned and the header is returned
     * as second value of the array.
     */
    static public function callRemoteAction($swUrl, $method, $controller, $action,
            $extraParameters = [], $extraHeaders = [], $returnHeader = FALSE) {
        $parsedUrl = parse_url($swUrl);
        $userPwd = key_exists('user', $parsedUrl) && key_exists('pass', $parsedUrl)
            ? "{$parsedUrl['user']}:{$parsedUrl['pass']}" : NULL;
        $params = [
                'control' => $controller,
                'action' => $action
            ];
        if (count($extraParameters)) {
            $params = array_merge($params, $extraParameters);
        }
        $headers = [];
        if ($method === 'POST') {
            $headers[] = 'Content-type: application/x-www-form-urlencoded';
            if (key_exists('query', $parsedUrl) && strlen($parsedUrl['query']) > 0) {
                $urlParameters = [];
                parse_str($parsedUrl['query'], $urlParameters);
                $params = array_merge($params, $urlParameters);
            }
            if (!is_null($userPwd)) {
                $basicAuth = base64_encode($userPwd);
                $headers[] = 'Authorization: Basic ' . $basicAuth;
            }
            $header = implode("\r\n", array_merge($headers, $extraHeaders));
            $context = stream_context_create(['http' => [
                    'method'  => $method,
                    'header' => $header,
                    'content' => http_build_query($params)
            ]]);
            $port = key_exists('port', $parsedUrl) && is_int($parsedUrl['port'])
                    ? ':' . strval($parsedUrl['port']) : '';
            $url = "{$parsedUrl['scheme']}://{$parsedUrl['host']}{$port}{$parsedUrl['path']}";
        } else {
            $context = NULL;
            if (count($extraHeaders) > 0) {
                $context = stream_context_create([
                    'http' => [
                      'method' => $method,
                      'header' => implode("\r\n", $extraHeaders),
                    ]
                ]);
            }
            $url = $swUrl
                . (key_exists('query', $parsedUrl) && strlen($parsedUrl['query']) > 0 ? '&' : '?')
                . http_build_query($params);
        }
        $response = file_get_contents($url, FALSE, $context);
        return $returnHeader ? [$response, $http_response_header] : $response;
    }

    static public function generateHtaccess() {
        $error = "Generation of the .htaccess file failed with error #%1.";
        if (!defined('ZNETDK_ROOT') || !defined('ZNETDK_ROOT_URI')) {
            self::writeErrorLog('ZNETDK ERROR', self::getFilledMessage($error, 1), TRUE);
            return FALSE;
        }
        $htaccessFilePath = ZNETDK_ROOT . '.htaccess';
        if (file_exists($htaccessFilePath)) {
            return TRUE;
        }
        if (!is_writable(ZNETDK_ROOT)) { // Root App directory not writable
            self::writeErrorLog('ZNETDK ERROR', self::getFilledMessage($error, 2), TRUE);
            return FALSE;
        }
        $template = <<<'EOT'
## BEGIN ZNETDK
# The directives between "BEGIN ZNETDK" and "END ZNETDK" are automatically
# generated by ZnetDK.

# Default file returned when only domain name is requested
DirectoryIndex index.php

# Don't show directory listings for URLs which map to a directory.
Options -Indexes

# 403 - Access forbidden (try to list directory content)
ErrorDocument 403 ZNETDK_ROOT_URIindex.php?control=httperror&action=403
# 404 - Resource not found
ErrorDocument 404 ZNETDK_ROOT_URIindex.php?control=httperror&action=404

# Module 'mod_rewrite' IS INSTALLED
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteBase ZNETDK_ROOT_URI
# No resource specified after the base URL
RewriteRule ^$ - [L]
# index.php is the only PHP script allowed
RewriteRule ^index\.php$ - [L]
# Root service-worker.js script is allowed
RewriteRule ^service\-worker\.js$ - [L]
# Public directories are allowed
RewriteRule ^applications/.*/public/.*$ - [L]
RewriteRule ^engine/public/.*$ - [L]
RewriteRule ^engine/tools/appwiz/public/.*$ - [L]
RewriteRule ^engine/tools/appwiz\-preview/public/.*$ - [L]
RewriteRule ^engine/modules/.*/public/.*$ - [L]
# Resources directory is allowed
RewriteRule ^resources/.*$ - [L]
# 403 - Access to other web resources is forbidden
RewriteRule ^.*$ index.php?control=httperror&action=403 [L]
</IfModule>

# Fontawesome fix for deployment over the SSL protocol
<FilesMatch "\.(eot|woff|woff2|svg|ttf)$">
FileETag None
<ifModule mod_headers.c>
Header unset Cache-Control
Header unset Pragma
Header unset Expires
</ifModule>
</FilesMatch>

# The HTTP_AUTHORIZATION variable is set for HTTP requests with Basic Authentication
# This variable is used for Web Services call with Basic Authentication
# This is workaround when CGI mode is enabled on Hosting Server.
SetEnvIf Authorization "(.*)" HTTP_AUTHORIZATION=$1

## END ZNETDK
EOT;
        $htaccessContent = str_replace(['ZNETDK_ROOT_URI', "\r\n"], [ZNETDK_ROOT_URI, PHP_EOL], $template);
        if (file_put_contents($htaccessFilePath, $htaccessContent) === FALSE) {
            self::writeErrorLog('ZNETDK ERROR', self::getFilledMessage($error, 3), TRUE);
            return FALSE;
        }
        return TRUE;
    }

}
