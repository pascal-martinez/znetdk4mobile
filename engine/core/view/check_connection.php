<!--
ZnetDK, Starter Web Application for rapid & easy development
See official website http://www.znetdk.fr 
Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
--------------------------------------------------------------------
View script for checking whether the database connection is OK and if
the ZnetDK security tables are properly installed.
File version: 1.1
Last update: 10/26/2015
-->
<script type="text/javascript">
    znetdk.useStyleSheet('<?php echo ZNETDK_ROOT_URI . \General::getFilledMessage(CFG_ZNETDK_CSS,"check_connection"); ?>');
</script>
<h3><?php echo LC_HOME_WELCOME;?></h3>
<form id="zdk-check-database" class="zdk-form">
    <fieldset>
        <legend><?php echo LC_HOME_LEGEND_DBSTATUS;?></legend>
        <ul>
            <li>
                <span class="title ui-state-active"><?php echo LC_HOME_TXT_DB_SETTINGS1;?></span>
                <span>
                    <?php echo LC_HOME_TXT_DB_SETTINGS2;?>
                </span>
            </li>
            <li class="connect">
                <span class="title ui-state-active"><?php echo LC_HOME_TXT_DB_CONNECT1;?></span>
                <span class="status">
                    <?php echo LC_HOME_TXT_DB_CONNECT2_OK;?>
                </span>
                <ul class="error ui-helper-hidden">
                    <li>
                        <span class="label"><?php echo LC_HOME_DATABASE_ERROR;?></span>
                        <span class="message"></span>
                    </li>
                </ul>
            </li>
            <li class="tables">
                <span class="title ui-state-active"><?php echo LC_HOME_TXT_DB_TABLES1;?></span>
                <span class="status">
                    <?php echo LC_HOME_TXT_DB_TABLES2_OK;?>
                </span>
                <ul class="error ui-helper-hidden">
                    <li>
                        <span class="label"><?php echo LC_HOME_DATABASE_ERROR;?></span>
                        <span class="message"></span>
                    </li>
                </ul>
            </li>
        </ul>
    </fieldset>
    <fieldset>
        <legend><?php echo LC_HOME_LEGEND_START;?></legend>
        <ul>
            <li><span class="title ui-state-active"><?php echo LC_HOME_TXT_START_MENU1;?></span>&nbsp;<span><?php echo LC_HOME_TXT_START_MENU2;?></span></li>
            <li><span class="title ui-state-active"><?php echo LC_HOME_TXT_START_CONCEPTS1;?></span>&nbsp;<span><?php echo LC_HOME_TXT_START_CONCEPTS2;?></span></li>
            <li><span class="title ui-state-active"><?php echo LC_HOME_TXT_START_API1;?></span>&nbsp;<span><?php echo LC_HOME_TXT_START_API2;?></span></li>
        </ul>
    </fieldset>
<?php
try { // Check database connection...
    \Database::getCoreDbConnection();
    \Database::getApplDbConnection();
    // Check if ZnetDK tables are properly installed...
    $error;
    if (!\Database::areCoreTablesProperlyInstalled($error)) {
        ?><span class="tables_failed ui-helper-hidden"><?php echo $error;?></span><?php
    }
} catch (PDOException $e) {
     ?><span class="connect_failed ui-helper-hidden"><?php echo $e->getMessage();?></span><?php
} catch (Exception $e) {
    ?><span class="connect_failed ui-helper-hidden"><?php echo $e->getMessage();?></span><?php
} ?>
</form>