<?php
/**
* ZnetDK, Starter Web Application for rapid & easy development
* See official website http://www.znetdk.fr
* Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
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
* Core french translations of the application
*
* File version: 1.22
* Last update: 12/15/2024
*/

/* General PHP localization settings (used by the PHP 'setlocale' function) */
define ('LC_LOCALE_ALL', serialize(array('fr_FR.UTF-8', 'French_France.1252', 'fr_FR', 'french')));

/* Overriden localization settings (instead of the 'setlocale' settings) */
define('LC_LOCALE_DECIMAL_SEPARATOR', NULL);
define('LC_LOCALE_THOUSANDS_SEPARATOR', NULL);
define('LC_LOCALE_NUMBER_OF_DECIMALS', NULL);
define('LC_LOCALE_CURRENCY_SYMBOL', NULL);
define('LC_LOCALE_CURRENCY_SYMBOL_PRECEDE', NULL);
define('LC_LOCALE_CURRENCY_SYMBOL_SEPARATE', NULL);
define('LC_LOCALE_DATE_FORMAT', NULL);
define('LC_LOCALE_CSV_SEPARATOR', ';');

/* jQueryUI datePicker language ISO code */
define('LC_LANG_ISO_CODE','fr');

/* General labels */
define('LC_PAGE_TITLE','Application ZnetDK');

/* Header labels */
define('LC_HEAD_TITLE','Application ZnetDK (core)');
define('LC_HEAD_SUBTITLE','Prête au développement...');
define('LC_HEAD_LNK_LOGOUT','Se déconnecter');
define('LC_HEAD_LNK_HELP','Aide');
define('LC_HEAD_USERPANEL_MY_USER_RIGHTS','Mes droits utilisateur');
define('LC_HEAD_USERPANEL_INSTALL','Installation');
define('LC_HEAD_USERPANEL_UNINSTALL','Désinstallation');

/* Header images */
define('LC_HEAD_IMG_LOGO_LINK_TITLE', 'Retour à l\'accueil');
define('LC_HEAD_IMG_LOGO',ZNETDK_ROOT_URI . CFG_ZNETDK_IMG_DIR . '/logoznetdk.svg?v=1');

/* Footer labels */
define('LC_FOOTER_LEFT','Version '.ZNETDK_VERSION);
define('LC_FOOTER_CENTER','Copyright 2014-2025 Pascal MARTINEZ');
define('LC_FOOTER_RIGHT','Réalisé avec <a href="https://www.znetdk.fr" target="_blank">ZnetDK</a>');

/* User Panel Installation labels */
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL', 'Installer l\'application...');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS', 'Infos utiles');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_IS_INSTALLED', 'Votre application est déjà installée.');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLED', 'Votre application n\'est pas encore installée. Tapez le bouton <b>'
        . LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL . '</b> ci-dessous pour l\'installer.');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLABLE', 'Votre application doit être installée manuellement. Voir <b>'
        . LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS . '</b> ci-dessous.');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_INTERNET_ADDRESS', 'Adresse internet');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_INTERNET_ADDRESS', 'L\'<i>adresse internet</i> à saisir dans la <b>barre d\'adresse</b> de votre navigateur est : %1');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_COPY_CLIPBOARD', 'Tapez le bouton ci-dessous pour copier l\'<i>adresse internet</i> dans le <b>presse-papier</b>.');
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_COPY_CLIPBOARD', 'Copier dans le presse-papier');
define('LC_HEAD_USERPANEL_INSTALL_SUCCESS_COPY_CLIPBOARD', 'Adresse copiée dans le presse-papier.');
define('LC_HEAD_USERPANEL_INSTALL_FAILED_COPY_CLIPBOARD', 'Echec de copie dans le presse-papier.');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_SEND_SMS', 'Tapez le bouton ci-dessous pour envoyer l\'<i>adresse internet</i> par SMS.');
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_SEND_SMS', 'Envoyer par SMS...');
define('LC_HEAD_USERPANEL_INSTALL_MSG_SEND_SMS', 'Voici l\'adresse internet de l\'application [%1] : %2');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_INSTALL_APPLE', 'Installer sur Apple iOS');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_INSTALL_APPLE', 'Pour installer votre application sur <b>iPhone</b> ou <b>iPad</b>, ouvrez votre navigateur <b>Safari</b> et saisissez l\'<i>adresse internet</i> de l\'application dans la <b>barre d\'adresse</b>.<br>Une fois l\'application chargée, tapez le bouton %1 et choisissez <b>Sur l\'écran d\'accueil</b> dans le menu.');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_COMPATIBILITY', 'Compatibilité');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_COMPATIBILITY', 'Votre application ne peut être installée que sur les <b>appareils</b> et <b>navigateurs</b> suivants.');
define('LC_HEAD_USERPANEL_INSTALL_SEE_COMPATIBILITY', 'Voir');

