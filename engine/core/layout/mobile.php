<!DOCTYPE HTML>
<!--
 ZnetDK, Starter Web Application for rapid & easy development
 See official website https://mobile.znetdk.fr
 Copyright (C) 2019 Pascal MARTINEZ (contact@znetdk.fr)
 License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 =============================================================================
 ZnetDK 'mobile' page layout
 File version: 1.12
 Last update: 12/15/2024
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
 */ 
$color = CFG_MOBILE_W3CSS_THEME_COLOR_SCHEME;
?>
<html lang="<?php echo $language; ?>">
    <head>
<?php self::renderMetaTags($metaDescription, $metaKeywords, $metaAuthor); ?>
        <title><?php echo $pageTitle; ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
<?php $faviconDir = ZNETDK_ROOT_URI . CFG_MOBILE_FAVICON_DIR . '/';
require ZNETDK_ROOT . CFG_MOBILE_FAVICON_CODE_FILENAME; ?>
        <style>.js #zdk-fouc,.js #zdk-custom-menu{display: none;}</style>
        <script>document.documentElement.className='js';</script>
<?php self::renderDependencies('css'); ?>
        <!-- CSS Font family -->
        <style>
        .znetdk-mobile-font {
            font-family: <?php echo CFG_MOBILE_CSS_FONT_FAMILY; ?>;
        }
        </style>
    </head>
    <body id="zdk-fouc" class="znetdk-mobile-font <?php echo $color['content']; ?>"
          data-ui-token="<?php echo \UserSession::setUIToken(); ?>"
          data-appver="<?php echo CFG_APPLICATION_VERSION; ?>"
          data-ajaxurl="<?php echo \General::getMainScript(TRUE); ?>"
          data-ajaxloader='<?php echo CFG_MOBILE_AJAX_LOADER_HTML_ELEMENT; ?>'
          data-networkerrormsg="<?php echo LC_MSG_ERR_NETWORK; ?>"
          data-service-worker-url="<?php echo CFG_MOBILE_SERVICE_WORKER_URL; ?>">
        <!-- Header title only for SEO purpose -->
        <!--<h1><?php echo LC_HEAD_TITLE; ?></h1>-->
        <!-- Main vertical menu -->
        <nav id="zdk-side-nav-menu" data-select="<?php echo $color['nav_menu_select']; ?>" data-hover="<?php echo $color['nav_menu_hover']; ?>" data-border-select="<?php echo $color['nav_menu_bar_select']; ?>" class="w3-sidebar w3-bar-block w3-collapse <?php echo $color['vertical_nav_menu']; ?> w3-card-2<?php echo CFG_VIEW_PAGE_RELOAD ? '' : ' w3-animate-left'; ?>">
            <!-- Close button -->
            <button class="close w3-right w3-button w3-hide-large <?php echo $color['nav_menu_close']; ?> <?php echo $color['btn_hover']; ?>" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times w3-xlarge" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></button>
            <div class="w3-clear"></div>
            <!-- Company logo -->
            <div class="w3-margin-bottom w3-center">
                <a id="zdk-company-logo" href="<?php self::renderLogoURL(); ?>" title="<?php echo LC_HEAD_IMG_LOGO_LINK_TITLE; ?>">
                    <img class="logo w3-hover-opacity w3-padding-16" src="<?php echo LC_HEAD_IMG_LOGO; ?>" alt="<?php echo strip_tags(LC_HEAD_TITLE); ?>">
                </a>
            </div>
            <?php self::renderNavigationMenu($controller); ?>
        </nav>
        <!-- Left pane -->
        <main class="w3-main">
            <!-- Header -->
            <header id="zdk-header" class="w3-top">
                <div class="banner w3-row <?php echo $color['banner']; ?>">
                    <div class="w3-col s10 m9 l5">
                        <!-- Main Vertical menu button -->
                        <a id="zdk-side-nav-button" class="w3-left w3-hide-large w3-hover-opacity w3-padding-small" href="#" aria-label="<?php echo LC_BTN_SHOW_MENU; ?>">
                            <i class="fa fa-navicon w3-xxlarge" aria-hidden="true" title="<?php echo LC_BTN_SHOW_MENU; ?>"></i>
                        </a>
                        <!-- Application Title -->
                        <span class="banner-title-small w3-large w3-hide-large"><?php echo LC_HEAD_TITLE; ?></span>
                        <span class="banner-title-large w3-left w3-padding w3-xlarge w3-hide-small w3-hide-medium"><?php echo LC_HEAD_TITLE; ?></span>
                    </div>
                    <!-- Connected user buttons -->
                    <div class="w3-col s2 m3 l7 w3-hide" id="zdk-connection-area" data-zdk-login="<?php echo $loginName; ?>"
                             data-zdk-username="<?php echo $connectedUser; ?>" data-zdk-usermail="<?php echo $userEmail; ?>"
                             data-zdk-changepwd="<?php echo LC_FORM_LBL_PASSWORD; ?>">
                        <!-- Spacer displayed on large screen when left side menu is displayed (200px added on the left) -->
                        <div class="adjust-centering w3-right w3-hide-small w3-hide-medium"></div>
                        <!-- logout icon -->
                        <a id="zdk-logout" class="w3-hide-small w3-hide-medium w3-right w3-padding-small w3-hover-opacity" href="#">
                            <i class="fa fa-sign-out fa-lg w3-xlarge"></i>
                            <span class="w3-large"><?php echo LC_HEAD_LNK_LOGOUT; ?></span>
                        </a>
                        <!-- Profile icon -->
                        <a id="zdk-profile" class="w3-right w3-padding-small w3-hover-opacity" href="#" aria-label="<?php echo LC_BTN_SHOW_USERPANEL; ?>">
                            <i class="fa fa-user fa-lg w3-xlarge" aria-hidden="true" title="<?php echo LC_BTN_SHOW_USERPANEL; ?>"></i>
                            <span class="w3-hide-small w3-hide-medium w3-large"><?php echo $loginName; ?></span>
                        </a>
                    </div>
                </div>
                <!-- Secondary Horizontal menu (dynamic) -->
                <nav id="zdk-tab-menu" class="<?php echo $color['horizontal_nav_menu']; ?>">
                    <!-- Spacer displayed on large screen when left side menu is displayed (200px added on the left) -->
                    <div class="adjust-centering w3-right w3-hide-small w3-hide-medium"></div>
                    <template>
                        <a href="#" class="menu-item w3-button w3-bottombar <?php echo $color['nav_menu_bar_select']; ?> <?php echo $color['nav_menu_hover']; ?> w3-padding">
                            <i class="fa fa-lg"></i>
                            <span class="w3-medium"></span>
                        </a>
                    </template>
                    <div class="items"></div>
                </nav>
                <!-- Installation message -->
                <div class="w3-cell-row w3-container">
                    <div id="zdk-install-message" class="w3-cell w3-hide" data-autodisplay="<?php echo CFG_MOBILE_INSTALL_MESSAGE_DISPLAY_AUTO ? 'yes' : 'no'; ?>">
                        <div class="w3-panel w3-content w3-round-xlarge w3-border <?php echo $color['install_border']; ?> <?php echo $color['install']; ?>">
                            <h3 class="<?php echo $color['install_txt']; ?>"><i class="fa fa-hdd-o"></i>&nbsp;<?php echo LC_MSG_ASK_INSTALL; ?></h3>
                            <button class="yes w3-button <?php echo $color['btn_yes']; ?> w3-margin-bottom w3-round-xlarge" type="button"><i class="fa fa-check"></i>&nbsp;<?php echo LC_BTN_YES; ?></button>
                            <button class="no w3-button <?php echo $color['btn_no']; ?> w3-margin-bottom w3-round-xlarge" type="button"><i class="fa fa-times"></i>&nbsp;<?php echo LC_BTN_NO; ?></button>
                        </div>
                    </div>
                    <!-- Spacer displayed on large screen when left side menu is displayed (200px added on the left) -->
                    <div class="adjust-centering w3-cell w3-hide-small w3-hide-medium"></div>
                </div>
                <!-- Message area -->
                <div class="w3-cell-row w3-container">
                    <div id="zdk-messages" class="w3-cell"></div>
                    <!-- Spacer displayed on large screen when left side menu is displayed (200px added on the left) -->
                    <div class="adjust-centering w3-cell w3-hide-small w3-hide-medium"></div>
                </div>
            </header>
            <!-- Content -->
            <div class="w3-margin-right w3-margin-left w3-hide">
                <?php self::renderCustomContent($controller); ?>
            </div>
            <!-- Footer -->
            <footer id="zdk-footer" class="w3-container w3-padding-16 <?php echo $color['footer']; ?> w3-center w3-border-top <?php echo $color['footer_border_top']; ?> w3-hidden">
                <?php $footer = LC_FOOTER_LEFT
                            . (is_string(LC_FOOTER_CENTER) && strlen(LC_FOOTER_CENTER) ? ' | ' : '')
                            . LC_FOOTER_CENTER . (is_string(LC_FOOTER_RIGHT) && strlen(LC_FOOTER_RIGHT) ? ' | ' : '')
                            . LC_FOOTER_RIGHT; ?>
                <div class="w3-hide-large"><?php echo $footer; ?></div>
                <div class="adjust-centering w3-hide-small w3-hide-medium"><?php echo $footer; ?></div>
            </footer>
        </main>
