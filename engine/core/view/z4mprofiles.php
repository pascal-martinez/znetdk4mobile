<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr
 * Copyright (C) 2019 Pascal MARTINEZ (contact@znetdk.fr)
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
 * ZnetDK Core profiles view for mobile
 *
 * File version: 1.9
 * Last update: 10/22/2024
 */
$color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
?>
<!-- Header -->
<div id="mzdk-profile-list-header" class="w3-row <?php echo $color['content']; ?> w3-hide-small w3-hide-medium w3-border-bottom <?php echo $color['list_border_bottom']; ?>">
    <div class="w3-col l3 w3-padding-small"><b><?php echo LC_TABLE_COL_PROFILE_NAME; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo LC_TABLE_COL_PROFILE_DESC; ?></b></div>
    <div class="w3-col l6 w3-padding-small"><b><?php echo LC_TABLE_COL_MENU_ITEMS; ?></b></div>
</div>
<!-- List of Profiles -->
<ul id="mzdk-profile-list" class="w3-ul w3-hide w3-margin-bottom" data-zdk-load="profiles:all">
    <li class="<?php echo $color['list_border_bottom']; ?> w3-hover-light-grey" data-id="{{profile_id}}">
        <div class="w3-row w3-stretch">
            <a class="edit" href="javascript:void(0)">
                <div class="w3-col s12 m6 l3 w3-padding-small">
                    <span class="w3-large"><strong>{{profile_name}}</strong></span>
                </div>
                <div class="w3-col s12 m6 l3 w3-padding-small">
                    <span>{{profile_description}}</span>
                </div>
                <div class="w3-col s12 m12 l6 w3-padding-small">
                    <span class="has-menu-items-{{has_menu_items}}">
                        <i class="<?php echo $color['icon']; ?> fa fa-sitemap fa-lg"></i>&nbsp;
                        <span class="menu-items">{{menu_items}}</span>
                    </span>
                </div>
            </a>
        </div>
    </li>
    <li><h3 class="<?php echo $color['msg_error']; ?> w3-center w3-stretch"><i class="fa fa-frown-o"></i>&nbsp;<?php echo LC_MSG_INF_NO_RESULT_FOUND; ?></h3></li>
</ul>
<!-- Modal dialog for adding and editing a Profile -->
<div id="mzdk-profile-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container <?php echo $color['modal_header']; ?>">
            <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
            <h4>
                <i class="fa fa-key fa-lg"></i>
                <span class="title"></span>
            </h4>
        </header>
        <form class="w3-container <?php echo $color['modal_content']; ?>" data-zdk-load="profiles:detail" data-zdk-submit="profiles:save">
            <input type="hidden" name="profile_id">
            <div class="w3-section">
                <label><b><?php echo LC_TABLE_COL_PROFILE_NAME; ?></b>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="profile_name" maxlength="50" required>
                </label>
                <label><b><?php echo LC_TABLE_COL_PROFILE_DESC; ?></b>
                    <textarea class="w3-input w3-border w3-margin-bottom" name="profile_description" rows="3" maxlength="200" required></textarea>
                </label>
                <label class="field-title"><b><?php echo LC_TABLE_COL_MENU_ITEMS; ?></b><br>
                    <select class="w3-select w3-border" name="menu_ids[]" multiple="multiple" size="12"></select>
                </label>
            </div>
            <!-- Submit button -->
            <p class="w3-padding"></p>
            <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                <i class="fa fa-save fa-lg"></i>&nbsp;
                <?php echo LC_BTN_SAVE; ?>
            </button>
        </form>
        <div class="w3-container w3-padding-16 w3-border-top <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
            <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CANCEL; ?>
            </button>
            <button type="button" class="remove w3-button <?php echo $color['btn_action']; ?>">
                <i class="fa fa-trash fa-lg"></i>&nbsp;
                <?php echo LC_BTN_REMOVE; ?>
            </button>
        </div>
    </div>
</div>
<style>
    #mzdk-profile-list-header {
        position: sticky;
    }
    #mzdk-profile-list-header li {
        padding-top: 0;
        padding-bottom: 0;
    }
    #mzdk-profile-list .has-menu-items-0 {
        display: none;
    }
    #mzdk-profile-list .menu-items {
        font-style: italic;
        word-break: break-word;
    }
    #mzdk-profile-modal button.remove {
        float: right;
    }
