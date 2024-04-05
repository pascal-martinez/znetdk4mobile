<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * ------------------------------------------------------------
 * Custom navigation menu of the application
 * YOU CAN FREELY CUSTOMIZE THE CONTENT OF THIS FILE
 */
namespace app;
class Menu implements \iMenu {

    static public function initAppMenuItems() {
        \MenuManager::addMenuItem(NULL, 'home', 'Home', 'fa-home');
        
        \MenuManager::addMenuItem(NULL, '_authorizations', LC_MENU_AUTHORIZATION, 'fa-unlock-alt');
        \MenuManager::addMenuItem('_authorizations', 'z4musers', LC_MENU_AUTHORIZ_USERS, 'fa-user');
        \MenuManager::addMenuItem('_authorizations', 'z4mprofiles', LC_MENU_AUTHORIZ_PROFILES, 'fa-key');
    }

}