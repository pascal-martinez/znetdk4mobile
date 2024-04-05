<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
Core authorizations view | UI Components events

File version: 1.4
Last update: 01/30/2024
-->
<script>
    $(document).ready(function () {

        /********* When clicking the new or edit button **********/
        $('#znetdk_user_actions').zdkactionbar({
            whenadd: function() {
                // Refresh profiles in the listbox
                refreshProfiles(false);
                // Default expiration date value
                $("#znetdk_user_dialog form input[name=expiration_date]").zdkinputdate('setW3CDate', '<?php echo \General::getCurrentW3CDate(); ?>');
                // Default user status is enabled (value = "1")
                $("#znetdk_user_dialog form input[name=user_enabled]").puiradiobutton('select', "1");
            },
            whenedit: function() {
                // Refresh profiles in the listbox keeping current selection
                refreshProfiles(true);
            }
        });
        function refreshProfiles(preserveSelection) {
            const lbElement = $('#znetdk_user_dialog select[name="profiles[]"]');
            if (!lbElement.hasClass('zdk-listbox')) {                
                // First time, Listbox widget not yet instantiated
                lbElement.addClass('zdk-listbox');
                if (preserveSelection === true) {
                    // user's profiles are selected once the profile list is loaded
                    const selectedProfiles = getSelectedProfiles();
                    if (selectedProfiles !== false) {
                        lbElement.one('zdklistboxdataloaded.znetdk_user_dialog', function(){
                            lbElement.zdklistbox('selectItemsByValues', selectedProfiles);
                        });
                    } else {
                        // Failed to get user's profiles, modal is closed...
                        $('#znetdk_user_dialog').one('zdkmodalaftershow.znetdk_user_dialog', function(){
                            $(this).zdkmodal('hide');
                        });
                        console.error("View 'users-ui-events': failed to get user's profiles, modal is closed...");
                    }
                }
                // Loading the profile list for the first time...
                lbElement.zdklistbox({
                    controller: 'users', 
                    action: 'profiles',
                    content: function(option) {
                        return '<span title="' + option.description + '">' + option.label + '</span>';
                    }
                });
            } else { // Listbox widget already instantiated and loaded
                // Listbox items refreshed preserving selection
                lbElement.zdklistbox('refresh', preserveSelection);
            }
        }
        function getSelectedProfiles() {
            var selections = $('#znetdk_users_datatable').zdkdatatable('getSelection');
            if (selections.length === 1 && selections[0]) {
                return selections[0]['profiles[]'];
            } else {
                return false;
            }
        }
        
        /******** 'click' events of the login name ********/
        $('#znetdk_users_datatable').on('click.znetdk_users_datatable', 'td.zdk-col-login_name', function () {
            $('#znetdk_users_datatable').one('zdkdatatablerowselect.znetdk_users_datatable', function () {
                // The form is displayed
                $(this).prevAll('.zdk-action-bar').find('button.zdk-bt-edit').click();
            });
        });
        /******* 'search' events of the search field ******/
        $('#znetdk_user_actions').on('zdkactionbarsearch.znetdk_user_actions', function (event) {
            filterFromUI();
            event.preventDefault();
        });
        /******* 'change' events of the status filter ******/
        $('#znetdk_user_actions .zdk-status-filter :radio').on('puiradiobuttonselectionchange.znetdk_user_actions', function () {
            filterFromUI();
        });
        
        /****** Filter the user list according to filter criteria *****/
        function filterFromUI() {
            var filters = {};
            filters.keyword = $('#znetdk_user_actions').find('.zdk-filter-rows input').val();
            filters.status = $('#znetdk_user_actions input[name=user_status_filter]:checked').val();                
            $('#znetdk_users_datatable').zdkdatatable('filterRows', JSON.stringify(filters));
        }
    });
</script>