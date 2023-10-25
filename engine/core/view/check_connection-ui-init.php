<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
UI initialization of the view check_connecion.
File version: 1.1
Last update: 10/26/2015
-->
<script>
    $(document).ready(function () {
        /**
         * Show the error message when connection to the database has failed
         */
        var connectErrorElement = $('#zdk-check-database > .connect_failed');
        if (connectErrorElement.length) {
            $('#zdk-check-database .connect .status').html('<?php echo LC_HOME_TXT_DB_CONNECT2_KO;?>');
            $('#zdk-check-database .connect .error .message').html(connectErrorElement.html());
            $('#zdk-check-database .connect .error').show();
        }
        /**
         * Show the error message when ZnetDK tables are not properly installed
         */
        var tablesErrorElement = connectErrorElement.length ? 
            connectErrorElement : $('#zdk-check-database > .tables_failed');
        if (tablesErrorElement.length) {
            $('#zdk-check-database .tables .status').html('<?php echo LC_HOME_TXT_DB_TABLES2_KO;?>');
            if (connectErrorElement.length === 0) {
                $('#zdk-check-database .tables .error .message').html(tablesErrorElement.html());
                $('#zdk-check-database .tables .error').show();
            }
        }
    });
</script>