define('LC_HEAD_USERPANEL_UNINSTALL_TEXT_GENERAL', 'Pour <b>désinstaller votre application</b>, depuis l\'<b>écran d\'accueil</b>, maintenez appuyé votre doigt sur l\'<b>icône de l\'application</b> quelques secondes jusqu\'à ce qu\'un menu soit affiché. Choisissez alors <b>désinstaller</b> ou <b>supprimer</b>.');
define('LC_HEAD_USERPANEL_UNINSTALL_TEXT_SPECIFIC', 'Sous Windows et pour certains navigateurs, les applications peuvent être désinstallées depuis une <b>page dédiée</b> (<i>copier et coller le lien ci-dessous dans la barre d\'adresse du navigateur indiqué</i>):');

/* Home page labels */
define('LC_HOME_WELCOME','Bienvenue dans ZnetDK');
define('LC_HOME_LEGEND_DBSTATUS',"Statut de la base de données de l'application");
define('LC_HOME_TXT_DB_SETTINGS1','Configuration');
define('LC_HOME_TXT_DB_SETTINGS2','utilisateur = <strong>'.CFG_SQL_APPL_USR.'@'.CFG_SQL_HOST
        .'</strong>, base de données = <strong>'. CFG_SQL_APPL_DB .'</strong>');
define('LC_HOME_TXT_DB_CONNECT1','Connexion à la base de données');
define('LC_HOME_TXT_DB_CONNECT2_OK','<span class="success">test réussi</span>');
define('LC_HOME_TXT_DB_CONNECT2_KO','<span class="failed">échec de connexion</span>');
define('LC_HOME_TXT_DB_TABLES1','Tables de sécurité');
define('LC_HOME_TXT_DB_TABLES2_OK','<span class="success">correctement installées</span>');
define('LC_HOME_TXT_DB_TABLES2_KO','<span class="failed">erreur détectée</span>');
define('LC_HOME_DATABASE_ERROR','Erreur: ');

define('LC_HOME_LEGEND_START','Bien débuter vos développements avec ZnetDK');
define('LC_HOME_TXT_START_MENU1',"Définition du menu");
define('LC_HOME_TXT_START_MENU2',"Le menu de l'application actuellement affiché est configuré dans le script PHP <strong>"
        . ZNETDK_APP_ROOT . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "menu.php</strong>"
        . " et peut être entièrement personnalisé pour afficher les nouvelles vues que vous avez développées.");
define('LC_HOME_TXT_START_CONCEPTS1','Concepts, Tutoriel & Démos');
define('LC_HOME_TXT_START_CONCEPTS2','vous disposez sur le site officiel de ZnetDK '
        . 'une présentation des <a href="http://www.znetdk.fr/concepts" target="_blank">concepts ZnetDK</a>, '
        . 'un <a href="http://www.znetdk.fr/tutoriel" target="_blank">tutoriel</a> '
        . 'et plusieurs <a href="http://www.znetdk.fr/demonstration" target="_blank">démonstrations</a>.');
