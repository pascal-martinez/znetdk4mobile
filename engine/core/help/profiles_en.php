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
<h1>User profiles</h1>
<p>The user profiles allow to extend or limit the access to the functions of the application,
    for all the users whom the profile was granted.</p>
<p>The access restriction or extension on application functions other than the ones of the navigation menu,
    directly depends on the access rules developed specifically for the needs of the application.</p>
<h2>New profile</h2>
<p>To add a profile, click on the button <q><?php echo LC_BTN_NEW;?></q> of the action bar.
Once the profile form opened, fill-in the following informations:</p>
<ul>
    <li><strong><?php echo LC_TABLE_COL_PROFILE_NAME;?></strong> : name given to the profile.</li>
    <li><strong><?php echo LC_TABLE_COL_PROFILE_DESC;?></strong> : description of the profile.</li>
    <li><strong><?php echo LC_TABLE_COL_MENU_ITEMS;?></strong> : navigation menu items granted thru the profile.
    To select several menu items, hold the key &lt;Control&gt; pressed while clicking on them.</li>
</ul>
<h2>Modify a profil</h2>
<p>The specifications of a user profile can be modified by selecting the corresponding row onto the profiles table
    and by clicking on the button  <q><?php echo LC_BTN_MODIFY;?></q> to display the edit form.</p>
<h2>Removal of a profile</h2>
<p>To remove a profile, select it into the table and click on the button <q><?php echo LC_BTN_REMOVE;?></q>.
The profile is removed after confirmation.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Attention</strong>: a profile can be removed only if it is not currently granted to a user.
        <br>First, unselect the profile to the users for who it is granted.</p>
    </div>
</div>