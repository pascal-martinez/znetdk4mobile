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
 * ZnetDK Core "Installation" view for mobile
 *
 * File version: 1.4
 * Last update: 10/21/2024
 */
$appUrl = str_replace('index.php', '', General::getApplicationURI());
$internetAddressText = General::getFilledMessage(LC_HEAD_USERPANEL_INSTALL_TEXT_INTERNET_ADDRESS, "<a href=\"{$appUrl}\">{$appUrl}</a>");
$safariShareIcon = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAA8CAIAAACvoq6rAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAzfHTVMAAAGHSURBVGje7dgxTsQwEAXQEUfgKNxgj8BRKOngBitaGiQuQEFJSYuo9grbUlKGHw2KHHu8iT0z2S3GmmI3ieMn27GToUFdvo/DzdMY+KEvpNdcPw5X92Pgh95EVhorUz/o7ZBrJhNObQ16+RIoaeCC7UCLGo2JnDTdJlJqsiPiBV6gu3e5sfSIiEZFe9DDR/XxzkDicoDqxqDdc3WxKUGlCdWNQbev1aVPBGUmVDcG/fyOUwFRLsQ1EJu4FqpvtJedBp1hcw3QeUGYevvP2RNeRivoxK3QEJrL5jstvk74gcTXFZo0K/dLcxDHZCIeqTV94woCgMduBGEg0xPluHpMap6vaUfg7z8oncV8dLOnLO0L3u8ou2NT3+hBaC6rTvqFxLZ6gAIUoAAFKEABmuUYLwKEz1N8KSP6sov2IH6t6XiRcgQZftYFKEABClCAAqQEde+R3buyAFKmYzRFTscoE1bdfVNNWDWl9JxiltJrSno6xSzp2ZQW9ugbIS28PnFuGAuJ8wspf8ppBYazmOWgAAAAAElFTkSuQmCC";
$safariShareIconTag = '<img src="' . $safariShareIcon . '" alt="Safari icon" width="18">';
$installOnAppleText = General::getFilledMessage(LC_HEAD_USERPANEL_INSTALL_TEXT_INSTALL_APPLE, $safariShareIconTag);
$smsMessage = General::getFilledMessage(LC_HEAD_USERPANEL_INSTALL_MSG_SEND_SMS, strip_tags(LC_HEAD_TITLE), $appUrl);
$color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
?>
<div id="mzdk-userpanel-install" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-hdd-o fa-lg"></i>
                <span class="title"><?php echo LC_HEAD_USERPANEL_INSTALL; ?></span>
            </h4>
        </header>
        <div class="w3-container <?php echo $color['modal_content']; ?>">
            <div class="is-installed w3-panel <?php echo $color['msg_info']; ?> w3-hide">
                <p><i class="fa fa-check fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_STATUS_IS_INSTALLED; ?></p>
            </div>
            <div class="not-installed w3-panel <?php echo $color['msg_warn']; ?> w3-hide">
                <p><i class="fa fa-exclamation-triangle fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLED; ?></p>
            </div>
            <div class="not-installable w3-panel <?php echo $color['msg_error']; ?> w3-hide">
                <p><i class="fa fa-times fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLABLE; ?></p>
            </div>
            <div class="install-button w3-hide">
                <div class="w3-padding-16"></div>
                <button class="w3-button w3-block <?php echo $color['btn_submit']; ?>" type="button"><i class="fa fa-hdd-o fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL; ?></button>
                <div class="w3-padding-16"></div>
            </div>
            <h2><i class="fa fa-question-circle"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS; ?></h2>
            <div class="w3-card w3-margin-bottom">
                <header class="info-web-address w3-container <?php echo $color['horizontal_nav_menu']; ?>">
                    <h4><i class="fa fa-globe fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_TITLE_INTERNET_ADDRESS; ?></h4>
                </header>
                <div class="w3-container">
                    <p><?php echo $internetAddressText; ?></p>
                    <p><?php echo LC_HEAD_USERPANEL_INSTALL_TEXT_COPY_CLIPBOARD; ?>
                        <button class="paste-to-clipboard w3-button w3-block <?php echo $color['btn_action']; ?>" type="button"
                                data-url="<?php echo $appUrl; ?>" 
                                data-success="<?php echo LC_HEAD_USERPANEL_INSTALL_SUCCESS_COPY_CLIPBOARD; ?>" 
                                data-failed="<?php echo LC_HEAD_USERPANEL_INSTALL_FAILED_COPY_CLIPBOARD; ?>">
                            <i class="fa fa-clipboard fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_BUTTON_COPY_CLIPBOARD; ?>
                        </button>
                    </p>
                    <p><?php echo LC_HEAD_USERPANEL_INSTALL_TEXT_SEND_SMS; ?>
                        <button class="send-by-sms w3-button w3-block <?php echo $color['btn_action']; ?>" type="button" data-sms="<?php echo $smsMessage; ?>">
                            <i class="fa fa-paper-plane fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_BUTTON_SEND_SMS; ?>
                        </button>
                    </p>
                </div>
            </div>
            <div class="info-iphone-install w3-card w3-margin-bottom">
                <header class="w3-container <?php echo $color['horizontal_nav_menu']; ?>">
                    <h4><i class="fa fa-apple fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_TITLE_INSTALL_APPLE; ?></h4>
                </header>
                <div class="w3-container">
                    <p><?php echo $installOnAppleText; ?></p>
                </div>
            </div>
            <div id="mzdk-userpanel-install-info-browser-compatibility" class="info-browser-compatibility w3-card w3-margin-bottom">
                <header class="w3-container <?php echo $color['horizontal_nav_menu']; ?>">
                    <h4><i class="fa fa-tablet fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL_TITLE_COMPATIBILITY; ?></h4>
                </header>
                <div class="w3-container">
                    <p><?php echo LC_HEAD_USERPANEL_INSTALL_TEXT_COMPATIBILITY; ?></p>
                  <ul class="w3-ul">
                      <li><span class="w3-tag <?php echo $color['tag']; ?>"><i class="fa fa-android"></i>&nbsp;Android</span> <i class="fa fa-chrome"></i>&nbsp;<b>Chrome</b>, Samsung Internet, Opera</li>
                      <li><span class="w3-tag <?php echo $color['tag']; ?>"><i class="fa fa-apple"></i>&nbsp;iOS</span> <i class="fa fa-safari"></i>&nbsp;<b>Safari</b> (<?php echo LC_HEAD_USERPANEL_INSTALL_SEE_COMPATIBILITY; ?> <i><?php echo LC_HEAD_USERPANEL_INSTALL_TITLE_INSTALL_APPLE; ?></i>)</li>
                      <li><span class="w3-tag <?php echo $color['tag']; ?>"><i class="fa fa-windows"></i>&nbsp;Windows</span> <i class="fa fa-edge"></i>&nbsp;<b>Edge</b>, Chrome, Opera</li>
                  </ul>
                </div>
            </div>
        </div>
        <div class="w3-container w3-padding-16 w3-border-top <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </div>
    </div>