define('LC_HOME_TXT_START_API1',"Référence de l'API");
define('LC_HOME_TXT_START_API2',"L'API de développement en <a href=\"http://www.znetdk.fr/api\" target=\"_blank\">PHP</a> "
        . 'et <a href="http://www.znetdk.fr/api#local_api" target="_blank">JavaScript</a> est également disponible sur le site internet, '
        . 'y compris la documentation relative aux <a href="http://www.znetdk.fr/composants_graphiques" target="_blank">composants graphiques ZnetDK</a>.');

/* Theme page label */
define('LC_THEME_MESSAGE','Cliquez sur l\'une des <strong>vignettes de thème</strong> ci-dessous pour en tester le rendu dans votre application.'
	.'<br/>Vous pouvez également retoucher un de ces thèmes ou <strong>créer votre propre thème</strong> depuis la page <a href="http://jqueryui.com/themeroller/" target="_blank">ThemeRoller</a> de jQuery UI...');

/* Widgets page label */
define('LC_WIDGETS_MESSAGE',"Visualisez ici un échantillon des <strong>composants graphiques PrimeUI</strong> avec lesquels vous pouvez développer côté client, les vues de votre application."
        . '<br>Découvrez une démonstration de tous les <strong>composants graphiques disponibles</strong> sur le <a href="http://www.primefaces.org/primeui/" target="_blank">site officiel PrimeUI</a>.');

/* Windows manager labels */
define('LC_WINMGR_TITLE',"Fenêtres");
define('LC_WINMGR_AUTOCLOSE',"Fermeture auto.");
define('LC_WINMGR_ADJUST_HORIZ',"Ajuster horizontal.");
define('LC_WINMGR_ADJUST_VERTI',"Ajuster vertical.");
define('LC_WINMGR_CLOSE_ALL',"Fermer tout");

/* FORM titles */
define('LC_FORM_TITLE_LOGIN','Connexion');
define('LC_FORM_TITLE_CHANGE_PASSWORD','Changer le mot de passe');
define('LC_FORM_TITLE_MY_ACCOUNT','Mon compte');
define('LC_FORM_TITLE_NEW_PASSWORD_REQUEST',"Demande d'un nouveau mot de passe");
define('LC_FORM_TITLE_SEARCH', 'Rechercher');
define('LC_FORM_TITLE_HELP','Aide en ligne - ');
define('LC_FORM_TITLE_USER_NEW','Nouvel utilisateur');
define('LC_FORM_TITLE_USER_MODIFY',"Modifier un utilisateur");
define('LC_FORM_TITLE_USER_REMOVE',"Supprimer un utilisateur");
define('LC_ACTION_SEARCH_USER_INPUT',"Rechercher des utilisateurs...");
define('LC_FORM_TITLE_PROFILE_NEW','Nouveau profil');
define('LC_FORM_TITLE_PROFILE_MODIFY',"Modifier un profil");
define('LC_FORM_TITLE_PROFILE_REMOVE',"Supprimer un profil");

/* Authorizations menu label */
define('LC_MENU_AUTHORIZATION','Habilitations');
define('LC_MENU_AUTHORIZ_USERS','Utilisateurs');
define('LC_MENU_AUTHORIZ_PROFILES','Profils');

/* Authorizations view labels */
define('LC_VIEW_AUTHORIZATION_USER','Utilisateur');
define('LC_VIEW_AUTHORIZATION_PROFILES','Profils');

