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
* Core Http Forgotten password view
*
* File version: 1.2
* Last update: 10/30/2024
*/
if (CFG_PAGE_LAYOUT === 'mobile') : 
    $color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME; ?>
        <div id="mzdk_forgot_password_dialog" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container <?php echo $color['modal_header']; ?>">
                    <span class="close w3-button w3-xlarge w3-hover-theme w3-display-topright"><i class="fa fa-times-circle fa-lg"></i></span>
                    <h4>
                        <i class="fa fa-unlock-alt fa-lg"></i>
                        <span class="title"><?php echo LC_FORM_TITLE_NEW_PASSWORD_REQUEST; ?></span>
                    </h4>
                </header>
                <form class="w3-container <?php echo $color['modal_content']; ?>" data-zdk-submit="forgotpassword:requestpassword">
                    <div class="w3-section">
                        <label class="zdk-required"><b><?php echo LC_FORM_LBL_USER_EMAIL; ?></b></label>
                        <input class="w3-input w3-border w3-margin-bottom" type="email" name="email" placeholder="<?php echo LC_FORM_NEW_PASSWORD_REQUEST_PLACEHOLDER; ?>" maxlength="100" required>
                        <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                            <i class="fa fa-check fa-lg"></i>&nbsp;
                            <?php echo LC_BTN_VALIDATE; ?>
                        </button>
                    </div>
                </form>
                <div class="w3-container w3-border-top w3-border-theme w3-padding-16 w3-theme-l4">
                    <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                        <i class="fa fa-close fa-lg"></i>&nbsp;
                        <?php echo LC_BTN_CANCEL; ?>
                    </button>
                </div>
            </div>
        </div>
<?php else : ?>
<div id="znetdk_forgot_password_dialog" class="zdk-modal" title="<?php echo LC_FORM_TITLE_NEW_PASSWORD_REQUEST; ?>" data-zdk-width="360px">
    <form class="zdk-form" data-zdk-action="forgotpassword:requestpassword">
        <label><?php echo LC_FORM_LBL_USER_EMAIL; ?></label>
        <input type="email" name="email" data-zdkerrmsg-type="<?php echo LC_MSG_ERR_EMAIL_INVALID; ?>" maxlength="100" placeholder="<?php echo LC_FORM_NEW_PASSWORD_REQUEST_PLACEHOLDER; ?>" required>
        <button class="zdk-bt-yes zdk-close-dialog"><?php echo LC_BTN_VALIDATE; ?></button>
        <button class="zdk-bt-cancel zdk-close-dialog" type="button"><?php echo LC_BTN_CANCEL; ?></button>
    </form>
</div>
<?php endif;