</div>
<script>
(function(){
    let dialogEl = $('#mzdk-userpanel-install');
    // Show installation status message
    if (znetdkMobile.install.isAppInstalled()) {
        dialogEl.find('.is-installed').removeClass('w3-hide');
    } else if (znetdkMobile.install.isAppInstallable()) {
        dialogEl.find('.not-installed').removeClass('w3-hide');
    } else {
        dialogEl.find('.not-installable').removeClass('w3-hide');
    }
    // Show installation button and handle click events
    if (znetdkMobile.install.isAppInstallable()) {
        dialogEl.find('.install-button').removeClass('w3-hide');
        dialogEl.find('.install-button button').on('click.mzdk-userpanel-install', function(){
            znetdkMobile.install.installApp(function(){ // Installation succeeded
                // Install button is hidden
                dialogEl.find('.install-button').addClass('w3-hide');
                // Message "App is installed" is displayed
                dialogEl.find('.is-installed').removeClass('w3-hide');
                dialogEl.find('.not-installed').addClass('w3-hide');
            });
        });
    }
    // Handle "Copy to clipboard" button click events
    dialogEl.find('button.paste-to-clipboard').on('click.mzdk-userpanel-install', function() {
        let successMsg = $(this).data('success'),
            failedMsg = $(this).data('failed');
        navigator.clipboard.writeText($(this).data('url')).then(function() {
            /* presse-papiers modifié avec succès */
            znetdkMobile.messages.showSnackbar(successMsg, false, dialogEl);
        }, function() {
            znetdkMobile.messages.showSnackbar(failedMsg, true, dialogEl);
        });
    });
    // Handle "Send by SMS" button click events
    dialogEl.find('button.send-by-sms').on('click.mzdk-userpanel-install', function(){
        znetdkMobile.browser.sendSms('...', $(this).data('sms'));
    });
})();
</script>