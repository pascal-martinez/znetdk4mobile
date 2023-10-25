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
<h1>Habilitation des utilisateurs</h1>
<p>Tout utilisateur de l'application doit être préalablement habilité pour pouvoir y accéder.</p>
<h2>Nouvel utilisateur</h2>
<p>Pour habiliter un nouvel utilisateur, cliquez sur le bouton <q><?php echo LC_BTN_NEW;?></q> de la barre d'action.
Après ouverture du formulaire d'enregistrement d'un utilisateur, renseignez les informations suivantes :</p>
<ul>
    <li><?php echo LC_FORM_FLD_USER_IDENTITY;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_USER_NAME;?></strong> : prénom et nom de l'utilisateur à habiliter.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_EMAIL;?></strong> : adresse email de l'utilisateur.</li>
        </ul>
    </li>
    <li><?php echo LC_FORM_FLD_USER_CONNECTION;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_LOGIN_ID;?></strong> : identifiant de connexion à l'application.</li>
            <li><strong><?php echo LC_FORM_LBL_PASSWORD;?></strong> : mot de passe de connexion à l'application.</li>
            <li><strong><?php echo LC_FORM_LBL_PASSWORD_CONFIRM;?></strong> : confirmation de saisie du mot de passe. Il doit
                être identique à celui saisi pour le champ <q><?php echo LC_FORM_LBL_PASSWORD;?></q>.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE;?></strong> : date de fin de validité du mot de passe. Par défaut,
             cette date est initialisée à la date du jour pour imposer à l'utilisateur de renouveler son mot de passe.</li>
        </ul>
    </li>
    <li><?php echo LC_FORM_FLD_USER_RIGHTS;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_USER_STATUS;?></strong> : l'utilisateur est par défaut <q><?php echo LC_FORM_LBL_USER_STATUS_ENABLED;?></q> ce qui lui confère le droit de se connecter.
                Pour lui interdire l'accès à l'application, son statut peut être renseigné à <q><?php echo LC_FORM_LBL_USER_STATUS_DISABLED;?></q>.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_MENU_ACCESS;?></strong> : lorsque l'option <q><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL;?></q> est cochée, l'utilisateur dispose alors d'un accès 
                complet au contenu du menu de navigation de l'application.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_PROFILES;?></strong> : profils accordés à l'utilisateur. Pour accorder plusieurs profils,
                la touche &lt;Control&gt; doit être maintenue enfoncée pendant la sélection dans la liste.</li>
        </ul>
    </li>
</ul>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Attention</strong> Le mot de passe saisi pour l'utilisateur doit être constitué d'un minimum de 8 chiffres ou lettres.</p>
    </div>
</div>
<h2>Mise à jour d'un utilisateur</h2>
<p>Les informations relatives à un utilisateur peuvent être modifiées en sélectionnant la ligne correspondante 
    dans le tableau et en cliquant sur le bouton <q><?php echo LC_BTN_MODIFY;?></q>.<br>
    Le formulaire de modification est alors affiché.</p>
<h3>Réinitialisation d'un mot de passe</h3>
<p>En cas d'oubli du mot de passe par un utilisateur, celui-ci peut être réinitialisé à une nouvelle valeur à
    l'aide du formulaire de modification en renseignant les champs <q><?php echo LC_FORM_LBL_PASSWORD;?></q> et <q><?php echo LC_FORM_LBL_PASSWORD_CONFIRM;?></q>.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong>Attention</strong> Pour obliger l'utilisateur à changer son mot de passe, la date <q><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE;?></q> doit être renseignée à une
            date antérieure ou égale à la date du jour.</p>
    </div>
</div>
<h3>Désactivation d'un utilisateur</h3>
<p>Pour désactiver l'accès d'un utilisateur à l'application, modifiez son statut à la valeur <q><?php echo LC_FORM_LBL_USER_STATUS_DISABLED;?></q> dans le formulaire de modification.</p>
<h2>Révocation d'un utilisateur</h2>
<p>Un utilisateur peut être définitivement révoqué de l'application en le sélectionnant dans le tableau des utilisateurs
    et en cliquant sur le bouton <q><?php echo LC_BTN_REMOVE;?></q>. Une confirmation est demandée avant sa suppression.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Attention</strong> Si l'utilisateur doit être révoqué temporairement, il est préférable de ne pas le supprimer et de simplement le désactiver.</p>
    </div>
</div>