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
 * ZnetDK Core "My user rights" view
 *
 * File version: 1.1
 * Last update: 01/11/2023
 */
$profileNamesAsList = '';
$profileIDs = [];
UserManager::getUserProfiles(UserSession::getUserId(), $profileNamesAsList, $profileIDs);
$profiles = count($profileIDs) > 0 ? explode(', ', $profileNamesAsList) : [];
$hasFullMenuAccess = UserSession::hasFullMenuAccess();
?>
<div id="znetdk_my_user_rights_dialog" class="zdk-modal" title="<?php echo LC_HEAD_USERPANEL_MY_USER_RIGHTS; ?>"
     data-icon="fa-key" data-zdk-width="380px">
    <form class="zdk-form">
        <?php if (count($profiles) > 0) : ?>
        <fieldset>
            <legend><i class="fa fa-users"></i>&nbsp;<?php echo LC_TABLE_COL_USER_PROFILES; ?></legend>
<?php                foreach ($profiles as $profileName) : ?>
            <div><i class="fa fa-check fa-lg" style="color:springgreen"></i>&nbsp;<?php echo $profileName; ?></div>
<?php                endforeach; ?>
        </fieldset>
<?php endif; ?>
        <fieldset>
            <legend><i class="fa fa-bars"></i>&nbsp;<?php echo LC_FORM_LBL_USER_MENU_ACCESS; ?></legend>
            <div>
                <span><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL; ?></span>
                <span><?php echo $hasFullMenuAccess
                        ? '<i class="fa fa-check fa-lg" style="color:springgreen"></i>&nbsp;' . LC_BTN_YES
                        : '<i class="fa fa-times fa-lg" style="color:red"></i>&nbsp;' . LC_BTN_NO; ?></span>
            </div>
        </fieldset>
        <!-- Form buttons -->
        <button class="zdk-bt-cancel zdk-close-dialog" type="button"><?php echo LC_BTN_CLOSE; ?></button>
    </form>
</div>