/* Authorizations Datatable labels */
define('LC_TABLE_AUTHORIZ_USERS_CAPTION','utilisateurs habilités');
define('LC_TABLE_AUTHORIZ_PROFILES_CAPTION','profils utilisateur');
define('LC_TABLE_COL_LOGIN_ID','Identifiant');
define('LC_TABLE_COL_USER','Utilisateur');
define('LC_TABLE_COL_USER_NAME','Nom Utilisateur');
define('LC_TABLE_COL_USER_EMAIL','Email');
define('LC_TABLE_COL_USER_STATUS','Statut');
define('LC_TABLE_COL_MENU_ACCESS','Accès au menu');
define('LC_TABLE_COL_USER_PROFILES','Profils');
define('LC_TABLE_COL_PROFILE_NAME','Profil');
define('LC_TABLE_COL_PROFILE_DESC','Description');
define('LC_TABLE_COL_MENU_ITEMS','Eléments de menu');

/* Login Form labels */
define('LC_FORM_LBL_LOGIN_ID','Identifiant');
define('LC_FORM_LBL_PASSWORD','Mot de passe');
define('LC_FORM_LBL_ORIG_PASSWORD','Mot de passe actuel');
define('LC_FORM_LBL_NEW_PASSWORD','Nouveau mot de passe');
define('LC_FORM_LBL_PASSWORD_CONFIRM','Confirmation du mot de passe');
define('LC_FORM_LBL_ACCESS','Acc&egrave;s');
define('LC_FORM_LBL_PUBL_ACC','public (expiration de session)');
define('LC_FORM_LBL_PRIV_ACC','priv&eacute;');
define('LC_FORM_LBL_REMEMBER_ME', 'Se souvenir de moi');
define('LC_FORM_LBL_TOGGLE_PASSWORD', 'Afficher / masquer le mot de passe');
define('LC_FORM_LBL_FORGOT_PASSWORD', 'Mot de passe oublié ?');
define('LC_FORM_LBL_PASSWORD_EXPECTED_LENGTH', 'Minimum 8 caractères');
define('LC_FORM_LBL_PASSWORD_EXPECTED_LOWERCASE', 'Au moins une lettre minuscule');
define('LC_FORM_LBL_PASSWORD_EXPECTED_UPPERCASE', 'Au moins une lettre majuscule');
define('LC_FORM_LBL_PASSWORD_EXPECTED_NUMBER', 'Au moins un chiffre');
define('LC_FORM_LBL_PASSWORD_EXPECTED_SPECIAL', 'Au moins un caractère spécial : !*+-/=.,;:_@#?%"\'$&');
define('LC_FORM_LBL_PASSWORDS_MUST_MATCH', 'Les mots de passe doivent être identiques');

/* User Form labels */
define('LC_FORM_FLD_USER_IDENTITY','Identité');
define('LC_FORM_FLD_USER_CONNECTION','Connexion');
define('LC_FORM_FLD_USER_RIGHTS','Droits');
define('LC_FORM_LBL_USER_NAME','Nom');
define('LC_FORM_LBL_USER_EMAIL','Email');
define('LC_FORM_LBL_USER_PHONE','Téléphone');
define('LC_FORM_LBL_USER_NOTES','Notes');
define('LC_FORM_LBL_USER_EXPIRATION_DATE','Expiration le');
define('LC_FORM_LBL_USER_STATUS','Statut');
define('LC_FORM_LBL_USER_STATUS_ENABLED','Activé');
define('LC_FORM_LBL_USER_STATUS_DISABLED','Désactivé');
define('LC_FORM_LBL_USER_STATUS_ARCHIVED','Archivé');
define('LC_FORM_LBL_USER_MENU_ACCESS','Accès au menu');
define('LC_FORM_LBL_USER_MENU_ACCESS_FULL','Complet');
define('LC_FORM_LBL_USER_PROFILES','Profils');

