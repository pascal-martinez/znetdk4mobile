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
 * File version: 1.0
 * Last update: 07/27/2022
 */
?>
<div id="mzdk-userpanel-uninstall" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container w3-theme-d5">
            <span class="close w3-button w3-xlarge w3-hover-theme w3-display-topright"><i class="fa fa-times-circle fa-lg"></i></span>
            <h4>
                <span class="fa-stack">
                    <i class="fa fa-hdd-o fa-stack-1x"></i>
                    <i class="fa fa-ban fa-stack-2x w3-text-red"></i>
                </span>
                <span class="title"><?php echo LC_HEAD_USERPANEL_UNINSTALL; ?></span>
            </h4>
        </header>
        <div class="w3-container w3-margin-bottom">
            <p><?php echo LC_HEAD_USERPANEL_UNINSTALL_TEXT_GENERAL; ?></p>
            <p><?php echo LC_HEAD_USERPANEL_UNINSTALL_TEXT_SPECIFIC; ?></p>
            <ul class="w3-ul">
                <li><span class="w3-tag w3-theme-l2"><i class="fa fa-chrome"></i>&nbsp;Chrome</span> <b>chrome://apps</b></li>
                <li><span class="w3-tag w3-theme-l2"><i class="fa fa-edge"></i>&nbsp;Edge</span> <b>edge://apps</b></li>
            </ul>
        </div>
        <div class="w3-container w3-border-top w3-border-theme w3-padding-16 w3-theme-l4">
            <button type="button" class="cancel w3-button w3-red">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CLOSE; ?>
            </button>
        </div>
    </div>
</div>