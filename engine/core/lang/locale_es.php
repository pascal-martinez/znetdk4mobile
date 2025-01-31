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
* Core spanish translations of the application
*
* File version: 1.22
* Last update: 12/15/2024
*/

/* General PHP localization settings (used by the PHP 'setlocale' function) */
define ('LC_LOCALE_ALL', serialize(array('es_ES.UTF-8', 'Spanish_Spain.1252', 'es_ES', 'spanish')));

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
define('LC_LANG_ISO_CODE','es');

/* General labels */
define('LC_PAGE_TITLE','Aplicación ZnetDK');

/* Header labels */
define('LC_HEAD_TITLE','Aplicación ZnetDK (core)');
define('LC_HEAD_SUBTITLE','Lista para desarrollar...');
define('LC_HEAD_LNK_LOGOUT','desconectarse');
define('LC_HEAD_LNK_HELP','Ayuda');
define('LC_HEAD_USERPANEL_MY_USER_RIGHTS','Mis derechos de usuario');
define('LC_HEAD_USERPANEL_INSTALL','Instalación');
define('LC_HEAD_USERPANEL_UNINSTALL','Desinstalación');

/* Header images */
define('LC_HEAD_IMG_LOGO_LINK_TITLE', 'Retorno al inicio');
define('LC_HEAD_IMG_LOGO',ZNETDK_ROOT_URI . CFG_ZNETDK_IMG_DIR . '/logoznetdk.svg?v=1');

/* Footer labels */
define('LC_FOOTER_LEFT','Versión '.ZNETDK_VERSION);
define('LC_FOOTER_CENTER','Copyright 2014-2025 Pascal MARTINEZ');
define('LC_FOOTER_RIGHT','Realizado con <a href="https://www.znetdk.fr" target="_blank">ZnetDK</a>');

/* User Panel Installation labels */
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL', 'Instalar la aplicación...');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS', 'Información útil');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_IS_INSTALLED', 'Su aplicación ya está instalada.');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLED', 'Su aplicación aún no está instalada. Toque el botón <b>'
        . LC_HEAD_USERPANEL_INSTALL_BUTTON_INSTALL . '</b> a continuación para instalarla.');
define('LC_HEAD_USERPANEL_INSTALL_STATUS_NOT_INSTALLABLE', 'Su aplicación debe instalarse manualmente. Ver <b>'
        . LC_HEAD_USERPANEL_INSTALL_TITLE_HELPFUL_INFOS . '</b> a continuación.');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_INTERNET_ADDRESS', 'Dirección de Internet');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_INTERNET_ADDRESS', 'La <i>dirección de Internet</i> que debe ingresar en la <b>barra de direcciones</b> de su navegador web es: %1');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_COPY_CLIPBOARD', 'Toque el botón a continuación para copiar la <i>dirección de Internet</i> en el portapapeles.');
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_COPY_CLIPBOARD', 'Copiar al portapapeles');
define('LC_HEAD_USERPANEL_INSTALL_SUCCESS_COPY_CLIPBOARD', 'Dirección copiada en el portapapeles.');
define('LC_HEAD_USERPANEL_INSTALL_FAILED_COPY_CLIPBOARD', '¡Error al copiar al portapapeles!');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_SEND_SMS', 'Toque el botón de abajo para enviar la <i>dirección de Internet</i> por SMS.');
define('LC_HEAD_USERPANEL_INSTALL_BUTTON_SEND_SMS', 'Enviar por SMS...');
define('LC_HEAD_USERPANEL_INSTALL_MSG_SEND_SMS', 'Aquí está la dirección web de la aplicación [%1]: %2');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_INSTALL_APPLE', 'Instalar en Apple iOS');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_INSTALL_APPLE', 'Para instalar su aplicación en <b>iPhone</b> o <b>iPad</b>, abra su navegador <b>Safari</b> e ingrese la dirección de Internet de la aplicación en la barra de direcciones.'
 . '<br>Una vez que se carga la aplicación, toque el botón %1 y elija <b>Añadir a pantalla de inicio</b> en el menú.');
define('LC_HEAD_USERPANEL_INSTALL_TITLE_COMPATIBILITY', 'Compatibilidad');
define('LC_HEAD_USERPANEL_INSTALL_TEXT_COMPATIBILITY', 'Su aplicación solo se puede instalar en las siguientes <b>plataformas</b> y <b>navegadores web</b>.');
define('LC_HEAD_USERPANEL_INSTALL_SEE_COMPATIBILITY', 'Ver');