/* Other Form labels */
define('LC_FORM_LBL_NO_FILE_SELECTED','&lt; Aucun fichier sélectionné ! &gt;');
define('LC_ACTION_ROWS_LABEL','Lignes par page');
define('LC_FORM_SEARCH_KEYWORD_LABEL', 'Mot-clé recherché');
define('LC_FORM_SEARCH_KEYWORD_CAPTION', 'Le mot-clé recherché concerne l\'identifiant de connexion, le nom de l\'utilisateur ou le profil affecté à l\'utilisateur.');
define('LC_FORM_SEARCH_KEYWORD_PLACEHOLDER', 'Saisissez un mot-clé à rechercher...');
define('LC_FORM_SEARCH_SORT_FIELD_LABEL', 'Trier le résultat par');
define('LC_FORM_SEARCH_SORT_ORDER_LABEL', 'Ordre de tri');
define('LC_FORM_SEARCH_SORT_ORDER_ASCENDING_LABEL', 'Croissant');
define('LC_FORM_SEARCH_SORT_ORDER_DESCENDING_LABEL', 'Décroissant');
define('LC_FORM_NEW_PASSWORD_REQUEST_PLACEHOLDER', 'Email du compte utilisateur concerné...');

/* BUTTON labels */
define('LC_BTN_LOGIN','Se connecter');
define('LC_BTN_CANCEL','Annuler');
define('LC_BTN_CLOSE','Fermer');
define('LC_BTN_SHOW_MENU', 'Afficher le menu');
define('LC_BTN_SHOW_USERPANEL', 'Panneau utilisateur');
define('LC_BTN_SAVE','Enregistrer');
define('LC_BTN_APPLY', 'Appliquer');
define('LC_BTN_VALIDATE', 'Valider');
define('LC_BTN_REFRESH','Actualiser');
define('LC_BTN_SEARCH','Rechercher...');
define('LC_BTN_SCROLL_TO_TOP','Retour en haut de page');
define('LC_BTN_NEW','Nouveau');
define('LC_BTN_MODIFY','Modifier');
define('LC_BTN_OPEN','Ouvrir');
define('LC_BTN_OK','Ok');
define('LC_BTN_REMOVE','Supprimer');
define('LC_BTN_MANAGE','Gérer');
define('LC_BTN_YES','Oui');
define('LC_BTN_NO','Non');
define('LC_BTN_SELECTFILE','Choisir...');
define('LC_BTN_EXPORT','Exporter...');
define('LC_BTN_IMPORT','Importer...');
define('LC_BTN_ARCHIVE','Archiver...');
define('LC_BTN_RESET_SORT', 'Tri par défaut');
define('LC_ACTION_SEARCH_KEYWORD_BTN_RUN','Lancer la recherche');
define('LC_ACTION_SEARCH_KEYWORD_BTN_CLEAR','Effacer le mot-clé de recherche');

/* Link labels */
define('LC_LNK_SHOW_NEXT_RESULTS', 'Voir les résultats suivants');

/* CRITICAL ERROR messages */
define('LC_MSG_CRI_ERR_SUMMARY','Incident technique');
define('LC_MSG_CRI_ERR_DETAIL',"Un problème technique est survenu pendant le traitement de la dernière action demandée. Veuillez contacter votre administrateur et lui signaler le détail de l'erreur ci-dessous :<br><span class='zdk-err-detail'>\"%1\"</span>");
define('LC_MSG_CRI_ERR_GENERIC',"Un problème technique est survenu pendant le traitement de la dernière action demandée. Veuillez réessayer ultérieurement.");

