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
 * ZnetDK Core users view for mobile
 *
 * File version: 1.9
 * Last update: 08/05/2023
 */
?>
<!-- Filter by status -->
<form id="mzdk-user-list-filter" class="w3-padding w3-panel w3-theme-l2">
    <div class="w3-cell w3-left">
        <span class="w3-margin-right"><i class="fa fa-list"></i>&nbsp;<b><?php echo LC_FORM_LBL_USER_STATUS; ?></b></span>
        <input id="mzdk-user-list-filter-status-enabled" class="w3-radio" type="radio" value="1" name="status_filter" checked>
        <label for="mzdk-user-list-filter-status-enabled"><?php echo LC_FORM_LBL_USER_STATUS_ENABLED; ?></label>&nbsp;&nbsp;
        <input id="mzdk-user-list-filter-status-disabled" class="w3-radio" type="radio" value="0" name="status_filter">
        <label for="mzdk-user-list-filter-status-disabled"><?php echo LC_FORM_LBL_USER_STATUS_DISABLED; ?></label>&nbsp;&nbsp;
        <input id="mzdk-user-list-filter-status-archived" class="w3-radio" type="radio" value="-1" name="status_filter">
        <label for="mzdk-user-list-filter-status-archived"><?php echo LC_FORM_LBL_USER_STATUS_ARCHIVED; ?></label>
    </div>
</form>
<!-- Header -->
<div id="mzdk-user-list-header" class="w3-row w3-text-theme w3-theme-light w3-hide-small w3-hide-medium w3-border-bottom w3-border-theme">
    <div class="w3-col l3 w3-padding-small"><b><?php echo LC_TABLE_COL_USER; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo LC_FORM_LBL_USER_EMAIL . ' / ' . LC_FORM_LBL_USER_PHONE; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo LC_FORM_LBL_USER_STATUS; ?></b></div>
    <div class="w3-col l3 w3-padding-small"><b><?php echo LC_FORM_FLD_USER_RIGHTS; ?></b></div>
</div>
<!-- List of Users -->
<ul id="mzdk-user-list" class="w3-ul w3-stretch w3-hide w3-margin-bottom"
        data-zdk-load="users:all" data-zdk-autocomplete="users:suggestions">
    <li class="w3-border-theme w3-hover-white" data-id="{{user_id}}">
        <div class="w3-row">
            <a class="edit" href="javascript:void(0)">
                <div class="w3-col s12 m6 l3 w3-padding-small">
                    <div class="w3-text-theme w3-large"><strong>{{user_name}}</strong></div>
                    <span class="w3-tag w3-theme-d1">{{login_name}}</span>
                    <span class="is-hidden{{notes_exist}}"><i>{{notes}}</i></span>
                </div>
            </a>
            <div class="w3-col s12 m6 l3 w3-padding-small">
                <a href="mailto:{{user_email}}">
                    <i class="w3-text-theme fa fa-envelope fa-lg"></i>&nbsp;
                    <span>{{user_email}}</span>
                </a>
                <div class="phone is-hidden{{user_phone}}">
                    <a href="tel:{{user_phone}}">
                        <i class="w3-text-theme fa fa-phone-square fa-lg"></i>&nbsp;
                        <span>{{user_phone}}</span>
                    </a>
                </div>
            </div>
            <div class="w3-col s12 m6 l3 w3-padding-small">
                <div class="w3-tag user-enabled-{{user_enabled}} w3-red"></div>
                <div class="expiration-date">
                    <i class="w3-text-theme fa fa-calendar-o fa-lg"></i>&nbsp;
                    <span class="expired-{{has_expired}}">{{expiration_date_locale}}</span>
                </div>
            </div>
            <div class="w3-col s12 m12 l3 w3-padding-small">
                <span class="menu-access-{{full_menu_access}} w3-tag w3-theme-d5">{{menu_access}}</span>
                <span class="has-profiles-{{has_profiles}}">&nbsp;
                    <i class="w3-text-theme fa fa-key fa-lg"></i>&nbsp;
                    <span class="user-profiles">{{user_profiles}}</span>
                </span>
            </div>
        </div>
    </li>
    <li><h3 class="w3-red w3-center"><i class="fa fa-frown-o"></i>&nbsp;<?php echo LC_MSG_INF_NO_RESULT_FOUND; ?></h3></li>
