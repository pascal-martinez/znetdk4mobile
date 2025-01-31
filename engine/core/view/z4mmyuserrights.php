<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr
 * Copyright (C) 2022 Pascal MARTINEZ (contact@znetdk.fr)
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
 * ZnetDK Core "My user rights" view for mobile
 *
 * File version: 1.4
 * Last update: 10/19/2024
 */
$profileNamesAsList = '';
$profileIDs = [];
UserManager::getUserProfiles(UserSession::getUserId(), $profileNamesAsList, $profileIDs);
$profiles = count($profileIDs) > 0 ? explode(', ', $profileNamesAsList) : [];
$hasFullMenuAccess = UserSession::hasFullMenuAccess();
$color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
?>
<div id="mzdk-my-user-rights" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-key fa-lg"></i>
                <span class="title"><?php echo LC_HEAD_USERPANEL_MY_USER_RIGHTS; ?></span>
            </h4>
        </header>
        <div class="w3-container <?php echo $color['modal_content']; ?>">
<?php if (count($profiles) > 0) : ?>
            <ul class="w3-ul w3-border w3-margin-top">
                <li><h3><i class="fa fa-users"></i>&nbsp;<?php echo LC_TABLE_COL_USER_PROFILES; ?></h3></li>
<?php                foreach ($profiles as $profileName) : ?>
                <li><i class="fa fa-check fa-lg w3-text-green"></i>&nbsp;<?php echo $profileName; ?></li>
<?php                endforeach; ?>
            </ul>
<?php endif; ?>
            <ul class="w3-ul w3-border w3-margin-top w3-margin-bottom">
                <li><h3><i class="fa fa-bars"></i>&nbsp;<?php echo LC_FORM_LBL_USER_MENU_ACCESS; ?></h3></li>
                <li>
                    <span class="w3-tag <?php echo $color['tag']; ?>"><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL; ?></span>
                    <span><?php echo $hasFullMenuAccess 
                        ? '<i class="fa fa-check fa-lg w3-text-green"></i>&nbsp;' . LC_BTN_YES 
                        : '<i class="fa fa-times fa-lg w3-text-red"></i>&nbsp;' . LC_BTN_NO; ?></span>
                </li>
            </ul>
        </div>
        <div class="w3-container w3-padding-16 w3-border-top <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </div>
    </div>
</div>