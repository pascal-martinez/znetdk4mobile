<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Core authorizations view | UI Components initialization
        
File version: 1.1
Last update: 03/03/2021
-->
<script>
    $(document).ready(function () {
        /******* Load specific CSS file ********/
        znetdk.useStyleSheet('<?php echo ZNETDK_ROOT_URI . \General::getFilledMessage(CFG_ZNETDK_CSS, "authoriz_profiles") . '?v=' . ZNETDK_VERSION; ?>');

        /********* Tree widget initialization *********/
        $('#znetdk_profile_tree').zdktree({
            animate: true,
            selectionMode: 'multiple',
            controller: 'profiles',
            action: 'menuitems',
            autoSelectFamily: true
        });
    });
</script>