</ul>
<!-- Modal dialog for adding and editing a User -->
<div id="mzdk-user-modal" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
        <header class="w3-container w3-theme-d5">
            <span class="close w3-button w3-xlarge w3-hover-theme w3-display-topright"><i class="fa fa-times-circle fa-lg"></i></span>
            <h4>
                <i class="fa fa-user fa-lg"></i>
                <span class="title"></span>
            </h4>
        </header>
        <form class="w3-container w3-theme-light" data-zdk-load="users:detail" data-zdk-submit="users:save">
            <input type="hidden" name="user_id">
            <div class="w3-section">
                <!-- Identity -->
                <h3 class="w3-border-top w3-text-theme w3-border-theme">
                    <i class="fa fa-id-badge fa-lg"></i>
                    <?php echo LC_FORM_FLD_USER_IDENTITY; ?>
                </h3>
                <label class="zdk-required"><?php echo LC_FORM_LBL_USER_NAME; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="user_name" maxlength="100" required>
                <label class="zdk-required"><?php echo LC_FORM_LBL_USER_EMAIL; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="email" name="user_email" required>
                <label class="field-title"><?php echo LC_FORM_LBL_USER_PHONE; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="tel" name="user_phone" maxlength="50">
                <label class="field-title"><?php echo LC_FORM_LBL_USER_NOTES; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="notes" maxlength="100">
                <!-- Connection -->
                <br>
                <h3 class="w3-border-top w3-text-theme w3-border-theme">
                    <i class="fa fa-unlock-alt fa-lg"></i>
                    <?php echo LC_FORM_FLD_USER_CONNECTION; ?>
                </h3>
                <label class="zdk-required"><?php echo LC_FORM_LBL_LOGIN_ID; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="login_name" autocomplete="off" value="" maxlength="20" required>
                <label class="zdk-required"><?php echo LC_FORM_LBL_PASSWORD; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="password" name="login_password" autocomplete="off" value="" maxlength="20" required>
                <label class="zdk-required"><?php echo LC_FORM_LBL_PASSWORD_CONFIRM; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="password" name="login_password2" autocomplete="off" value="" maxlength="20" required>

                <!-- User rights -->
                <br>
                <h3 class="w3-border-top w3-text-theme w3-border-theme">
                    <i class="fa fa-key fa-lg"></i>
                    <?php echo LC_FORM_FLD_USER_RIGHTS; ?>
                </h3>
                <label class="zdk-required"><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE; ?></label>
                <input class="w3-input w3-border w3-margin-bottom" type="date" name="expiration_date" required>
                <label class="field-title"><?php echo LC_FORM_LBL_USER_STATUS; ?></label><br>
                <input id="mzdk-user-modal-radio-enabled" class="w3-radio" type="radio" value="1" name="user_enabled">
                <label for="mzdk-user-modal-radio-enabled"><?php echo LC_FORM_LBL_USER_STATUS_ENABLED; ?></label>&nbsp;&nbsp;
                <input id="mzdk-user-modal-radio-disabled" class="w3-radio" type="radio" value="0" name="user_enabled">
                <label for="mzdk-user-modal-radio-disabled"><?php echo LC_FORM_LBL_USER_STATUS_DISABLED; ?></label>
                <input id="mzdk-user-modal-radio-archived" class="w3-radio" type="radio" value="-1" name="user_enabled">
                <label for="mzdk-user-modal-radio-archived"><?php echo LC_FORM_LBL_USER_STATUS_ARCHIVED; ?></label>
                <p></p>
                <label class="field-title"><?php echo LC_FORM_LBL_USER_MENU_ACCESS; ?></label><br>
                <input id="mzdk-user-modal-check-full-menu-access" class="w3-check" type="checkbox" name="full_menu_access" value="1">
                <label for="mzdk-user-modal-check-full-menu-access"><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL; ?></label>
                <p></p>
                <label class="field-title"><?php echo LC_FORM_LBL_USER_PROFILES; ?></label><br>
                <select class="w3-select w3-border" name="profiles[]" multiple="multiple" size="6">
                </select>
            </div>
            <!-- Submit button -->
            <p class="w3-padding"></p>
            <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">
                <i class="fa fa-check fa-lg"></i>&nbsp;
                <?php echo LC_BTN_SAVE; ?>
            </button>
        </form>
        <div class="w3-container w3-border-top w3-border-theme w3-padding-16 w3-theme-l4">
            <button type="button" class="cancel w3-button w3-red">
                <i class="fa fa-close fa-lg"></i>&nbsp;
                <?php echo LC_BTN_CANCEL; ?>
            </button>
            <button type="button" class="remove w3-button w3-theme-action">
                <i class="fa fa-trash fa-lg"></i>&nbsp;
                <?php echo LC_BTN_REMOVE; ?>
            </button>
        </div>
    </div>
