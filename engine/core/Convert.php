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
 * Core API for data conversion
 *
 * File version: 1.10
 * Last update: 08/30/2023
 */

/**
 * Various ZnetDK conversion methods
 */
class Convert {

    /**
     * Formats the specified number to be displayed as a money
     * @param mixed $number Number to convert
     * @param boolean $withCurrencySymbol Specifies whether the currency symbol
     * is to be added to the formatted number (added by default)
     * @param integer $numberOfDecimals Number of decimals of the converted
     * @param boolean $forPdfPrinting If TRUE, the currency symbol of the
     * formated number is suitable for PDF printing
     * amount
     * @return string Number formated as a money
     */
    static public function toMoney($number, $withCurrencySymbol=TRUE, $numberOfDecimals=NULL, $forPdfPrinting=FALSE) {
        if (is_null($number)) {
            return NULL;
        }
        $decimalNumber = self::toDecimal($number);
        $decimalSeparator = \api\Locale::getDecimalSeparator();
        $thousandsSeparator = \api\Locale::getThousandsSeparator();
        $decimals = is_null($numberOfDecimals) ? \api\Locale::getNumberOfDecimals() : $numberOfDecimals;
        $numberWithoutSymbol = \number_format($decimalNumber,$decimals,$decimalSeparator,$thousandsSeparator);
        return $withCurrencySymbol
            ?\api\Locale::addCurrencySymbol($numberWithoutSymbol, $forPdfPrinting)
            : $numberWithoutSymbol;
    }

    /**
     * Converts the specified number to a formated number suitable for storage
     * in the database.
     * The decimal separator is a dot (i.e '.') and the grouping character is
     * removed.
     * @param mixed $number The number to convert
     * @param integer $numberOfDecimals Number of decimals expected in the
     * database
     * @return string The formated amount
     */
    static public function toDecimalForDB($number, $numberOfDecimals=NULL) {
        if (is_string($number) && trim($number) === '') {
            return '';
        }
        $convertedAmount = self::toMoney($number, FALSE, $numberOfDecimals);
        return self::removeThousandsSeparator(
                self::convertDecimalSeparatorToDotCharacter($convertedAmount));
    }

    /**
     * Converts a decimal number, especially from a string format to a float
     * format.
     * @param mixed $value Decimal number to convert.
     * @return float Value converted to a float number
     */
    static public function toDecimal($value) {
        if (!is_string($value)) {
            return $value;
        }
        $thousandsAndSeparatorOK = self::removeThousandsSeparator(
                self::convertDecimalSeparatorToDotCharacter($value));
        return floatval($thousandsAndSeparatorOK);
    }

    static private function removeThousandsSeparator($value) {
        $thousandsSeparator = \api\Locale::getThousandsSeparator();
        return str_replace($thousandsSeparator, '', strval($value));
    }

    static private function convertDecimalSeparatorToDotCharacter($value) {
        $decimalSeparator = \api\Locale::getDecimalSeparator();
        return str_replace($decimalSeparator, '.', strval($value));
    }

    /**
     * Converts the specified string from ISO-8859-1 to UTF-8 encoding
     * @param String $string String to convert
     * @param String $fromEncoding Character encoding of the string to convert
     * (ISO-8859-1 by default)
     * @return String Converted string in UTF-8
     */
    static public function toUTF8($string, $fromEncoding = 'ISO-8859-1') {
        json_encode($string);
        if (json_last_error() === JSON_ERROR_UTF8) {
            if (extension_loaded('mbstring')) {
                return mb_convert_encoding($string, 'UTF-8', $fromEncoding);
            } elseif (function_exists('iconv')) {
                return iconv($fromEncoding, 'UTF-8', $string);
            } elseif (extension_loaded('intl')) {
                return UConverter::transcode($string, 'UTF-8', $fromEncoding);
            }
            throw new \Exception('No encoding function is installed.');
        }
        return $string;
    }

    /**
     * Converts the specified string from UTF-8 to ISO-8859-1 encoding
     * @param String $string String to convert
     * @param String $fromEncoding Character encoding of the string to convert
     * (UTF-8 by default)
     * @return String Converted string in ISO-8859-1
     */
    static public function toISO88591($string) {
        if (extension_loaded('mbstring')) {
            return mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8');
        } elseif (function_exists('iconv')) {
            return iconv('UTF-8', 'ISO-8859-1', $string);
        } elseif (extension_loaded('intl')) {
            return UConverter::transcode($string, 'ISO-8859-1', 'UTF-8');
        }
        throw new \Exception('No encoding function is installed.');
    }

