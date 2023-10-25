<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Core authorizations view | UI Components events

File version: 1.0
Last update: 09/18/2015
-->
<script>
    $(document).ready(function () {
        $('#znetdk_profile_actions').zdkactionbar({
            whenadd: function() {
                /* All tree nodes are expanded */
                $("#znetdk_profile_tree").zdktree('expandNode', $("#znetdk_profile_tree > ul li"));
            },
            whenedit: function() {
                /* Only selected tree nodes are expanded */
                $("#znetdk_profile_tree").zdktree('collapseNode', $("#znetdk_profile_tree > ul li"));
                $("#znetdk_profile_tree li span.ui-state-highlight").each(function() {
                   $("#znetdk_profile_tree").zdktree('expandNode', $(this).parent('span').parent('li')); 
                });
            },
            whenremove: function() {
                $(this).zdkactionbar('option','getRemoveConfirm', function(toCallback,
                        rowID,identifierName, dialogTitle) {
                    var $this = this, identifier = new Object();
                    identifier[identifierName] = rowID;
                    znetdk.request({
                        control:'profiles',
                        action:'removeconfirm',
                        data:identifier,
                        callback: function(response) {
                            znetdk.getUserConfirmation({
                                title: dialogTitle,
                                message: response.question,
                                yesLabel: response.yes_label,
                                noLabel: response.no_label,
                                callback: function (confirmation) {
                                    if (confirmation) {
                                        toCallback.call($this,rowID,identifierName);
                                    }
                                }
                            });
                        }
                    });
                });
            }
        });
    });
</script>