</div>
<style>
    #mzdk-user-list-header {
        position: sticky;
    }
    #mzdk-user-list-header li {
        padding-top: 0;
        padding-bottom: 0;
    }
    #mzdk-user-list .is-hidden {
        display: none;
    }
    #mzdk-user-list .user-enabled-0 {
        color: #fff!important;
        background-color: #f44336!important;
    }
    #mzdk-user-list .user-enabled-0:after {
        content: "<?php echo LC_FORM_LBL_USER_STATUS_DISABLED; ?>";
    }
    #mzdk-user-list .user-enabled-1 {
        color: #fff!important;
        background-color: #4CAF50!important;
    }
    #mzdk-user-list .user-enabled-1:after {
        content: "<?php echo LC_FORM_LBL_USER_STATUS_ENABLED; ?>";
    }
    #mzdk-user-list .user-enabled--1 {
        color: #fff!important;
        background-color: #000!important;
    }
    #mzdk-user-list .user-enabled--1:after {
        content: "<?php echo LC_FORM_LBL_USER_STATUS_ARCHIVED; ?>";
    }
    #mzdk-user-list .phone,
    #mzdk-user-list .expiration-date {
        margin-top: 6px;
    }
    #mzdk-user-list .expired-1 {
        font-weight: bold;
        color: #f44336;
    }
    #mzdk-user-list .menu-access-0 {
        display: none;
    }
    #mzdk-user-list .menu-access-1 {
        margin-bottom: 6px;
    }
    #mzdk-user-list .user-profiles {
        font-style: italic;
        word-break: break-word;
    }
    #mzdk-user-list .has-profiles-0 {
        display: none;
    }
    #mzdk-user-modal h3 {
        text-transform: uppercase;
    }
    #mzdk-user-modal label.zdk-required,
    #mzdk-user-modal label.field-title {
        font-weight: bold;
    }
    #mzdk-user-modal button.remove {
        float: right;
    }
</style>
<script>
<?php if (CFG_DEV_JS_ENABLED) : ?>
    console.log("'z4musers' ** For debug purpose **");