<?php if (CFG_AUTHENT_REQUIRED === TRUE) : ?>
        <!-- Login form -->
        <div id="zdk-login-modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4">
                <header class="w3-container <?php echo $color['modal_header']; ?>">
                    <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
                    <h4>
                        <i class="fa fa-unlock-alt fa-lg"></i>
                        <span class="title"><?php echo LC_FORM_TITLE_LOGIN; ?></span>
                    </h4>
                </header>
                <form class="w3-container <?php echo $color['modal_content']; ?>" data-zdk-submit="Security:login">
                    <input type="hidden" name="access" value="<?php echo CFG_SESSION_DEFAULT_MODE; ?>">
                    <div class="w3-section">
                        <label>
                            <b><?php echo LC_FORM_LBL_LOGIN_ID; ?></b>
                            <input id="zdk-login-id" class="w3-input w3-border w3-margin-bottom" type="text" name="login_name" autocomplete="username" required>
                        </label>
                        <label class="zdk-password w3-show-block">
                            <b><?php echo LC_FORM_LBL_PASSWORD; ?></b>
                            <input class="w3-input w3-border w3-margin-bottom" type="password" name="password" autocomplete="current-password" required>
                            <a class="zdk-toggle-password" href="#" aria-label="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"><i class="fa fa-eye-slash fa-lg" aria-hidden="true" title="<?php echo LC_FORM_LBL_TOGGLE_PASSWORD; ?>"></i></a>
                        </label>