define('LC_HEAD_USERPANEL_UNINSTALL_TEXT_GENERAL', 'Para <b>desinstalar su aplicación</b>, desde la <b>pantalla de inicio</b>, mantenga presionado el <b>ícono de la aplicación</b> durante unos segundos hasta que aparezca un menú. Luego elija <b>desinstalar</b> o <b>eliminar</b>.');
define('LC_HEAD_USERPANEL_UNINSTALL_TEXT_SPECIFIC', 'En algunos navegadores web, las aplicaciones se pueden desinstalar desde una <b>página dedicada</b> (<i>copie y pegue el enlace a continuación en la barra de direcciones del navegador dado</i>):');

/* Home page labels */
define('LC_HOME_WELCOME','Bienvenido en ZnetDK');
define('LC_HOME_LEGEND_DBSTATUS','Estado de la base de datos de la aplicación');
define('LC_HOME_TXT_DB_SETTINGS1','configuración');
define('LC_HOME_TXT_DB_SETTINGS2','usuario = <strong>'.CFG_SQL_APPL_USR.'@'.CFG_SQL_HOST
        .'</strong>, base de datos = <strong>'. CFG_SQL_APPL_DB .'</strong>');
define('LC_HOME_TXT_DB_CONNECT1','Conexión a la base de datos');
define('LC_HOME_TXT_DB_CONNECT2_OK','<span class="success">prueba exitosa</span>');
define('LC_HOME_TXT_DB_CONNECT2_KO','<span class="failed">failed to connect</span>');
define('LC_HOME_TXT_DB_TABLES1','Tablas de seguridad');
define('LC_HOME_TXT_DB_TABLES2_OK','<span class="success">corectamente instaladas</span>');
define('LC_HOME_TXT_DB_TABLES2_KO','<span class="failed">instalación errónea</span>');
define('LC_HOME_DATABASE_ERROR','Error: ');

define('LC_HOME_LEGEND_START','Comience su desarrollo con ZnetDK');
define('LC_HOME_TXT_START_MENU1',"Definición de menú");
define('LC_HOME_TXT_START_MENU2',"el menú de la aplicación que aparece actualmente, está configurado en el script <strong>"
        . ZNETDK_APP_ROOT . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "menu.php</strong>"
        . " y puede ser totalmente personalizado para mostrar las nuevas vistas desarrolladas.");
define('LC_HOME_TXT_START_CONCEPTS1','Conceptos, Tutorial y Demos');
define('LC_HOME_TXT_START_CONCEPTS2','encontrará en el sitio web oficial '
        . 'una presentación de los  <a href="http://www.znetdk.fr/concepts" target="_blank">conceptos ZnetDK</a>, '
        . 'un <a href="http://www.znetdk.fr/tutoriel" target="_blank">tutorial</a> '
        . 'y varias <a href="http://www.znetdk.fr/demonstration" target="_blank">demostraciones</a>.');
define('LC_HOME_TXT_START_API1','Referencia de la API');
define('LC_HOME_TXT_START_API2','la API de desarrollo en <a href="http://www.znetdk.fr/api" target="_blank">PHP</a> '
        . 'y <a href="http://www.znetdk.fr/api#local_api" target="_blank">JavaScript</a> también está disponible en el sitio web, '
        . 'incluyendo la documentación relativa a los <a href="http://www.znetdk.fr/composants_graphiques" target="_blank">widgets de ZnetDK</a>.');

/* Theme page label */
define('LC_THEME_MESSAGE','Haga clic sobre una <strong>miniatura del tema</strong> para visualizarla en su aplicación.'
	.'<br/>También puede editar uno de estos temas o <strong>crear su propio tema</strong> desde la página <a href="http://jqueryui.com/themeroller/" target="_blank">ThemeRoller</a> de jQuery UI...');

/* Widgets page label */
define('LC_WIDGETS_MESSAGE',"Encuentra aquí una muestra de los <strong>widgets PrimeUI</strong> con el que puede desarrollar las vistas de su aplicación del lado del cliente."
        . '<br>Vea una demostración de <strong>todos los widgets disponibles</strong> en el <a href="http://www.primefaces.org/primeui/" target="_blank">sitio web PrimeUI</a>.');

