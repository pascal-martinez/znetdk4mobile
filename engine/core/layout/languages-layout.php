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
 * Language selection for application layout
 *
 * File version: 1.2
 * Last update: 10/18/2023
 */
if (count($allLanguages) === 1) { ?>
                            <div id="zdk-language-area">
                                <a href="<?php echo $mainScriptWithGetParams; ?>">
                                    <img id="language_button" src="<?php echo ZNETDK_ROOT_URI . \api\Locale::getLanguageIcon(current($allLanguages)); ?>" alt="<?php echo \api\Locale::getLanguageLabel(current($allLanguages)); ?>"> <?php echo \api\Locale::getLanguageLabel(current($allLanguages)) .PHP_EOL; ?>
                                </a>
                            </div>
<?php } else { ?>
                            <div id="zdk-language-area">
                                <form action="<?php echo $mainScript; ?>"><?php if (!\General::isDefaultApplication()) { echo PHP_EOL; ?>
                                    <input type="hidden" name="<?php echo \Request::getOtherApplication(TRUE); ?>" value="<?php echo ZNETDK_APP_NAME;?>"><?php } echo PHP_EOL; ?>
                                    <img src="<?php echo ZNETDK_ROOT_URI . \api\Locale::getLanguageIcon($sessionLanguage); ?>" alt="<?php echo \api\Locale::getLanguageLabel($sessionLanguage); ?>">
                                    <select name="lang" style="width:94px;" data-countries='<?php echo $jsonCountries; ?>' data-curlang="<?php echo $sessionLanguage; ?>"></select>
                                </form>
                            </div>
    <?php
}