<?php if (CFG_SESSION_SELECT_MODE === TRUE) : ?>
                        <input id="zdk-login-modal-remember-me" class="w3-check" type="checkbox">
                        <label for="zdk-login-modal-remember-me"><?php echo LC_FORM_LBL_REMEMBER_ME; ?></label>
<?php endif;
if (CFG_FORGOT_PASSWORD_ENABLED === TRUE && !UserSession::isAuthenticated(TRUE)) : ?>
                        <a class="zdk-forgot-pwd w3-right w3-margin-top w3-margin-bottom w3-hide" href="#"><?php echo LC_FORM_LBL_FORGOT_PASSWORD; ?></a>
<?php endif; ?>
                        <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                            <i class="fa fa-check fa-lg"></i>&nbsp;
                            <?php echo LC_BTN_LOGIN; ?>
                        </button>
                    </div>
                </form>
                <div class="w3-container w3-padding-16 w3-border-top <?php echo $color['modal_footer_border_top']; ?> <?php echo $color['modal_footer']; ?>">
                    <button type="button" class="cancel w3-button <?php echo $color['btn_cancel']; ?>">
                        <i class="fa fa-close fa-lg"></i>&nbsp;
                        <?php echo LC_BTN_CANCEL; ?>
                    </button>
                </div>
            </div>
        </div>
        <!-- logged in user panel -->
        <div id="zdk-userpanel-modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4 <?php echo $color['modal_content']; ?>">
                <header class="w3-container <?php echo $color['modal_header']; ?>">
                    <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
                    <h4>
                        <i class="fa fa-user fa-lg"></i>
                        <span class="title"><?php echo LC_FORM_TITLE_MY_ACCOUNT; ?></span>
                    </h4>
                </header>
                <div class="w3-container w3-center">
                    <h3 class="username">&nbsp;</h3>
                    <p class="usermail"></p>
                    <button type="button" class="changepwd w3-button <?php echo $color['btn_action']; ?> <?php echo $color['btn_hover']; ?> w3-block w3-section w3-padding"><i class="fa fa-unlock-alt fa-lg"></i>&nbsp;<?php echo LC_FORM_LBL_PASSWORD; ?></button>
                    <button type="button" class="myuserrights w3-button <?php echo $color['btn_action']; ?> <?php echo $color['btn_hover']; ?> w3-block w3-section w3-padding"><i class="fa fa-key fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_MY_USER_RIGHTS; ?></button>
                    <button type="button" class="install w3-button <?php echo $color['btn_action']; ?> <?php echo $color['btn_hover']; ?> w3-block w3-section w3-padding w3-hide"><i class="fa fa-hdd-o fa-lg"></i>&nbsp;<?php echo LC_HEAD_USERPANEL_INSTALL; ?></button>
                    <button type="button" class="uninstall w3-button <?php echo $color['btn_action']; ?> <?php echo $color['btn_hover']; ?> w3-block w3-section w3-padding w3-hide">
                        <span class="fa-stack">
                            <i class="fa fa-hdd-o fa-stack-1x"></i>
                            <i class="fa fa-ban fa-stack-2x w3-text-red"></i>
                        </span>&nbsp;<?php echo LC_HEAD_USERPANEL_UNINSTALL; ?>
                    </button>
                    <button type="button" class="logout w3-button <?php echo $color['btn_logout']; ?> <?php echo $color['btn_hover']; ?> w3-block w3-section w3-padding w3-hide-large"><i class="fa fa-sign-out fa-lg"></i>&nbsp;<?php echo LC_HEAD_LNK_LOGOUT; ?></button>
                </div>
            </div>
        </div>
