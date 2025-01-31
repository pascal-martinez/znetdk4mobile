/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2019 Pascal MARTINEZ (contact@znetdk.fr)
 * License GNU GPL http://www.gnu.org/licenses/gpl-3.0.html GNU GPL
 * --------------------------------------------------------------------
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * --------------------------------------------------------------------
 * ZnetDK Javascript library for mobile page layout
 *
 * File version: 1.13
 * Last update: 01/17/2025
 */

/* global FormData, BeforeInstallPromptEvent */

var znetdkMobile = {
    hideClass: 'w3-hide',
    ajax: {
        requestContext: [],
        loaderElementId: "zdk-ajax-loading",
        requestInProgress: 0,
        customAjaxUrl: null
    },
    authentication: {
        loginFormId: '#zdk-login-modal',
        urlLoginParamName: 'login',
        changePasswordFormId: '#zdk-changepwd-modal',
        changePasswordView: 'Z4MChangePwdCtrl',
        connectedUserPanelId: '#zdk-userpanel-modal',
        rememberMeLocalStorageKey: 'znetdkmobile_authentication_remember_me',
        loginNameStorageKey: 'znetdkmobile_authentication_login_name',
        loginWithEmailStorageKey: 'znetdkmobile_authentication_login_with_email',
        myUserRightsModalId: '#mzdk-my-user-rights',
        myUserRightsViewName: 'z4mmyuserrights',
        events: {}
    },
    browser: {
        confirmationOnApplicationClose: true,
        disablingDelay: 500,
        events: {}
    },
    header: {
        headerId: '#zdk-header',
        menuButtonId: '#zdk-side-nav-button',
        connectionAreaId: '#zdk-connection-area',
        autoHideOnScrollEnabled: false,
        events: {}
    },
    navigation: {
        companyLogoId: '#zdk-company-logo',
        menuDefinitionId: '#zdk-custom-menu',
        verticalMenuId: '#zdk-side-nav-menu',
        horizontalMenuId: '#zdk-tab-menu',
        verticalMenuItemClasses: 'w3-bar-item w3-button w3-leftbar',
        menuIconTemplate: '<i class="fa fa-lg fa-fw"></i>',
        autoReloadViewClass: 'zdk-viewreload',
        events: {
            beforeViewDisplayName: 'beforeviewdisplay',
            afterViewDisplayName: 'afterviewdisplay'
        }
    },
    content: {
        containerId: '#zdk-content',
        defaultContainerId: '#default_content',
        events: {
            displayViewName: 'displayview',
            topSpaceChangeName: 'topspacechange'
        }
    },
    footer: {
        footerId: '#zdk-footer'
    },
    messages: {
        element: null,
        containerId: '#zdk-messages',
        messageTemplateId: '#zdk-message-tpl',
        snackbarTemplateId: '#zdk-snackbar-tpl',
        colors: {},
        icons: {
            info: 'fa-info-circle',
            warn: 'fa-warning',
            error: 'fa-times-circle',
            critical: 'fa-ban'
        },
        autoCloseDuration: 6000,
        events: {}
    },
    log: {},
    serviceWorker: {
        isRegistered: false
    },
    install: {
        installMessageId: '#zdk-install-message',
        installViewName: 'z4minstall',
        installModalId: '#mzdk-userpanel-install',
        uninstallViewName: 'z4muninstall',
        uninstallModalId: '#mzdk-userpanel-uninstall',
        isInstalledStorageKey: 'znetdkmobile_install_ok',
        noInstallStorageKey: 'znetdkmobile_install_no',
        installPrompt: null,
        events: {}
    },
    modal: {
        element: null,
        cssClass: 'w3-modal',
        closeOnSubmitSuccess: true,
        events: {
            beforeOpenName: 'beforeshow',
            afterOpenName: 'aftershow',
            beforeUiModalCloseNane: 'beforeuimodalclose', // For internal usage
            beforeCloseName: 'beforehide',
            afterCloseName: 'afterhide'
        }
    },
    form: {
        element: null,
        inputData: null,
        inputInErrorClass: 'z4m-form-invalid',
        messageTemplate: '<div class="w3-panel"><p><i class="icon fa"></i>&nbsp;&nbsp;<span class="msg"></span></p></div>',
        revealPwdIcon: 'fa-eye',
        hidePwdIcon: 'fa-eye-slash',
        remoteActions: {
            submit: {
                controller: null,
                action: null
            },
            load: {
                controller: null,
                action: null
            }
        },
        events: {
            afterSubmitSuccessName: 'aftersubmitsuccess'
        }
    },
    action: {
        buttonTemplateId: '#zdk-action-tpl',
        buttonGap: 60,
        buttons: {
            add: {id: '#zdk-mobile-action-add'},
            refresh: {id: '#zdk-mobile-action-refresh'},
            search: {id: '#zdk-mobile-action-search'},
            scrollup: {id: '#zdk-mobile-action-scrollup'}
        },
        views: {},
        events: {}
    },
    list: {
        element: null,
        rowTemplate: null,
        noRowMessage: '<li><h3>No row found!</h3></li>',
        nextRowsLinkTemplateId: '#zdk-show-next-rows-tpl',
        customSortCriteria: null,
        defaultCustomSortCriterium: null,
        rowsPerPage: 20,
        heightDiffForNewPage: 200,
        infiniteScroll: true,
        displayRowCountInMenuTab: true,
        isAutocompleteOnSearchEnabled: false,
        uniqueSearchedKeyword: false,
        searchedKeywordAsJson: false,
        searchKeywordCaption: null,
        searchKeywordMinStringLengh: 3,
        beforeSearchRequestCallback: null,
        beforeInsertRowCallback: null,
        afterInsertRowCallback: null,
        loadedCallback: null,
        searchModalId: '#zdk-searchinlist-modal',
        sortFieldStorageKey: 'znetdkmobile_list_sort_field',
        sortOrderStorageKey: 'znetdkmobile_list_sort_order',
        sortLabelStorageKey: 'znetdkmobile_list_sort_label',
        keywordsStorageKey: 'znetdkmobile_list_filter_keywords',
        remoteActions: {
            load: {
                controller: null,
                action: null
            },
            autocomplete: {
                controller: null,
                action: null
            }
        },
        events: {
            afterClickEditButtonName: 'afterClickEdit',
            onContentScrollName: 'onContentScroll',
            afterPageLoadedName: 'afterpageloaded'
        }
    },
    autocomplete: {
        element: null,
        minStringLength: 1,
        delay: 300,
        maxNumberOfCachedItems: 0,
        cacheLifetime: 'page', /* 'selection', 'page' or 'localStorage' (TODO) */
        listTemplateId: '#zdk-autocomplete-tpl',
        itemTemplateId: '#zdk-autocomplete-item-tpl',
        prevQueryString: null,
        itemCache: [],
        remoteActions: {
            autocomplete: {
                controller: null,
                action: null
            }
        }
    },
    file: {}
};

if (z4m === undefined) {
    var z4m = znetdkMobile; // Short alias of znetdkMobile global variable
}