</style>
<script>
<?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4mprofiles' ** For debug purpose **");
<?php endif; ?>
    $(function(){
        var z4mprofileList = znetdkMobile.list.make('#mzdk-profile-list', false, false);
        z4mprofileList.beforeSearchRequestCallback = function(requestData) {
            if (requestData.hasOwnProperty('count')) {
                requestData.rows = requestData.count;
                delete requestData.count;
            }
        };
        z4mprofileList.setModal('#mzdk-profile-modal', true, function(innerForm){
            // NEW
            this.setTitle('<?php echo LC_FORM_TITLE_PROFILE_NEW; ?>');
            // The remove button is hidden
            this.element.find('button.remove').addClass('w3-hide');
            // Menu items are loaded
            const modalObj = this;
            loadMenuItems(innerForm, function(){
                // Modal can be displayed now as the menu items are loaded
                openModal(modalObj);
            });
            // The modal dialog is not displayed now
            return false;
        }, function(innerForm, formData) {
            // EDIT
            this.setTitle('<?php echo LC_FORM_TITLE_PROFILE_MODIFY; ?>');
            // The remove button is shown
            this.element.find('button.remove').removeClass('w3-hide');
            // Refresh the menu item list and select the menu items ones
            const modalObj = this;
            loadMenuItems(innerForm, function() {
                if (formData.hasOwnProperty('menu_ids[]')) {
                    innerForm.setInputValue('menu_ids[]', formData['menu_ids[]']);
                }
                // Modal can be displayed now as the menu items are loaded
                openModal(modalObj);
            });
            // The modal dialog is not displayed now
            return false;
        });
        function loadMenuItems(formElement, callback) {
            znetdkMobile.ajax.request({
                controller: 'profiles',
                action: 'menuitems',
                callback: function(response) {
                    var menuItemElement = formElement.element.find('select[name="menu_ids[]"]');
                    menuItemElement.empty();
                    $.each(response.treenodes, function() {
                        appendListElement(this);
                    });
                    if (typeof callback === 'function') {
                        callback();
                    }
                    function appendListElement(item, level, group) {
                        var newLevel = typeof level === 'integer' ? level : 0;
                        if (newLevel > 1) {
                            return; // No more than 2 levels are supported
                        }
                        if (item.children.length === 0) { // Leaf element
                            var parentElement = group instanceof jQuery === false
                                ? menuItemElement : group;
                            parentElement.append('<option value="' + item.data + '">' + item.label + '</option>');
                        } else {
                            var groupElement = $('<optgroup label="' + item.label + '"/>');
                            $.each(item.children, function() {
                                appendListElement(this, newLevel+1, groupElement);
                            });
                            menuItemElement.append(groupElement);
                        }
                    }
                }
            });
        }
        // Open modal dialog: on form submit success, the list is refreshed
        function openModal(modalObj) {
            modalObj.open(function(response){
                if (response.success === true) {
                    z4mprofileList.refresh();
                }
            });
        }
        // Click on remove button
        $('#mzdk-profile-modal button.remove').on('click', function() {
            znetdkMobile.messages.ask("<?php echo LC_FORM_TITLE_PROFILE_REMOVE; ?>",
                    "<?php echo LC_MSG_ASK_REMOVE; ?>", {yes: "<?php echo LC_BTN_YES; ?>",
                    no: "<?php echo LC_BTN_NO; ?>"}, function(isYes) {
                if (!isYes) {
                    return;
                }
                znetdkMobile.ajax.request({
                    controller: 'profiles',
                    action: 'remove',
                    data: {profile_id: $('#mzdk-profile-modal input[name=profile_id]').val()},
                    callback: function(response) {
                        // The list is refreshed
                        z4mprofileList.refresh();
                        // The modal is closed
                        var modal = znetdkMobile.modal.make('#mzdk-profile-modal');
                        modal.close();
                        // The removal notification shown
                        if (response.success) { // Success
                            znetdkMobile.messages.showSnackbar(response.msg);
                        } else { // Error
                            znetdkMobile.messages.add('error', response.summary, response.msg, false);
                        }
                    }
                });
            });
        });
        // List header sticky position taking in account ZnetDK autoHideOnScrollEnabled property
        onTopSpaceChange();
        $('body').on('topspacechange.z4mprofiles', onTopSpaceChange);
        function onTopSpaceChange() {
            $('#mzdk-profile-list-header').css('top', znetdkMobile.header.autoHideOnScrollEnabled
                ? 0 : znetdkMobile.header.getHeight());
        }
    });
</script>