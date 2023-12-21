<!DOCTYPE HTML>
<!--
 ZnetDK, Starter Web Application for rapid & easy development
 See official website http://www.znetdk.fr
 Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
 License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 =============================================================================
 ZnetDK page layout "custom"
 File version: 1.6
 Last update: 10/17/2023
-->
<?php /**
 * Input variables >>
 * 	- $pageTitle       : title of the page
 * 	- $loginName       : login name
 * 	- $connectedUser   : user name of the connected user
 * 	- $userEmail       : user email of the connected user
 * 	- $language        : current language of the page
 * 	- $controller      : used by the method renderNavigationMenu() if CFG_VIEW_PAGE_RELOAD is enabled or HTTP
 *                           error occured
 * 	- $metaDescription : meta Tag "description" to render if CFG_VIEW_PAGE_RELOAD is enabled
 * 	- $metaKeywords    : meta Tag "keywords" to render if CFG_VIEW_PAGE_RELOAD is enabled
 * 	- $metaAuthor      : meta Tag "author" to render if CFG_VIEW_PAGE_RELOAD is enabled
*/?>
<html lang="<?php echo $language; ?>">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php self::renderMetaTags($metaDescription, $metaKeywords, $metaAuthor); ?>
        <title><?php echo $pageTitle; ?></title>
<?php if (CFG_NON_MOBILE_PWA_ENABLED) :
    $faviconDir = ZNETDK_ROOT_URI . CFG_MOBILE_FAVICON_DIR . '/';
    require ZNETDK_ROOT . CFG_MOBILE_FAVICON_CODE_FILENAME;
endif; ?>
        <style>.js #zdk-fouc{display: none;}</style>
        <script>document.documentElement.className='js';</script>
<?php self::renderDependencies('css'); ?>
    </head>
    <body id="zdk-fouc" data-ui-token="<?php echo \UserSession::setUIToken(); ?>" data-appver="<?php echo CFG_APPLICATION_VERSION; ?>"<?php echo CFG_NON_MOBILE_PWA_ENABLED ? ' data-service-worker-url="'.CFG_MOBILE_SERVICE_WORKER_URL.'"' : ''; ?>>
        <div id="zdk-messages"></div><div id="zdk-critical-err"></div>
        <span id="zdk-network-error-msg" class="ui-helper-hidden"><?php echo LC_MSG_ERR_NETWORK; ?></span>
        <img class="ui-helper-hidden" src="<?php echo ZNETDK_ROOT_URI; ?>resources/images/messages.png">
        <div id="zdk-header">
            <a id="zdk-header-logo" href="<?php self::renderLogoURL(); ?>" title="<?php echo LC_HEAD_IMG_LOGO_LINK_TITLE; ?>">
                <img src="<?php echo LC_HEAD_IMG_LOGO; ?>" alt="<?php echo strip_tags(LC_HEAD_TITLE); ?>">
            </a>
            <h1><?php echo LC_HEAD_TITLE; ?></h1>
            <h2><?php echo LC_HEAD_SUBTITLE; ?></h2>
            <div id="zdk-connection-area" data-zdk-login="<?php echo $loginName; ?>" data-zdk-username="<?php echo $connectedUser; ?>"
                 data-zdk-usermail="<?php echo $userEmail; ?>" data-zdk-changepwd="<?php echo LC_FORM_LBL_PASSWORD; ?>" data-zdk-myuserrights="<?php echo LC_HEAD_USERPANEL_MY_USER_RIGHTS; ?>"<?php echo !isset($connectedUser) ? ' class="ui-helper-hidden"' : ''; ?>>
                <a id="zdk-profile" href="#"><i class="icon fa fa-user-circle fa-lg"></i><?php echo $loginName; ?></a>
                <a id="zdk-logout" href="#"><i class="icon fa fa-power-off fa-lg"></i><?php echo LC_HEAD_LNK_LOGOUT; ?></a>
            </div>
<?php self::renderLangSelection(); ?>
            <div id="zdk-help-area" data-zdk-helptitle="<?php echo LC_FORM_TITLE_HELP; ?>" data-zdk-helpclosebutton="<?php echo LC_BTN_CLOSE; ?>"<?php echo CFG_HELP_ENABLED ? '' : ' class="ui-helper-hidden"'; ?>>
                <a href="#"><img src="<?php echo ZNETDK_ROOT_URI . CFG_ZNETDK_IMG_DIR; ?>/help.png" alt="help"/><?php echo LC_HEAD_LNK_HELP; ?></a>
            </div>
        </div>
        <?php self::renderNavigationMenu($controller); ?>
        <?php self::renderBreadcrumb(); ?>
        <?php self::renderCustomContent($controller); ?>
        <img id="zdk-ajax-loading-img" class="ui-helper-hidden" src="<?php echo ZNETDK_ROOT_URI . CFG_AJAX_LOADING_IMG; ?>" alt="ajax loader">
        <div class="ui-helper-clearfix"></div>
        <div id="zdk-footer">
            <div><?php echo LC_FOOTER_LEFT; ?></div>
            <div><?php echo LC_FOOTER_CENTER; ?></div>
            <div><?php echo LC_FOOTER_RIGHT; ?></div>
        </div>
<?php self::renderDependencies('js'); ?>
        <script>document.getElementById('zdk-fouc').style.display='block';</script>
    </body>
</html>