(function($, z4m) {
//******************************* INITIALIZATION *******************************

/**
 * The page is fully loaded
 */
$(document).ready(function () {
    if (z4m.isZnetDK4MobileApp()) {
        z4m.initColors();
        z4m.initApp(); // Is a ZnetDK 4 Mobile App
    }
});

z4m.isZnetDK4MobileApp = function() {
    return $('meta[name=generator][content^=ZnetDK]').length === 1;
};

/**
 * Initializes the color CSS classes used by the API
 */
z4m.initColors = function() {
    for (const color of ['info', 'warn', 'error', 'critical', 'snackbar']) {
        z4m.messages.colors[color] = $(z4m.messages.messageTemplateId).data(color);
    }
    z4m.navigation.verticalMenuItemClasses += ' ' + $(z4m.navigation.verticalMenuId).data('hover')
        + ' ' + $(z4m.navigation.verticalMenuId).data('borderSelect');
    z4m.navigation.activeMenuItemClass = $(z4m.navigation.verticalMenuId).data('select');
    z4m.navigation.activeMenuItemBorderClass = $(z4m.navigation.verticalMenuId).data('borderSelect');
    z4m.autocomplete.selectedItemCssClass = $(z4m.autocomplete.itemTemplateId).data('select');
};

/**
 * Initialize the application once the main HTML page is loaded
 * - The login form is displayed if authentication is required
 * - The vertical and horizontal menus are built from the menu definition found
 * into the HTML page
 * - The embedded view or the view matching the first menu item is displayed
 * - The events handled by the application are attached to the built-in event
 *  handlers
 */
z4m.initApp = function () {
    let isMenuBuilt;
    if (z4m.authentication.isRequired()) { // Authentication is required
        // No navigation available
        z4m.navigation.setNoNavigation();
        z4m.header.hideConnectionArea(true);
        // Show login form
        z4m.authentication.showLoginForm();
    } else { // No Authentication required (user authenticated or authentication disabled
        // Building of the navigation menus
        isMenuBuilt = z4m.navigation.build();
        // Is authentication enabled ?
        if (z4m.authentication.isEnabled()) {
            // The header connected user buttons are displayed
            z4m.header.showConnectionArea();
            // The 'login' param is removed from the query string of the URL
            z4m.authentication.removeLoginParamFromUrl();
        } else {
            z4m.header.hideConnectionArea();
        }
    }
    // Handle all events
    this.browser.events.handleViewportResize(); // Viewport resize
    this.modal.events.handleAllClose(); // Close modal dialog
    this.form.events.handleAllInput(); // Form input data modified by user
    this.form.events.handleAllSubmit(); // Submit a data form
    this.browser.events.preventMultipleClicks(); // Prevents multiple clicks
    this.form.events.handleTogglePassword(); // Show/hide password
    this.messages.events.handleAllClose(); // Close a message panel
    this.action.events.handleClick(); // Click on action buttons
    this.list.events.handleEdit(); // Click on list edit buttons
    this.list.events.handleScroll(); // Scroll of the list items
    if (z4m.authentication.isEnabled()
            && !z4m.authentication.isRequired()) {
        this.header.events.handleProfileButtonClick(); // Heading Profile button
        this.header.events.handleLogoutButtonClick(); // Logout button
    }
    if (!z4m.authentication.isRequired() && isMenuBuilt) {
        this.install.events.handleBeforeInstallPrompt(); // App installation (A2HS)
    }
    // Service Worker registration
    this.serviceWorker.register();
};

//***************************** AJAX PUBLIC METHODS ****************************

/**
 * Returns the Ajax URL and its parameter as an Object
 * @returns {Object} The AJAX URL as properties:
 * url: the URL without parameters
 * paramName: the parameter name
 * paramValue: the parameter value
 */
z4m.ajax.getParamsFromAjaxURL = function() {
    if (this.customAjaxUrl !== null) {
        return this.customAjaxUrl;
    }
    var requestUrl = $('body').data('ajaxurl'),
            URLArray = requestUrl.split("?"),
            paramArray = [],
            result = {};
    result.url = URLArray[0];
    if (URLArray.length === 2) {
        paramArray = URLArray[1].split("=");
        result.paramName = paramArray[0];
        result.paramValue = paramArray[1];
    }
    return result;
};

/**
 * Set a custom url for AJAX requests
 * @param {string} url URL of the AJAX requests
 * @param {string} paramName Optional URL parameter name (i.e 'appl')
 * @param {string} paramValue Optional Name of the application
 */
z4m.ajax.setCustomAjaxURL = function(url, paramName, paramValue) {
    this.customAjaxUrl = {url: url};
    if (typeof paramName === 'string' && typeof paramValue === 'string') {
        this.customAjaxUrl.paramName = paramName;
        this.customAjaxUrl.paramValue = paramValue;
    }
};

/**
 * Toggle Ajax loader
 * @param {boolean} isVisible If true, loader is visible, otherwise is hidden.
 */
z4m.ajax.toggleLoader = function(isVisible) {
    const overlayId = 'zdkmobile-ajax-loading-overlay',
            loaderId = z4m.ajax.loaderElementId;
    if (isVisible) {
        let loaderDef = $('body').data('ajaxloader'),
            loaderEl = $(loaderDef);
        loaderEl.attr('id', loaderId);
        $('body').append(loaderEl);
        $('body').append('<div id="' + overlayId+ '"/>');
    } else {
        $('#' + loaderId).remove();
        $('#' + overlayId).remove();
    }
};

/**
 * Send an AJAX request to a ZnetDK PHP application controller
 * @param {Object} options The request parameters:
 * controller: the application controller name (mandatory)
 * action: the application controller action name (mandatory)
 * data: the data as JS Object to send to the controller action (optional)
 * callback: the function to callback when request succeeded
 * htmlTarget: the HTML element as jQuery object in which the request response
 * is to append to.
 * errorCallback: the function to call back when request failed
 * @returns {jqXHR|Boolean} The jQuery object returned by the jQuery $.ajax
 * method or false if the control and action properties are not set properly.
 */
z4m.ajax.request = function (options) {
    if (options.hasOwnProperty('controller') && !options.hasOwnProperty('control')) {
        options.control = options.controller; // 'controller' property also supported
    }
    if (options.control && options.action) {
        var ajaxURL = this.getParamsFromAjaxURL();
        var ajaxOptions = {
            type: "POST",
            url: ajaxURL.url,
            //******************* AJAX EVENT HANDLERS **************************
            /**
             * Event Handler of an AJAX request when sent.
             * The Ajax Loader image and overlay are added to the body
             */
            beforeSend: function () {
                if (!z4m.ajax.requestInProgress) {
                    z4m.ajax.toggleLoader(true);
                }
                z4m.ajax.requestInProgress += 1;
            },
            /**
             * Event Handler of an AJAX request when succeeded.
             * If the AJAX response is a view, it is added to the end of the target HTML
             * element.
             * If the AJAX response is an object, it is passed to the callback function.
             * The callback function when specified as parameter of the AJAX request is
             * called.
             * An error message is displayed if the response is invalid.
             * @param {String|Object} response The response of the remote controller action
             */
            success: function (response) {
                try {
                    if (options.htmlTarget) {
                        options.htmlTarget.prepend(response);
                        if (typeof options.callback === "function") {
                            options.callback(response);
                        }
                    } else if (typeof response === "object") {
                        if (typeof options.callback === "function") {
                            options.callback(response);
                        } else if (response.hasOwnProperty('msg')
                                && (response.hasOwnProperty('success')
                                        || response.hasOwnProperty('warning'))) {
                            var levelMsg = response.success === false ? 'error' :
                                    response.warning === true ? 'warn' : 'info',
                                    summary = response.hasOwnProperty('summary') ? response.summary : 'Message';
                            if (levelMsg !== 'error' && (!response.hasOwnProperty('summary')
                                    || response.summary === null || response.summary === '')) {
                                // Message displayed as Snackbar if the summary is missing and
                                // the message level is not 'error'
                                z4m.messages.showSnackbar(response.msg, levelMsg === 'warn');
                            } else {
                                z4m.messages.add(levelMsg, summary, response.msg, false);
                            }
                        }
                    } else {
                        z4m.messages.add('error', 'Message',
                                'Invalid Ajax response sent by the web server!', false);
                    }
                } catch (error) {
                    hideLoaderImage();
                    z4m.navigation.closeVerticalMenu();
                    z4m.messages.add('critical', 'OOPS!',
                            'A Javascript error occured while processing the AJAX request response! See your browser console for details.');
                    z4m.log.error("JS error dectected while processing the response of the '" + options.control
                        + ':' + options.action + "' controller's action."
                        + (typeof response === 'object' ? "\nResponse: " + JSON.stringify(response) : '')
                        + "\nJS error: " + (error.hasOwnProperty('stack') ? error.stack : error.message));
                    z4m.ajax.emptyRequestContext(); // Request context is emptied
                }
            },
            /**
             * Event Handler of an AJAX request when failed.
             * The error message is displayed.
             * When the HTTP error code is 401, the AJAX request is queued and the login
             * form is displayed.
             * If the option.errorCallback is set, the function is called back when the
             * the HTTP error code is different from 401.
             * @param {Object} response The error informations
             */
            error: function (response) {
                var isDisconnected, errorMsg, errorSummary, appVersion, reloadSummary,
                        reloadMsg, errorLevel = response.status === 401 ? 'warn' : 'critical';
                if (/application\/json/.test(response.getResponseHeader('Content-Type'))) {
                    try {
                        let errorObject = JSON.parse(response.responseText);
                        isDisconnected = errorObject.is_disconnected;
                        errorMsg = errorObject.msg;
                        errorSummary = errorObject.summary;
                        appVersion = errorObject.appver;
                        reloadSummary = errorObject.reload_summary;
                        reloadMsg = errorObject.reload_msg;
                    } catch (e) {
                    }
                }
                if (response.status === 0) {
                    let msgArray = $('body').data('networkerrormsg').split("|");
                    errorSummary = msgArray[0];
                    errorMsg = msgArray[1];
                    errorLevel = 'error';
                } else if (errorMsg === undefined) {
                    errorMsg = "The JSON response returned by the controller='" + options.control + "' and the action='" + options.action +
                            "' can't be parsed! HTTP status: " + response.status + ' ' + response.statusText;
                    errorSummary = 'Error parsing server response';
                }
                if (typeof options.errorCallback === "function"
                        && options.errorCallback(response) === false) {
                    z4m.ajax.emptyRequestContext(); // Request context is emptied
                    return;
                }
                if (response.status === 401 && isDisconnected === false) {
                    // Show session timed out message as snack bar
                    z4m.messages.showSnackbar(errorMsg, true);
                    if (typeof appVersion === 'number' && typeof reloadSummary === 'string'
                            && typeof reloadMsg === 'string'
                            && parseInt($('body').data('appver')) < appVersion) {
                        // New app's version, reloading is required
                        reloadApp(reloadSummary, reloadMsg);
                    } else {
                        // Current request is queued for execution after authentication
                        z4m.ajax.requestContext.push(options);
                        if (z4m.ajax.requestContext.length === 1) {
                            // Login dialog to renew user credentials displayed only once
                            z4m.authentication.showLoginForm(true);
                        }
                    }
                } else if (response.status === 401 && isDisconnected === true) {
                    // User is disconnected, redirect to login page
                    reloadApp(errorSummary, errorMsg);
                } else {
                    z4m.messages.add(errorLevel, errorSummary, errorMsg, false);
                    z4m.ajax.emptyRequestContext(); // Request context is emptied
                }
            },
            /**
             * Event Handler of an AJAX request when terminated.
             * The AJAX Loader image is hidden
             */
            complete: function () {
                hideLoaderImage();
            }
        };
        if (options.data && options.data instanceof FormData) {
            let requestData = options.data;
            requestData.append("control", options.control);
            requestData.append("action", options.action);
            if (ajaxURL.hasOwnProperty('paramName')) {
                requestData.append(ajaxURL.paramName, ajaxURL.paramValue);
            }
            ajaxOptions.data = requestData;
            ajaxOptions.processData = false;
            ajaxOptions.contentType = false;
        } else if (options.data && typeof options.data === "object") {
            let requestData;
            if (Array.isArray(options.data)) {
                requestData = 'control=' + options.control + '&action=' + options.action + '&' + $.param(options.data);
            } else { // Is Object...
                var property;
                requestData = 'control=' + options.control + '&action=' + options.action;
                for (property in options.data) {
                    var value = options.data[property],
                            encodedValue = typeof value === 'string' ? encodeURIComponent(value) : value;
                    if (typeof value !== 'undefined' && value !== null) {
                        requestData += '&' + property + '=' + encodedValue;
                    }
                }
            }
            if (ajaxURL.hasOwnProperty('paramName')) {
                requestData += '&' + ajaxURL.paramName + '=' + ajaxURL.paramValue;
            }
            ajaxOptions.data = requestData;
        } else {
            ajaxOptions.data = {control: options.control, action: options.action};
            if (ajaxURL.hasOwnProperty('paramName')) {
                ajaxOptions.data[ajaxURL.paramName] = ajaxURL.paramValue;
            }
        }
        return $.ajax(addUITokenToAjaxOptions(ajaxOptions));
    }
    z4m.log.error("Call to the request method failed, properties 'control' or 'action' are missing: ", options);
    return false;
    /**
     * The Ajax Loader image and overlay are removed from the body
     */
    function hideLoaderImage() {
        if (z4m.ajax.requestInProgress === 1) {
            z4m.ajax.toggleLoader(false);
        }
        z4m.ajax.requestInProgress -= 1;
    }
    function reloadApp(summary, msg) {
        z4m.messages.notify(summary, msg, 'Ok', function(){
            // No longer confirmation message on application reload or close
            z4m.browser.events.detachBeforeUnload();
            // The page is reloaded
            location.reload();
        });
    }
    function addUITokenToAjaxOptions(ajaxOptions) {
        const token = $('body').data('ui-token');
        if (token && token.length > 0) {
            if (ajaxOptions.data instanceof FormData) {
                ajaxOptions.data.append('uitk', token);
            } else if (typeof ajaxOptions.data === 'string') {
                ajaxOptions.data += '&uitk=' + token;
            } else if (typeof ajaxOptions.data === 'object') {
                ajaxOptions.data.uitk = token;
            }
        }
        return ajaxOptions;
    }
};

/**
 * Load a remote view and add it to the DOM of the HTML page
 * @param {String} viewName Name of the view to load
 * @param {jQuery} targetHtmlElement The HTML element as jQuery object that will
 * contain the view once loaded
 * @param {function} callback An optional function to call back once the view
 * had been added at the end of the target HTML container
 * @returns {jqXHR|Boolean} The jQuery object returned by the jQuery $.ajax
 * method or false if the view name is not specified and if the target
 * HTML element is not a jQuery element.
 */
z4m.ajax.loadView = function (viewName, targetHtmlElement, callback) {
    var requestOptions = {
        control: viewName,
        action: 'show',
        htmlTarget: targetHtmlElement
    };
    if (typeof callback === 'function') {
        requestOptions.callback = callback;
    }
    if (targetHtmlElement instanceof jQuery && typeof viewName === 'string') {
        return z4m.ajax.request(requestOptions);
    }
    return false;
};

/**
 * Execute the last Ajax requests that were queued waiting for authentication
 */
z4m.ajax.requestFromQueue = function () {
    var ajaxObject = z4m.ajax,
            queueSize = ajaxObject.requestContext.length;
    for (var index = 0; index < queueSize; index++) {
        if (index >= ajaxObject.requestContext.length) {
            // Request context emptied after error.
            break;
        }
        ajaxObject.request(ajaxObject.requestContext[index]);
    }
    // Only the executed queries are removed.
    ajaxObject.requestContext.splice(0, queueSize);
};

/**
 * Empties the request context
 */
z4m.ajax.emptyRequestContext = function () {
    z4m.ajax.requestContext = [];
};

/*
 * Initialize the 'controller' and 'action' properties of the specified JS object
 * from the 'data-zdk-load', 'data-zdk-submit' or 'data-zdk-autocomplete'
 * attribute of its 'element' property.
 * See as an example of object to initialize the 'z4m.form' or the
 * 'z4m.list' object.
 * @param {String} type The type of controller action to initialize among the
 * 'load', 'submit' and 'autocomplete' choices.
 * @param {Object} object The JS object having the 'action', 'controller' and
 * 'element' properties.
 * @returns {Boolean} Object true when initialization succeeds, false otherwise.
 */
z4m.ajax.initControllerActionProperties = function (type, object) {
    if (type !== 'load' && type !== 'submit' && type !== 'autocomplete') {
        z4m.log.error('The type of controller action is invalid!');
        return false;
    }
    if (object === null || typeof object !== 'object') {
        z4m.log.error('Not a JS object!');
        return false;
    }
    if (!object.hasOwnProperty('element')) {
        z4m.log.error("'element' property is missing!", object);
        return false;
    }
    if (object.element instanceof jQuery === false) {
        z4m.log.error('Not a jQuery element!', object.element);
        return false;
    }
    var actionAttrib = object.element.attr('data-zdk-' + type);
    if (typeof actionAttrib === 'string') {
        var actionArray = actionAttrib.split(":");
        if (!object.hasOwnProperty('remoteActions')) {
            object.remoteActions = {};
        }
        object.remoteActions[type] = {
            controller: actionArray[0],
            action: actionArray[1]
        };
        return true;
    } else {
        return false;
    }
};

//************************ BROWSER PUBLIC METHODS **************************

/**
 * Set document title according to the vertical menu active item
 * @param {String} label the label to display as title of the page
 */
z4m.browser.addLabelToTitle = function (label) {
    var separator = " | ";
    var newTitle = document.title;
    var sepIndex = newTitle.indexOf(separator);
    if (sepIndex === -1) {
        newTitle = label === null || label === "" ? newTitle : label + separator + newTitle;
    } else {
        newTitle = label === null || label === "" ? newTitle.substring(sepIndex + separator.length) : label + separator + newTitle.substring(sepIndex + separator.length);
    }
    document.title = newTitle;
};

/**
 * Returns the path that prefixes the local storage key to avoid the store
 * values to be overwritten when several applications are installed on the same
 * internet domain name.
 * @returns {String} The local storage key path prefix
 */
z4m.browser.getLocalDataKeyPath = function() {
    var params = z4m.ajax.getParamsFromAjaxURL(),
            url = params.url.replace('index.php', '');
    if (params.hasOwnProperty('paramName') && params.paramName === 'appl'
            && params.hasOwnProperty('paramValue')) {
        url += params.paramValue + '/';
    }
    return url;
};

/**
 * Stores in the web browser local storage the specified value
 * @param {String} storageKey Identifier of the value stored locally
 * @param {String} value The value to store
 * @returns {Boolean} true if the storage succeeded, false otherwise.
 */
z4m.browser.storeLocalData = function (storageKey, value) {
    var path = this.getLocalDataKeyPath();
    try {
        localStorage.setItem(path + storageKey, value);
        return true;
    } catch (e) {
        z4m.log.error('local storage not supported by the browser!');
        return false;
    }
};

/**
 * Retrieves the value stored in the web browser local storage for the
 * specified key
 * @param {String} storageKey Identifier of the value stored locally
 * @returns {DOMString|Boolean} The value found or false if the value does
 * not exist.
 */
z4m.browser.readLocalData = function (storageKey) {
    var path = this.getLocalDataKeyPath();
    try {
        var storedValue = localStorage.getItem(path + storageKey);
        if (storedValue) {
            return storedValue;
        } else {
            return false;
        }
    } catch (e) {
        z4m.log.error('local storage not supported by the browser!');
        return false;
    }
};

/**
 * Removes the data matching the specified key from the web browser local storage
 * @param {String} storageKey Identifier of the value stored locally
 */
z4m.browser.removeLocalData = function (storageKey) {
    var path = this.getLocalDataKeyPath();
    try {
        localStorage.removeItem(path + storageKey);
    } catch (e) {
        z4m.log.error('local storage not supported by the browser!');
    }
};

/**
 * Displays the screen for dialing a telephone number and pre-fills it with the
 * telephone number specified in parameter.
 * @param {String} phoneNumber The phone number
 */
z4m.browser.doPhoneCall = function(phoneNumber) {
    var callablePhoneNbr = phoneNumber.replace(/\./g, '');
    document.location.replace('tel:' + callablePhoneNbr);
};

/**
 * Displays the screen for writing a SMS and pre-fills it with the specified
 * phone number and text of the SMS.
 * @param {String} phoneNumber The phone number
 * @param {String} message The text of the SMS
 */
z4m.browser.sendSms = function(phoneNumber, message) {
    var callablePhoneNbr = phoneNumber.replace(/\./g, '');
    document.location.replace('sms:' + callablePhoneNbr + ';?&body=' + encodeURIComponent(message.trim()));
};

/**
 * Disables temporarily a clickable element to avoid multiple click events
 * @param {jQuery} element The clickable element AS jQuery Object.
 */
z4m.browser.disableTemporarily = function(element) {
    element.prop('disabled', true);
    setTimeout(function(){
        element.prop('disabled', false);
    }, z4m.browser.disablingDelay);
};

/**
 * Declare an handler for the 'resize' events and then adjust the UI when the
 * viewport is resized or when its orientation changes.
 */
z4m.browser.events.handleViewportResize = function () {
    $(window).on('resize.z4m', function () {
        /* The page content top spacing is adjusted */
        z4m.content.setTopSpacing();
        /* The action buttons are positioned according to the footer height */
        z4m.action.adjustPosition();
    });
};

/**
 * Declare an handler for the 'beforeunload' events.
 * A confirmation message is displayed when the browser is closed and when
 * the browser tab containing the application is closed.
 * This confirmation message is not displayed when :
 * - the application is configured to be reloaded each time a new view is
 *   displayed,
 * - the login form is displayed
 * - the 'confirmationOnApplicationClose' property is set to false.
 */
z4m.browser.events.handleBeforeUnload = function () {
    if (z4m.browser.confirmationOnApplicationClose
            && !z4m.navigation.isPageToBeReloaded()
            && !z4m.authentication.isRequired()) {
        $(window).on('beforeunload.z4m', function (event) {
            event.preventDefault();
            return (event.returnValue = '');
        });
    }
};

/**
 * Detach the handlers declared for the 'beforeunload' events
 */
z4m.browser.events.detachBeforeUnload = function () {
    $(window).off('beforeunload.z4m');
};

/**
 * Prevents multiple clicks on anchor and button elements by disabling them
 * temporarily
 */
z4m.browser.events.preventMultipleClicks = function() {
    $('body').on('click.z4m-browser-prevent-multiple-clicks', 'a, button:not(:submit)', function() {
        z4m.browser.disableTemporarily($(this));
    });
};

//*************************** HEADER PUBLIC METHODS ****************************

/**
 * Get the header element containing the connected user buttons
 * @returns {jQuery} The element as a jQuery object
 */
z4m.header.getConnectionArea = function () {
    return $(this.connectionAreaId);
};

/**
 * Get the login name of the connected user
 * @returns {string} The login name
 */
z4m.header.getConnectedUserLogin = function () {
    return this.getConnectionArea().data('zdk-login');
};

/**
 * Get the connected user name
 * @returns {string} The user name
 */
z4m.header.getConnectedUserName = function () {
    return this.getConnectionArea().data('zdk-username');
};

/**
 * Get the connected user email
 * @returns {string} The user email
 */
z4m.header.getConnectedUserMail = function () {
    return this.getConnectionArea().data('zdk-usermail');
};

/**
 * Get the height of the header
 * @returns {integer} Height in pixels
 */
z4m.header.getHeight = function () {
    return $(this.headerId).height();
};

/**
 * Get the menu button as a jQuery element
 * @returns {jQuery} Button element
 */
z4m.header.getMenuButton = function () {
    return $(this.menuButtonId);
};

/**
 * Hide the header connection area
 * @@param {boolean} isDisconnected if true, header is displayed for
 * disconnected state.
 */
z4m.header.hideConnectionArea = function (isDisconnected) {
    $(this.connectionAreaId).addClass(z4m.hideClass);
    $(this.headerId).find('.banner-title-small,.banner-title-large').addClass('no-connection');
    if (isDisconnected === true) {
        $(this.headerId).find('.banner-title-small,.banner-title-large').addClass('is-disconnected');
    }
};

/**
 * Show the header connection area
 */
z4m.header.showConnectionArea = function () {
    $(this.connectionAreaId).removeClass(z4m.hideClass);
    $(this.headerId).find('.banner-title-small,.banner-title-large').removeClass('no-connection');
};

/**
 * Is header visible ?
 * See z4m.header.events.handleHideHeaderOnScroll
 * @returns {Boolean} Returns true if visible, false otherwise.
 */
z4m.header.isVisible = function () {
    return $(z4m.header.headerId).css('top') === '0px';
};

/**
 * Hides automatically the page header when the page is scrolled down.
 * See z4m.header.events.handleHideHeaderOnScroll.
 * @param {Boolean|undefined} isEnabled Enabled by default; if set to false, the
 * page header is no longer hidden on scroll.
 */
z4m.header.autoHideOnScroll = function (isEnabled) {
    this.events.handleHideHeaderOnScroll(isEnabled);
};

/**
 * Display the user panel when clicking on the header profile button
 */
z4m.header.events.handleProfileButtonClick = function () {
    $('#zdk-profile').on('click.z4m_header', function (event) {
        z4m.authentication.showUserPanel();
        event.preventDefault();
    });
};

/**
 * Disconnect the user when clicking on the header logout button
 */
z4m.header.events.handleLogoutButtonClick = function () {
    $('#zdk-logout').on('click.z4m_header', function (event) {
        z4m.authentication.disconnect();
        event.preventDefault();
    });
};

/**
 * Hide the page header on scroll
 * @param {Boolean|undefined} isEnabled When set to false, the page header is
 * no longer hidden on scroll.
 */
z4m.header.events.handleHideHeaderOnScroll = function(isEnabled) {
    $(window).off('scroll.z4m_header');
    if (isEnabled === false) {
        z4m.header.autoHideOnScrollEnabled = false;
        return;
    }
    z4m.header.autoHideOnScrollEnabled = true;
    $(window).on('scroll.z4m_header', function() {
        if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
            z4m.content.setTopSpacingToTargetAnchor();
            $(z4m.header.headerId).css('top', z4m.header.getHeight()*-1);
        } else {
            $(z4m.header.headerId).css('top', 0);
        }
    });
};

//************************** CONTENT PUBLIC METHODS ****************************

/**
 * Get the view container of the application
 * @returns {jQuery} The container element as jQuery element
 */
z4m.content.getContainer = function () {
    return $(this.containerId);
};

/**
 * Get the default container of the application
 * @returns {jQuery} The default container element as jQuery element
 */
z4m.content.getDefaultContainer = function () {
    return $(this.defaultContainerId);
};

/**
 * Display the view container of the application
 */
z4m.content.showContainer = function () {
    this.getContainer().parent().removeClass(z4m.hideClass);
};

/**
 * Get the ID of the preloaded view into the main application page
 * @returns {String} The identifier of the view or null if no preloaded view
 * exists
 */
z4m.content.getPreloadedViewId = function () {
    var view = this.getContainer().find('.zdk-filled').eq(0);
    return this.getViewId(view);
};

/**
 * Get the ID of the specified view element
 * @param {jQuery} viewElement The view element
 * @returns {string|null} The view ID
 */
z4m.content.getViewId = function (viewElement) {
    if (viewElement.length === 1) {
        let splittedID = (viewElement.attr('id')).split('-');
        splittedID.splice(0, 1); splittedID.splice(-1, 1);
        return splittedID.join('-');
    }
    return null;
};

/**
 * Display the specified view and scroll its content to the position of the
 * specified anchor.
 * @param {string} viewID The ID of the view
 * @param {string} anchor The HTML ID of the anchor into the view
 */
z4m.content.displayView = function (viewID, anchor) {
    $('body').trigger(this.events.displayViewName, [viewID, anchor]);
};

/**
 * Reload the specified view and scroll its content to the position of the
 * specified anchor.
 * @param {string} viewID The ID of the view
 * @param {string} anchor The HTML ID of the anchor into the view
 */
z4m.content.reloadView = function (viewID, anchor) {
    $('body').trigger(this.events.displayViewName, [viewID, anchor, true]);
};


/**
 * Indicates whether the default container is hidden or not
 * @returns {boolean} Value true if hidden
 */
z4m.content.isDefaultContainerHidden = function () {
    return this.getDefaultContainer().hasClass('ui-helper-hidden');
};

/**
 * Set the top spacing of the content (css padding) to ensure its visibility
 * according to the header height.
 * In addition, a style element is added to the page for adjusting the scroll
 * bar position according to the header height when going to an anchor, except
 * if the page header is hidden on scroll.
 */
z4m.content.setTopSpacing = function () {
    var headerHeight = z4m.header.getHeight(),
        originalHeight = parseFloat(this.getContainer().css('padding-top')),
        headerHeightHasChanged = headerHeight !== originalHeight;
    this.getContainer().css('padding-top', headerHeight);
    this.setTopSpacingToTargetAnchor();
    if (headerHeightHasChanged) {
        $('body').trigger(this.events.topSpaceChangeName,
            [originalHeight, headerHeight]);
    }
};

/**
 * Set top spacing to the target anchor to ensure its visibility
 * according to the header height except if the page header is hidden on scroll.
 */
z4m.content.setTopSpacingToTargetAnchor = function () {
    var headerHeight = z4m.header.getHeight();
    if ($('#zdk-anchor-adjust').length > 0) {
        $('#zdk-anchor-adjust').remove();
    }
    if (z4m.header.autoHideOnScrollEnabled === false) {
        $('body').append(
                '<style id="zdk-anchor-adjust">'
                + ':target {'
                + 'padding-top:' + headerHeight + 'px;'
                + 'margin-top:-' + headerHeight + 'px;'
                + 'display: inline-block;}'
                + '</style>'
                );
    }
};

/**
 * Display the specified HTML text within the view content
 * @param {string} html The HTML text
 */
z4m.content.setHtml = function (html) {
    this.getContainer().empty().html(html);
};

/**
 * Get the element of the view currently displayed
 * @returns {jQuery} The view as jQuery Element
 */
z4m.content.getDisplayedView = function () {
    return this.getContainer().find('.zdk-view:visible');
};

/**
 * Get the ID of the view currently displayed
 * @returns {string} The ID of the displayed view
 */
z4m.content.getDisplayedViewId = function () {
    var view = this.getDisplayedView();
    return this.getViewId(view);
};

/**
 * Get the view ID from a child element
 * @param {jQuery} childElement The element within the view
 * @returns {String} The identifier of the view
 */
z4m.content.getParentViewId = function (childElement) {
    if (childElement instanceof jQuery === false) {
        z4m.log.error('The specified child element is not jQuery object!');
        return null;
    }
    var viewElement = childElement.closest('.zdk-view');
    return this.getViewId(viewElement);
};

/**
 * Indicate whether the specified view exists into the DOM
 * @param {String} viewId ID of the view
 * @returns {Boolean} Value true if the view already exists
 */
z4m.content.doesViewExistInDom = function (viewId) {
    var view = this.getContainer().find('#znetdk-' + viewId + '-view');
    return view.length === 1;
};

/**
 * Scroll the page to show the specified anchor.
 * If the anchor is not specified, the anchor is read from the URL if it is set
 * @param {String} anchor HTML ID of the anchor
 * @returns {Boolean} Value true when anchor exists and is displayed
 */
z4m.content.goToAnchor = function (anchor) {
    if (anchor === undefined) {// No anchor specified
        anchor = location.hash; // Read from URL
        if (anchor.length === 0) { // No anchor in URL
            return false;
        }
    } else {
        anchor = '#' + anchor;
    }
    if ($(anchor).length !== 1) {
        return false; // anchor element not found
    }
    if (z4m.navigation.isPageToBeReloaded()) {
        var tempLink = $('<a href="' + anchor + '"></a>').appendTo('body');
        tempLink[0].click();
        tempLink.remove();
    } else {
        var anchorPosition = $(anchor).offset().top,
                headerHeight = z4m.header.getHeight();
        $(window).scrollTop(anchorPosition - headerHeight);
    }
    return true;
};

//*************************** FOOTER PUBLIC METHODS ****************************

/**
 * Hide the footer
 */
z4m.footer.hide = function () {
    $(this.footerId).addClass(z4m.hideClass);
};

/**
 * Show the footer
 */
z4m.footer.show = function () {
    $(this.footerId).removeClass(z4m.hideClass);
};

/**
 * Obsolete since version 3.0
 * Display the footer at the bottom of the viewport when the page
 * content height is lower than the the viewport height
 */
z4m.footer.adjustPosition = function () {
    this.show();
};

/**
 * Get the footer height
 * @returns {float} The height of the footer in pixels
 */
z4m.footer.getHeight = function () {
    var footerElement = $(this.footerId),
            footerHeight = footerElement.outerHeight(true);
    if (footerHeight === 0) { // The footer hidden so the height returned is zero
        footerElement.css('visibility', 'hidden');
        this.show();
        footerHeight = footerElement.outerHeight(true);
        this.hide();
        footerElement.css('visibility', 'visible');
    }
    return footerHeight;
};


//*************************** MESSAGE PUBLIC METHODS ***************************

/**
 * Get the message container
 * @returns {jQuery} The container element as jQuery element
 */
z4m.messages.getContainer = function () {
    return $(this.containerId);
};

/**
 * Display the specified message
 * @param {String} severity The severity of the message: 'info', 'warn', 'error'
 * or 'critical'
 * @param {String} summary Title of the message
 * @param {String} detail Text of the message
 * @param {Boolean} autoHide If set to true or undefined, the message is
 * automatically hidden after the time set in seconds for the
 * 'autoCloseDuration' property
 */
z4m.messages.add = function (severity, summary, detail, autoHide) {
    const newEl = $(this.messageTemplateId).contents().filter('div').clone();
    newEl.addClass(this.colors[severity]).find('.icon').addClass(this.icons[severity]);
    newEl.find('.summary').html(summary);
    newEl.find('.detail').html(detail);
    newEl.appendTo(this.getContainer());
    if (severity !== 'critical' && (autoHide === undefined || autoHide === true)) {
        window.setTimeout(function () {
            newEl.remove();
            z4m.content.setTopSpacing();
        }, this.autoCloseDuration);
    }
    z4m.content.setTopSpacing();
};

/**
 * Add multiples messages into the message area
 * @param {array} messages The messages to add to the message container
 * @returns {Boolean} Value true when succeeded
 */
z4m.messages.addMulti = function (messages) {
    if (!Array.isArray(messages)) {
        z4m.log.error('Not an array!');
        return false;
    }
    var $this = this;
    messages.forEach(function (message) {
        if (Array.isArray(message)) {
            $this.add.apply($this, message);
        }
    });
    return true;
};

/**
 * Remove all the messages from the message container
 */
z4m.messages.removeAll = function () {
    this.getContainer().empty();
    z4m.content.setTopSpacing();
};

/**
 * Display the message as a snackbar message
 * @param {String} text The text of the message
 * @param {undefined|Boolean} isWarning When set to true, the snackbar message
 * is displayed as a warning message
 * @param {undefined|jQuery} parentContainer Optional jQuery element containing
 * the snackbar message (useful for display over a modal dialog).
 */
z4m.messages.showSnackbar = function (text, isWarning, parentContainer) {
    const newEl = $(this.snackbarTemplateId).contents().filter('div').clone();
    newEl.addClass(isWarning === true ? this.colors.warn : this.colors.snackbar);
    newEl.find('.icon').addClass(isWarning === true ? this.icons.warn : this.icons.info);
    newEl.find('.msg').html(text);
    newEl.appendTo(parentContainer === undefined ? $('body') : parentContainer);
    window.setTimeout(function () {
        newEl.remove();
    }, 2500);
};

/**
 * Display a notification message
 * @param {String} title Title displayed into the title bar
 * @param {String} message The notification message
 * @param {String} buttonLabel The label of the OK button ('Ok' if undefined)
 * @param {function} callback The function to call back when the OK button is
 * pressed
 */
z4m.messages.notify = function (title, message, buttonLabel, callback) {
    var modal = $('#zdk-notification-modal');
    modal.find('.title').html(title);
    modal.find('.message').html(message);
    if (typeof buttonLabel === 'string') {
        modal.find('button').html(buttonLabel);
    }
    modal.find('button').one('click.z4m_messages', function () {
        modal.hide();
        if (typeof callback === 'function') {
            callback();
        }
    });
    modal.show();
};

/**
 * Display a message for confirmation purpose
 * @param {String} title Title displayed into the title bar
 * @param {String} question Text of the question asked to the user
 * @param {Object} buttons Labels of the YES and NO buttons ('Yes' and 'No' by
 * default)
 * @param {function} callback The function to call back when the YES or NO button
 * is pressed. The parameter passed to the function is a Boolean variable set to
 * true when the YES button is pressed
 */
z4m.messages.ask = function (title, question, buttons, callback) {
    var modal = $('#zdk-confirmation-modal'),
            yesLabel, noLabel;
    modal.find('.title').html(title);
    modal.find('.message').html(question === null
        ? modal.find('.message').data('default-msg') : question);
    if (buttons !== null && typeof buttons === 'object'
            && buttons.hasOwnProperty('yes') && buttons.hasOwnProperty('no')) {
        yesLabel = buttons.yes;
        noLabel = buttons.no;
    } else {
        yesLabel = modal.find('button.yes span.label').data('default-label');
        noLabel = modal.find('button.no span.label').data('default-label');
    }
    modal.find('button.yes span.label').html(yesLabel);
    modal.find('button.no span.label').html(noLabel);
    modal.find('button').off('click.z4m_messages');
    modal.find('button').one('click.z4m_messages', function () {
        modal.hide();
        if (typeof callback === 'function') {
            callback($(this).hasClass('yes'));
        }
    });
    modal.show();
    modal.find('button.no').trigger('focus');
};

/**
 * Close a message when its close button is pressed
 */
z4m.messages.events.handleAllClose = function () {
    z4m.messages.getContainer().on('click.z4m_messages', 'a.close', function (event) {
        $(this).parent().remove();
        z4m.content.setTopSpacing();
        event.preventDefault();
    });
};

//***************************** LOG PUBLIC METHODS *****************************

/**
 * Display into the Web browser console the specified message as a warning
 * message
 * @param {String} message Text of the message
 * @param {Object} objectToLog Object to log into the console
 * @param {String} severity Value 'error' when it is an error, otherwise is
 *  a warning message
 */
z4m.log.warn = function (message, objectToLog, severity) {
    var consoleMethod;
    if (severity === 'error') {
        consoleMethod = console.error;
    } else {
        consoleMethod = console.warn;
    }
    if (typeof objectToLog === 'object') {
        consoleMethod('[z4m]', message, ', Traced object:', objectToLog);
    } else {
        consoleMethod('[z4m]', message);
    }
};

/**
 * Display into the Web browser console the specified message as an error
 * message
 * @param {String} message Text of the message
 * @param {Object} objectToLog Object to log into the console
 */
z4m.log.error = function (message, objectToLog) {
    this.warn(message, objectToLog, 'error');
};

//*********************** AUTHENTICATION PUBLIC METHODS ************************

/**
 * Indicates whether authentication is enabled or not for the application
 * @returns {Boolean} Value true when authentication is enabled
 */
z4m.authentication.isEnabled = function () {
    var loginName = z4m.header.getConnectedUserLogin();
    return loginName !== '';
};

/**
 * Indicates whether the user must authenticated or not
 * @returns {Boolean} Value true when user must be authenticated
 */
z4m.authentication.isRequired = function () {
    return (z4m.navigation.getMenuDefinition().length === 0
            && z4m.content.isDefaultContainerHidden());
};

/**
 * Show the change password modal dialog (loaded on demand)
 * When this modal displayed while password has expired, the old password field
 * is pre-filled and is hidden (only new password and its confirmation are
 * entered by user).
 * @param {String} login The user login name
 * @param {String} oldPwd In option, the old user password
 * @param {String} msg In option a message to display into the
 *  change password form
 */
z4m.authentication.changePassword = function (login, oldPwd, msg) {
    const $this = this, isUserConnected = msg === undefined;
    z4m.modal.make(this.changePasswordFormId, this.changePasswordView, function(){
        const modal = this, form = this.getInnerForm();
        form.init({login_name: login});
        if (oldPwd !== undefined) {
            form.setInputValue('password', oldPwd);
        }
        this.open(function (response) { // On submit
            if (response.success) {
                    form.reset();
                    modal.close();
                    z4m.messages.showSnackbar(response.msg);
                    if (!isUserConnected) {
                        setTimeout(function(){ location.reload(); }, 500);
                    }
                    return false; // Message has been already displayed as Snackbar
                }
            }, function () { // On close
                form.reset();
                if (!isUserConnected) {
                    $this.cancelLogin(modal);
                    return false; // Modal not closed by default event handler
                }
            }, isUserConnected ? 'password' : 'login_password'
        );
        if (msg) {
            form.showInfo(msg, true);
        }
    });
};

/**
 * Display the user panel showing his user name and email address and
 * allowing to change his password
 */
z4m.authentication.showUserPanel = function () {
    var $this = this,
            modalElement = $(this.connectedUserPanelId),
            modal = z4m.modal.make(modalElement),
            userName = z4m.header.getConnectedUserName(),
            email = z4m.header.getConnectedUserMail();
    modalElement.find('h3.username').text(userName);
    modalElement.find('p.usermail').text(email);
    modal.open();
    _handleButtonClick('changepwd', function(){
        const isLoginNameEmail = z4m.browser.readLocalData(this.loginWithEmailStorageKey);
        this.changePassword(isLoginNameEmail === '1' ? email : z4m.header.getConnectedUserLogin());
    });
    _handleButtonClick('myuserrights', function(){
        z4m.modal.make(this.myUserRightsModalId, this.myUserRightsViewName, function(){ this.open(); });
    });
    _handleButtonClick('install', function(){ z4m.install.showInstallView(); },
        !z4m.serviceWorker.isRegistered);
    _handleButtonClick('uninstall', function(){ z4m.install.showUninstallView(); },
        !z4m.serviceWorker.isRegistered);
    _handleButtonClick('logout', function(){
        this.disconnect();
    });
    function _handleButtonClick(buttonClass, onClick, isOnlyOff) {
        var eventName = 'click.z4m_auth',
                button = modalElement.find('button.' + buttonClass);
        button.off(eventName);
        if (isOnlyOff === true) { return; }
        button.on(eventName, function () {
            modal.close();
            onClick.call($this);
        });
        button.removeClass(z4m.hideClass);
    }
};

/**
 * Display the login form in a modal dialog.
 * If user is already connected and his session has expired, the login name is
 * pre-filled and the keyboard focus is set on the password field.
 * @param {Boolean} renewCredentials When set to true, the login dialog is
 * closed and the queued ajax requests are executed. Otherwise the page is
 * reloaded.
 */
z4m.authentication.showLoginForm = function (renewCredentials) {
    var $this = this,
            modal = z4m.modal.make($(this.loginFormId)),
            focusedField = initLoginName();
    handleRememberMeClick();
    if (initRememberMeState()) {
        // Forgot password link only displayed on trusted terminal
        handleForgotPasswordClick();
    }
    modal.open(
            function (response) { // On submit
                if (response.success === true || response.newpasswordrequired) {
                    memorizeRememberMeState(response.login_with_email);
                }
                if (response.success === true) {
                    if (renewCredentials === true) {
                        modal.close();
                        z4m.ajax.requestFromQueue();
                    } else {
                        location.reload(); // The page is reloaded
                    }
                }
                if (response.newpasswordrequired) { // Change password required
                    modal.close();
                    $this.changePassword(modal.getInnerForm().getInputValue('login_name'),
                        modal.getInnerForm().getInputValue('password'), response.msg);
                    // The error message must not be displayed
                    // by the form submit event default handler.
                    return false;
                } else if (response.toomuchattempts) { // User account disabled
                    // The login button is disabled
                    modal.getInnerForm(true).find('button[type=submit]').prop('disabled', true);
                }
            },
            function () { // On close
                $this.cancelLogin(modal);
                // The modal dialog is closed by the cancelLogin method.
                // So it must not be closed by the default 'close' event handler.
                return false;
            },
            focusedField // Form Field with focus
    );
    function initLoginName() {
        const login = getDefaultLoginName();
        if (login !== null) {
            // The login name is pre-filled
            modal.getInnerForm().setInputValue('login_name', login);
            // The focus is set on the password field
            return 'password';
        }
        function getDefaultLoginName() {
            const urlLogin = new URL(window.location.toLocaleString())
                    .searchParams.get($this.urlLoginParamName);
            if (isOK(urlLogin)) {
                return urlLogin;
            }
            const userLogin = z4m.header.getConnectedUserLogin();
            if (isOK(userLogin)) {
                return userLogin;
            }
            const localLogin = z4m.browser.readLocalData($this.loginNameStorageKey);
            return isOK(localLogin) ? localLogin : null;
            function isOK(val) {
                return typeof val === 'string' && val.length > 0;
            }
        };
    }
    function handleRememberMeClick() {
        $('#zdk-login-modal-remember-me').off('change.z4m')
                .on('change.z4m', function () {
            var accessElement = $(this).closest('form').find('input[name=access]'),
                accessValue = $(this).is(':checked') ? 'private' : 'public';
            accessElement.val(accessValue);
        });
    }
    function initRememberMeState() {
        var accessValue = z4m.browser.readLocalData($this.rememberMeLocalStorageKey),
                rememberMeElement = $('#zdk-login-modal-remember-me');
        if (rememberMeElement.length === 1 && accessValue !== false) {
            var accessElement = modal.getInnerForm(true).find('input[name=access]');
            accessElement.val(accessValue);
            rememberMeElement.prop('checked', accessValue === 'private');
        }
        return accessValue !== false;
    }
    function memorizeRememberMeState(loginWithEmail) {
        var accessValue = modal.getInnerForm().getInputValue('access');
        z4m.browser.storeLocalData($this.rememberMeLocalStorageKey, accessValue);
        if (accessValue === 'private') {
            let loginName = modal.getInnerForm().getInputValue('login_name');
            z4m.browser.storeLocalData($this.loginNameStorageKey, loginName);
        } else {
            z4m.browser.removeLocalData($this.loginNameStorageKey);
        }
        z4m.browser.storeLocalData($this.loginWithEmailStorageKey, loginWithEmail);
    }
    function handleForgotPasswordClick() {
        modal.getInnerForm(true).find('.zdk-forgot-pwd').off('click.z4m')
                .one('click.z4m', function(event) {
            z4m.ajax.loadView('forgotpassword', $('body'), function() {
                modal.close();
                var resetPwdModal = z4m.modal.make('#mzdk_forgot_password_dialog');
                resetPwdModal.open(onSubmit, onCloseModal);
                function onSubmit(response) {
                    resetPwdModal.close();
                    z4m.messages.notify(response.summary, response.msg, null, function(){
                        $this.cancelLogin(modal);
                    });
                    return false;
                }
                function onCloseModal() {
                    $this.cancelLogin(modal);
                }
            });
            event.preventDefault();
        }).removeClass(z4m.hideClass);
    }
};

/**
 * Removes if exists, the 'login' param from the query string of the URL.
 */
z4m.authentication.removeLoginParamFromUrl = function() {
    const url = new URL(document.location.href);
    const params = new URLSearchParams(url.search);
    params.delete(this.urlLoginParamName);
    url.search = params.toString();
    history.replaceState({}, '', url.toString());
};

/**
 * Disconnect the connected user
 */
z4m.authentication.disconnect = function () {
    var $this = this;
    z4m.ajax.request({
        control: 'security',
        action: 'logout',
        callback: function (response) {
            $this.setNoConnectionState(response.msg);
            // No longer confirmation message on application reload or close
            z4m.browser.events.detachBeforeUnload();
        }
    });
};

/**
 * Cancel le login process and close the login form
 * @param {Object} modal The modal dialog object of the login form
 */
z4m.authentication.cancelLogin = function (modal) {
    var $this = this;
    z4m.ajax.request({
        control: 'security',
        action: 'cancellogin',
        callback: function (response) {
            $this.setNoConnectionState(response.msg);
            modal.close();
        }
    });
};

/**
 * Change the display of the application in the case of a user who is no longer
 * connected
 * @param {String} message Message to display in the view container to notify
 * the user that is no longer connected to the application
 */
z4m.authentication.setNoConnectionState = function (message) {
    /* Connection area in header is hidden */
    z4m.header.hideConnectionArea(true);
    /* Installation message is hidden */
    z4m.install.hideInstallableMessage();
    /* Custom messages are all removed */
    z4m.messages.removeAll();
    /* Navigation menus are hidden */
    z4m.navigation.setNoNavigation();
    /* The page content top spacing is adjusted */
    z4m.content.setTopSpacing();
    /* The Action buttons are hidden */
    z4m.action.hide();
    /* Display of the disconnection confirmation message */
    z4m.content.setHtml(message);
    /* The page content is displayed if hidden */
    z4m.content.showContainer();
};


//************************* NAVIGATION PUBLIC METHODS **************************

/**
 * Get the menu definition of the application as a jQuery element
 * @returns {jQuery} The menu element
 */
z4m.navigation.getMenuDefinition = function () {
    return $(this.menuDefinitionId);
};

/**
 * Get the vertical menu element as a jQuery element
 * @returns {jQuery} The vertical menu element
 */
z4m.navigation.getVerticalMenu = function () {
    return $(this.verticalMenuId);
};

/**
 * Get the horizontal menu element as a jQuery element
 * @returns {jQuery} The horizontal menu
 */
z4m.navigation.getHorizontalMenu = function () {
    return $(this.horizontalMenuId);
};

/**
 * Get the vertical menu width
 * @returns {float} The vertical menu width in pixels
 */
z4m.navigation.getVerticalMenuWidth = function () {
    return this.getMenuDefinition().width();
};

/**
 * Returns the identifier of the specified menu item element
 * @param {jQuery} menuElement Menu item element as jQuery element
 * @returns {String|null} The menu item identifier or null if the specified menu
 * item is not valid.
 */
z4m.navigation.getMenuItemId = function(menuElement) {
    if (menuElement instanceof jQuery && menuElement.length === 1) {
        var splittedID = (menuElement.attr('id')).split("-"),
            menuItemId = '';
        for (var i=1; i < splittedID.length-1; i++) {
            menuItemId += (menuItemId.length > 0 ? '-' : '') + splittedID[i];
        }
        return menuItemId;
    }
    return null;
};

/**
 * Returns the ID of the first menu item.
 * @param {jQuery} parent Optional, the parent menu item (level one)
 * @returns {String|false} The menu item ID found of false if not found.
 */
z4m.navigation.getFirstChildMenuItemId = function(parent) {
    function _getFirstChildMenuItem(parent) {
        if (parent === undefined) {
            parent = $this.getMenuDefinition().find('ul > li').first();
        }
        if (parent.length) {
            var child = parent.find('ul>li').first();
            if (child.length) {
                return _getFirstChildMenuItem(child);
            } else {
                return parent;
            }
        } else {
            return false;
        }
    }
    var $this = this, item = _getFirstChildMenuItem(parent);
    if (item === false) {
        return false;
    }
    return this.getMenuItemId(item);
};

/**
 * Build the navigation menu of the application from its menu definition
 * loaded into the main HTML page
 * @returns {Boolean} Value true when menu building succeeded. Returns false
 * when the application is configured with CFG_VIEW_PAGE_RELOAD = TRUE (see
 * config.php script) and a HTTP 404 Error occured (view unknown).
 */
z4m.navigation.build = function () {
    var $this = this;
    // Extra initialization
    _hideSubItems();
    _addW3cssClassesToMenu();
    _displayMenuIcons();
    _showMenu(); // Menu is initialy hidden for preventing FOUC effect
    z4m.content.showContainer();// The view container is displayed (hidden when main page is loaded)

    // Display the initial view once the main page is loaded according to the
    // CFG_VIEW_PAGE_RELOAD parameter value:
    // If FALSE, the view matching the first menu item is displayed
    // If TRUE, the embedded view into the main page is shown
    if (_displayInitialView() === false) { //CFG_VIEW_PAGE_RELOAD === TRUE && HTTP Error 404
        // The page content top spacing is adjusted
        z4m.content.setTopSpacing();
        return false;
    }
    // Bind events
    _bindEvents();

    return true;

    // Internal private functions
    function _hideSubItems() {
        $this.getMenuDefinition().find('li.has-sub > ul').hide();
    }
    function _addW3cssClassesToMenu() {
        $this.getMenuDefinition().find('a').addClass($this.verticalMenuItemClasses);
    }
    function _displayMenuIcons() {
        $this.getMenuDefinition().find('li > a').each(function () {
            var icon = $(this).data('icon');
            if (typeof icon === 'string') {
                const iconEl = $($this.menuIconTemplate);
                iconEl.addClass(icon);
                $(this).prepend(iconEl);
            }
        });
    }
    function _showMenu() {
        $this.getMenuDefinition().css('display', 'block');
    }
    function _bindEvents() {
        // Click on the vertical menu button
        z4m.header.getMenuButton().on('click.z4m', function (event) {
            $this.openVerticalMenu();
            event.preventDefault();
        });
        // Click on the vertical menu close button
        $this.getVerticalMenu().find('button.close').on('click.z4m', function () {
            $this.closeVerticalMenu();
        });
        // Click on the company logo
        $($this.companyLogoId).on('click.z4m', function (event) {
            if (!$this.isPageToBeReloaded()) {
                _displayInitialView();
                event.preventDefault();
            }
        });
        // Click on a vertical menu item
        $this.getMenuDefinition().on('click.z4m_navigation', 'a', function (event) {
            var menuItemId = $(this).next('ul').length === 0
                    ? $this.getMenuItemId($(this).parent()) // No subitem
                    : $this.getFirstChildMenuItemId($(this).parent()); // Subitems exist
            _displayView(menuItemId);
            event.preventDefault();
        });
        // Click on a horizontal menu item
        $this.getHorizontalMenu().on('click.z4m_navigation', 'a', function (event) {
            // Handled only if click on a hyperlink
            var menuItemId = $(this).data('view_id');
            _displayView(menuItemId);
            event.preventDefault();
        });
        // Display view sent event
        $('body').on('displayview.z4m_navigation', function (event, viewID, anchor, reload) {
            _displayView(viewID, anchor, reload);
        });
    }
    function _displayInitialView() {
        if ($this.getMenuDefinition().length === 0) {
            // Menu is missing (404 HTTP error)
            return false;
        }
        if ($this.isPageToBeReloaded()) {
            // The view already exists into the main page
            _displayPreloadedView();
        } else {
            // The view is loaded by AJAX request
            _displayView();
        }
        function _displayPreloadedView() {
            var innerViewId = z4m.content.getPreloadedViewId(),
                    item = _getMenuItem(innerViewId),
                    itemId = $this.getMenuItemId(item);
            if (innerViewId !== itemId) {
                innerViewId = itemId;
            }
            if (_initHorizontalMenu(item) === false) {
                return false;
            }
            // The menu items are activated in the vertical and horizontal menus
            _setVerticalMenuItemActive(innerViewId);
            _setHorizontalItemActive(innerViewId);
            // The page content top spacing is adjusted
            z4m.content.setTopSpacing();
            // If an anchor is set into the URL, the page is scroll to the anchor
            z4m.content.goToAnchor();
        }
    }
    function _displayView(viewID, anchor, reload) {
        var noViewSpecified = viewID === undefined,
                menuItemId = noViewSpecified ? $this.getFirstChildMenuItemId() : viewID,
                containerID = _getViewContainerID(menuItemId),
                containerElement = $('#' + containerID),
                containerExists = (containerElement.length > 0),
                menuItemElement = _getMenuItem(menuItemId);
        if (menuItemElement === false) {
            z4m.log.error("The view ID = '" + viewID + "' is unknown!");
            return false;
        }
        if ($this.isPageToBeReloaded()) { /* Page reload */
            // The page is reloaded to be replaced by the one matching the new view ID
            // If an anchor is specified, it is added at the end of the URI
            var uriAnchor = anchor === undefined ? '' : '#' + anchor;
            location.assign(menuItemElement.children('a').first().attr('href') + uriAnchor);
            return;
        }
        if (!noViewSpecified) {
            z4m.install.hideInstallableMessage();
        }
        if (containerExists && (reload === true
                || containerElement.find('.' + $this.autoReloadViewClass).length === 1)) {
            // The view is removed first
            containerElement.remove();
            containerExists = false;
        }
        if (containerExists) {
            // View container already exists...
            _showView(menuItemId, anchor);
        } else {
            // View container does not yet exist...
            containerElement = $('<div id="' + containerID + '" class="zdk-view"/>');
            _getViewsContainer().prepend(containerElement);
            containerElement.hide();
            z4m.ajax.loadView(menuItemId, containerElement, function () {
                _showView(menuItemId, anchor);
            });
        }
        function _showView(viewID, anchor) {
            var viewElement = $('#' + _getViewContainerID(viewID)),
                    viewIsVisible = viewElement.is(':visible'),
                    displayedView = _getViewsContainer().children(".zdk-view").filter(":visible");
            $this.events.triggerBeforeViewDisplay(viewID);
            if (!viewIsVisible && displayedView.length >= 1) {
                // The current displayed view is first hidden if it is not yet
                // the view to display
                displayedView.fadeOut(200);
                displayedView.promise().done(function () {
                    showObj();
                });
            } else {
                showObj();
            }
            function showObj() {
                _initHorizontalMenu(_getMenuItem(viewID)); // Horizontal menu initialized
                _setHorizontalItemActive(viewID); // Horizontal menu item set active
                _setVerticalMenuItemActive(viewID); // Vertical menu item set active
                z4m.browser.addLabelToTitle(// Menu item label displayed as browser tab label
                        _getMenuItemLabel(menuItemId));
                z4m.form.events.handleAllInvalid(viewElement.find('form'));// Form Input Invalid events
                if (!viewIsVisible) {
                    // The view is displayed if it is not already displayed
                    viewElement.fadeIn(200, function () {
                        $this.events.triggerAfterViewDisplay(viewID);
                        z4m.content.goToAnchor(anchor); // The view is positionned on the anchor
                    });
                } else {
                    $this.events.triggerAfterViewDisplay(viewID);
                    z4m.content.goToAnchor(anchor); // The view is positionned on the anchor
                }
                function _getMenuItemLabel(viewID) {
                    return _getMenuItem(viewID).children("a").text();
                }
            }
        }
    }
    function _initHorizontalMenu(verticalMenuItem) {
        if (verticalMenuItem === false) {
            return false;
        }
        if (_isRootMenuItem(verticalMenuItem)) {
            _addItemToHorizontalMenu(verticalMenuItem, true);
        } else {
            _addSubItemsToHorizontalMenu(verticalMenuItem.parent('ul'));
        }
        /* The page content top spacing is adjusted */
        z4m.content.setTopSpacing();
        return true;
        function _isRootMenuItem(menuElement) {
            var rootItem = _getRootMenuItem(menuElement);
            return rootItem === menuElement;
        }
    }
    function _getRootMenuItem(menuElement) {
        var result = menuElement;
        menuElement.parentsUntil($this.getMenuDefinition()).filter('li').each(function () {
            if ($(this).parentsUntil($this.getMenuDefinition()).filter('li').length === 0) {
                result = $(this);
                return false;
            }
        });
        return result;
    }
    function _getMenuItem(viewID) {
        var menuItem = $this.getMenuDefinition().find('ul > li[id=znetdk-' + viewID + '-menu]');
        if (menuItem.length === 0) {
            menuItem = $this.getMenuDefinition().find('ul > li.is-selected');
        }
        return menuItem.length === 1 ? menuItem : false;
    }
    function _setVerticalMenuItemActive(viewID) {
        var menuItem = _getMenuItem(viewID);
        _resetMenuItemActive();
        _getRootMenuItem(menuItem).addClass($this.activeMenuItemClass)
            .addClass('is-active');
        function _resetMenuItemActive() {
            $this.getMenuDefinition().find('li.' + $this.activeMenuItemClass)
                .removeClass($this.activeMenuItemClass)
                .removeClass('is-active');
        }
    }
    function _setHorizontalItemActive(viewID) {
        var menuItem = null;
        if (viewID === undefined) {
            menuItem = $this.getHorizontalMenu().find('.items a:first');
        } else {
            _resetTabItemActive();
            menuItem = $this.getHorizontalMenu().find('.items a[data-view_id=' + viewID + ']');
            if (menuItem.length === 0) {
                z4m.log.error("Horizontal tab menu: view ID='" + viewID + "' unknown.");
            }
        }
        menuItem.addClass($this.activeMenuItemClass).addClass('is-active');
        function _resetTabItemActive() {
            $this.getHorizontalMenu().find('.items .menu-item')
                .removeClass($this.activeMenuItemClass).removeClass('is-active');
        }
    }
    function _addItemToHorizontalMenu(menuItem, onlyOne) {
        var tabmenu = $this.getHorizontalMenu(),
                link = menuItem.children('a'),
                icon = link.data('icon'),
                label = link.text(),
                newItem = tabmenu.find('template').contents().filter('a').clone();
        if (icon === undefined) {
            newItem.find('i').remove(); // No icon set
        } else {
            newItem.find('i').addClass(icon); // Icon exists
        }
        if ($this.isPageToBeReloaded) {
            newItem.attr('href', link.attr('href'));
        }
        newItem.find('span').text(label);
        newItem.attr('data-view_id', $this.getMenuItemId(menuItem));
        if (onlyOne === true) {
            tabmenu.find('.items').empty();
        }
        tabmenu.find('.items').append(newItem);
    }
    /**
     * Display the tab menu from the clicked side nav menu item
     * @param {jQuery} parentItem Parent UL element of the side nav menu
     * containing the submenu definition.
     */
    function _addSubItemsToHorizontalMenu(parentItem) {
        var tabmenu = $this.getHorizontalMenu();
        tabmenu.find('.items').empty();
        parentItem.find('>li').each(function () {
            _addItemToHorizontalMenu($(this));
        });
    }
    function _getViewContainerID(viewID) {
        return 'znetdk-' + viewID + '-view';
    }
    function _getViewsContainer() {
        var container = z4m.content.getContainer();
        return container.length ? container : $('body');
    }
}
;

/**
 * Returns true when the application is configured (CFG_VIEW_PAGE_RELOAD = TRUE)
 * to force the main application page to be reloaded each time a new view is
 * displayed.
 * @returns {boolean} true if the main page is to reload for each view displayed,
 * false otherwise.
 */
z4m.navigation.isPageToBeReloaded = function () {
    return z4m.navigation.getMenuDefinition().hasClass('zdk-pagereload');
};

/**
 * Hide the vertical and horizontal menus of the application
 */
z4m.navigation.setNoNavigation = function () {
    $('main').css('margin-left', '0');
    this.getVerticalMenu().css('visibility', 'hidden');
    this.getHorizontalMenu().css('visibility', 'hidden');
    z4m.header.getMenuButton().css('visibility', 'hidden');
};

/**
 * Show the vertical menu
 */
z4m.navigation.openVerticalMenu = function () {
    this.getVerticalMenu().show();
};

/**
 * Hide the vertical menu
 */
z4m.navigation.closeVerticalMenu = function () {
    this.getVerticalMenu().hide();
};

/**
 * Display on the right of the horizontal menu item label, the count of rows
 * displayed into the view's list
 * @param {integer} rowCount The number of rows
 * @param {String} viewId The ID of the view
 * @returns {Boolean} Value true when succeeded, false when the view ID does not
 * match any view loaded into the view container
 */
z4m.navigation.addRowCountToHorizontalMenuItem = function (rowCount, viewId) {
    var menuItem = this.getHorizontalMenu().find('.items a[data-view_id=' + viewId + ']');
    if (menuItem.length === 0) {
        z4m.log.error('Unable to get the horizontal menu item for the displayed view!');
        return false;
    }
    if (menuItem.find('span.row-count').length === 0) {
        menuItem.find('span').last().after('<span class="row-count"/>');
    }
    menuItem.find('span.row-count').text(' (' + rowCount + ')');
    /* The page content top spacing is adjusted */
    z4m.content.setTopSpacing();
    return true;
};

/**
 * Clear the row count displayed on the right of the horizontal menu item label.
 * @param {String} viewId The ID of the view
 * @returns {Boolean} Value true when succeeded, false when the view ID does not
 * match any view loaded into the view container
 */
z4m.navigation.clearRowCountFromHorizontalMenuItem = function (viewId) {
    var menuItem = this.getHorizontalMenu().find('.items a[data-view_id=' + viewId + ']');
    if (menuItem.length === 0) {
        z4m.log.error('Unable to get the horizontal menu item for the displayed view!');
        return false;
    }
    menuItem.find('span.row-count').remove();
    /* The page content top spacing is adjusted */
    z4m.content.setTopSpacing();
    return true;
};

/**
 * Trigger the 'beforeviewdisplay' event just before displaying the specified
 * view
 * @param {String} viewId The ID of the view
 */
z4m.navigation.events.triggerBeforeViewDisplay = function (viewId) {
    /* Action buttons are temporarily hidden */
    z4m.action.hide();
    /* The page content top spacing is adjusted */
    z4m.content.setTopSpacing();
    /* Custom event is triggered */
    $('body').trigger(z4m.navigation.events.beforeViewDisplayName, [viewId]);
};

/**
 * Trigger the 'afterviewdisplay' event just after displaying the specified
 * view
 * @param {String} viewId The ID of the view
 */
z4m.navigation.events.triggerAfterViewDisplay = function (viewId) {
    /* The sidebar is hidden after clicking on an item menu and the page scrolled up */
    z4m.navigation.closeVerticalMenu();
    /* Action buttons are adjusted */
    z4m.action.adjustPosition();
    /* Custom event is triggered */
    $('body').trigger(z4m.navigation.events.afterViewDisplayName, [viewId]);
};


//*************************** MODAL PUBLIC METHODS *****************************

/**
 * Instantiate the modal dialog from the specified element.
 * @param {String|jQuery} modalElementSelector The string selector of the modal
 * (i.e '#my-modal') or a jQuery element of the modal.
 * @param {String} viewName Optional, the name of the view containing the modal
 * dialog. If the modal dialog does not exist in the DOM, the given view name is
 * loaded to add the modal dialog in the DOM.
 * @param {function} onViewLoaded Optional, when the viewName is specified, this
 * function is called back once the view is loaded if the modal does not yet
 * exist in the DOM. If the modal already exists, the function is directly
 * called. The this object of this callback function is the modal object.
 * @returns {modalObject|null} The modal object or null if the specified element
 * is invalid or if the viewName and onViewLoaded are specified as parameter of
 * the function.
 */
z4m.modal.make = function (modalElementSelector, viewName, onViewLoaded) {
    var modalElement = modalElementSelector instanceof jQuery
            ? modalElementSelector : $(modalElementSelector);
    if (typeof modalElementSelector === 'string' && modalElement.length === 0
            && typeof viewName === 'string' && viewName.length > 0
            && typeof onViewLoaded === 'function') {
        z4m.ajax.loadView(viewName, $('body'), function(){
            onViewLoaded.call(getNewObject($(modalElementSelector)));
        });
        return null;
    }
    if (modalElement.length !== 1) {
        z4m.log.error('Modal element is empty or multiple!');
        return null;
    }
    if (!modalElement.hasClass(this.cssClass)) {
        z4m.log.error('Modal CSS class missing!', modalElement);
        return null;
    }
    if (typeof onViewLoaded === 'function') {
        onViewLoaded.call(getNewObject(modalElement));
        return null;
    }
    return getNewObject(modalElement);
    // Returns new modal Object
    function getNewObject(modalElement) {
        var modalObject = Object.create(z4m.modal);
        modalObject.element = modalElement;
        z4m.form.events.handleAllInvalid(modalElement.find('form'));// Form Input Invalid events
        return modalObject;
    }
};

/**
 * Returns the form of the modal.
 * If more than one form exist, only the first one is returned.
 * @param {Boolean} asJqueryElement If true, the form is return as a jQuery
 *  element. Otherwise, the form is returned as a z4m object.
 * @param {String} selectorClass Optional CSS class of the form if multiple
 *  forms exist within the modal (for example 'my-form').
 * @returns {z4m.form|jQuery|Boolean} The form of the modal by default
 * as a z4m object or as a jQuery element. Returns false if no form
 * exists or if more than one form exist.
 */
z4m.modal.getInnerForm = function (asJqueryElement, selectorClass) {
    var form = this.element.find('form'
        + (typeof selectorClass === 'string' ? '.' + selectorClass : '')
    );
    if (form.length === 0) {
        return false;
    } else if (form.length > 1) {
        form = form.first();
    }
    return asJqueryElement === true ? form : z4m.form.make(form);
};

/**
 * Display the modal dialog
 * @param {function} onSubmit The function to callback when clicking on the
 * inner form submit button. If this callback function returns false, the modal
 * dialog is not closed once submit succeeded.
 * @param {function} onClose The function to callback when closing the modal
 * dialog. If this callback function returns false, the modal dialog is not
 * automatically closed.
 * @param {String} focusedInputName The name of the inner form input element
 * for which the keyboard focus is set
 * @returns {Boolean} Value true when it is opened successfully, false otherwise
 */
z4m.modal.open = function (onSubmit, onClose, focusedInputName) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('Modal is not instantiated!');
        return false;
    }
    if (this.element.triggerHandler(this.events.beforeOpenName, [this]) === false) {
        return false;
    }
    _registerCloseCallback(this, onClose);
    this.element.show();
    _initForm(this, onSubmit);
    this.element.trigger(this.events.afterOpenName, [this]);
    return true;
    // Private functions
    function _registerCloseCallback(modalObject, closeCallback) {
        if (typeof closeCallback !== 'function') {
            return false;
        }
        var eventName = modalObject.events.beforeUiModalCloseNane + '.z4m_modal';
        modalObject.element.off(eventName);
        modalObject.element.on(eventName, function () {
            return closeCallback();
        });
    }
    function _initForm(modalObject, submitCallback) {
        var form = modalObject.getInnerForm(true);
        if (form === false) {
            return false;
        }
        var formObject = z4m.form.make(form, function (response) {
            var returnedValue = typeof submitCallback === 'function'
                    ? submitCallback(response) : true;
            if (returnedValue !== false && response.success === true
                    && modalObject.closeOnSubmitSuccess === true) {
                modalObject.close();
            }
            return returnedValue;
        });
        if (formObject.doesInputExist(focusedInputName)) {
            formObject.setFocus(focusedInputName);
        } else {
            formObject.setFocusOnFirstInput();
        }
    }

};