/* ERROR messages */
define('LC_MSG_ERR_LOGIN','Identifiant ou mot de passe invalide !');
define('LC_MSG_ERR_DIFF_LOGIN',"Vous devez utiliser le même identifiant pour renouveler votre connexion !");
define('LC_MSG_ERR_LOGIN_EXPIRATION',"Veuillez saisir un <b>nouveau mot de passe</b> (<i>2 fois</i> avec la confirmation) car votre mot de passe actuel <i>n'est plus valide</i>.");
define('LC_MSG_ERR_LOGIN_TOO_MUCH_ATTEMPTS',"Le nombre d'essais autorisés pour vous authentifier a été dépassé !<br>Votre compte utilisateur a été désactivé.");
define('LC_MSG_ERR_LOGIN_THROTTLING_TOO_MUCH_ATTEMPTS', 'En raison du trop grand nombre d\'échecs de connexion, veuillez attendre %1 secondes avant de vous connecter à nouveau.');
define('LC_MSG_ERR_HTTP','<h3>Erreur HTTP %1 !</h3><p><a href="%2">Cliquez ici</a> pour retourner à la page d\'accueil.</p>');
define('LC_MSG_ERR_OFFLINE','<h3>PAS DE CONNEXION INTERNET</h3><p>Une connexion internet est nécessaire pour utiliser votre application.<br><a href="%1">Essayer à nouveau</a>.</p>');
define('LC_MSG_ERR_MAINTENANCE','<h3>MAINTENANCE EN COURS</h3><p>Votre application est momentanément indisponible en raison de travaux de maintenance. Veuillez réessayer plus tard.<br><a href="%1">Essayer à nouveau</a>.</p>');
define('LC_MSG_ERR_SELECT_RECORD',"Une erreur est survenue! Lecture des données impossible.");
define('LC_MSG_ERR_SAVE_RECORD',"Une erreur est survenue ! L'enregistrement a échoué.");
define('LC_MSG_ERR_REMOVE_RECORD',"Une erreur est survenue ! Suppression impossible.");
define('LC_MSG_ERR_MISSING_VALUE',"Veuillez saisir une valeur !");
define('LC_MSG_ERR_MISSING_VALUE_FOR',"Veuillez saisir une valeur pour '%1'!");
define('LC_MSG_ERR_PWD_MISMATCH','Le mot de passe et sa confirmation de saisie sont différents !');
define('LC_MSG_ERR_PWD_IDENTICAL','Le nouveau mot de passe doit être différent du mot de passe actuel !');
define('LC_MSG_ERR_PASSWORD_INVALID','Mot de passe invalide.');
define('LC_MSG_ERR_PASSWORD_BADLENGTH','Le mot de passe doit contenir un minimum de 8 caractères, au moins 1 lettre majuscule et minuscule et 1 chiffre !'
    . '<br>Les caractères spéciaux suivants sont également acceptés : ! * + - / = . , ; : _ @ # ? % " \' $ &');
define('LC_MSG_ERR_EMAIL_INVALID',"L'adresse email n'est pas une adresse valide !");
define('LC_MSG_ERR_LOGIN_BADLENGTH',"L'identifiant de connexion doit contenir entre 6 et 20 caractères !");
define('LC_MSG_ERR_VALUE_BADLENGTH','Valeur saisie de longueur incorrecte !');
define('LC_MSG_ERR_LOGIN_EXISTS',"L'identifiant de connexion existe déjà pour un autre utilisateur !");
define('LC_MSG_ERR_PROFILE_EXISTS',"Un profil nommé '%1' existe déjà !");
define('LC_MSG_ERR_EMAIL_EXISTS',"L'adresse email existe déjà pour un autre utilisateur !");
define('LC_MSG_ERR_DATE_INVALID','Le format de date est invalide !');
define('LC_MSG_ERR_VALUE_INVALID','Valeur inattendue !');
define('LC_MSG_ERR_REMOVE_PROFILE','Suppression impossible ! Le profil est actuellement affecté à un ou plusieurs utilisateurs.');
define('LC_MSG_ERR_NETWORK','Erreur réseau|Vérifiez votre connexion réseau et recommencez.');
define('LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY','Opération non autorisée');
define('LC_MSG_ERR_FORBIDDEN_ACTION_MESSAGE',"Vous n'êtes pas autorisé à effectuer l'opération demandée.");
define('LC_MSG_ERR_PWD_RESET_REQUEST_FAILED', 'Une demande de changement de mot de passe est en cours. Veuillez patienter et recommencer plus tard.');
define('LC_MSG_ERR_PWD_RESET_FAILED', 'Votre demande de nouveau mot de passe n\'est plus valide.<br><a href="%1">Veuillez recommencer</a>.');

