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
<h1>Habilitaciones del usario</h1>
<p>Cualquier usuario de la aplicación debe ser autorizado primero si quiere usarlo..</p>
<h2>Nuevo usuario</h2>
<p>Para autorizar a un usuario, haga clic en el botón <q><?php echo LC_BTN_NEW;?></q> de la barra de acción.
    Una vez que el formulario de registro de usuario se abrió, rellenar la siguiente información:</p>
<ul>
    <li><?php echo LC_FORM_FLD_USER_IDENTITY;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_USER_NAME;?></strong>: nombre y apellido del usuario para autorizar.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_EMAIL;?></strong>: correo electrónico del usuario.</li>
        </ul>
    </li>
    <li><?php echo LC_FORM_FLD_USER_CONNECTION;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_LOGIN_ID;?></strong> : identificador pedido la conexión a la aplicación.</li>
            <li><strong><?php echo LC_FORM_LBL_PASSWORD;?></strong> : la contraseña necesaria para autenticar al usuario.</li>
            <li><strong><?php echo LC_FORM_LBL_PASSWORD_CONFIRM;?></strong> : confirmación de la contraseña.
                Esta contraseña debe ser idéntica a la prevista para el campo <q><?php echo LC_FORM_LBL_PASSWORD;?></q>.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE;?></strong> : fecha de caducidad de la contraseña.
                Por defecto, esta fecha se ha inicializado a la fecha actual con el fin de obligar al usuario a renovar su contraseña.</li>
        </ul>
    </li>
    <li><?php echo LC_FORM_FLD_USER_RIGHTS;?>
        <ul>
            <li><strong><?php echo LC_FORM_LBL_USER_STATUS;?></strong> : por defecto, el usuario es <q><?php echo LC_FORM_LBL_USER_STATUS_ENABLED;?></q>
                lo que significa que él está autorizado para conectarse a la aplicación.
                Para negarle el acceso a la aplicación, su estado tiene que ser ajustado a <q><?php echo LC_FORM_LBL_USER_STATUS_DISABLED;?></q>.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_MENU_ACCESS;?></strong> : cuando la opción <q><?php echo LC_FORM_LBL_USER_MENU_ACCESS_FULL;?></q>
                está activada, el usuario tiene un acceso completo al menú de navegación de la aplicación.</li>
            <li><strong><?php echo LC_FORM_LBL_USER_PROFILES;?></strong> : perfiles concedidos al usuario. Para concederle más de un perfil,
                mantenga presionada la tecla &lt;Control&gt; presionada mientras selecciona los otros perfiles.</li>
        </ul>
    </li>
</ul>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Atención</strong> a la contraseña tecleada por el usuario debe contener un mínimo de 8 cifras y letras.</p>
    </div>
</div>
<h2>Actualización de la información de usuario</h2>
<p>La información del usuario se puede modificar mediante la selección de la fila correspondiente en la tabla a continuación,
    haciendo clic en el botón <q><?php echo LC_BTN_MODIFY;?></q>. Aparece entonces la forma edición.</p>
<h3>Restablecimiento de la contraseña del usuario</h3>
<p>Si el usuario olvidó su contraseña, puede restablecer a través del formulario de edición mediante la cumplimentación
    de los campos <q><?php echo LC_FORM_LBL_PASSWORD;?></q> y <q><?php echo LC_FORM_LBL_PASSWORD_CONFIRM;?></q>.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
            <strong>Atención</strong> a imponer un usuario cambiar su contraseña, la fecha <q><?php echo LC_FORM_LBL_USER_EXPIRATION_DATE;?></q>
            debe establecerse en una fecha inferior o igual a la fecha actual.</p>
    </div>
</div>
<h3>Desactivación de un usuario</h3>
<p>Para deshabilitar el acceso de un usuario de la aplicación, cambiar su condición a la <q><?php echo LC_FORM_LBL_USER_STATUS_DISABLED;?></q>
    valor en el formulario de edición.</p>
<h2>La revocación de un usuario</h2>
<p>Un usuario puede ser revocado definitivamente de la aplicación mediante la selección de la fila correspondiente en la tabla de usuario
    y haciendo clic en el botón <q><?php echo LC_BTN_REMOVE;?></q>. Una confirmación se solicita antes de su traslado.</p>
<div class='ui-widget'>
    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
        <p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
        <strong>Atención</strong> si un usuario tiene que ser revocado temporalmente, es mejor desactivarlo mientras que suprimirlo.</p>
    </div>
</div>