/**
 * Close the modal dialog
 * @param {Boolean|undefined} checkDataFormsModified When set to true,
 * check if the inner input form data are modified before closing.
 * If so, a confirmation message is displayed before.
 * @returns {Boolean} Value true if modal is closed, false otherwise
 */
z4m.modal.close = function (checkDataFormsModified) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('Modal is not instantiated!');
        return false;
    }
    if (this.element.triggerHandler(this.events.beforeCloseName, [this]) === false) {
        return false;
    }
    var modalElement = this.element, $this = this;
    _areDataFormsModified(function(){
        modalElement.hide();
        modalElement.trigger(z4m.modal.events.afterCloseName, [$this]);
    });
    return true;
    function _areDataFormsModified(callback) {
        if (checkDataFormsModified === false || checkDataFormsModified === undefined) {
            return callback(); // No checking
        }
        var isModified = false;
        modalElement.find('form[data-zdk-submit]').each(function(){
            var formObject = z4m.form.make($(this));
            if (formObject.isModified()) {
                isModified = true;
                return false; // Break the loop
            }
        });
        if (!isModified) {
            return callback(); // No data modified into the forms
        }
        z4m.messages.ask(modalElement.find('button.cancel').text(),
            null, null, function(isYes){
            if (isYes) {
                callback(); // User ignores changes
            }
        });
    }
};

