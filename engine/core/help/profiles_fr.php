<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Core Users help view (french)
	
File version: 1.0
Last update: 09/18/2015
-->
<h1>Profils utilisateur</h1>
<p>Les profils utilisateurs constituent le moyen de réduire ou étendre l'accès aux
    fonctionnalités de l'application, à l'ensemble des utilisateurs auxquels le profil
    a été accordé.</p>
<p>La restriction ou l'extension d'accès aux fonctionnalités autres que celles du menu de navigation, dépend
directement des règles d'accès développées spécifiquement pour les besoins de l'application.</p>
<h2>Nouveau profil</h2>
<p>Pour ajouter un nouveau profil, cliquez sur le bouton <q><?php echo LC_BTN_NEW;?></q> de la barre d'action.
Après ouverture du formulaire d'enregistrement d'un profil, renseignez les informations suivantes :</p>
<ul>
    <li><strong><?php echo LC_TABLE_COL_PROFILE_NAME;?></strong> : nom du profil.</li>
    <li><strong><?php echo LC_TABLE_COL_PROFILE_DESC;?></strong> : description du profil.</li>
    <li><strong><?php echo LC_TABLE_COL_MENU_ITEMS;?></strong> : éléments du menu de navigation accordés par le profil.
    Pour sélectionner plusieurs éléments de menu, la touche &lt;Control&gt; doit être maintenue enfoncée pendant
    la sélection.</li>
</ul>
<h2>Modifier un profil</h2>
<p>Les caractéristiques d'un profil utilisateur peuvent être modifiées en le sélectionnant dans le tableau des profils
    et en cliquant sur le bouton <q><?php echo LC_BTN_MODIFY;?></q> pour ouvrir le formulaire de modification.</p>
<h2>Suppression d'un profil</h2>
<p>Pour supprimer un profil, sélectionnez-le dans le tableau et cliquez sur le bouton <q><?php echo LC_BTN_REMOVE;?></q>.
Le profil est supprimé après confirmation de sa suppression.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Attention</strong> : la suppression d'un profil n'est autorisée que s'il n'a pas été accordé à un utilisateur.
        <br>Retirez préalablement aux utilisateurs qui y font référence, le profil à supprimer.</p>
    </div>
</div>