/* Windows manager labels */
define('LC_WINMGR_TITLE',"Ventanas");
define('LC_WINMGR_AUTOCLOSE',"Cierre auto.");
define('LC_WINMGR_ADJUST_HORIZ',"Ajuste horizontal.");
define('LC_WINMGR_ADJUST_VERTI',"Ajuste vertical.");
define('LC_WINMGR_CLOSE_ALL',"Cerrar todo");

/* FORM titles */
define('LC_FORM_TITLE_LOGIN','Conexión');
define('LC_FORM_TITLE_CHANGE_PASSWORD','Cambio de contraseña');
define('LC_FORM_TITLE_MY_ACCOUNT','Mi cuenta');
define('LC_FORM_TITLE_NEW_PASSWORD_REQUEST','Pide una nueva contraseña');
define('LC_FORM_TITLE_SEARCH', 'Buscar');
define('LC_FORM_TITLE_HELP','Ayuda en línea - ');
define('LC_FORM_TITLE_USER_NEW','Nuevo usuario');
define('LC_FORM_TITLE_USER_MODIFY',"Modificar un usuario");
define('LC_FORM_TITLE_USER_REMOVE',"Eliminar usuario");
define('LC_ACTION_SEARCH_USER_INPUT',"Buscar usuarios...");
define('LC_FORM_TITLE_PROFILE_NEW','Nuevo perfil');
define('LC_FORM_TITLE_PROFILE_MODIFY',"Modificar un perfil");
define('LC_FORM_TITLE_PROFILE_REMOVE',"Eliminar perfil");

/* Authorizations menu label */
define('LC_MENU_AUTHORIZATION','Permisos');
define('LC_MENU_AUTHORIZ_USERS','Usarios');
define('LC_MENU_AUTHORIZ_PROFILES','Perfiles');

/* Authorizations view labels */
define('LC_VIEW_AUTHORIZATION_USER','Usuario');
define('LC_VIEW_AUTHORIZATION_PROFILES','Perfiles');
define('LC_VIEW_AUTHORIZATION_USERS','Usuarios registrados');

/* Authorizations Datatable labels */
define('LC_TABLE_AUTHORIZ_USERS_CAPTION','usuarios registrados');
define('LC_TABLE_AUTHORIZ_PROFILES_CAPTION','perfiles de usuario');
define('LC_TABLE_COL_LOGIN_ID','Login de conexión');
define('LC_TABLE_COL_USER','Usario');
define('LC_TABLE_COL_USER_NAME','Nombre Usario');
define('LC_TABLE_COL_USER_EMAIL','Email');
define('LC_TABLE_COL_USER_STATUS','Estado');
define('LC_TABLE_COL_MENU_ACCESS','Accesso al menú');
define('LC_TABLE_COL_USER_PROFILES','Perfiles');
define('LC_TABLE_COL_PROFILE_NAME','Perfil');
define('LC_TABLE_COL_PROFILE_DESC','Descripción');
define('LC_TABLE_COL_MENU_ITEMS','Elementos de menú');

/* Login Form labels */
define('LC_FORM_LBL_LOGIN_ID','Login');
define('LC_FORM_LBL_PASSWORD','Contraseña');
define('LC_FORM_LBL_ORIG_PASSWORD','Contraseña actual');
define('LC_FORM_LBL_NEW_PASSWORD','Nueva contraseña');
define('LC_FORM_LBL_PASSWORD_CONFIRM','Confirmación');
define('LC_FORM_LBL_ACCESS','Accesso');
define('LC_FORM_LBL_PUBL_ACC','público (finaliza la sesión)');
define('LC_FORM_LBL_PRIV_ACC','privado');
define('LC_FORM_LBL_REMEMBER_ME', 'Recuérdame');
define('LC_FORM_LBL_TOGGLE_PASSWORD', 'Mostrar / ocultar contraseña');
define('LC_FORM_LBL_FORGOT_PASSWORD', 'Contraseña olvidada ?');
define('LC_FORM_LBL_PASSWORD_EXPECTED_LENGTH', 'Mínimo 8 caracteres');
define('LC_FORM_LBL_PASSWORD_EXPECTED_LOWERCASE', 'Al menos una letra minúscula');
define('LC_FORM_LBL_PASSWORD_EXPECTED_UPPERCASE', 'Al menos una letra mayuscula');
define('LC_FORM_LBL_PASSWORD_EXPECTED_NUMBER', 'al menos un dígito');
define('LC_FORM_LBL_PASSWORD_EXPECTED_SPECIAL', 'Al menos un carácter especial: !*+-/=.,;:_@#?%"\'$&');
define('LC_FORM_LBL_PASSWORDS_MUST_MATCH', 'Las contraseñas deben coincidir');