/**
 * Set the title of the modal dialog
 * @param {String} title The title to display into the dialog title bar
 * @returns {Boolean} Value when succeeded, false otherwise
 */
z4m.modal.setTitle = function (title) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('Modal is not instantiated!');
        return false;
    }
    var titleElement = this.element.find('header .title');
    if (titleElement.length === 1) {
        titleElement.html(title);
        return true;
    }
    return false;
};

/**
 * Handle Click events on the modal close buttons and then close the modal.
 * Modal can also be closed by typing the ESC key.
 */
z4m.modal.events.handleAllClose = function () {
    var modalClass = '.' + z4m.modal.cssClass,
            selector = modalClass + ' span.close, '
            + modalClass + ' a.close, '
            + modalClass + ' button.cancel';
    $('body').on('click.z4m_modal', selector, function () {
        var modalObject = z4m.modal.make($(this).closest(modalClass));
        if (modalObject !== null
                && modalObject.events.triggerBeforeClose.call(modalObject) !== false) {
            modalObject.close(true);
        }
    });
    $(document).on('keydown.z4m_modal', function(event){
        let modalEl = event.target.closest('.' + z4m.modal.cssClass);
        modalEl = modalEl === null ? $('.' + z4m.modal.cssClass + ':visible') : $(modalEl);
        if (modalEl.length === 1 && event.key === 'Escape') {
            modalEl.find('header .close').trigger('click');
        }
    });
};

