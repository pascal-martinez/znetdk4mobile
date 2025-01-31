<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2024 Pascal MARTINEZ (contact@znetdk.fr)
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
 * ZnetDK Core "Change password" view for mobile
 *
 * File version: 1.1
 * Last update: 10/19/2024
 */
$color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
?>
<div id="zdk-changepwd-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-unlock-alt fa-lg"></i>
                <span class="title"><?php echo LC_FORM_TITLE_CHANGE_PASSWORD; ?></span>
            </h4>
        </header>
        <form class="w3-container <?php echo $color['modal_content']; ?>" data-zdk-submit="Security:login">
            <input type="hidden" name="access" value="private">
            <div class="w3-section">
                <label>
                    <b><?php echo LC_FORM_LBL_LOGIN_ID; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="login_name" autocomplete="off" readonly>
                </label>
                <label class="zdk-password old-password w3-show-block">
                    <b><?php echo LC_FORM_LBL_ORIG_PASSWORD; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" name="password" autocomplete="current-password" required>
                    <a class="zdk-toggle-password" href="#" aria-label="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"><i class="fa fa-eye-slash fa-lg" aria-hidden="true" title="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"></i></a>
                </label>
                <label class="zdk-password w3-show-block">
                    <b><?php echo LC_FORM_LBL_NEW_PASSWORD; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="password" name="login_password" autocomplete="new-password" required>
                    <a class="zdk-toggle-password" href="#" aria-label="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"><i class="fa fa-eye-slash fa-lg" aria-hidden="true" title="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"></i></a>
                </label>
                <ul class="pwd-requirement w3-ul w3-margin-bottom">
<?php if (is_string(CFG_CHECK_PWD_LOWERCASE_REGEXP)): ?>
                    <li class="w3-text-red" data-regexp="<?php echo CFG_CHECK_PWD_LOWERCASE_REGEXP; ?>"><i class="fa fa-times"></i> <b><?php echo LC_FORM_LBL_PASSWORD_EXPECTED_LOWERCASE; ?></b></li>
<?php endif; if (is_string(CFG_CHECK_PWD_UPPERCASE_REGEXP)): ?>
                    <li class="w3-text-red" data-regexp="<?php echo CFG_CHECK_PWD_UPPERCASE_REGEXP; ?>"><i class="fa fa-times"></i> <b><?php echo LC_FORM_LBL_PASSWORD_EXPECTED_UPPERCASE; ?></b></li>
<?php endif; if (is_string(CFG_CHECK_PWD_NUMBER_REGEXP)): ?>
                    <li class="w3-text-red" data-regexp="<?php echo CFG_CHECK_PWD_NUMBER_REGEXP; ?>"><i class="fa fa-times"></i> <b><?php echo LC_FORM_LBL_PASSWORD_EXPECTED_NUMBER; ?></b></li>
<?php endif; if (is_string(CFG_CHECK_PWD_SPECIAL_REGEXP)): ?>
                    <li class="w3-text-red" data-regexp="<?php echo CFG_CHECK_PWD_SPECIAL_REGEXP; ?>"><i class="fa fa-times"></i> <b><?php echo LC_FORM_LBL_PASSWORD_EXPECTED_SPECIAL; ?></b></li>
<?php endif; if (is_string(CFG_CHECK_PWD_LENGTH_REGEXP)): ?>
                    <li class="w3-text-red" data-regexp="<?php echo CFG_CHECK_PWD_LENGTH_REGEXP; ?>"><i class="fa fa-times"></i> <b><?php echo LC_FORM_LBL_PASSWORD_EXPECTED_LENGTH; ?></b></li>
<?php endif; ?>
                </ul>
                <label class="zdk-password w3-show-block">
                    <b><?php echo LC_FORM_LBL_PASSWORD_CONFIRM; ?></b>
                    <input class="w3-input w3-border" type="password" name="login_password2" autocomplete="new-password" required>
                    <a class="zdk-toggle-password" href="#" aria-label="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"><i class="fa fa-eye-slash fa-lg" aria-hidden="true" title="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"></i></a>
                </label>
                <ul class="pwd-match w3-ul w3-margin-bottom">
                    <li class="w3-text-red"><i class="fa fa-times"></i> <b><?php echo LC_FORM_LBL_PASSWORDS_MUST_MATCH; ?></b></li>
                </ul>
                <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                    <i class="fa fa-save fa-lg"></i>&nbsp;
                    <?php echo LC_BTN_SAVE; ?>
                </button>
            </div>
        </form>
        <div class="w3-container w3-padding-16 w3-border-top <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CANCEL; ?>
            </button>
        </div>
    </div>
</div>
<script>
<?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4mchangepwd' ** For debug purpose **");
<?php endif; ?>
    (function () {
        const colors = ['w3-text-red', 'w3-text-green'],
            icons = ['fa-times', 'fa-check'],
            oldPwdEl = $('#zdk-changepwd-modal input[name=password]'),
            newPwdEl = $('#zdk-changepwd-modal input[name=login_password]'),
            newPwdPanel = $('#zdk-changepwd-modal .pwd-requirement'),
            confirmPwdEl = $('#zdk-changepwd-modal input[name=login_password2]'),
            confirmPwdPanel = $('#zdk-changepwd-modal .pwd-match');
        $('#zdk-changepwd-modal').on('beforeshow', function () {            
            if (oldPwdEl.val() !== '') {
                $(this).find('label.old-password').addClass('w3-hide')
                    .removeClass('w3-show-block');
                newPwdPanel.removeClass('w3-hide');
            } else {
                newPwdPanel.addClass('w3-hide');
            }            
            confirmPwdPanel.addClass('w3-hide');
            updateStateNewPwdConstraints('');
            updateStateConfirm('', '');
        });
        newPwdEl.on('focus', function(){
            newPwdPanel.removeClass('w3-hide');
        }).on('keyup', function(){
            updateStateNewPwdConstraints(newPwdEl.val());
        });
        confirmPwdEl.on('focus', function(){
            confirmPwdPanel.removeClass('w3-hide');
        }).on('keyup', function(){
            updateStateConfirm(newPwdEl.val(), $(this).val());
        });
        function updateStateNewPwdConstraints(newPwdValue) {
            newPwdPanel.find('li[data-regexp]').each(function(){
                const regexp = new RegExp($(this).data('regexp'), 'g');
                const isOk = regexp.test(newPwdValue);
                $(this).removeClass(colors[isOk?0:1]).addClass(colors[isOk?1:0]);
                $(this).children('i').removeClass(icons[isOk?0:1]).addClass(icons[isOk?1:0]);
            });
        }
        function updateStateConfirm(newPwdValue, confirmPwdValue) {
            const msgEl = confirmPwdPanel.children('li');
            const isOk = newPwdValue.length > 0 && newPwdValue === confirmPwdValue;
            msgEl.removeClass(colors[isOk?0:1]).addClass(colors[isOk?1:0]);
            msgEl.children('i').removeClass(icons[isOk?0:1]).addClass(icons[isOk?1:0]);
        }
    })();
</script>