<?php endif; ?>
    $(function(){
        var z4muserList = znetdkMobile.list.make('#mzdk-user-list');
        z4muserList.beforeInsertRowCallback = function(rowData) {
            rowData.notes_exist = rowData.notes.length > 0 ? 'yes' : '';
        };
        z4muserList.beforeSearchRequestCallback = function(requestData) {
            var filters = {};
            filters.status = $('#mzdk-user-list-filter input[name=status_filter]:checked').val();
            if (requestData.hasOwnProperty('keyword')) {
                filters.keyword = requestData.keyword[0];
                delete requestData.keyword;
            }
            if (requestData.hasOwnProperty('count')) {
                requestData.rows = requestData.count;
                delete requestData.count;
            }
            requestData.search_criteria = JSON.stringify(filters);
        };
        z4muserList.setCustomSortCriteria({
            login_name: "<?php echo LC_TABLE_COL_LOGIN_ID; ?>",
            user_name: "<?php echo LC_TABLE_COL_USER_NAME; ?>",
            expiration_date: "<?php echo LC_FORM_LBL_USER_EXPIRATION_DATE; ?>"
        }, 'login_name');
        z4muserList.setModal('#mzdk-user-modal', true, function(innerForm){ // NEW
            const modalObj = this;
            modalObj.setTitle('<?php echo LC_FORM_TITLE_USER_NEW; ?>');
            // The expiration date is set to today by default
            innerForm.element.find('input[name=expiration_date]')[0].valueAsDate = new Date();
            // The user is enabled by default
            innerForm.setInputValue('user_enabled', '1');
            // The remove button is hidden
            modalObj.element.find('button.remove').addClass('w3-hide');
            // Refresh the profile list
            loadProfiles(innerForm, function(){
                // Modal can be displayed now as the profiles are loaded
                openModal(modalObj);
            });
            // The modal dialog is not displayed now
            return false;
        }, function(innerForm, formData) { // EDIT
            const modalObj = this;
            this.setTitle('<?php echo LC_FORM_TITLE_USER_MODIFY; ?>');
            // The remove button is shown
            this.element.find('button.remove').removeClass('w3-hide');
            // Refresh the profile list...
            loadProfiles(innerForm, function() {
                //  ... and the user's profiles are selected
                innerForm.setInputValue('profiles[]', formData['profiles[]'], true);
                // Modal can be displayed now as the profiles are loaded
                openModal(modalObj);
            });            
            // The modal dialog is not displayed now
            return false;
        });
        z4muserList.uniqueSearchedKeyword = true;
        znetdkMobile.action.setScrollUpButtonForView(
                znetdkMobile.content.getParentViewId($('#mzdk-user-list')));
        function loadProfiles(formElement, callback) {
            znetdkMobile.ajax.request({
                controller: 'users',
                action: 'profiles',
                callback: function(response) {
                    var profileElement = formElement.element.find('select[name="profiles[]"]');
                    profileElement.empty();
                    $.each(response.rows, function() {
                        profileElement.append('<option value="' + this.value + '" title="' + this.description + '">'
                                + this.label + '</option>');
                    });
                    if (typeof callback === 'function') {
                        callback();
                    }
                }
            });
        }
        // Open modal dialog: on form submit success, the list is refreshed
        function openModal(modalObj) {
            modalObj.open(function(){
                z4muserList.refresh();
            });
        }
        // Filter by status
        $('#mzdk-user-list-filter input[name=status_filter]').on('change.mzdk-user', function(){
            z4muserList.refresh();
        });
        // Click on remove button
        $('#mzdk-user-modal button.remove').on('click', function() {
            znetdkMobile.messages.ask("<?php echo LC_FORM_TITLE_USER_REMOVE; ?>",
                    "<?php echo LC_MSG_ASK_REMOVE; ?>", {yes: "<?php echo LC_BTN_YES; ?>",
                    no: "<?php echo LC_BTN_NO; ?>"}, function(isYes) {
                if (!isYes) {
                    return;
                }
                znetdkMobile.ajax.request({
                    controller: 'users',
                    action: 'remove',
                    data: {user_id: $('#mzdk-user-modal input[name=user_id]').val()},
                    callback: function(response) {
                        // The list is refreshed
                        z4muserList.refresh();
                        // The modal is closed
                        var modal = znetdkMobile.modal.make('#mzdk-user-modal');
                        modal.close();
                        // The removal notification shown
                        znetdkMobile.messages.showSnackbar(response.msg);
                    }
                });
            });
        });
        // List header sticky position taking in account ZnetDK autoHideOnScrollEnabled property
        onTopSpaceChange();
        $('body').on('topspacechange.z4musers', onTopSpaceChange);
        function onTopSpaceChange() {
            $('#mzdk-user-list-header').css('top', znetdkMobile.header.autoHideOnScrollEnabled
                ? 0 : znetdkMobile.header.getHeight());
        }
    });
</script>