/**
 * Trigger the before close event when a modal dialog is closed
 * @returns {Boolean}
 */
z4m.modal.events.triggerBeforeClose = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('Modal is not instantiated!');
        return null;
    }
    var status = this.element.triggerHandler(this.events.beforeUiModalCloseNane);
    return status !== false;
};

//*************************** FORM PUBLIC METHODS ******************************

/**
 * Instantiate a new form object from the specified HTML form element.
 * @param {String|jQuery} formElementSelector The form element as a jQuery
 * element or a string for selecting a HTML form
 * @param {function} submitCallback A function to call back when the submit
 * button is pressed
 * @returns {Object} The form object
 */
z4m.form.make = function (formElementSelector, submitCallback) {
    var formElement = formElementSelector instanceof jQuery
            ? formElementSelector : $(formElementSelector);
    if (formElement.length !== 1) {
        z4m.log.error('Form element is empty or multiple!');
        return null;
    }
    if (!formElement.is('form')) {
        z4m.log.error('Not a form element!', formElement);
        return null;
    }
    var formObject = Object.create(this);
    formObject.element = formElement;
    z4m.ajax.initControllerActionProperties('submit', formObject);
    z4m.ajax.initControllerActionProperties('load', formObject);
    formObject.inputData = new FormData(formElement[0]);
    _registerSubmitCallback(submitCallback);
    return formObject;

    function _registerSubmitCallback(submitCallback) {
        if (typeof submitCallback !== 'function') {
            return false;
        }
        var eventName = formObject.events.afterSubmitSuccessName + '.z4m_form';
        formElement.off(eventName);
        formElement.on(eventName, function (event, response) {
            return submitCallback(response);
        });
    }
};

/**
 * Check if form is instantiated
 * @returns {Boolean} true if instantiated, false otherwise
 */
z4m.form.isInstance = function() {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('Form is not instantiated!');
        return false;
    }
    return true;
};

/**
 * Set the focus on the first input field into the form
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.setFocusOnFirstInput = function () {
    if (!this.isInstance()) return false;
    var selector = 'textarea:visible:not([disabled]):not([readonly])'
        + ',select:visible:not([disabled]):not([readonly])'
        + ',input:visible:not([disabled]):not([readonly])',
        focusedElement = this.element.find(selector).first();
    if (focusedElement.length === 1) {
        focusedElement.trigger('focus');
        return true;
    }
    return false;
};

/**
 * Set the focus on the specified input field
 * @param {String} inputName Name of input field ('name' HTML attribute)
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.setFocus = function (inputName) {
    if (!this.isInstance()) return false;
    if (typeof inputName === 'string') {
        var focusedElement = this.element.find('[name="' + inputName + '"]');
        if (focusedElement.length > 0) {// Multiple inputs accepted (case of radio buttons)
            focusedElement.focus().select();
            return true;
        }
    }
    return false;
};

/**
 * Set the modified data state of a form
 * @param {Boolean} isModified If true, the form data are set modified.
 *  Otherwise the form data are set not modified.
 * @returns {Boolean} Value true on success. False if the parameter is not a
 * boolean value.
 */
z4m.form.setDataModifiedState = function (isModified) {
    if (!this.isInstance()) return false;
    if (typeof isModified !== 'boolean') {
        return false;
    }
    this.element.data('is-modified', isModified ? 'y' : 'n');
    if (isModified) {
        z4m.browser.events.handleBeforeUnload();
    } else {
        z4m.browser.events.detachBeforeUnload();
    }
    return true;
};

/**
 * Indicates whether the form data are modified by the user
 * @returns {Boolean} Value true if the form data are modified by the user
 */
z4m.form.isModified = function() {
    if (!this.isInstance()) return false;
    return this.element.data('is-modified') === 'y';
};

/**
 * Reset the form by clearing the input fields and hidding the displayed error
 * message.
 * The hidden input fields are also reset.
 * @returns {Boolean} Value true when the input form is reset, false otherwise.
 */
z4m.form.reset = function () {
    if (!this.isInstance()) return false;
    this.hideError();
    this.hideInfo();
    this.element[0].reset();
    // Hidden fields are also reset
    this.element.find('input[type=hidden]').val('');
    // The form data state is set to not modified
    this.setDataModifiedState(false);
    return true;
};

/**
 * Initialize the data form from the specified value object
 * @param {Object} valueObject A Javascript object having properties named
 * as each input field name of the form
 * @param {Boolean} isFormResetBefore When set to true or undefined, the form
 * values are cleared before initialization.
 * @returns {Boolean} Value true if initialization succeeded.
 */
z4m.form.init = function (valueObject, isFormResetBefore) {
    if (valueObject === null || typeof valueObject !== 'object') {
        z4m.log.error('Not a value object!');
        return false;
    }
    if (Object.keys(valueObject).length === 0) {
        z4m.log.error('The value object is empty!');
        return false;
    }
    if (!this.isInstance()) return false;
    if (isFormResetBefore === undefined || isFormResetBefore === true) {
        this.reset();
    }
    for (var inputName in valueObject) {
        this.setInputValue(inputName, valueObject[inputName], true);
    }
    return true;
};

/**
 * Load the form data from the specified ID and the remote controller
 * action specified through the 'data-zdk-load' HTML attribute
 * @param {string} id Identifier of the data to load into the form
 * @param {function} callback The callback function to execute once the data
 * are loaded in the form
 * @returns {Boolean} Value true if the 'data-zdk-load' is defined, false
 * otherwise
 */
z4m.form.load = function (id, callback) {
    if (!this.isInstance()) return false;
    if (!this.hasOwnProperty('remoteActions')
            || !this.remoteActions.hasOwnProperty('load')
            || !this.remoteActions.load.hasOwnProperty('controller')
            || !this.remoteActions.load.hasOwnProperty('action')
            || typeof this.remoteActions.load.controller !== 'string'
            || typeof this.remoteActions.load.action !== 'string') {
        z4m.log.error('The data loading controller action is not properly set!');
        return false;
    }
    var $this = this;
    z4m.ajax.request({
        control: this.remoteActions.load.controller,
        action: this.remoteActions.load.action,
        data: {id: id},
        callback: function (response) {
            if ($this.init(response) && typeof callback === 'function') {
                callback(response);
            }
        }
    });
    return true;
};

/**
 * Display an info message on the top of the form
 * @param {String} msg The info message
 * @param {Boolean} isWarn If true, the message is displayed as a warning
 * @param {Boolean} hidePrevInfos If true, the previous displayed infos are
 * hidden
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.showInfo = function (msg, isWarn, hidePrevInfos) {
    if (!this.isInstance()) return false;
    if (hidePrevInfos === true) {
        this.hideInfo();
    }
    const newEl = $(this.messageTemplate);
    newEl.addClass(isWarn ? ['z4m-warn', z4m.messages.colors.warn]
        :['z4m-info', z4m.messages.colors.info]);
    newEl.find('.icon').addClass(isWarn ? z4m.messages.icons.warn
        : z4m.messages.icons.info);
    newEl.find('.msg').html(msg);
    this.element.prepend(newEl);
    this.element[0].scrollIntoView();
    return true;
};

/**
 * Hide the info message currently displayed into the form
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.hideInfo = function () {
    if (!this.isInstance()) return false;
    this.element.find('div.z4m-info, div.z4m-warn').remove();
    return true;
};

/**
 * Display an error message on the top of the form or directly on the entry
 * field (input, textarea and select) if inputName is specified (call of
 * setCustomValidity() method).
 * @param {String} message The error message
 * @param {String} inputName The name of the input on which the focus is set (in
 * option). When multiple inputs exist with the same name, the position of the
 * input can be indicated after the input name (for example 'my_input:5').
 * @param {Boolean} hidePrevErrors If true, the previous displayed errors are
 * hidden
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.showError = function (message, inputName, hidePrevErrors) {
    if (!this.isInstance()) return false;
    if (hidePrevErrors === true) {
        this.hideError();
    }
    let inputFound = [], pos;
    if (typeof inputName === 'string') {
        const withPos = inputName.split(':', 2);
        pos = withPos.length === 2 && !isNaN(parseInt(withPos[1],10))
            ? parseInt(withPos[1],10) : null;
        inputFound = this.element.find('[name="' + withPos[0] + '"]');
    }
    if (inputFound.length > 0) {
        if (pos === null) {
            this.setFocus(inputName);
        } else {
            inputFound = inputFound.eq(pos);
            inputFound.focus().select();
        }
        this.setLastInputInError(inputFound, message);
    } else {
        const newEl = $(this.messageTemplate);
        newEl.addClass(['alert', z4m.messages.colors.error]);
        newEl.find('.icon').addClass(z4m.messages.icons.error);
        newEl.find('.msg').html(message);
        this.element.prepend(newEl);
        this.element[0].scrollIntoView();
    }
    return true;
};

/**
 * Hide the error message currently displayed into the form
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.hideError = function () {
    if (!this.isInstance()) return false;
    this.unsetLastInputInError();
    this.element.find('div.alert').remove();
    return true;
};

/**
 * Set the last input in error by adding the input in error CSS class.
 * @param {jQuery} inputEl Input field element (input, textarea or select) as
 * jQuery object
 * @param {string} errorMessage In option, the text of the error message to
 * display for the input in error
 * @returns {Boolean} Returns false if the method is called out of an
 * instantiated form object, if the specified input element is not a jQuery
 * element or if an input element is already set in error.
 */
z4m.form.setLastInputInError = function (inputEl, errorMessage) {
    if (!this.isInstance()) return false;
    if (inputEl instanceof jQuery === false) {
        z4m.log.error('Specified input element is invalid!');
        return false;
    }
    if (this.getLastInputInError() !== null) {
        return false; // An input in error is already set
    }
    var $this = this;
    inputEl.addClass(z4m.form.inputInErrorClass);
    if (typeof errorMessage === 'string' && errorMessage.length > 0) {
        inputEl[0].setCustomValidity(getHtmlAsText(errorMessage));
        inputEl[0].reportValidity();
    }
    this.element.on('change.z4m_form_showerror', function(){
        $this.unsetLastInputInError();
    });
    return true;
    function getHtmlAsText(html) {
        var pureText = html.replace('<br>', "\n"),
                tempDiv = $('<div/>');
        tempDiv.html(pureText);
        return tempDiv.text();
    }
};

/**
 * Returns the last input element identified in error
 * @returns {jQuery|Boolean|null} The last input element in error as jQuery
 * Object, null if no input in error is found or false if the form element is
 * not a jQuery object.
 */
z4m.form.getLastInputInError = function () {
    if (!this.isInstance()) return false;
    var lastInputInError = this.element.find('.' + z4m.form.inputInErrorClass);
    if (lastInputInError.length > 0) {
        return lastInputInError;
    }
    return null;
};

/**
 * Clear the last input field in error memorized for a form after it has been
 * submitted.
 * @returns {Boolean} Returns false if the method is called out of an
 * instantiated form object.
 */
z4m.form.unsetLastInputInError = function () {
    if (!this.isInstance()) return false;
    var lastInputInError = this.getLastInputInError();
    if (lastInputInError instanceof jQuery) {
        lastInputInError[0].setCustomValidity('');
        lastInputInError.removeClass(z4m.form.inputInErrorClass);
        this.element.off('change.z4m_form_showerror');
    }
    return true;
};

/**
 * Indicates whether the specified input field exists or not
 * @param {String} inputName Name given to the input through the HTML name
 * attribute
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.doesInputExist = function (inputName) {
    if (!this.isInstance()) return false;
    return typeof inputName === 'string'
            && this.element.find('[name="' + inputName + '"]').length > 0;
};

/**
 * Get the value of the specified input field
 * @param {String} inputName Name of the input
 * @returns {String|Boolean} The value of the input field, false otherwise
 */
z4m.form.getInputValue = function (inputName) {
    if (!this.isInstance()) return false;
    if (typeof inputName !== 'string') {
        z4m.log.error('String type expected for the inputName parameter!');
        return false;
    }
    var inputElement = this.element.find('[name="' + inputName + '"]');
    if (inputElement.length === 0) {
        z4m.log.error("No input found with name='" + inputName + "'!");
        return false;
    }
    if (inputElement.is('input')) {
        if (inputElement.length === 1) {
            var inputTypes = ['text', 'color', 'date', 'datetime-local', 'email',
                'hidden', 'month', 'number', 'password', 'range', 'search', 'tel',
                'time', 'url', 'week'],
                    currentInputType = inputElement.attr('type');
            if (currentInputType === undefined
                    || inputTypes.indexOf(currentInputType) !== -1) {
                return inputElement.val();
            } else if (currentInputType === 'checkbox') {
                return inputElement.is(':checked') ? inputElement.val() : '';
            }
            z4m.log.error("The input type='" + currentInputType + "' is not supported!");
            return false;
        } else { // Multiple input elements with the same name (radio buttons or checkboxes)
            let radioValueFound = null, radioButtonCount = 0, checkedBoxes = [],
                firstInputType = null;
            inputElement.each(function () {
                firstInputType = firstInputType === null ? $(this).attr('type') : firstInputType;
                if ($(this).attr('type') === 'radio' && $(this).prop('checked') === true) {
                    radioValueFound = $(this).val();
                    return false; // break
                }
                if ($(this).attr('type') === 'checkbox' && $(this).prop('checked') === true) {
                    checkedBoxes.push($(this).val());
                }
                if ($(this).attr('type') === 'radio') {
                    radioButtonCount++;
                }
            });
            if (firstInputType === 'radio' && radioValueFound !== null) {
                return radioValueFound;
            } else if (firstInputType === 'radio' && inputElement.length === radioButtonCount) {
                // No radio button is selected
                return radioValueFound;
            } else if (firstInputType === 'checkbox') {
                return checkedBoxes;
            }
            z4m.log.error("The multiple input element with name='" + inputName + "' is not supported!");
            return false;
        }
    }
    if (inputElement.is('select')) {
        if (inputElement.prop('multiple')) {
            let selectedItems = [];
            inputElement.find('option:selected').each(function () {
                selectedItems.push($(this).val());
            });
            return selectedItems;
        }
        return inputElement.val();
    }
    if (inputElement.is('textarea')) {
        return inputElement.val();
    }
    z4m.log.error("The input with name='" + inputName + "' is not supported!");
    return false;
};

/**
 * Set the value of the specified input field
 * @param {String} inputName Name of the input field for which setting the value
 * @param {String|Array} inputValue Value(s) to set to the input field
 * @param {Boolean} silent When set to false, an error is displayed into the
 * browser console if the specified input field not exists
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.setInputValue = function (inputName, inputValue, silent) {
    if (!this.isInstance()) return false;
    if (typeof inputName !== 'string') {
        z4m.log.error('The input name must be a string!');
        return false;
    }
    var inputElement = this.element.find('[name="' + inputName + '"]');
    if (inputElement.length === 0) {
        if (silent !== true) {
            z4m.log.error("No element found in the DOM with the name '" + inputName + "'!");
        }
        return false;
    }
    if (inputElement.is('input')
            && (inputElement.attr('type') === 'radio'
                    || inputElement.attr('type') === 'checkbox')) {
        // RADIO BUTTON OR CHECKBOK
        if (inputValue === '') {
            return false; // Empty value
        }
        var checkedElement = inputElement.filter('[value="' + inputValue + '"]');
        if (checkedElement.length === 1) {
            checkedElement.prop('checked', true);
            return true;
        }
        if (inputElement.attr('type') === 'radio') {
            z4m.log.error("The input element of type '" + inputElement.attr('type')
                    + "' and named '" + inputName
                    + "' does not exist with the value='" + inputValue + "'!");
            return false;
        }
        // CHECKBOX
        inputElement.prop('checked', false); // Forced to unchecked
        if (Array.isArray(inputValue) && inputValue.length > 0) {
            $.each(inputValue, function () {
                var selectedInput = inputElement.filter('[value="' + this + '"]');
                if (selectedInput.length === 1) {
                    selectedInput.prop('checked', true);
                }
            });
        }
        return true;
    } else if (inputElement.is('select') && inputElement.prop('multiple') === true) {
        // SELECT MULTIPLE
        if (!Array.isArray(inputValue)) {
            if (silent !== true) {
                z4m.log.error("The value for the multiple select element with name='"
                        + inputName + "' must be an array!", inputValue);
            }
            return false;
        }
        $.each(inputValue, function () {
            var selectedOption = inputElement.find('option[value="' + this + '"]');
            if (selectedOption.length === 1) {
                selectedOption.prop('selected', true);
            }
        });
        inputElement.scrollTop(0);
        return true;
    } else {
        // OTHERS
        inputElement.val(inputValue);
        return true;
    }
};

/**
 * Set the form readonly
 * @param {Boolean} isReadOnly When set to true, the form values can't be
 *  changed. If set to false, the form values so can be changed.
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.form.setReadOnly = function (isReadOnly) {
    if (!this.isInstance()) return false;
    var readOnlyState = isReadOnly === undefined || isReadOnly === true;
    this.element.find('input:not([type=hidden],[type=radio],[type=checkbox]), textarea').each(function () {
        $(this).prop('readonly', readOnlyState);
    });
    this.element.find('select, input[type=radio],input[type=checkbox]').each(function () {
        $(this).prop('disabled', readOnlyState);
    });
    this.element.find('button[type=submit], input[type=submit]').prop('disabled', readOnlyState);
};

/**
 * Handle the input events of the forms and update their modified data state
 * (see HTML 'data-is-modified' attribute).
 */
