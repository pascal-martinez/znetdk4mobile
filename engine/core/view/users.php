<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
ZnetDK Core users view
        
File version: 1.4
Last update: 03/14/2023
-->
<div id="znetdk_user_actions" class="zdk-action-bar"
        data-zdk-dialog="znetdk_user_dialog"
        data-zdk-datatable="znetdk_users_datatable">
    <button class="zdk-bt-refresh"></button>
    <button class="zdk-bt-add" title="<?php echo LC_FORM_TITLE_USER_NEW; ?>"><?php echo LC_BTN_NEW; ?></button>
    <button class="zdk-bt-edit" title="<?php echo LC_FORM_TITLE_USER_MODIFY; ?>"
            data-zdk-noselection="<?php echo LC_MSG_WARN_ROW_NOTSELECTED; ?>"
            ><?php echo LC_BTN_MODIFY; ?>
    </button>
    <button class="zdk-bt-remove" title="<?php echo LC_FORM_TITLE_USER_REMOVE; ?>"
            data-zdk-noselection="<?php echo LC_MSG_WARN_ROW_NOTSELECTED; ?>"
            data-zdk-action="users:remove"
            data-zdk-confirm="<?php echo LC_MSG_ASK_REMOVE.':'.LC_BTN_YES.':'.LC_BTN_NO; ?>"
            ><?php echo LC_BTN_REMOVE; ?>
    </button>
    <!-- Number of rows per page -->
    <select class="zdk-select-rows" title="<?php echo LC_ACTION_ROWS_LABEL; ?>">  
        <option value="10">10</option>
        <option value="20">20</option>
        <option value="100">100</option>
    </select>
    <div class="zdk-status-filter">
        <label><?php echo LC_FORM_LBL_USER_STATUS; ?></label>
        <div class="zdk-radiobuttongroup" data-name="user_status_filter">
            <input type="radio" value="1" checked>
            <label><?php echo LC_FORM_LBL_USER_STATUS_ENABLED; ?></label>
            <input type="radio" value="0">
            <label><?php echo LC_FORM_LBL_USER_STATUS_DISABLED; ?></label>
            <input type="radio" value="-1">
            <label><?php echo LC_FORM_LBL_USER_STATUS_ARCHIVED; ?></label>
        </div>
    </div>
    <!-- Search form -->
    <div class="zdk-filter-rows">
        <input class="zdk-autofocus" title="<?php echo LC_ACTION_SEARCH_USER_INPUT; ?>" data-zdk-action="users:suggestions">
        <button class="zdk-bt-clear" title="<?php echo LC_ACTION_SEARCH_KEYWORD_BTN_CLEAR; ?>"></button>
        <button class="zdk-bt-search" title="<?php echo LC_ACTION_SEARCH_KEYWORD_BTN_RUN; ?>" data-zdk-novalue="<?php echo LC_MSG_WARN_SEARCH_NO_VALUE; ?>"></button>
    </div>
</div>
<div id="znetdk_users_datatable" class="zdk-datatable zdk-synchronize" title='<?php echo LC_TABLE_AUTHORIZ_USERS_CAPTION;?>'
            data-zdk-action="users:all" data-zdk-paginator="10" data-zdk-cols-resize="true"
            data-zdk-columns='[
                {"field":"login_name", "headerText": "<?php echo LC_TABLE_COL_LOGIN_ID;?>", "sortable":true},
                {"field":"user", "headerText": "<?php echo LC_TABLE_COL_USER;?>", "sortable":true, "isHtml":true},
                {"field":"menu_access", "headerText": "<?php echo LC_TABLE_COL_MENU_ACCESS;?>", "sortable":true},
                {"field":"user_profiles", "headerText": "<?php echo LC_TABLE_COL_USER_PROFILES;?>", "sortable":false,"tooltip":true}
            ]'>
