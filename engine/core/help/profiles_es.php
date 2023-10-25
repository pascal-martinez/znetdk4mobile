<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Core Users help view (spanish)
	
File version: 1.0
Last update: 09/18/2015
-->
<h1>Perfiles de usuario</h1>
<p>Los perfiles de usuario permiten de reducir o extender el acceso a las funcionalidades de la aplicación,
    para todos los usuarios a los que se concedió el perfil.</p>
<p>La restricción o la extensión de acceso a las funcionalidades otras que las de la menú de navegación,
    depende directamente de la reglas de acceso desarolladas para los requisitos de la aplicación.</p>
<h2>Nuevo perfil</h2>
<p>Para añadir un perfil, haga clic en el botón <q><?php echo LC_BTN_NEW;?></q> de la barra de acción.
    Después de abrir el formulario de registro de perfil, complete la siguiente información:</p>

<ul>
    <li><strong><?php echo LC_TABLE_COL_PROFILE_NAME;?></strong> : nombre del perfil.</li>
    <li><strong><?php echo LC_TABLE_COL_PROFILE_DESC;?></strong> : descripción del perfil.</li>
    <li><strong><?php echo LC_TABLE_COL_MENU_ITEMS;?></strong> : elementos del menú de navegación concedidos por el perfil.
    Para seleccionar varios elementos de menú, mantenga la tecla &lt;Control&gt; pulsada durante la selección.</li>
</ul>
<h2>Editar un perfil</h2>
<p>Las características de un perfil de usuario se pueden cambiar seleccionándolo en la tabla de perfiles y 
    haciendo clic en el botón <q><?php echo LC_BTN_MODIFY;?></q> para abrir el formulario de edición.</p>
<h2>Suprimir un perfil</h2>
<p>Para suprimir un perfil, selecciónelo en la tabla y haga clic en el botón <q><?php echo LC_BTN_REMOVE;?></q>.
    El perfil se suprima después de confirmar su supresión.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Precaución</strong> : suprimir un perfil sólo está permitido si no se concede a un usuario.
        Retire primero el perfil a los usuarios que hacen referencia al el.</p>
    </div>
</div>