z4m.form.events.handleAllInput = function () {
    $('body').on('input.z4m_form_submit', 'form[data-zdk-submit]', function (event) {
        if ($(event.target).is(':input')) {
            var formElement = $(this),
                    formObject = z4m.form.make(formElement);
            formObject.setDataModifiedState(true);
        }
    });
};

/**
 * Handle the invalid events of the inputs in the forms
 * @param {jQuery} formElement Form element as jQuery object
 * @returns {Boolean} true on success
 */
z4m.form.events.handleAllInvalid = function (formElement) {
    if (formElement instanceof jQuery === false) {
        z4m.log.error('Form is not a jQuery object!');
        return false;
    }
    var eventName = 'invalid.z4m_form_invalid';
    formElement.find(':input').off(eventName).on(eventName, function(){
        let formElement = $(this).closest('form'),
            formObject = z4m.form.make(formElement);
        formObject.setLastInputInError($(this));
    });
    return true;
};

/**
 * Handle the submit events of the forms by sending the form data in AJAX when
 * a controller and an action are set through the 'data-zdk-submit' HTML5
 *  attribute.
 */
z4m.form.events.handleAllSubmit = function () {
    $('body').on('submit.z4m_form_submit', 'form[data-zdk-submit]', function (event) {
        if ('submitter' in event.originalEvent) {
            z4m.browser.disableTemporarily($(event.originalEvent.submitter));
        }
        var formElement = $(this),
                formObject = z4m.form.make(formElement);
        z4m.ajax.request({
            control: formObject.remoteActions.submit.controller,
            action: formObject.remoteActions.submit.action,
            data: formObject.inputData,
            callback: function (response) {
                formObject.hideError();
                if (formObject.events.triggerAfterSubmitSuccess.call(formObject, response) === false) {
                    return false;
                }
                if (response.success === false) {
                    formObject.showError(response.msg, response.ename);
                } else if (response.hasOwnProperty('msg') && response.hasOwnProperty('summary')) {
                    var severity = response.hasOwnProperty('success') && response.success ? 'info' : 'error';
                    if (response.hasOwnProperty('warning') && response.warning) {
                        severity = 'warn';
                    }
                    if (response.summary === null) {
                        z4m.messages.showSnackbar(response.msg, response.warning);
                    } else {
                        z4m.messages.add(severity, response.summary, response.msg);
                    }
                }
            },
            errorCallback: function(response) {
                if (response.hasOwnProperty('status') && response.hasOwnProperty('responseJSON')
                        && response.responseJSON.hasOwnProperty('msg')) {
                    const error = (response.responseJSON.hasOwnProperty('summary')
                        ? '<b>' + response.responseJSON.summary + '</b><br>' : '')
                        + response.responseJSON.msg;
                    formObject.showError(error, null, true);
                    return false;
                }
                return true;
            }
        });
        event.preventDefault();
    });
};

/**
 * Trigger the aftersubmitsuccess event when the form data is sent successfully
 * to the remote controller action.
 * @param {type} response The response of the remote controller action
 * @returns {Boolean|null} Value null if form is not instantiated, true or false
 * according to the value returned by the event handler defined by the developer
 */
z4m.form.events.triggerAfterSubmitSuccess = function (response) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('Form is not instantiated!');
        return null;
    }
    var status = this.element.triggerHandler(this.events.afterSubmitSuccessName, [response]);
    return status !== false;
};

/**
 * Handle the click events of the show/hide button on the password input fields
 */
z4m.form.events.handleTogglePassword = function () {
    $('body').on('click.z4m_form_password', 'a.zdk-toggle-password', function (event) {
        var passwordInput = $(this).prev('input'),
                inputType = passwordInput.attr('type');
        if (inputType === 'password') {
            passwordInput.attr('type', 'text');
            $(this).children('i').removeClass(z4m.form.hidePwdIcon).addClass(z4m.form.revealPwdIcon);
        } else if (inputType === 'text') {
            passwordInput.attr('type', 'password');
            $(this).children('i').removeClass(z4m.form.revealPwdIcon).addClass(z4m.form.hidePwdIcon);
        }
        event.preventDefault();
    });
};

//************************** ACTION PUBLIC METHODS *****************************

/**
 * Specify the action buttons to display each time the specified view is
 * displayed and the function to call back when the action button is pressed
 * @param {String} viewId ID of the view
 * @param {Object} options For each button set as property 'add', 'refresh',
 *  'search' and 'scrollup', the sub-properties 'isVisible' (boolean) and
 *  'callback' (function)
 * @returns {Boolean} Value true if the options are set properly and the view
 * exists, false otherwise
 */
z4m.action.registerView = function (viewId, options) {
    if (options === null || typeof options !== 'object') {
        z4m.log.error("The 'options' parameter is not an object!");
    }
    var $this = this,
            isOptionOk = false;
    $.each(options, function (button, properties) {
        if (!$this.buttons.hasOwnProperty(button)
                || !properties.hasOwnProperty('isVisible')
                || typeof properties.isVisible !== 'boolean') {
            isOptionOk = false;
            return false; // break
        }
        isOptionOk = true;
    });
    if (isOptionOk === false) {
        z4m.log.error("The 'option' properties are invalid!");
        return false;
    }
    if (z4m.content.doesViewExistInDom(viewId)) {
        if (!$this.views.hasOwnProperty(viewId)) {
            $this.views[viewId] = {};
        }
        $.each(options, function (button, properties) {
            $this.views[viewId][button] = properties;
        });
        return true;
    }
    z4m.log.error("The view '" + viewId + "' does not exist in the DOM!");
    return false;
};

/**
 * Display the scroll to top action button for the specified view
 * @param {String} viewId ID of the view
 * @returns {Boolean} Value true when the view exists, false otherwise
 */
z4m.action.setScrollUpButtonForView = function (viewId) {
    return this.registerView(viewId, {
        scrollup: {
            isVisible: true,
            callback: function () {
                $("html, body").animate({scrollTop: 0}, 'fast');
            }
        }
    });
};

/**
 * Show or hide the action buttons for the view currently displayed
 * @returns {Boolean} Value true when action buttons are shown or hidden for
 * the view currently displayed, false otherwise
 */
z4m.action.toggle = function () {
    var $this = this, viewId = z4m.content.getDisplayedViewId();
    if (viewId === null) {
        return false;
    }
    if (!this.views.hasOwnProperty(viewId)) {
        this.hide(); // View not registered, action buttons are all hidden
        return false;
    }
    var footerHeight = z4m.footer.getHeight(),
            verticalPos = footerHeight - 10;
    $.each(this.buttons, function (button, properties) {
        if ($this.views[viewId].hasOwnProperty(button)
                && $this.views[viewId][button].isVisible) { // Button is set visible
            // Position is adjusted
            $(properties.id).css({
                bottom: verticalPos,
                right: 5
            });
            verticalPos += $this.buttonGap;
            // Button is shown
            $($this.buttons[button].id).removeClass(z4m.hideClass);
        } else { // Button is set hidden
            $($this.buttons[button].id).addClass(z4m.hideClass);
        }
    });
    return true;
};
/**
 * Hide all the action buttons
 */
z4m.action.hide = function () {
    $.each(this.buttons, function () {
        var buttonId = this.id;
        $(buttonId).addClass(z4m.hideClass);
    });
};

/**
 * Adjust the position of the action buttons
 * @return {Boolean} Value true when action buttons position is adjusted for
 * the view currently displayed, false otherwise
 */
z4m.action.adjustPosition = function () {
    return this.toggle();
};

/**
 * Add a custom action button
 * @param {String} name Name given to the custom button (no space allowed in the
 * name).
 * @param {String} iconCssClass Class name of the icon displayed on the button
 * @param {String} colorCssClass Class name of the color used to display the
 * button
 * @param {String} title Title given to the button for accessibility purpose. If
 * title is not set, the 'name' parameter is used instead.
 * @returns {Boolean} Value true on success, false otherwise
 */
z4m.action.addCustomButton = function (name, iconCssClass, colorCssClass, title) {
    if (name.indexOf(' ') > -1) {
        z4m.log.error("Space characters are not allowed in the button name: '" + name + "'!");
        return false;
    }
    if (this.buttons.hasOwnProperty(name)) {
        z4m.log.error("The '" + name + "' button name already exists!");
        return false;
    }
    var buttonIdPrefix = 'zdk-mobile-action-custom-',
        buttonIdSuffix = 1,
        buttonId = '';
    while ($('#'+buttonIdPrefix+buttonIdSuffix).length > 0) {
        buttonIdSuffix++;
    }
    buttonId = buttonIdPrefix + buttonIdSuffix;
    const buttonTitle = typeof title === 'string' ? title : name;
    const newEl = $(this.buttonTemplateId).contents().filter('a').clone();
    newEl.attr('id', buttonId).attr('aria-label', buttonTitle)
            .addClass([name, colorCssClass]);
    newEl.find('.icon').addClass(iconCssClass).attr('title', buttonTitle);
    $('#zdk-mobile-action-search').after(newEl);
    this.buttons[name] = {id: '#'+buttonId};
    return true;
};

/**
 * Removes the specified custom button.
 * If it is registered for a view then it is unregistered also.
 * @param {string} name Name given to the action button when it has been added
 * through the addCustomButton() method.
 * @returns {Boolean} Value true on success, false if the custom button does not
 * exist for the specified name.
 */
z4m.action.removeCustomButton = function (name) {
    const buttonEl = $('.zdk-mobile-action.' + name),
        viewsFound = [], $this = this;
    if (buttonEl.length === 0) {
        z4m.log.error("The button named '" + name + "' does not exist in the DOM!");
        return false;
    }
    if (buttonEl.attr('id').indexOf('zdk-mobile-action-custom-') === -1) {
        z4m.log.error("The button named '" + name + "' is not a custom button!");
        return false;
    }
    if (!this.buttons.hasOwnProperty(name)) {
        z4m.log.error("The button named '" + name + "' is unknown!");
        return false;
    }
    $.each(this.views, function (view) {
        $.each($this.views[view], function (button) {
            if (button === name) {
                viewsFound.push(view);
            }
        });
    });
    $.each(viewsFound, function() {
        delete $this.views[this][name];
    });
    buttonEl.remove();
    delete this.buttons[name];
    return true;
};

/**
 * Handle the click events of the action buttons and execute the callback
 *  function when an action button is clicked
 */
z4m.action.events.handleClick = function () {
    $('body').on('click.z4m_action', 'a.zdk-mobile-action', function (event) {
        event.preventDefault();
        var viewId = z4m.content.getDisplayedViewId();
        if (viewId === null) {
            z4m.log.error("Unable to identify the ID of the currently displayed view.");
            return false;
        }
        if (!z4m.action.views.hasOwnProperty(viewId)) {
            //View not registered
            z4m.log.error("The view ID='" + viewId + "' is not registered.");
            return false;
        }
        var buttonId = '#' + $(this).attr('id'), buttonKey = null;
        $.each(z4m.action.buttons, function (key, properties) {
            if (properties.id === buttonId) {
                buttonKey = key;
                return false; // Break the loop
            }
        });
        if (buttonKey === null) {
            z4m.log.error("No action button definition found for the ID='" + buttonId + "'!");
            return false;
        }
        if (!z4m.action.views[viewId][buttonKey].hasOwnProperty('callback')) {
            z4m.log.error("No callback function set for the '" + buttonKey + "' button of the view ID='" + viewId + "'.");
            return false;
        }
        // The callback method is executed
        z4m.action.views[viewId][buttonKey].callback();
    });
};

//*************************** LIST PUBLIC METHODS ******************************

/**
 * Instantiate the list object for the specified UL HTML element
 * @param {String} listElementId Identifier ('id' HTML attribute value) of the
 *  UL HTML element
 * @param {Boolean} refresh If true or undefined, the 'refresh' action button
 *  is displayed for refreshing the list content on demand
 * @param {Boolean} search If true or undefined, the 'search' action button is
 * displayed for filtering/sorting the list content
 * @returns {Object|null} The instantiated object for the list
 */
z4m.list.make = function (listElementId, refresh, search) {
    if (typeof listElementId !== 'string') {
        z4m.log.error('List element ID is not a string!');
        return null;
    }
    if ($(listElementId).length !== 1) {
        z4m.log.error('List element is empty!');
        return null;
    }
    if (!$(listElementId).is('ul')) {
        z4m.log.error('Not a List!', $(listElementId));
        return null;
    }
    const listObjectProperty = 'znetdk4mobileListObject';
    if ($(listElementId)[0].hasOwnProperty(listObjectProperty)) {
        // Data list already instantiated, its object is returned
        return $(listElementId)[0][listObjectProperty];
    }
    const listObject = Object.create(this);
    listObject.element = $(listElementId);
    var firtRows = listObject.element.children();
    if (firtRows.length === 0) {
        z4m.log.error('No row found within the List!', $(listElementId));
        return null;
    } else if (firtRows.length > 2) {
        z4m.log.error('More than 2 rows are defined!', $(listElementId));
    }
    if (!firtRows.first().is('li')) {
        z4m.log.error('The first row element is not a list item!', firtRows.first());
    }
    if (firtRows.length === 2 && !firtRows.eq(1).is('li')) {
        z4m.log.error('The second row element is not a list item!', firtRows.first());
    }
    if (z4m.ajax.initControllerActionProperties('load', listObject) === false) {
        z4m.log.error("The 'data-zdk-load' attribute is missing!");
        return null;
    }
    // Memorize the custom 'No row found' message and remove it
    if (firtRows.length === 2) {
        listObject.noRowMessage = '<li>' + firtRows.eq(1).html() + '</li>';
        firtRows.eq(1).remove();
    }
    // Memorize the row template
    listObject.rowTemplate = listObject.element.html();
    // Row template is removed to avoid flash effect
    listObject.element.find('li').remove();
    // View is registered for action buttons
    const actionButtons = {};
    if (search === true || search === undefined) {
        actionButtons.search = {
            isVisible: true,
            callback: function () {
                listObject.showSearchModal();
            }
        };
    }
    if (refresh === true || refresh === undefined) {
        actionButtons.refresh = {
            isVisible: true,
            callback: function () {
                listObject.refresh();
            }
        };
    }
    const listViewId = z4m.content.getParentViewId(listObject.element);
    if (actionButtons.hasOwnProperty('search') || actionButtons.hasOwnProperty('refresh')) {
        z4m.action.registerView(listViewId, actionButtons);
    }
    // Add the filter buttons memorized into the local storage
    addTagFromLocalStorage();
    // 'Display view' events are handled for refreshing the list
    const isFirst = listObject.element[0] === listObject.element.closest('.zdk-view').find('ul[data-zdk-load]')[0];
    if (!z4m.navigation.isPageToBeReloaded() && isFirst) {
        const afterViewDisplayEventName = z4m.navigation.events.afterViewDisplayName + '.z4m_list_' + listViewId;
        $('body').off(afterViewDisplayEventName);
        $('body').on(afterViewDisplayEventName, function (event, viewId) {
            if (listViewId === viewId) {
                listObject.refresh();
            }
        });
    }
    // 'Click' Events of the Remove filter buttons are handled for refreshing the list
    if (search === true || search === undefined) {
        listObject.element.parent().on('click.z4m_list', '.search-filter-container .remove', function () {
            var searchTag = $(this).closest('.search-tag'),
                filterContainer = $(this).closest('.search-filter-container');
            // The tag is cleared into the local storage
            clearTagIntoLocalStorage(searchTag);
            // The tag is removed
            searchTag.remove();
            // The filter container is removed if it is empty
            if (filterContainer.is(':empty')) {
                filterContainer.remove();
            }
            // The list is refreshed
            listObject.refresh();
        });
    }
    // Autocomplete suggestions on search field if data-zdk-autocomplete is set for the list
    listObject.isAutocompleteOnSearchEnabled = z4m.ajax.initControllerActionProperties(
            'autocomplete', listObject);
    // Data List object memorized in element property to avoid multiple instantiations
    listObject.element[0][listObjectProperty] = listObject;
    if (z4m.navigation.isPageToBeReloaded()) {
        listObject.refresh();
    }
    return listObject;
    /**
     * Adds the search filter tags from the local storage
     */
    function addTagFromLocalStorage() {
        var listId = listObject.element.attr('id'),
            viewId = z4m.content.getParentViewId(listObject.element),
            storageKeySuffix = '_' + listId + '_' + viewId,
            sortField = z4m.browser.readLocalData(listObject.sortFieldStorageKey + storageKeySuffix),
            sortOrder = z4m.browser.readLocalData(listObject.sortOrderStorageKey + storageKeySuffix),
            sortLabel = z4m.browser.readLocalData(listObject.sortLabelStorageKey + storageKeySuffix),
            keywords = z4m.browser.readLocalData(listObject.keywordsStorageKey + storageKeySuffix);

        if (keywords !== false) {
            // Memorized keywords are applied
            var keywordsAsArray = keywords.split('&&');
            keywordsAsArray.forEach(function(keyword) {
                listObject.applyFilterAndSortCriterium(keyword, null, null, null, true);
            });
        }
        if (sortField !== false && sortOrder !== false && sortLabel !== false) {
            // Memorized Sort criteria are applied
            listObject.applyFilterAndSortCriterium('', sortField, sortOrder, sortLabel, true);
        }
    }
    /**
     * Removes from the local storage the data of the removed search tag
     * @param {jQuery} searchTag search tag element
     */
    function clearTagIntoLocalStorage(searchTag) {
        var listId = listObject.element.attr('id'),
            viewId = z4m.content.getParentViewId(listObject.element),
            storageKeySuffix = '_' + listId + '_' + viewId;
        if (searchTag.is('.filter-sort-criterium')) {
            // The sort criterium are cleared
            z4m.browser.removeLocalData(listObject.sortFieldStorageKey + storageKeySuffix);
            z4m.browser.removeLocalData(listObject.sortOrderStorageKey + storageKeySuffix);
            z4m.browser.removeLocalData(listObject.sortLabelStorageKey + storageKeySuffix);
        } else if (searchTag.is('.search-filter')) {
            var doRemoveFilterTag = true;
            // The keyword is cleared
            if (listObject.uniqueSearchedKeyword !== true) {
                var storedKeywords = z4m.browser.readLocalData(listObject.keywordsStorageKey + storageKeySuffix);
                if (storedKeywords === false) {
                    return; // No stored keyword
                }
                var keywordsAsArray = storedKeywords.split('&&'),
                        keywordToClear = searchTag.find('.filter-value').text(),
                        keywordWithJsonDataToClear = '[[' + searchTag.attr('data-filter-jsondata') + ']]'
                            + keywordToClear,
                        newStoredKeywords = '';
                keywordsAsArray.forEach(function(keyword) {
                    if (keyword !== keywordToClear && keyword !== keywordWithJsonDataToClear) {
                        newStoredKeywords += newStoredKeywords === '' ? keyword : '&&' +  keyword;
                    }
                });
                if (newStoredKeywords !== '') {
                    z4m.browser.storeLocalData(listObject.keywordsStorageKey + storageKeySuffix, newStoredKeywords);
                    doRemoveFilterTag = false;
                }
            }
            if (doRemoveFilterTag) {
                // Only one keyword is applied, so all keywords are removed
                z4m.browser.removeLocalData(listObject.keywordsStorageKey + storageKeySuffix);
            }
        }
    }
};

