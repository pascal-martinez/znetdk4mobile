<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Core Users help view (english) 
	
File version: 1.0
Last update: 09/18/2015
-->
<h1>User authorization</h1>
<p>Any user of the application must be first authorized if he wants to use it.</p>
<h2>New user</h2>
<p>To authorize a user, click on the button <q><?php echo LC_BTN_NEW;?></q> of the action bar.
Once the user registration form opened, fill-in the information below:</p>
<ul>
    <li><?php echo LC_FORM_FLD_USER_IDENTITY;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_USER_NAME;?></strong>: firstname and lastname of the user to authorize.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_EMAIL;?></strong>: user email.</li>
        </ul>
    </li>
    <li><?php echo LC_FORM_FLD_USER_CONNECTION;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_LOGIN_ID;?></strong> : identifier asked for the connection to the application.</li>
            <li><strong><?php echo LC_FORM_LBL_PASSWORD;?></strong> : password required to authenticate the user.</li>
            <li><strong><?php echo LC_FORM_LBL_PASSWORD_CONFIRM;?></strong> : password confirmation. This password must be
                identical to the one entered for the field <q><?php echo LC_FORM_LBL_PASSWORD;?></q>.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE;?></strong> : expiration date of the password. By default,
             this date is initialized to the current date in order to force the user to renew his password.</li>
        </ul>
    </li>
    <li><?php echo LC_FORM_FLD_USER_RIGHTS;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_USER_STATUS;?></strong> : by default, the user is <q><?php echo LC_FORM_LBL_USER_STATUS_ENABLED;?></q> what means he is authorized to connect to the application.
                To deny him the access to the application, his status has to be set to <q><?php echo LC_FORM_LBL_USER_STATUS_DISABLED;?></q>.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_MENU_ACCESS;?></strong> : when the option <q><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL;?></q> is checked, then the user has a full access 
                to the application's navigation menu.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_PROFILES;?></strong> : profiles granted to the user. To grant him more than one profile,
                hold the key &lt;Control&gt; pressed while selecting the other profiles.</li>
        </ul>
    </li>
</ul>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Attention</strong> the password keyed in for the user must contain a minimum of 8 figures and letters.</p>
    </div>
</div>
<h2>Updating user information</h2>
<p>The user's information can be modified by selecting the appropriate row in the table and then by clicking on the button <q><?php echo LC_BTN_MODIFY;?></q>.
    The edition form is then displayed.</p>
<h3>Resetting the user's password</h3>
<p>If user forgot his password, it can be reset thru the edit form by filling in the fields <q><?php echo LC_FORM_LBL_PASSWORD;?></q> and
    <q><?php echo LC_FORM_LBL_PASSWORD_CONFIRM;?></q>.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong>Attention</strong> to impose a user to change his password, the date <q><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE;?></q> must be set to a date
            lower or equal to the current date.</p>
    </div>
</div>
<h3>Disabling a user</h3>
<p>To disable the access of a user from the application, change his status to the value <q><?php echo LC_FORM_LBL_USER_STATUS_DISABLED;?></q> in the edit form.</p>
<h2>Revoking a user</h2>
<p>A user can be definitively revoked from the application by selecting the appropriate row in the user table 
    and by clicking on the button <q><?php echo LC_BTN_REMOVE;?></q>. A confirmation is requested before the removal.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Attention</strong> if a user is to be revoked temporarily, it's better to disable it rather than remove it.</p>
    </div>
</div>