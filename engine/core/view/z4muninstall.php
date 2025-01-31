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
 * File version: 1.3
 * Last update: 10/19/2024
 */
$color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
?>
<div id="mzdk-userpanel-uninstall" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <span class="fa-stack">
                    <i class="fa fa-hdd-o fa-stack-1x"></i>
                    <i class="fa fa-ban fa-stack-2x w3-text-red"></i>
                </span>
                <span class="title"><?php echo LC_HEAD_USERPANEL_UNINSTALL; ?></span>
            </h4>
        </header>
        <div class="w3-container <?php echo $color['modal_content']; ?>">
            <p><?php echo LC_HEAD_USERPANEL_UNINSTALL_TEXT_GENERAL; ?></p>
            <p><?php echo LC_HEAD_USERPANEL_UNINSTALL_TEXT_SPECIFIC; ?></p>
            <ul class="w3-ul">
                <li><span class="w3-tag <?php echo $color['tag']; ?>"><i class="fa fa-chrome"></i>&nbsp;Chrome</span> <b>chrome://apps</b></li>
                <li><span class="w3-tag <?php echo $color['tag']; ?>"><i class="fa fa-edge"></i>&nbsp;Edge</span> <b>edge://apps</b></li>
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