/**
 * Memorize the next page number of data to load in the list when the list
 * is scrolled down.
 * This method is used to simulate the infinite scroll mechanism
 * @param {Integer} pageNumber The page number
 * @returns {Boolean} Value true when the method is called in the context of a
 * list object, false otherwise.
 */
z4m.list.setNextPageToLoad = function (pageNumber) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    this.element.data('page', pageNumber);
    return true;
};

/**
 * Get the next page number of data to load in the list when the list is
 * scrolled down.
 * This method is used to simulate the infinite scroll mechanism
 * @returns {Integer|false} The page number when succeeded, false when called
 * out of the context of a list object
 */
z4m.list.getNextPageToLoad = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    return parseInt(this.element.data('page'));
};

/**
 * Memorize the HTML document height in pixels after the loading of extra rows
 *  in a list.
 * This method is used to simulate the infinite scroll mechanism
 * @param {Float} documentHeight The height of the document in pixels
 * @returns {Boolean} Value true when called in the context of a list object,
 * false otherwise.
 */
z4m.list.setLastDocumentHeight = function (documentHeight) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    this.element.data('height', documentHeight);
    return true;
};

/**
 * Get the last memorized document height of the application
 * This method is used to simulate the infinite scroll mechanism
 * @returns {Float|false} The number of pixels of false if the method is not
 * called in the context of a list object
 */
z4m.list.getLastDocumentHeight = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    return parseFloat(this.element.data('height'));
};

/**
 * Memorize the total number of rows loaded into the list
 * This method is used to simulate the infinite scroll mechanism
 * @param {Integer} rowCount Number of rows
 * @returns {Boolean} Value true when called in the context of a list object,
 * false otherwise.
 */
z4m.list.setTotalRowCount = function (rowCount) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    this.element.data('total', rowCount);
    return true;
};

/**
 * Get the number of rows loaded into the list
 * This method is used to simulate the infinite scroll mechanism
 * @returns {Integer|false} The number of rows of false if the method is not
 * called in the context of a list object
 */
z4m.list.getTotalRowCount = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    return parseInt(this.element.data('total'));
};

/**
 * Filter and sort the list's rows
 * The filter keywords and sort criteria are memorized into the local storage
 * @param {String} filterValue The keyword for filtering the list content
 * @param {String} sortfield The field name to sort by. When is equal to
 * '_default', no sort is applied.
 * @param {String} sortorder The sort order of the data ('1' for ascending order
 *  or '-1' for descending order)
 *  @param {String} sortlabel The label of the sort field name (optional, set
 *  only when the sort filter is applied from the local storage)
 *  @param {Boolean} noRefresh When set to true, the list is not refreshed
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.list.applyFilterAndSortCriterium = function (filterValue,
        sortfield, sortorder, sortlabel, noRefresh) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    var isSortCriteriumToApply = sortfield !== null && sortfield !== '_default'
            && (sortfield !== this.defaultCustomSortCriterium || sortorder !== '1'),
            filterContainer = this.element.parent().children('.search-filter-container');

    // Displayed sort criterium are removed
    filterContainer.find('.filter-sort-criterium').remove();

    // Displayed keyword are removed
    if (this.uniqueSearchedKeyword === true) {
        filterContainer.find('.search-filter').remove();
    }
    if (filterValue !== '' || isSortCriteriumToApply) {
        if (filterContainer.length === 0) {
            filterContainer = $(this.searchModalId).find('.search-filter-container').clone();
            filterContainer.removeClass(z4m.hideClass);
            filterContainer.prependTo(this.element.parent());
        }
        // Display keyword filters
        if (filterValue !== '') {
            var filterElement = $(this.searchModalId).find('.search-filter').clone();
            filterElement.find('.filter-value').text(getFilterValueLabel());
            filterElement.attr('data-filter-jsondata', getFilterValueJsonData());
            filterElement.attr('data-filter-key', 'keyword');
            filterElement.appendTo(filterContainer);
            filterElement.removeClass(z4m.hideClass);
        }
        // Display sort criterium
        if (isSortCriteriumToApply) {
            var orderClass = sortorder === '1' ? 'asc' : 'desc',
                    sortElement = $(this.searchModalId).find('.filter-sort-criterium.' + orderClass).clone();
            sortElement.find('.label').text(sortlabel === undefined
                        ? this.customSortCriteria[sortfield] : sortlabel);
            sortElement.attr('data-sortfield', sortfield);
            sortElement.attr('data-sortorder', sortorder);
            sortElement.appendTo(filterContainer);
            sortElement.removeClass(z4m.hideClass);
        }
        if (noRefresh === true) {
            return true;
        } else {
            // The filters are memorized
            addFiltersToLocalStorage(this);
            // The list content is refresh
            return this.refresh();
        }
    }
    return false;
    function getFilterValueLabel() {
        var endDataSeparatorPos = filterValue.indexOf(']]');
        if (endDataSeparatorPos === -1) {
            return filterValue;
        }
        return filterValue.substring(endDataSeparatorPos + 2);
    }
    function getFilterValueJsonData() {
        var startDataSeparatorPos = filterValue.indexOf('[['),
                endDataSeparatorPos = filterValue.indexOf(']]');
        if (startDataSeparatorPos === -1 || endDataSeparatorPos === -1) {
            return {label:filterValue};
        }
        return filterValue.substring(startDataSeparatorPos + 2, endDataSeparatorPos);
    }
    /**
     * Stores in the local storage the filter and sort criteria
     * @param listContext The list context
     */
    function addFiltersToLocalStorage(listContext) {
        var listId = listContext.element.attr('id'),
                viewId = z4m.content.getParentViewId(listContext.element),
                storageKeySuffix = '_' + listId + '_' + viewId;
        if (isSortCriteriumToApply) {
            // Sort criteria are stored
            var sortTag = listContext.element.parent().find('.filter-sort-criterium'),
                    sortLabel = sortTag.find('span.label').text();

            z4m.browser.storeLocalData(listContext.sortFieldStorageKey + storageKeySuffix, sortfield);
            z4m.browser.storeLocalData(listContext.sortOrderStorageKey + storageKeySuffix, sortorder);
            z4m.browser.storeLocalData(listContext.sortLabelStorageKey + storageKeySuffix, sortLabel);
        }
        if (filterValue !== '') {
            var keywords = filterValue;
            if (listContext.uniqueSearchedKeyword === false) {
                var storedKeywords = z4m.browser.readLocalData(listContext.keywordsStorageKey + storageKeySuffix);
                if (storedKeywords !== false) {
                    keywords = storedKeywords + '&&' + filterValue;
                }
            }
            z4m.browser.storeLocalData(listContext.keywordsStorageKey + storageKeySuffix, keywords);
        }
    }
};

/**
 * Refresh the list from the data returned by the remote controller action set
 * for the list through the 'data-zdk-load' HTML5 attribute
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.list.refresh = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    // The list is shown if initialy hidden
    this.element.removeClass(z4m.hideClass);
    // Pagination infos are reset
    this.setNextPageToLoad(1);
    this.setTotalRowCount(this.rowsPerPage);
    this.setLastDocumentHeight(0);
    // The rows are downloaded from the controller action
    this.loadNewDataPage();
    return true;
};

/**
 * Load a new page of data rows into the list
 * This method is used to simulate the infinite scroll mechanism
 * @returns {Boolean} Value true when succeeded, false otherwise
 */
z4m.list.loadNewDataPage = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    if (this.remoteActions.load.controller === null || this.remoteActions.load.action === null) {
        z4m.log.error('Controller or action property not set!');
        return false;
    }
    var $this = this,
            nextPage = this.getNextPageToLoad(),
            first = (nextPage - 1) * this.rowsPerPage,
            requestData = {first: first, count: this.rowsPerPage};
    if (first >= this.getTotalRowCount()) {
        return false; // No more rows to load
    }
    // Scroll events are handled for loading data pages (infinite scroll)
    var eventName = this.events.onContentScrollName + '.z4m_list';
    if (nextPage === 1) { // First page to load so no scroll event handled
        this.element.off(eventName);
    }
    // If filters are set, they are added to the request Data
    addFiltersToRequestData.call(this, requestData);
    z4m.ajax.request({
        control: this.remoteActions.load.controller,
        action: this.remoteActions.load.action,
        data: requestData,
        callback: function (response) {
            if (!response.hasOwnProperty('rows') || !response.hasOwnProperty('total')) {
                console.error('z4m.list.loadNewDataPage(): invalid AJAX response.');
                return;
            }
            if (nextPage === 1) {
                // Rows are removed first
                $this.element.find('li').remove();
                // 'Show next results' link removed
                removeShowNextRowsLink();
            }
            if (response.rows.length > 0) {
                $this.setTotalRowCount(response.total);
                $this.setNextPageToLoad(nextPage + 1);
                $.each(response.rows, function () {
                    var rowData = $(this)[0];
                    // Row data overload
                    if (typeof $this.beforeInsertRowCallback === 'function') {
                        $this.beforeInsertRowCallback.call($this, rowData);
                    }
                    var newRowEl = appendRow(rowData);
                    if (typeof $this.afterInsertRowCallback === 'function') {
                        $this.afterInsertRowCallback.call($this, newRowEl);
                    }
                });
                if (nextPage === 1 && response.total > $this.rowsPerPage) {
                    // Data pagination enabled, data pages are loaded on scroll
                    handleScrollEvents();
                    // Display of the 'Show next results' link
                    addShowNextRowsLink();
                } else if (response.total <= $this.element.find('li').length) {
                    // No more rows to load, 'show next results' link is removed
                    removeShowNextRowsLink();
                }
            } else if (nextPage === 1) {
                // No result found
                $this.element.append($this.noRowMessage);
            }
            // The total number of rows is displayed on the horizontal menu item
            if ($this.displayRowCountInMenuTab) {
                z4m.navigation.addRowCountToHorizontalMenuItem(
                    response.total, z4m.content.getParentViewId($this.element));
            }
            // Callback function called if defined
            if (typeof $this.loadedCallback === 'function') {
                $this.loadedCallback.call($this, response.rows.length, nextPage);
            }
            // 'afterpageloaded' event triggered
            $this.element.trigger(z4m.list.events.afterPageLoadedName,
                    [$this, response.rows.length, nextPage]);
            // Private functions
            function appendRow(rowData) {
                var newRowAsHtml = $this.rowTemplate;
                $.each(rowData, function (key, value) {
                    var toReplace = '{{' + key + '}}';
                    newRowAsHtml = newRowAsHtml.replace(new RegExp(toReplace, 'g'), value);
                });
                var newRowAsElement = $(newRowAsHtml);
                $this.element.append(newRowAsElement);
                return newRowAsElement;
            }
            function handleScrollEvents() {
                if ($this.infiniteScroll) {
                    $this.element.on(eventName, function () {
                        var windowHeight = $(window).height(),
                                documentHeight = $(document).height(),
                                scrollBarPosition = $(window).scrollTop(),
                                newPageLevel = windowHeight + scrollBarPosition + $this.heightDiffForNewPage,
                                lastDocumentHeight = $this.getLastDocumentHeight();
                        if (newPageLevel > documentHeight && lastDocumentHeight < documentHeight) {
                            $this.loadNewDataPage();
                            $this.setLastDocumentHeight(documentHeight);
                        }
                    });
                }
            }
            function addShowNextRowsLink() {
                const newEl = $($this.nextRowsLinkTemplateId).contents().filter('div').clone();
                $this.element.after(newEl);
                newEl.find('a').on('click.z4m_list', function(event){
                    event.preventDefault();
                    let docHeight = $(document).height();
                    $this.loadNewDataPage();
                    $this.setLastDocumentHeight(docHeight);
                });
            }
            function removeShowNextRowsLink() {
                const linkContainer = $this.element.next('.show-next-rows');
                if (linkContainer.length === 1) {
                    linkContainer.find('a').off('click.z4m_list');
                    linkContainer.remove();
                }
            }
        }
    });
    return true;
    // Private function
    function addFiltersToRequestData(requestData) {
        // Keywords
        var $this = this, filters = this.element.parent().find('.search-filter');
        filters.each(function () {
            var filterKey = $(this).data('filter-key'),
                    filterJsonData = $(this).data('filter-jsondata'),
                    filterValue = $(this).find('.filter-value').text();
            if (requestData.hasOwnProperty(filterKey)) {
                requestData[filterKey].push(filterValue);
            } else {
                requestData[filterKey] = [filterValue];
            }
            if ($this.searchedKeywordAsJson && typeof filterJsonData === 'object') {
                if (requestData.hasOwnProperty(filterKey + '_json')) {
                    requestData[filterKey + '_json'].push(JSON.stringify(filterJsonData));
                } else {
                    requestData[filterKey + '_json'] = [JSON.stringify(filterJsonData)];
                }
            }
        });
        // Sort Criterium
        var sortCriterium = this.element.parent().find('.filter-sort-criterium');
        if (sortCriterium.length === 1) {
            requestData['sortfield'] = sortCriterium.data('sortfield');
            requestData['sortorder'] = sortCriterium.data('sortorder');
        }
        // Request data overload
        if (typeof this.beforeSearchRequestCallback === 'function') {
            this.beforeSearchRequestCallback(requestData);
        }
    }
};

/**
 * Declare the modal dialog to display for editing an existing item or for adding
 * a new one
 * @param {String} modalElementId The identifier of the modal dialog ('id' HTML
 * attribute)
 * @param {Boolean} isFormModifiable When set to true or undefined, the row data
 * can be modified through the modal dialog and the 'add' action bar button is
 * displayed.
 * @param {function|Boolean} onAdd The function to call back for initialization
 * purpose when adding a new row, just before the modal dialog display. If set
 * to false, no 'Add' action button is added to the list.
 * If the specified callback function returns false, the modal dialog is not
 * open (the callback function then takes care of opening the modal at the
 * appropriate time).
 * @param {function} onEdit The function to call back for initialization purpose
 * when editing an existing row, just before the modal dialog display.
 * If the specified callback function returns false, the modal dialog is not
 * open (the callback function then takes care of opening the modal at the
 * appropriate time).
 * @returns {Boolean} Value true when succeeded, false if the method is not
 * called into the context of a list object
 */
z4m.list.setModal = function (modalElementId, isFormModifiable, onAdd, onEdit) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    var $this = this,
            isModifiable = isFormModifiable === true || isFormModifiable === undefined;
    // Set Add action
    if (onAdd !== false) {
        z4m.action.registerView(z4m.content.getParentViewId(this.element),
            {
                add: {
                    isVisible: isModifiable,
                    callback: function () {
                        var modal = z4m.modal.make(modalElementId),
                                innerForm = modal.getInnerForm();
                        // Form is reset
                        innerForm.reset();
                        // Modal is open
                        openModal(modal, innerForm, onAdd);
                    }
                }
            }
        );
    }
    // Set Edit action
    var eventName = this.events.afterClickEditButtonName + '.z4m_list';
    this.element.off(eventName);
    this.element.on(eventName, function (event, rowId) {
        var modal = z4m.modal.make(modalElementId),
                innerForm = modal.getInnerForm();
        innerForm.load(rowId, function (response) {
            // The form inputs are set readonly if edit parameter == false
            if (!isModifiable) {
                innerForm.setReadOnly();
            }
            // Modal is open
            openModal(modal, innerForm, onEdit, response);
        });
    });
    return true;
    // Open Modal dialog
    function openModal(modalObj, formObj, beforeOpenCallback, formData) {
        if (typeof beforeOpenCallback === 'function'
                && beforeOpenCallback.call(modalObj, formObj, formData) === false) {
            return;
        }
        modalObj.open(function (submitResponse) {
            if (submitResponse.hasOwnProperty('success') && submitResponse.success === false) {
                return; // No data list refresh
            }
            // Submit succeeded so the list is refreshed
            $this.refresh();
        });
    }
};

/**
 * Display the search modal dialog for entering a keyword to search among the
 * list's rows and for setting the sort criterium
 * @returns {Boolean} Value true when succeeded, false if the method is not
 * called into the context of a list object
 */
z4m.list.showSearchModal = function () {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    var $this = this,
            modal = z4m.modal.make(this.searchModalId),
            innerForm = modal.getInnerForm(),
            captionEl = $(this.searchModalId).find('label .caption'),
            keywordInput = $(this.searchModalId).find('input[name=keyword]'),
            sortInputs = $(this.searchModalId).find('.sort-criterium'),
            sortDropdown = sortInputs.find('select[name=sortfield]');
    // The search field is set by default 'required'
    keywordInput.prop('required', true);
    captionEl.html(typeof this.searchKeywordCaption === 'string'
        ? this.searchKeywordCaption : '');
    if (this.isAutocompleteOnSearchEnabled) {
        keywordInput.removeData('item');
        const searchAutocomplete = z4m.autocomplete.make(this.searchModalId + ' input[name=keyword]', {
            controller: this.remoteActions.autocomplete.controller,
            action: this.remoteActions.autocomplete.action
        }, onSuggestionSelected);
        searchAutocomplete.minStringLength = this.searchKeywordMinStringLengh;
    } else {
        // The search field is set with HTML5 attribute 'autocomplete' on if
        // the custom autocomplete feature is disabled
        keywordInput.attr('autocomplete', 'on');
    }
    // The sort criteria dropdown is emptied
    sortDropdown.empty();
    // The sort crtieria inputs are hidden by default
    sortInputs.addClass(z4m.hideClass);
    // If custom sort criteria are set...
    if (this.customSortCriteria !== null && typeof this.customSortCriteria === 'object') {
        // The dropdown is filled
        for (var criterium in this.customSortCriteria) {
            sortDropdown.append('<option value="' + criterium
                    + '">' + this.customSortCriteria[criterium] + '</option>');
        }
        // The sort crtieria inputs are shown
        sortInputs.removeClass(z4m.hideClass);
        // The keyword input is no longer set required
        keywordInput.prop('required', false);
    }
    // The form is reset
    innerForm.reset();
    // Current applied sort criterium is selected
    setCurrentSortCriteriumInForm();
    // The modal is displayed
    modal.open();
    // Submit events are attached
    $(this.searchModalId + ' form').off('submit.zdkmobile_list');
    $(this.searchModalId + ' form').on('submit.zdkmobile_list', function (event) {
        var keyword = innerForm.getInputValue('keyword'),
                sortfield = innerForm.getInputValue('sortfield'),
                sortorder = innerForm.getInputValue('sortorder');
        if (keyword !== '' && $this.searchedKeywordAsJson) {
            var keywordItemData = keywordInput.data('item');
            if (typeof keywordItemData === 'object') {
                keyword = '[[' + JSON.stringify(keywordItemData) + ']]' + keyword;
            } else {
                keyword = '[[' + JSON.stringify({label:keyword}) + ']]' + keyword;
            }
        }
        $this.applyFilterAndSortCriterium(keyword, sortfield, sortorder);
        modal.close();
        event.preventDefault();
    });
    return true;
    /**
     * Set the last sort criterium applied
     * @returns {Boolean} Value true if a sort criterium was previously applied,
     * false otherwise.
     */
    function setCurrentSortCriteriumInForm() {
        var sortTag = $this.element.parent().find('.filter-sort-criterium');
        if (sortTag.length !== 1) {
            return false;
        }
        var sortfield = sortTag.data('sortfield'),
                sortorder = sortTag.data('sortorder');
        innerForm.setInputValue('sortfield', sortfield);
        innerForm.setInputValue('sortorder', sortorder);
        return true;
    };
    /**
     * When a suggestion is selected, its extra data are memorized as HTML5 data
     * property of the input element.
     * @param {Object} item The selected item property values
     */
    function onSuggestionSelected(item) {
        if ($this.searchedKeywordAsJson) {
            var storedItem = {};
            for (var property in item) {
                if (item.hasOwnProperty(property) && property !== 'label') {
                    storedItem[property] = item[property];
                }
            }
            if (Object.keys(storedItem).length > 0) {
                $(this).data('item', storedItem);
            } else {
                $(this).removeData('item');
            }
        }
    }
};