/* User Form labels */
define('LC_FORM_FLD_USER_IDENTITY','Datos personales');
define('LC_FORM_FLD_USER_CONNECTION','Conexión');
define('LC_FORM_FLD_USER_RIGHTS','Permisos');
define('LC_FORM_LBL_USER_NAME','Nombre');
define('LC_FORM_LBL_USER_EMAIL','Email');
define('LC_FORM_LBL_USER_PHONE','Teléfono');
define('LC_FORM_LBL_USER_NOTES','Notas');
define('LC_FORM_LBL_USER_EXPIRATION_DATE','Expira el');
define('LC_FORM_LBL_USER_STATUS','Estado');
define('LC_FORM_LBL_USER_STATUS_ENABLED','Activado');
define('LC_FORM_LBL_USER_STATUS_DISABLED','Desactivado');
define('LC_FORM_LBL_USER_STATUS_ARCHIVED','Archivado');
define('LC_FORM_LBL_USER_MENU_ACCESS','Accesso al menú');
define('LC_FORM_LBL_USER_MENU_ACCESS_FULL','Completo');
define('LC_FORM_LBL_USER_PROFILES','Perfiles');

/* Other Form labels */
define('LC_FORM_LBL_NO_FILE_SELECTED','&lt; No archivo seleccionnado! &gt;');
define('LC_ACTION_ROWS_LABEL','Líneas por página');
define('LC_FORM_SEARCH_KEYWORD_LABEL', 'Palabra clave');
define('LC_FORM_SEARCH_KEYWORD_CAPTION', 'La palabra clave buscada se relaciona con el ID de inicio de sesión, el nombre de usuario o el perfil asignado al usuario.');
define('LC_FORM_SEARCH_KEYWORD_PLACEHOLDER', 'Entra la palabra clave de su búsqueda...');
define('LC_FORM_SEARCH_SORT_FIELD_LABEL', 'Clasificar el resultado por');
define('LC_FORM_SEARCH_SORT_ORDER_LABEL', 'Orden de clasificación');
define('LC_FORM_SEARCH_SORT_ORDER_ASCENDING_LABEL', 'Ascendente');
define('LC_FORM_SEARCH_SORT_ORDER_DESCENDING_LABEL', 'Descendente');
define('LC_FORM_NEW_PASSWORD_REQUEST_PLACEHOLDER', 'Email de la cuenta de usuario en cuestión');

/* BUTTON labels */
define('LC_BTN_LOGIN','Conectarse');
define('LC_BTN_CANCEL','Cancelar');
define('LC_BTN_CLOSE','Cerrar');
define('LC_BTN_SHOW_MENU', 'Mostrar el menú');
define('LC_BTN_SHOW_USERPANEL', 'Panel de usuario');
define('LC_BTN_SAVE','Guardar');
define('LC_BTN_APPLY', 'Aplicar');
define('LC_BTN_VALIDATE', 'Validar');
define('LC_BTN_REFRESH','Actualizar');
define('LC_BTN_SEARCH','Buscar...');
define('LC_BTN_SCROLL_TO_TOP','Vuelve al comienzo');
define('LC_BTN_NEW','Nuevo');
define('LC_BTN_MODIFY','Editar');
define('LC_BTN_OPEN','Abrir');
define('LC_BTN_OK','Ok');
define('LC_BTN_REMOVE','Eliminar');
define('LC_BTN_MANAGE','Administrar');
define('LC_BTN_YES','Sí');
define('LC_BTN_NO','No');
define('LC_BTN_SELECTFILE','Elegir...');
define('LC_BTN_EXPORT','Exportar...');
define('LC_BTN_IMPORT','Importar...');
define('LC_BTN_ARCHIVE','Archivar...');
define('LC_BTN_RESET_SORT', 'Ordenar por defecto');
define('LC_ACTION_SEARCH_KEYWORD_BTN_RUN','Iniciar la búsqueda');
define('LC_ACTION_SEARCH_KEYWORD_BTN_CLEAR','Eliminar la palabra clave');

/* Link labels */
define('LC_LNK_SHOW_NEXT_RESULTS', 'Ver los siguientes resultados');