/* WARNING messages */
define('LC_MSG_WARN_NO_AUTH',"Vous n'êtes pas connecté(e). Veuillez vous authentifier.");
define('LC_MSG_WARN_SESS_TIMOUT',"Votre session a expir&eacute;. Veuillez vous reconnecter.");
define('LC_MSG_WARN_HELP_NOTFOUND',"Aucune aide n'existe pour la page actuellement affichée.");
define('LC_MSG_WARN_ROW_NOTSELECTED',"Veuillez s'il vous plaît sélectionner en premier une ligne !");
define('LC_MSG_WARN_PROFILE_ROWS_EXIST',"<p><strong><span style='color:red;'>Attention</span></strong> : "
        . "<span style='font-style:italic;'>ce profil a été associé à des lignes de données de l'application qui seront également supprimées!</span></p>");
define('LC_MSG_WARN_SEARCH_NO_VALUE','Saisissez tout d\'abord un critère de recherche !');
define('LC_MSG_WARN_NEW_VERSION_SUMMARY', 'Nouvelle version disponible');
define('LC_MSG_WARN_NEW_VERSION_MSG', 'Votre application va être rechargée dans votre navigateur.');
define('LC_MSG_WARN_LOGGED_OUT_SUMMARY', 'Connexion interrompue');
define('LC_MSG_WARN_LOGGED_OUT_MSG', 'Vous allez être redirigé vers la page de connexion.');

/* INFO messages */
define('LC_MSG_INF_LOGIN',"Connexion réussie.");
define('LC_MSG_INF_PWDCHANGED',"Votre mot de passe a été modifié.");
define('LC_MSG_INF_USERSTORED',"Utilisateur enregistré.");
define('LC_MSG_INF_USERREMOVED',"Utilisateur supprimé.");
define('LC_MSG_INF_USER_PROFILE_STORED',"Profil enregistré.");
define('LC_MSG_INF_USER_PROFILE_REMOVED',"Profil supprimé.");
define('LC_MSG_INF_REQUEST_PWD_RESET_PROCESSED', 'Si cette adresse email est bien dans notre base de données, vous allez recevoir un email pour réinitialiser votre mot de passe.');
define('LC_MSG_INF_PWD_RESET_PROCESSED', 'Votre mot de passe provisoire vous a été envoyé par email.<br><a href="%1">Cliquez ici</a> pour vous connecter.');
define('LC_MSG_INF_LOGOUT','<h3>Déconnexion réussie.</h3><p><a href="">Cliquez ici</a> pour vous reconnecter.</p>');
define('LC_MSG_INF_CANCEL_LOGIN','<h3>Connexion annulée.</h3><p><a href="">Cliquez ici</a> pour vous connecter.</p>');
define('LC_MSG_INF_SAVE_RECORD','Enregistrement de la ligne réussi.');
define('LC_MSG_INF_REMOVE_RECORD','Suppression de la ligne réussie.');
define('LC_MSG_INF_SELECT_LIST_ITEM',"Pour une sélection multiple, maintenez la touche <Control> enfoncée tout en cliquant sur un élément de la liste.");
define('LC_MSG_INF_SELECT_TREE_NODE',"Pour une sélection multiple, maintenez la touche <Control> enfoncée tout en cliquant sur un noeud de l'arbre.");
define('LC_MSG_INF_NO_RESULT_FOUND', 'Aucun résultat trouvé.');

/* QUESTION messages */
define('LC_MSG_ASK_REMOVE','Souhaitez-vous réellement supprimer cet enregistrement ?');
define('LC_MSG_ASK_CANCEL_CHANGES','Les données du formulaire ont été modifiées.'
        . '<br><br>Quitter <b>sans</b> enregistrer ?');
define('LC_MSG_ASK_INSTALL', 'Installer l\'application ?');