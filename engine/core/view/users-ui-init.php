<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Authorizations view | UI View initialization
        
File version: 1.1
Last update: 03/03/2021
-->
<script>
    $(document).ready(function () {
        /******* Load specific CSS file ********/
        znetdk.useStyleSheet('<?php echo ZNETDK_ROOT_URI . \General::getFilledMessage(CFG_ZNETDK_CSS, "authoriz_users") . '?v=' . ZNETDK_VERSION; ?>');
    });
</script>