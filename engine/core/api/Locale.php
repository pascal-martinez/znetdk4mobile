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
 * Core Localization API
 *
 * File version: 1.6
 * Last update: 03/23/2023 
 */

namespace api;

/**
 * ZnetDK core localization API
 */
Class Locale {

    /**
     * Identifies the language to use for the application, loads the related
     * labels translations and finally memorize the language in the user session.
     * The default language (CFG_DEFAULT_LANGUAGE) is used if the language sent
     * in the HTTP request as GET parameter is not supported by the application.
     * If no language is specified in the HTTP request, the language previously
     * stored in the user session is the one used.
     * Finally, if no language is specified as GET parameter and no language is 
     * stored in session, the language configured for the web browser is used if
     * it is supported by the application. 
     */
    static public function setApplicationLanguage() {
        $language = CFG_DEFAULT_LANGUAGE;
        if (CFG_MULTI_LANG_ENABLED) {
            $langInRequest = \Request::getLanguage();
            $langInSession = \UserSession::getLanguage();
            $langInHeader = \Request::getAcceptLanguage();
            if (isset($langInRequest)) {
                $language = $langInRequest; // Priority to the REQUEST lang
            } elseif (isset($langInSession)) {
                $language = $langInSession; // Else the SESSION lang is used if set
            } elseif (isset($langInHeader)) {
                // Otherwise, browser language is read from the HTTP request header
                $language = substr($langInHeader, 0, 2);
            }
        }
        self::includeApplicationTranslations($language);
        self::includeModulesTranslations($language);
        self::includeCoreTranslations($language);
        // New language is set in SESSION lang
        \UserSession::setLanguage($language);
        // Set locale settings
        self::setLocale();
    }
    
    /**
     * Returns the locale settings according to the settings of the LC_LOCALE_ALL
     * constant defined into the 'locale.php' file
     * @return Array The locale settings as array matching the 'setLocale' 
     * parameters. For example: 0 => 'LC_ALL', 1 => 'fr_FR', 2 => 'fra'.
     */
    static public function getLocale() {
        if (!defined('LC_LOCALE_ALL')) {
            return NULL;
        }
        $localeSettings = unserialize(LC_LOCALE_ALL);
        if (!is_array($localeSettings)) {
            return NULL;
        }
        array_unshift($localeSettings, LC_ALL);
        return $localeSettings;
    }

    /**
     * Sets the locale settings according to the settings of the LC_LOCALE_ALL
     * constant defined into the 'locale.php' file
     * @return string|boolean The current locale string if locale is successfully
     * set, FALSE otherwise
     */
    static public function setLocale() {
        $localeSettings = self::getLocale();
        if (is_null($localeSettings)) {
            return setlocale(LC_ALL, 0);
        }
        return call_user_func_array('setlocale', $localeSettings);
    }
    
    /**
     * Returns the language label which matches the specified code in ISO 639-1 format.
     * The language labels are configured for the CFG_COUNTRY_LABELS parameter. 
     * @param string $code Language code for which the label is to return
     * @return string Label of the language
     */
    static public function getLanguageLabel($code) {
        $languages = unserialize(CFG_COUNTRY_LABELS);
        if (array_key_exists($code, $languages)) {
            return $languages[$code];
        } else {
            return 'no label!';
        }
    }

    /**
     * Returns the filename of the icon that matches the specified language code
     * in ISO 639-1 format.
     * The language icon is configured for the parameter CFG_COUNTRY_ICONS
     * @param string $code Language code for which the icon is requested
     * @return string Filename of the language icon 
     */
    static public function getLanguageIcon($code) {
        $languages = unserialize(CFG_COUNTRY_ICONS);
        if (array_key_exists($code, $languages)) {
            return $languages[$code];
        } else {
            return 'no icon!';
        }
    }

    /**
     * Return the languages supported by the application 
     * @param boolean $exlude_sess_lang Specifies whether the language stored
     * in session must be excluded from the list.
     * @return array List of the language codes in ISO 639-1 format
     */
    static public function getActiveLanguages($exlude_sess_lang = false) {
        $languages = array();
        foreach (glob(ZNETDK_APP_ROOT . '/app/lang/locale_*.php') as $filename) {
            $curr_lang = substr($filename, -6, 2);
            if ($exlude_sess_lang && $curr_lang === \UserSession::getLanguage()) {
                // When $exlude_sess_lang is set to true, current session language is not returned
            } else {
                $languages[] = substr($filename, -6, 2);
            }
        }
        return $languages;
    }

    /**
     * Returns the decimal separator matching the current language of the application
     * @return string Decimal separator ('.' or ',')
     */
    static public function getDecimalSeparator() {
        if (LC_LOCALE_DECIMAL_SEPARATOR === NULL) {
            $locale = localeconv();
            $separator = \Convert::toUTF8($locale['mon_decimal_point']);
            return $separator === '' ? '.' : $separator;
        } else {
            return LC_LOCALE_DECIMAL_SEPARATOR;
        }
    }
    
    /**
     * Returns the thousand separator matching the current language of the application
     * @return string The thousand separator (' ', '.' or ',')
     */
    static public function getThousandsSeparator() {
        if (LC_LOCALE_THOUSANDS_SEPARATOR === NULL) {
            $locale = localeconv();
            $separator = \Convert::toUTF8($locale['mon_thousands_sep']);
            return $separator === ',' || $separator === '.' ? $separator : ' ';
        } else {
            return LC_LOCALE_THOUSANDS_SEPARATOR;
        }
    }
    
    /**
     * Returns the number of decimals matching the current language of the application
     * @return int Number of decimals (usually 2)
     */
    static public function getNumberOfDecimals() {
        if (LC_LOCALE_NUMBER_OF_DECIMALS === NULL) {
            $locale = localeconv();
            return $locale['frac_digits'] > 10 ? 2 : $locale['frac_digits'];
        } else {
            return LC_LOCALE_NUMBER_OF_DECIMALS;
        }
    }
    
    /**
     * Returns the step for entering a number from an HTML5 input element of
     * type "number", according to the number of decimals defined for the
     * current language. This value is ready to set the 'step' HTML5 attribute 
     * of a number input
     * @return string Step value, for example '0.01' if 2 decimals are allowed 
     */
    static public function getStepNumber() {
        $zeros = str_repeat('0',self::getNumberOfDecimals()-1);
        $step = '0.'.$zeros.'1';
        return $step;
    }

    /**
     * Indicates whether the currency symbol precedes or not the amount
     * @return boolean TRUE if the currency symbol does precede the amount,
     * FALSE otherwise
     */
    static public function doesCurrencySymbolPrecedeAmount() {
        if (LC_LOCALE_CURRENCY_SYMBOL_PRECEDE === NULL) {
            $locale = localeconv();
            return $locale['p_cs_precedes'];
        } else {
            return LC_LOCALE_CURRENCY_SYMBOL_PRECEDE;
        }
    }

    /**
     * Returns the separator character located between the amount and the 
     * currency symbol
     * @return string Separator of the currency symbol with the amount
     */
    static public function getCurrencySymbolSeparator() {
        if (LC_LOCALE_CURRENCY_SYMBOL_SEPARATE === NULL) {
            $locale = localeconv();
            return $locale['p_sep_by_space'] ? ' ' : '';
        } else {
            return LC_LOCALE_CURRENCY_SYMBOL_SEPARATE ? ' ' : '';
        }
    }
    
    /**
     * Returns the currency symbol
     * @param boolean $forPdfPrinting If TRUE, if the currency symbol returned
     * is the Euro symbol(i.e "€), the Ansi version is returned instead (obtained
     * by the "chr(128)" statement)
     * @return string The currency symbol
     */
    static public function getCurrencySymbol($forPdfPrinting = FALSE) {
        if (LC_LOCALE_CURRENCY_SYMBOL === NULL) {
            $locale = localeconv();
            $symbolUTF8 = \Convert::toUTF8($locale['currency_symbol']);
            $symbol = $symbolUTF8 === $locale['currency_symbol'] ? $symbolUTF8 
                : \Convert::toUTF8($locale['currency_symbol'], 'Windows-1252');            
        } else {
            $symbol = LC_LOCALE_CURRENCY_SYMBOL;
        }
        if ($forPdfPrinting && $symbol === '€') {
            return chr(128);
        }
        return $symbol;
    }
    
    /**
     * Returns the date format used by the DateTimeInterface::format() PHP
     * method according the current selected language in the 
     * LC_LOCALE_DATE_FORMAT PHP constant.
     * @return string Configured date format in LC_LOCALE_DATE_FORMAT.
     */
    static public function getLocaleDateFormat() {
        return LC_LOCALE_DATE_FORMAT;        
    }
    
    /**
     * Adds the currency symbol to the specified amount according to the
     * current language set for the application.
     * If a currency symbol is set for the LC_LOCALE_CURRENCY_SYMBOL constant,
     * then it is used instead of the one returned by the 'localeconv' PHP 
     * function.
     * @param string $amount The amount to be completed by the currency symbol
     * @param boolean $forPdfPrinting If TRUE, the Euro symbol (i.e "€") is 
     * replaced by the Ansi character set symbol (obtained by "chr(128)") for
     * PDF printing purpose.  
     * @return string The amount with the currency symbol
     */
    static public function addCurrencySymbol($amount, $forPdfPrinting = FALSE) {
        $space = self::getCurrencySymbolSeparator();
        $currencySymbol = self::getCurrencySymbol($forPdfPrinting);
        if (self::doesCurrencySymbolPrecedeAmount()) {
            return $currencySymbol . $space . $amount;
        } else {
            return $amount . $space . $currencySymbol;
        }
    }
        
    /**
     * Includes for the specified language, the specific translations defined 
     * at the application level.
     * @param string $language Language code in ISO 639-1 format. This code 
     * is modified to the default language if no translation exists for the 
     * specified language in parameter 
     */
    static private function includeApplicationTranslations(&$language) {
        \ErrorHandler::suspend();
        $langPath = ZNETDK_APP_ROOT . DIRECTORY_SEPARATOR . 'app'
                . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR;
        if (!include "{$langPath}locale_{$language}.php") {
            $language = CFG_DEFAULT_LANGUAGE;
            if (!include "{$langPath}locale_{$language}.php") {
                include "{$langPath}locale.php";
            }
        }
        \ErrorHandler::restart();
    }
    
    /**
     * Includes for the specified language, the specific translations defined 
     * at the core level.
     * @param string $language Language code in ISO 639-1 format
     */
    static private function includeCoreTranslations($language) {
        \ErrorHandler::suspend();
        $langPath = ZNETDK_CORE_ROOT . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR; 
        if (!include "{$langPath}locale_{$language}.php") {
            include "{$langPath}locale_en.php"; // English by default if $language not supported 
        }
        \ErrorHandler::restart();
    }
    
    /**
     * Includes for the specified language, the specific translations defined 
     * at modules level.
     * @param string $language Language code in ISO 639-1 format
     */
    static private function includeModulesTranslations($language) {
        \ErrorHandler::suspend();
        $modules = \General::getModules();
        if ($modules) {
            foreach ($modules as $moduleName) {
                $path = ZNETDK_MOD_ROOT . DIRECTORY_SEPARATOR . $moduleName
                    . DIRECTORY_SEPARATOR . 'mod' . DIRECTORY_SEPARATOR. 'lang'
                    . DIRECTORY_SEPARATOR . 'locale_%1.php';
                if (!include \General::getFilledMessage($path, $language)) {
                    // English by default if $language not supported 
                    include \General::getFilledMessage($path, 'en');
                }
            }
        }
        \ErrorHandler::restart();
    }
}
