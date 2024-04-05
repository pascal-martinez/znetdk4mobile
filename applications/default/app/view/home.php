<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * ------------------------------------------------------------
 * Home view of the starter mobile application
 * YOU CAN FREELY CUSTOMIZE THE CONTENT OF THIS FILE
 */
?>

<div class="w3-container w3-center w3-theme-l3 w3-padding-64 w3-text-theme" style="margin:-1px  -16px 0px -16px;">
    <img class="w3-padding-16" src="<?php echo ZNETDK_ROOT_URI . 'engine/public/images/logoznetdk.png'; ?>" alt="banner logo">
    <h1 class="w3-margin w3-jumbo">ZnetDK 4 Mobile</h1>
    <h3 class="w3-xlarge">Starter Web Application...</h3>
</div>

<div class="w3-row-padding w3-padding-32 w3-container">
    <div class="w3-content">
        <div class="w3-third w3-center">
            <i class="fa fa-mobile w3-text-theme" style="font-size: 300px;"></i>
        </div>
        <div class="w3-twothird">
            <h2>Congratulations!</h2>
            <h5 class="w3-padding-32">Your Starter Application is properly installed and ready to customize and enhance.</h5>
            <p class="w3-text-grey">To get access to the online documentation, go to the <a class="w3-text-theme w3-hover-opacity" href="https://mobile.znetdk.fr/getting-started" target="_blank">mobile.znetdk.fr/getting-started</a> website page.</p>
        </div>
    </div>
</div>
<div class="w3-row-padding w3-padding-32 w3-container">
    <div class="w3-content">
        <div class="w3-third w3-center">
            <i class="fa fa-database w3-text-theme w3-padding-32" style="font-size: 180px;"></i>
        </div>
        <div class="w3-twothird">
            <h2 id="z4m-sa-home-db-status">Database access status</h2>
            <div class="w3-section">
                <span class="title w3-tag w3-theme">Settings</span>
<?php           $connectionStringError = 'not configured properly';
                $connectionString = 'User: <strong>' . CFG_SQL_APPL_USR . '@' . CFG_SQL_HOST
                        . '</strong>, DB: <strong>' . CFG_SQL_APPL_DB . '</strong>';
                if (CFG_SQL_APPL_USR === NULL || CFG_SQL_HOST === NULL || CFG_SQL_APPL_DB === NULL) : ?>
                    <b class="w3-text-red"><?php echo $connectionStringError; ?></b>
<?php           else : ?>
                    <span class="w3-text-green"><?php echo $connectionString; ?></span>
<?php           endif; ?>
            </div>
            <div class="w3-section">
                <span class="title w3-tag w3-theme">Connection</span>
<?php       try { // Check database connection...
                $connectionFailed = FALSE;
                \Database::getCoreDbConnection();
                \Database::getApplDbConnection(); ?>
                <span class="w3-text-green">tested successfully</span>
<?php       } catch (Exception $e) {
                $connectionFailed = TRUE; ?>
                <b class="w3-text-red">error detected...</b>
                <div class="w3-panel w3-card w3-animate-top w3-display-container w3-red">
                    <h3><i class="fa fa-times-circle"></i>&nbsp;Failed to connect!</h3>
                    <p><?php echo $e->getMessage(); ?></p>
                </div>
<?php       } ?>          
            </div>
            <div class="w3-section">
                <span class="title w3-tag w3-theme">Security SQL tables</span>
<?php       $securityTableError = 'Connection to database failed.';
            if ($connectionFailed 
                || !\Database::areCoreTablesProperlyInstalled($securityTableError)) : ?>
                <b class="w3-text-red">error detected!</b>
                <div class="w3-panel w3-card w3-animate-top w3-display-container w3-red">
                    <h3><i class="fa fa-times-circle"></i>&nbsp;Error details...</h3>
                    <p><?php echo $securityTableError; ?></p>
                </div>
<?php       else : ?>
                <span class="w3-text-green">properly installed</span>
<?php       endif; ?>
            </div>
            <button class="w3-btn w3-theme-action" onclick="znetdkMobile.content.reloadView('home', 'z4m-sa-home-db-status')">
                <i class="fa fa-refresh fa-lg"></i><span>&nbsp;Reload to check again</span>
            </button>
        </div>
    </div>
</div>