    /**
     * Formats the specified W3C date using the locale settings of the application
     * If the date is followed by a time, this time is kept as is.
     * @param string $W3CDate Date formatted in W3C format ('Y-m-d')
     * @return string Date formatted according to the current locale settings
     */
    static public function W3CtoLocaleDate($W3CDate) {
        if (!is_string($W3CDate)) {
            return NULL;
        }
        $formatedDate = self::toLocaleDate(new \DateTime($W3CDate));
        return strlen($W3CDate) === 19 ? $formatedDate . substr($W3CDate, 10) : $formatedDate;
    }

    /**
     * Converts a 'DateTime' object to a localized date.
     * If LC_LOCALE_DATE_FORMAT is NULL, the 'Intl' extension is used to get
     * the date format matching the locale set for LC_LOCALE_ALL.
     * Finally if LC_LOCALE_ALL is not specified, 'Y-m-d' date format is applied.
     * @param DateTime $dateTime A DateTime object
     * @return string The localized date
     */
    static public function toLocaleDate($dateTime) {
        $dateFormat = \api\Locale::getLocaleDateFormat();
        if (is_null($dateFormat) && extension_loaded('intl')) {
            $locale = \api\Locale::getLocale();
            if (is_array($locale) && key_exists(1, $locale)) {
                $dateFormatter = new IntlDateFormatter($locale[1], IntlDateFormatter::SHORT, IntlDateFormatter::NONE);
                return $dateFormatter->format($dateTime);
            }
        }
        return $dateTime->format(is_null($dateFormat) ? 'Y-m-d' : $dateFormat);
    }

    /**
     * Converts a '\DateTime' object to a W3C formated date
     * @param DateTime $dateTime A DateTime object
     * @return string Formated date in W3C standard
     */
    static public function toW3CDate($dateTime) {
        return $dateTime->format('Y-m-d');
    }

    /**
     * Converts the strings of the specified array from UTF-8 to Windows-1252
     * character set.
     * @param array $values Strings in a one dimension array encoded in UTF-8
     * @return array Values converted to Windows-1252 character set
     */
    static public function valuesToAnsi($values) {
        $convertedValues = array();
        foreach ($values as $key => $value) {
            if (extension_loaded('mbstring')) {
                $convertedValues[$key] = mb_convert_encoding(strval($value), 'Windows-1252', 'UTF-8');
            } elseif (function_exists('iconv')) {
                $convertedValues[$key] = iconv('UTF-8', 'Windows-1252', strval($value));
            } elseif (extension_loaded('intl')) {
                $convertedValues[$key] = UConverter::transcode(strval($value), 'Windows-1252', 'UTF-8');
            } else {
                throw new \Exception('No decoding function is installed.');
            }
        }
        return $convertedValues;
    }

    /**
     * Converts a base64 URL to a binary value
     * @param string $base64Url The base64 URL
     * @return string The converted binary value or an empty string if the
     * parameter value is an empty string or NULL if conversion failed;
     */
    static public function base64UrlToBinary($base64Url) {
        if ($base64Url === '') {
            return '';
        }
        $base64Data = explode(',', $base64Url);
        if (count($base64Data) !== 2) {
            return NULL;
        }
        $decoded = base64_decode($base64Data[1], TRUE);
        if ($decoded === FALSE) {
            return NULL;
        }
        return $decoded;
    }

    /**
     * Converts a binary value to a Base64 URL
     * @param string $binaryValue The binary value to convert
     * @return string The converted value or an empty string if the parameter
     * value is an empty string or NULL if conversion failed;
     */
    static public function binaryToBase64Url($binaryValue) {
        if ($binaryValue === '') {
            return '';
        }
        $mimeType = (new finfo(FILEINFO_MIME_TYPE))->buffer($binaryValue);
        if ($mimeType === FALSE) {
            return NULL;
        }
        $encoded = base64_encode($binaryValue);
        if ($encoded === FALSE) {
            return NULL;
        }
        return 'data:' . $mimeType . ';base64,' . $encoded;
    }

}