/* CRITICAL ERROR messages */
define('LC_MSG_CRI_ERR_SUMMARY','Problema técnico');
define('LC_MSG_CRI_ERR_DETAIL',"Ha ocurrido un problema. Por favor, póngase en contacto con su administrador para informar de los detalles del error a continuación:<br><span class='zdk-err-detail'>\"%1\"</span>");
define('LC_MSG_CRI_ERR_GENERIC',"Ha ocurrido un problema. Vuelva a intentarlo más tarde.");

/* ERROR messages */
define('LC_MSG_ERR_LOGIN','Login o contraseña incorrecta !');
define('LC_MSG_ERR_DIFF_LOGIN','Tiene que utilizar el mismo login para conectarse de nuevo!');
define('LC_MSG_ERR_LOGIN_EXPIRATION','Ingrese una <b>nueva contraseña</b> (<i>2 veces</i> con confirmación) ya que su contraseña actual <i>ya no es válida</i>.');
define('LC_MSG_ERR_LOGIN_TOO_MUCH_ATTEMPTS','El maximo de intentos autorizados ha sido alcanzado!<br>Su cuenta de usuario ha sido desactivada.');
define('LC_MSG_ERR_LOGIN_THROTTLING_TOO_MUCH_ATTEMPTS', 'Debido a demasiados fallos de inicio de sesión, espere %1 segundos antes de iniciar sesión nuevamente.');
define('LC_MSG_ERR_HTTP','<h3>Error HTTP %1!</h3><p><a href="%2">Haga clic aquí</a> para volver a la página de inicio.</p>');
define('LC_MSG_ERR_OFFLINE','<h3>NO CONEXION INTERNET</h3><p>Se necesita una una conexión internet para usar este aplicación. <br><a href="%1">Intentar de nuevo</a>.</p>');
define('LC_MSG_ERR_MAINTENANCE','<h3>MANTENIMIENTO EN PROGRESO</h3><p>Su aplicación no está disponible temporalmente debido a trabajos de mantenimiento. Por favor, inténtelo de nuevo más tarde.<br><a href="%1">Intentar de nuevo</a>.</p>');
define('LC_MSG_ERR_SELECT_RECORD',"Ha ocurrido un error! No se pueden seleccionar los datos!");
define('LC_MSG_ERR_SAVE_RECORD',"Ha ocurrido un error! No se puede guardar el registro!");
define('LC_MSG_ERR_REMOVE_RECORD',"Ha ocurrido un error! No se puede eliminar el registro!");
define('LC_MSG_ERR_MISSING_VALUE',"Por favor, introduzca un valor!");
define('LC_MSG_ERR_MISSING_VALUE_FOR',"Por favor, introduzca un valor por '%1'!");
define('LC_MSG_ERR_PWD_MISMATCH','La contraseña y su confirmación no corresponden!');
define('LC_MSG_ERR_PWD_IDENTICAL','La nueva contraseña tiene que ser diferente de la contraseña actual!');
define('LC_MSG_ERR_PASSWORD_INVALID','Contraseña invalida.');
define('LC_MSG_ERR_PASSWORD_BADLENGTH','La contraseña debe contener un mínimo de 8 caracteres, al menos 1 letra mayúscula y minúscula y 1 número.'
            .'<br>También se aceptan los siguientes caracteres especiales: ! * + - / = . , ; : _ @ # ? % " \' $ &');
define('LC_MSG_ERR_EMAIL_INVALID','El email no es válido!');
define('LC_MSG_ERR_LOGIN_BADLENGTH','¡El login de conexión debe contener entre 6 y 20 caracteres!');
define('LC_MSG_ERR_VALUE_BADLENGTH','El número de caracteres es incorrecto para este valor!');
define('LC_MSG_ERR_LOGIN_EXISTS','Un usario ya existe con el mismo login de conexión!');
define('LC_MSG_ERR_PROFILE_EXISTS',"El perfil '%1' ya existe con el mismo nombre!");
define('LC_MSG_ERR_EMAIL_EXISTS','Un usario ya existe con el mismo email!');
define('LC_MSG_ERR_DATE_INVALID','El formato de la fecha no es válido !');
define('LC_MSG_ERR_VALUE_INVALID','Valor inesperado !');
define('LC_MSG_ERR_REMOVE_PROFILE','No se puede suprimir! El perfil está actualmente asignado a uno o más usuarios.');
define('LC_MSG_ERR_NETWORK','Error en la red|Compruebe su conexión de red y vuelve a intentarlo.');
define('LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY','Operación no permitida');
define('LC_MSG_ERR_FORBIDDEN_ACTION_MESSAGE',"No se le permite hacer la operación solicitada.");
define('LC_MSG_ERR_PWD_RESET_REQUEST_FAILED', 'Hay una solicitud de cambio de contraseña en curso. Espere y vuelva a intentarlo más tarde.');
define('LC_MSG_ERR_PWD_RESET_FAILED', 'Su solicitud de una nueva contraseña ya no es válida.<br><a href="%1">Empiece de nuevo.</a>.');