<?php endif; ?>
        <!-- Search in list modal dialog -->
        <div id="zdk-searchinlist-modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4 <?php echo $color['modal_content']; ?>">
                <header class="w3-container <?php echo $color['modal_header']; ?>">
                    <a class="close w3-button w3-xlarge <?php echo $color['btn_hover']; ?> w3-display-topright" href="javascript:void(0)" aria-label="<?php echo LC_BTN_CLOSE; ?>"><i class="fa fa-times-circle fa-lg" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i></a>
                    <h4>
                        <i class="fa fa-search fa-lg"></i>
                        <span class="title"><?php echo LC_FORM_TITLE_SEARCH; ?></span>
                    </h4>
                </header>
                <form class="w3-container w3-section">
                    <label>
                        <b><?php echo LC_FORM_SEARCH_KEYWORD_LABEL; ?></b>
                        <span class="caption"></span>
                        <input class="w3-input w3-border" type="search" name="keyword"
                           placeholder="<?php echo LC_FORM_SEARCH_KEYWORD_PLACEHOLDER; ?>">
                    </label>
                    <div class="sort-criterium w3-margin-top w3-hide">
                        <label>
                            <b><?php echo LC_FORM_SEARCH_SORT_FIELD_LABEL; ?></b>
                            <select class="w3-select w3-border w3-margin-bottom" name="sortfield"></select>
                        </label>
                        <span><b><?php echo LC_FORM_SEARCH_SORT_ORDER_LABEL; ?></b></span><br>
                        <input id="zdk-searchinlist-modal-sort-order-asc" class="w3-radio" type="radio" name="sortorder" value="1" checked>
                        <label for="zdk-searchinlist-modal-sort-order-asc"><?php echo LC_FORM_SEARCH_SORT_ORDER_ASCENDING_LABEL; ?></label><br>
                        <input id="zdk-searchinlist-modal-sort-order-desc" class="w3-radio" type="radio" name="sortorder" value="-1">
                        <label for="zdk-searchinlist-modal-sort-order-desc"><?php echo LC_FORM_SEARCH_SORT_ORDER_DESCENDING_LABEL; ?></label>
                    </div>
                    <button class="w3-button w3-block <?php echo $color['btn_submit']; ?> w3-section w3-padding" type="submit">
                        <i class="fa fa-check fa-lg"></i>&nbsp;
                        <?php echo LC_ACTION_SEARCH_KEYWORD_BTN_RUN; ?>
                    </button>
                </form>
            </div>
            <div class="search-filter-container w3-bar w3-hide"></div>
            <div class="search-tag search-filter w3-left w3-section w3-hide">
                <div class="<?php echo $color['search_criterium']; ?> w3-margin-right">
                    <i class="fa fa-tag fa-lg w3-margin-left"></i>
                    <span class="filter-value"></span>
                    <span class="remove w3-button w3-hover-opacity"><i class="fa fa-times-circle fa-lg"></i></span>
                </div>
            </div>
            <div class="search-tag filter-sort-criterium asc w3-left w3-section w3-hide">
                <div class="<?php echo $color['search_sort']; ?> w3-margin-right">
                    <i class="fa fa-sort-alpha-asc fa-lg w3-margin-left"></i>
                    <span class="label"></span>
                    <span class="remove w3-button w3-hover-opacity"><i class="fa fa-times-circle fa-lg"></i></span>
                </div>
            </div>
            <div class="search-tag filter-sort-criterium desc w3-left w3-section w3-hide">
                <div class="<?php echo $color['search_sort']; ?> w3-margin-right">
                    <i class="fa fa-sort-alpha-desc fa-lg w3-margin-left"></i>
                    <span class="label"></span>
                    <span class="remove w3-button w3-hover-opacity"><i class="fa fa-times-circle fa-lg"></i></span>
                </div>
            </div>
        </div>
        <!-- Fixed Action buttons -->
        <a id="zdk-mobile-action-scrollup" class="zdk-mobile-action w3-hide w3-btn w3-circle w3-ripple w3-xlarge <?php echo $color['btn_scrollup']; ?> w3-card-4" href="javascript:void(0)" aria-label="<?php echo LC_BTN_SCROLL_TO_TOP; ?>"><i class="fa fa-arrow-up" aria-hidden="true" title="<?php echo LC_BTN_SCROLL_TO_TOP; ?>"></i></a>
        <a id="zdk-mobile-action-add" class="zdk-mobile-action w3-hide w3-btn w3-circle w3-ripple w3-xlarge <?php echo $color['btn_action']; ?> w3-card-4" href="javascript:void(0)" aria-label="<?php echo LC_BTN_NEW; ?>"><i class="fa fa-plus" aria-hidden="true" title="<?php echo LC_BTN_NEW; ?>"></i></a>
        <a id="zdk-mobile-action-refresh" class="zdk-mobile-action w3-hide w3-btn w3-circle w3-ripple w3-xlarge <?php echo $color['btn_refresh']; ?> w3-card-4" href="javascript:void(0)" aria-label="<?php echo LC_BTN_REFRESH; ?>"><i class="fa fa-refresh" aria-hidden="true" title="<?php echo LC_BTN_REFRESH; ?>"></i></a>
        <a id="zdk-mobile-action-search" class="zdk-mobile-action w3-hide w3-btn w3-circle w3-ripple w3-xlarge <?php echo $color['btn_search']; ?> w3-card-4" href="javascript:void(0)" aria-label="<?php echo LC_BTN_SEARCH; ?>"><i class="fa fa-search" aria-hidden="true" title="<?php echo LC_BTN_SEARCH; ?>"></i></a>
        <!-- Notification dialog -->
        <div id="zdk-notification-modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4 <?php echo $color['modal_content']; ?>">
                <header class="w3-container <?php echo $color['modal_header']; ?>">
                    <h4>
                        <i class="fa fa-info-circle fa-lg"></i>
                        <span class="title">&nbsp;</span>
                    </h4>
                </header>
                <div class="w3-container">
                    <p class="message"></p>
                    <button class="w3-container w3-button w3-block <?php echo $color['btn_action']; ?> <?php echo $color['btn_hover']; ?> w3-section w3-padding" type="button"><?php echo LC_BTN_OK; ?></button>
                </div>
            </div>
        </div>
        <!-- Confirmation dialog -->
        <div id="zdk-confirmation-modal" class="w3-modal">
            <div class="w3-modal-content w3-card-4 <?php echo $color['modal_content']; ?>">
                <header class="w3-container <?php echo $color['modal_header']; ?>">
                    <h4>
                        <i class="fa fa-question-circle fa-lg"></i>
                        <span class="title">&nbsp;</span>
                    </h4>
                </header>
                <div class="w3-container">
                    <p class="message" data-default-msg="<?php echo LC_MSG_ASK_CANCEL_CHANGES; ?>"></p>
                    <div class="w3-section">
                        <button class="yes w3-button <?php echo $color['btn_yes']; ?>" type="button"><i class="fa fa-check fa-lg"></i>&nbsp;<span class="label" data-default-label="<?php echo LC_BTN_YES; ?>"></span></button>
                        <button class="no w3-button <?php echo $color['btn_no']; ?> w3-right" type="button"><i class="fa fa-times fa-lg"></i>&nbsp;<span class="label" data-default-label="<?php echo LC_BTN_NO; ?>"></span></button>
                    </div>
                </div>
            </div>
        </div>
        <template id="zdk-message-tpl" data-info="<?php echo $color['msg_info']; ?>"
                  data-warn="<?php echo $color['msg_warn']; ?>" 
                  data-error="<?php echo $color['msg_error']; ?>"
                  data-critical="<?php echo $color['msg_critical']; ?>"
                  data-snackbar="<?php echo $color['msg_success']; ?>">
            <div class="w3-panel w3-card w3-animate-top w3-display-container">
                <a class="close w3-button w3-large w3-display-topright" href="#" aria-label="<?php echo LC_BTN_CLOSE; ?>">
                    <i class="fa fa-times" aria-hidden="true" title="<?php echo LC_BTN_CLOSE; ?>"></i>
                </a>
                <h3><i class="icon fa"></i>&nbsp;<span class="summary"></span></h3>
                <p class="detail"></p>
            </div>
        </template>
        <template id="zdk-snackbar-tpl">
            <div class="z4m-snackbar w3-panel w3-card w3-animate-bottom">
                <p class="w3-center"><i class="icon fa"></i>&nbsp;<span class="msg"></span></p>
            </div>
        </template>
        <template id="zdk-action-tpl">
            <a class="zdk-mobile-action w3-hide w3-btn w3-circle w3-ripple w3-xlarge w3-card-4" href="javascript:void(0)">
                <i class="icon fa" aria-hidden="true"></i>
            </a>
        </template>
        <template id="zdk-show-next-rows-tpl">
            <div class="show-next-rows w3-bar w3-center">
                <a class="w3-button <?php echo $color['btn_action']; ?> <?php echo $color['btn_hover']; ?>" href="#"><?php echo LC_LNK_SHOW_NEXT_RESULTS; ?></a>
            </div>
        </template>
        <template id="zdk-autocomplete-tpl">
            <ul class="autocomplete w3-ul w3-card w3-hoverable w3-hide"></ul>
        </template>
        <template id="zdk-autocomplete-item-tpl" data-select="<?php echo $color['autocomplete_select']; ?>">
            <li class="<?php echo $color['autocomplete_hover']; ?>"></li>
        </template>
<?php self::renderDependencies('js');
self::renderExtraHtmlCode(); ?>
        <script>document.getElementById('zdk-fouc').style.display='block';</script>
    </body>
</html>