/**
 * Define the sort criteria displayed within the search modal dialog for sorting
 * the list's rows
 * @param {Object} sortCriteria An object with properties as sorting key and
 * values as label to display to the users
 * @param {String} defaultSortCriterium The sorting key to apply by default
 * @returns {Boolean} Value true when succeeded, false if the method is not
 *  called into the context of a list object or if its parameter are not
 *  properly set
 */
z4m.list.setCustomSortCriteria = function (sortCriteria, defaultSortCriterium) {
    if (this.element instanceof jQuery === false) {
        z4m.log.error('List is not instantiated!');
        return false;
    }
    if (sortCriteria === null || typeof sortCriteria !== 'object') {
        z4m.log.error('Not a JS object!');
        return false;
    }
    if (Object.keys(sortCriteria).length === 0) {
        z4m.log.error('The sort criteria value object is empty!');
        return false;
    }
    this.customSortCriteria = sortCriteria;
    if (typeof defaultSortCriterium === 'string') {
        if (sortCriteria.hasOwnProperty(defaultSortCriterium)) {
            this.defaultCustomSortCriterium = defaultSortCriterium;
        } else {
            z4m.log.error('The default sort criterium does not match any sort criteria!');
            return false;
        }
    }
    return true;
};

/**
 * Handle the click events on the row edit buttons by triggering a
 * 'afterclickeditbutton' event that is then catched for displaying the edit
 * modal dialog
 */
z4m.list.events.handleEdit = function () {
    var $this = this, eventName = 'click.z4m_list';
    z4m.content.getContainer().on(eventName, 'ul[data-zdk-load] a.edit', function (event) {
        var listElement = $(this).closest('ul'),
                rowElement = $(this).closest('li'),
                rowId = rowElement.data('id');
        if (rowId === undefined) {
            z4m.log.warn("The 'data-id' attribute is missing!");
            return false;
        }
        listElement.triggerHandler($this.afterClickEditButtonName, [rowId]);
        event.preventDefault();
    });
};

/**
 * Handle the scroll events of the window for loading the list's rows.
 * This method is used to simulate the infinite scroll mechanism
 */
z4m.list.events.handleScroll = function () {
    var $this = this, eventName = 'scroll.z4m_list';
    $(window).on(eventName, function () {
        var displayedView = z4m.content.getDisplayedView();
        if (displayedView.length !== 1) {
            return false;
        }
        var listElement = displayedView.find('ul[data-zdk-load]');
        if (listElement.length === 0) {
            return false;
        }
        listElement.eq(0).triggerHandler($this.onContentScrollName);
    });
};

//*********************** AUTOCOMPLETE PUBLIC METHODS **************************

/**
 * Instantiate a new autocomplete object from the specified input field element
 * @param {jQuery|String} inputElementSelector The selector of the input field
 * or the input element as a jQuery object.
 * @param {Object} controllerAction The controller and the action to call
 * remotely to retrieve the autocompletion suggestions
 * @param {function} onSelect A function to call back when a suggestion has been
 * choosen by the user
 * @param {function} renderCallback Optional function called to customize the
 * display of each suggestion. This function is called with the suggestion's
 * data as parameter and must return the new label in text or HTML format.
 * @returns {Object|null} The instantiated autocomplete object or null if the
 * instantiation failed
 */
z4m.autocomplete.make = function (inputElementSelector, controllerAction,
        onSelect, renderCallback) {
    var inputElement = inputElementSelector instanceof jQuery
            ? inputElementSelector : $(inputElementSelector);
    if (inputElement.length !== 1) {
        z4m.log.error('Autocomplete element is empty or multiple!');
        return null;
    }
    if (!inputElement.is('input')) {
        z4m.log.error('Must be an input element!', inputElement);
        return null;
    }
    if (inputElement.attr('type') !== 'search') {
        z4m.log.error("The input type must be 'search'!", inputElement);
        return null;
    }
    if (controllerAction === undefined) {
        z4m.log.error("The controller action is missing!");
        return null;
    }
    if (controllerAction === null || typeof controllerAction !== 'object') {
        z4m.log.error("The controller action must be an object!", controllerAction);
        return null;
    }
    if (!controllerAction.hasOwnProperty('controller')) {
        z4m.log.error("The property 'controller' is missing!", controllerAction);
        return null;
    }
    if (!controllerAction.hasOwnProperty('action')) {
        z4m.log.error("The property 'action' is missing!", controllerAction);
        return null;
    }
    // HTML5 autocomplete attribute set to 'off'
    inputElement.attr('autocomplete', 'off');
    var autocompleteObject = Object.create(this);
    autocompleteObject.element = inputElement;
    autocompleteObject.remoteActions = {
        autocomplete: {
            controller: controllerAction.controller,
            action: controllerAction.action
        }
    };
    var list = autocompleteObject.element.next('ul.autocomplete'), timeout = null;
    if (list.length === 1) {
        list.remove();
    }
    list = $(autocompleteObject.listTemplateId).contents().filter('ul').clone();
    autocompleteObject.element.after(list);

    _registerInputEvents();
    _registerSelectSuggestionEvents();
    return autocompleteObject;

    // PRIVATE METHODS
    function _registerInputEvents() {
        var eventName = 'input.z4m_autocomplete';
        autocompleteObject.element.off(eventName);
        autocompleteObject.element.on(eventName, function (event) {
            var queryString = $(this).val();
            _removeSuggestions();
            if (queryString.length < autocompleteObject.minStringLength) {
                return; // Number of characters insufficient
            }
            if (timeout === null) {
                timeout = window.setTimeout(async function () {
                    await _showSuggestions(queryString);
                    timeout = null;
                }, autocompleteObject.delay);
            }
        });
    }
    function _showSuggestions(queryString) {
        return new Promise(function(resolve) {
            if (!_isRequestRequired(queryString)// Useless request, no result for the previous query string
                    || _showCachedSuggestions(queryString)) {// Suggestions stored in cache are shown
                resolve();
                return;
            }
            z4m.ajax.request({
                control: controllerAction.controller,
                action: controllerAction.action,
                data: {query: queryString},
                callback: function (response) {
                    if (autocompleteObject.element.is(':focus') && response.length > 0) {
                        _addSuggestionsToList(response, queryString);
                        _addToCacheData(response, queryString);
                        list.removeClass(z4m.hideClass);
                        _registerClickOutOfTheAutocomplete();
                        _registerKeyboardAction();
                    }
                    _setPreviousQueryString(queryString, response.length);
                    resolve();
                }
            });
        });
    }
    function _removeSuggestions() {
        list.empty();
        list.addClass(z4m.hideClass);
        _registerClickOutOfTheAutocomplete(true);
        _registerKeyboardAction(true);
    }
    function _addSuggestionsToList(response, queryString) {
        $.each(response, function () {
            if (this.label === undefined) {
                z4m.log.warn("'label' property is missing in autocomplete suggestions!", this, 'error');
                return false; // Break
            }
            var itemLabel = this.label,
                item = $(autocompleteObject.itemTemplateId).contents().filter('li').clone(),
                escapedQueryString = queryString.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'),
                htmlLabel = itemLabel.replace(new RegExp(escapedQueryString, 'gi'), '<strong>$&</strong>');
            if (typeof renderCallback === 'function') {
                itemLabel = renderCallback(this);
                if (typeof itemLabel === 'string') {
                    htmlLabel = itemLabel.replace(this.label, htmlLabel);
                } else {
                    z4m.log.warn("The 'renderCallback' function set for autocomplete must return a string!");
                }
            }
            item.html(htmlLabel);
            item.data('item', this);
            list.append(item);
        });
    }
    /**
     * Memorizes the previous query string
     * @param {String} queryString The previous query string
     * @param {Integer} responseCount The count of suggestions found for this
     * query string
     */
    function _setPreviousQueryString(queryString, responseCount) {
        autocompleteObject.prevQueryString = {
            queryString: queryString,
            responseCount: responseCount
        };
    }
    /**
     * For optimization purpose, checks if retrieving suggestions from the
     * remote web server is required or not according to the previous query
     * string value and the count of matching suggestions.
     * @param {String} queryString The current query string
     * @returns {Boolean} Returns false if the previous query string is set,
     * if no suggestions were found for it and if it is contained into the
     * current query string. Otherwise return true.
     */
    function _isRequestRequired(queryString) {
        if (autocompleteObject.prevQueryString !== null
                && autocompleteObject.prevQueryString.responseCount === 0
                && queryString.indexOf(autocompleteObject.prevQueryString.queryString) > -1) {
             // current query string is included into the previous query string
             // And the previous query string returned no suggestions.
            return false;
        }
        return true;
    }
    /**
     * Shows existing suggestions in cache matching the specified query string
     * @param {String} queryString The query string to search in cache
     * @returns {Boolean} Returns true if data exist in cache, false otherwise
     */
    function _showCachedSuggestions(queryString) {
        for (let i=0; i < autocompleteObject.itemCache.length; i++) {
            if (autocompleteObject.itemCache[i].queryString === queryString) {
                _addSuggestionsToList(autocompleteObject.itemCache[i].listOfItems, queryString);
                list.removeClass(z4m.hideClass);
                return true;
            }
        }
        return false; // No cache data
    }
    /**
     * Adds data in cache matching the specified query string
     * @param {array} response The data to store in cache
     * @param {String} queryString The query string
     */
    function _addToCacheData(response, queryString) {
        if (autocompleteObject.itemCache.length
                >= autocompleteObject.maxNumberOfCachedItems) {
            autocompleteObject.itemCache.shift(); // remove old cache item
        }
        if (autocompleteObject.maxNumberOfCachedItems > 0) {
            autocompleteObject.itemCache.push({
                queryString: queryString,
                listOfItems: response
            });
        }
    }
    function _registerSelectSuggestionEvents() {
        var eventName = 'click.z4m_autocomplete';
        list.off(eventName);
        list.on(eventName, 'li', function () {
            var item = $(this).data('item'),
                    doSelection = true;
            if (typeof onSelect === 'function') {
                doSelection = onSelect.call(autocompleteObject.element, item);
            }
            if (doSelection !== false) {
                autocompleteObject.element.val(item.label);
            }
            _removeSuggestions();
            if (autocompleteObject.cacheLifetime === 'selection') {
                autocompleteObject.itemCache = []; // Cache entries removed
            }
        });
    }
    function _registerClickOutOfTheAutocomplete(unregisterOnly) {
        var eventName = 'click.z4m_autocomplete_close';
        $(document).off(eventName);
        if (unregisterOnly === true) {
            return false;
        }
        $(document).on(eventName, ':not(.autocomplete)', function () {
            _removeSuggestions();
        });
        return true;
    }
    function _registerKeyboardAction(unregisterOnly) {
        var eventName = 'keydown.z4m_autocomplete';
        autocompleteObject.element.off(eventName);
        if (unregisterOnly === true) {
            return false;
        }
        autocompleteObject.element.on(eventName, function (event) {
            if (event.keyCode === 40) { // DOWN key is pressed
                _setItemActive('down');
            } else if (event.keyCode === 38) { // UP key is pressed
                _setItemActive('up');
            } else if (event.keyCode === 13) { // ENTER key is pressed
                event.preventDefault();
                list.find('li.' + autocompleteObject.selectedItemCssClass).click();
            } else if (event.keyCode === 9) { // TAB key is pressed
                _removeSuggestions();
            }
        });
    }
    function _setItemActive(direction) {
        var selectedItem = list.find('li.' + autocompleteObject.selectedItemCssClass);
        if (selectedItem.length === 0) { // No item selected
            list.find('li').first().addClass(autocompleteObject.selectedItemCssClass);
        } else if (direction === 'up') {
            let prevItem = selectedItem.prev();
            selectedItem.removeClass(autocompleteObject.selectedItemCssClass);

            if (prevItem.length === 1) {
                prevItem.addClass(autocompleteObject.selectedItemCssClass);
            } else {
                list.find('li').last().addClass(autocompleteObject.selectedItemCssClass);
            }
        } else if (direction === 'down') {
            let nextItem = selectedItem.next();
            selectedItem.removeClass(autocompleteObject.selectedItemCssClass);
            if (nextItem.length === 1) {
                nextItem.addClass(autocompleteObject.selectedItemCssClass);
            } else {
                list.find('li').first().addClass(autocompleteObject.selectedItemCssClass);
            }
        }
    }
};

//*********************** SERVICE WORKER PUBLIC METHODS ************************

/**
 * Register the service worker of the application
 * The 'z4m.serviceWorker.isRegistered' property is set to true when
 * registration succeeded (set to false by default).
 * @returns {Boolean} Returns false is service worker is disabled and when the
 * 'serviceWorker' is not supported by the web browser. Otherwise returns true.
 */
z4m.serviceWorker.register = function () {
    var appUrl = (z4m.ajax.getParamsFromAjaxURL()).url.replace('index.php', ''),
        scriptUrl = $('body').data('service-worker-url'),
        fullUrl = appUrl + scriptUrl;
    if (scriptUrl.length === 0) {
        return false;
    }
    if ('serviceWorker' in navigator) {
        // Register a service worker hosted at the root of the
        // site using a more restrictive scope.
        navigator.serviceWorker.register(fullUrl).then(function(){ // Success
            z4m.serviceWorker.isRegistered = true;
        }, function (error) { // Error
            z4m.log.error("'" + fullUrl + "': " + error.message);
        });
    } else {
        z4m.log.warn('Service workers are not supported.');
        return false;
    }
    return true;
};

//**************************** INSTALL PUBLIC METHODS *****************************

/**
 * Checks whether the App is installable or not
 * @returns {Boolean} Value true if App is installable ('beforeinstallprompt'
 * A2HS event triggered).
 */
z4m.install.isAppInstallable = function() {
    return this.installPrompt !== null;
};

/**
 * Checks whether the App is installed or not
 * @returns {Boolean} Value true if App is installed
 */
z4m.install.isAppInstalled = function() {
    // For iOS
    if(window.navigator.standalone) {
        return true;
    }
    // For Android
    if(window.matchMedia('(display-mode: standalone)').matches) {
        return true;
    }
    // "Is installed" state is memorized in local storage
    if (z4m.browser.readLocalData(this.isInstalledStorageKey) === 'yes') {
        return true;
    }
    return false; // App not installed
};

/**
 * Displays a message to notify user that App can be installed.
 * This message is only displayed if App is installable (see isAppInstallable).
 * If user says No, the message is no longer displayed next time.
 * @param {Boolean} onlyIfAutomaticDisplayEnabled Optional, when set to true,
 * the message is only shown if the CFG_MOBILE_INSTALL_MESSAGE_DISPLAY_AUTO
 * PHP constant is set to TRUE.
 * @returns {Boolean} Returns true if the message has been displayed, otherwise
 * returns false
 */
z4m.install.showInstallableMessage = function(onlyIfAutomaticDisplayEnabled) {
    var messageEl = $(this.installMessageId);
    if (!this.isAppInstallable()
            || (z4m.navigation.isPageToBeReloaded()
                && z4m.content.getPreloadedViewId() !== z4m.navigation.getFirstChildMenuItemId())
            || z4m.browser.readLocalData(z4m.install.noInstallStorageKey) === 'yes'
            || (onlyIfAutomaticDisplayEnabled && messageEl.data('autodisplay') === 'no')) {
        return false;
    }
    // Click button events
    messageEl.find('button').off('click.z4m_install').on('click.z4m_install', function(){
        if ($(this).hasClass('yes')) {
            z4m.install.installApp(z4m.install.hideInstallableMessage);
        } else if ($(this).hasClass('no')) {
            // "No install" state is memorized in local storage
            z4m.browser.storeLocalData(z4m.install.noInstallStorageKey, 'yes');
            z4m.install.hideInstallableMessage();
        }
    });
    messageEl.removeClass(z4m.hideClass);
    z4m.content.setTopSpacing();
    return true;
};

/**
 * Hides the installation message if displayed
 */
z4m.install.hideInstallableMessage = function() {
    $(z4m.install.installMessageId).addClass(z4m.hideClass);
    z4m.content.setTopSpacing();
};

/**
 * Displays the view for installing the App
 */
z4m.install.showInstallView = function() {
    z4m.modal.make(this.installModalId, this.installViewName, function(){
        this.open();
    });
};

/**
 * Displays the view for uninstalling the App
 */
z4m.install.showUninstallView = function() {
    z4m.modal.make(this.uninstallModalId, this.uninstallViewName, function(){
        this.open();
    });
};

/**
 * Install the application (A2HS)
 * @param {function} onSuccess Callback function called when the installation
 * has succeeded.
 * @return boolean Returns false if the A2HS install prompt is not available.
 */
z4m.install.installApp = function(onSuccess) {
    if (z4m.install.installPrompt !== null) {
        // Show the prompt
        z4m.install.installPrompt.prompt();
        // Wait for the user to respond to the prompt
        z4m.install.installPrompt.userChoice.then(function(choiceResult) {
            if (choiceResult && choiceResult.outcome === 'accepted') {
                // Prompt is reset once installed.
                z4m.install.installPrompt = null;
                // "Is installed" state is stored in local storage
                z4m.browser.storeLocalData(z4m.install.isInstalledStorageKey, 'yes');
                // "No install" state is cleared in local storage
                z4m.browser.removeLocalData(z4m.install.noInstallStorageKey);
                // OnSuccess function called back
                if (typeof onSuccess === 'function') {
                    onSuccess.call(z4m, onSuccess);
                }
            }
        });
        return true;
    }
    return false;
};

/**
 * Handles 'beforeinstallprompt' event (A2HS) and catch it in order
 * to trigger App installation later by calling the
 * z4m.install.installApp() method.
 */
z4m.install.events.handleBeforeInstallPrompt = function() {
    $(window).on('beforeinstallprompt.z4m_install', function(event) {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        event.preventDefault();
        if (typeof event.originalEvent === 'object'
                && event.originalEvent instanceof BeforeInstallPromptEvent
                && typeof event.originalEvent.prompt === 'function') {
            // Stash the event so it can be triggered later.
            z4m.install.installPrompt = event.originalEvent;
            // "Is installed" state is removed from local storage
            z4m.browser.removeLocalData(z4m.install.isInstalledStorageKey);
            // Installation message is automatically displayed
            z4m.install.showInstallableMessage(true);
        }
    });
};

//**************************** FILE PUBLIC METHODS *****************************

/**
 * Download from the specified URL the specified resource (picture or document)
 * and display it.
 * @param {String} url The url of the resource to download
 */
z4m.file.display = function (url) {
    // First check if the user session has not expired
    z4m.ajax.request({controller: 'security', action: 'isconnected'});
    // Download and display the picture or document
    var link = document.createElement("a");
    link.href = url;
    link.rel = 'noopener';
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
};
})(jQuery, z4m);