</div>
<div id="znetdk_user_dialog" class="zdk-modal" title="<?php echo LC_FORM_TITLE_USER_NEW; ?>" data-zdk-width="760px">
    <form class="zdk-form" autocomplete="off"
          data-zdkerrmsg-required="<?php echo LC_MSG_ERR_MISSING_VALUE; ?>"
          data-zdk-action="users:save" data-zdk-datatable="znetdk_users_datatable">
        <!-- User ID -->
        <input class="zdk-row-id" type="hidden" name="user_id">
         <!-- Identity -->
        <fieldset>
            <legend><?php echo LC_FORM_FLD_USER_IDENTITY; ?></legend>
            <!-- User name -->
            <label><?php echo LC_FORM_LBL_USER_NAME; ?></label>
            <input type="text" name="user_name" maxlength="100" required>
            <!-- Email -->
            <label><?php echo LC_FORM_LBL_USER_EMAIL; ?></label>
            <input type="email" name="user_email" maxlength="100" required 
                   data-zdkerrmsg-type="<?php echo LC_MSG_ERR_EMAIL_INVALID; ?>">
            <!-- Phone -->
            <label><?php echo LC_FORM_LBL_USER_PHONE; ?></label>
            <input type="text" name="user_phone" maxlength="50">
            <!-- Notes -->
            <label><?php echo LC_FORM_LBL_USER_NOTES; ?></label>
            <input type="text" name="notes" maxlength="100">
        </fieldset>
        <fieldset> <!-- Connection -->
            <legend><?php echo LC_FORM_FLD_USER_CONNECTION; ?></legend>
            <!-- Login ID -->
            <label><?php echo LC_FORM_LBL_LOGIN_ID; ?></label>
            <input type="text" name="login_name" autocomplete="off" value="" maxlength="20" required>
            <!-- Password -->
            <label><?php echo LC_FORM_LBL_PASSWORD; ?></label>
            <input type="password" name="login_password" autocomplete="off" value="" maxlength="20" required>
            <!-- Password confirmation -->
            <label><?php echo LC_FORM_LBL_PASSWORD_CONFIRM; ?></label>
            <input type="password" name="login_password2" autocomplete="off" value="" maxlength="20" required>
            <!-- Expiration date -->
            <label><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE; ?></label>
            <input type="date" name="expiration_date" required
                data-zdkerrmsg-date="<?php echo LC_MSG_ERR_DATE_INVALID; ?>">
        </fieldset>
        <fieldset> <!-- User rights -->
            <legend><?php echo LC_FORM_FLD_USER_RIGHTS; ?></legend>
            <!-- Status -->
            <label><?php echo LC_FORM_LBL_USER_STATUS; ?></label>
            <div class="zdk-radiobuttongroup" data-name="user_enabled">
                <input type="radio" value="1">
                <label><?php echo LC_FORM_LBL_USER_STATUS_ENABLED; ?></label>
                <input type="radio" value="0">
                <label><?php echo LC_FORM_LBL_USER_STATUS_DISABLED; ?></label>
                <br>
                <input type="radio" value="-1">
                <label><?php echo LC_FORM_LBL_USER_STATUS_ARCHIVED; ?></label>
            </div>
            <!-- Menu access -->
            <label><?php echo LC_FORM_LBL_USER_MENU_ACCESS; ?></label>
            <input type="checkbox" name="full_menu_access" value="1"/>
            <span><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL; ?></span>
            <!-- Profiles -->
            <div class="zdk-form-entry">
                <label class="zdk-align-top" title="<?php echo LC_MSG_INF_SELECT_LIST_ITEM; ?>"><?php echo LC_FORM_LBL_USER_PROFILES; ?>&nbsp;<i class="fa fa-info-circle"></i></label>
                <select name="profiles[]" multiple="multiple"></select>
            </div>
        </fieldset>
        <!-- Form buttons -->
        <button class="zdk-bt-save zdk-close-dialog" type="submit"><?php echo LC_BTN_SAVE; ?></button>
        <button class="zdk-bt-cancel zdk-close-dialog" type="button"><?php echo LC_BTN_CANCEL; ?></button>
    </form>
</div>