/* WARNING messages */
define('LC_MSG_WARN_NO_AUTH',"No esta conectado. Por favor, identifíquese.");
define('LC_MSG_WARN_SESS_TIMOUT',"Su sesión ha caducado. Por favor, iniciar sesión nuevamente.");
define('LC_MSG_WARN_HELP_NOTFOUND',"No hay archivo de ayuda para la página actual.");
define('LC_MSG_WARN_ROW_NOTSELECTED',"Por favor seleccione primero una línea!");
define('LC_MSG_WARN_PROFILE_ROWS_EXIST',"<p><strong><span style='color:red;'>Atención</span></strong>: "
        . "<span style='font-style:italic;'>este perfil está asociado con registros de la aplicación que también se eliminarán!</span></p>");
define('LC_MSG_WARN_SEARCH_NO_VALUE', "Por favor introduzca primero un criterio!");
define('LC_MSG_WARN_NEW_VERSION_SUMMARY', 'Nueva versión disponible');
define('LC_MSG_WARN_NEW_VERSION_MSG', 'Su aplicación se volverá a cargar en su navegador web.');
define('LC_MSG_WARN_LOGGED_OUT_SUMMARY', 'Conexión interrumpida');
define('LC_MSG_WARN_LOGGED_OUT_MSG', 'Será redirigido a la página de inicio de sesión.');

/* INFO messages */
define('LC_MSG_INF_LOGIN',"Se ha conectado con éxito.");
define('LC_MSG_INF_PWDCHANGED',"Su contraseña ha sido cambiada correctamente.");
define('LC_MSG_INF_USERSTORED',"Usuario guardado.");
define('LC_MSG_INF_USERREMOVED',"Usuario eliminado.");
define('LC_MSG_INF_USER_PROFILE_STORED',"Perfil guardado.");
define('LC_MSG_INF_USER_PROFILE_REMOVED',"Perfil eliminado.");
define('LC_MSG_INF_REQUEST_PWD_RESET_PROCESSED', 'Si esa dirección de correo electrónico está en nuestra base de datos, le enviaremos un correo electrónico para restablecer su contraseña.');
define('LC_MSG_INF_PWD_RESET_PROCESSED', 'Su contraseña temporal le ha sido enviada por correo electrónico.<br><a href="%1">Haga clic aquí</a> para conectarse.');
define('LC_MSG_INF_LOGOUT','<h3>Desconexión correcta.</h3><p><a href="">Haga clic aquí</a> para conectarse de nuevo.</p>');
define('LC_MSG_INF_CANCEL_LOGIN','<h3>Conexión cancelada.</h3><p><a href="">Haga clic aquí</a> para conectarse.</p>');
define('LC_MSG_INF_SAVE_RECORD','Registro guardado correctamente.');
define('LC_MSG_INF_REMOVE_RECORD','Registro eliminado correctamente.');
define('LC_MSG_INF_SELECT_LIST_ITEM','Para seleccionar varios registros, mantenga la tecla <Control> presionada mientras hace clic en un elemento de la lista.');
define('LC_MSG_INF_SELECT_TREE_NODE','Para seleccionar varios registros, mantenga la tecla <Control> presionada mientras hace clic en un nodo del árbol.');
define('LC_MSG_INF_NO_RESULT_FOUND', 'No se han encontrado resultados.');

/* QUESTION messages */
define('LC_MSG_ASK_REMOVE','¿Realmente quiere eliminar el registro seleccionado?');
define('LC_MSG_ASK_CANCEL_CHANGES','Los datos del formulario han sido cambiados'
        . '<br><br>¿Realmente quiere quitar sin guardar los cambios?');
define('LC_MSG_ASK_INSTALL', '¿Instala la aplicación?');