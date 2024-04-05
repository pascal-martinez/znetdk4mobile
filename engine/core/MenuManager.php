<?php

/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website http://www.znetdk.fr 
 * Copyright (C) 2015 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Core Navigation menu API
 *
 * File version: 1.8
 * Last update: 03/18/2024 
 */

/** ZnetDK core navigation menu API */
Class MenuManager {

    // Properties
    static private $menuItems = array();

    // Private methods
    /**
     * Initializes the menu item list from the application menu definition
     * (script 'app/menu.php' of the application)
     */
    static private function initMenuItems() {
        if (count(self::$menuItems) === 0) {
            // Menu items must be initialized before being returned
            try {
                if (class_exists('app\\Menu') &&
                        method_exists('app\\Menu', 'initAppMenuItems')) {
                    $appMenuClass = '\\app\\Menu';
                    $appMenuClass::initAppMenuItems();
                }
            } catch (\Exception $e) {
                \General::writeErrorLog('ZNETDK ERROR', "MNU-001: no menu definition found for the application '" . ZNETDK_APP_NAME .
                        "' or its method 'initAppMenuItems' does not exist! (" . $e->getCode() .")", true);
            }
        }
    }

    /**
     * Checks whether the specified menu item already exists or not
     * @param array $menuItems The list of all the menu items
     * @param string $menuItemID Identifier of the menu to find out
     * @return boolean TRUE if the menu item exists, FALSE otherwise
     */
    static private function isMenuItem($menuItems, $menuItemID) {
        foreach ($menuItems as $value) {
            if ((isset($value[2]) && self::isMenuItem($value[2], $menuItemID)) || (!isset($value[2]) && $value[0] === $menuItemID)) {
                // Menu item found
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the menu item matching the specified criterium
     * @param Integer $criteriaIndex Index of the menu item characteristic to 
     * compare with the specified criterium
     * @param mixed $criteria Criterium for searching the menu item
     * @param Array $childrenMenuItems Menu items for which the menu item is
     * searched
     * @return Array The menu item matching the specified criterium
     */
    static private function getMenuItemByCriteria($criteriaIndex, $criteria, $childrenMenuItems = NULL) {
        if (isset($childrenMenuItems)) {
            $menuItems = $childrenMenuItems;
        } else {
            $menuItems = self::getMenuItems();
        }
        foreach ($menuItems as $value) {
            if ($value[$criteriaIndex] === $criteria) {
                // Menu item found
                return $value;
            } else if (isset($value[2])) {
                $foundItem = self::getMenuItemByCriteria($criteriaIndex, $criteria, $value[2]);
                if (isset($foundItem)) {
                    return $foundItem;
                }
            }
        }
        return NULL;
    }

    /**
     * Adds the specified sub-menu item
     * @param string $parentMenuItemID Identifier of the parent menu item under
     * which the submenu item is to be added
     * @param array $subMenuItem Characteristics of the submenu item to add
     * @param array $childrenMenuItems List of the menu items among which the 
     * parent menu item exists 
     * @return boolean
     */
    static private function addSubMenuItem($parentMenuItemID, $subMenuItem, &$childrenMenuItems = NULL) {
        if (isset($childrenMenuItems)) {
            $menuItems = &$childrenMenuItems;
        } else {
            $menuItems = &self::$menuItems;
        }
        foreach ($menuItems as &$value) {
            if ($value[0] === $parentMenuItemID) {
                // Parent Menu item is found
                $value[2][] = $subMenuItem;
                return true;
            } elseif (isset($value[2]) && self::addSubMenuItem($parentMenuItemID, $subMenuItem, $value[2])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Adds a menu item to the navigation menu. This method is called from the
     * class "app\Menu" of the application.
     * @param string $parentMenuItemID Parent menu item ID, NULL for root item.
     * @param string $menuItemID Menu item ID of the item to add.
     * @param string $menuItemLabel Menu item label of the item to add.
     * @param string $menuItemIcon HTML style class of the icon to display for 
     * the menu item.
     * @param string $menuItemSEOlink SEO link for the menu item (only used if 
     * 'CFG_VIEW_PAGE_RELOAD' is set to TRUE).
     * @param string $menuItemDescription Text for the HTML 'meta' tag
     * 'description' (only used if 'CFG_VIEW_PAGE_RELOAD' is set to TRUE).
     * @param string $menuItemKeywords Text for the HTML 'meta' tag 'keywords'
     * (only used if 'CFG_VIEW_PAGE_RELOAD' is set to TRUE).
     * @param string $menuItemAuthor Text for the HTML 'meta' tag 'author' 
     * (only used if 'CFG_VIEW_PAGE_RELOAD' is set to TRUE).
     * @throws Exception Triggered if the specified menu item has been 
     * already defined or if the parent menu item does not exist.
     */
    static public function addMenuItem($parentMenuItemID, $menuItemID, $menuItemLabel, $menuItemIcon = NULL, $menuItemSEOlink = NULL
    , $menuItemDescription = NULL, $menuItemKeywords = NULL, $menuItemAuthor = NULL) {
        if (self::isMenuItem(self::$menuItems, $menuItemID)) {
            //Menu Item ID already exists, error is traced
            $message = "MNU-003: the menu item ID '$menuItemID' already exists!";
            \General::writeErrorLog('ZNETDK ERROR', $message, true);
        } elseif (isset($parentMenuItemID)) {
            // Adding sub menu item...
            if (!self::addSubMenuItem($parentMenuItemID, array($menuItemID, $menuItemLabel, NULL, $menuItemIcon, $menuItemSEOlink, $menuItemDescription, $menuItemKeywords, $menuItemAuthor))) {
                //Parent menu Item ID does not exist, error is traced
                $message = "MNU-004: the parent menu item ID '$parentMenuItemID' does not exist!";
                \General::writeErrorLog('ZNETDK ERROR', $message, true);
            }
        } else {
            // Adding root menu item...
            self::$menuItems[] = array($menuItemID, $menuItemLabel, NULL, $menuItemIcon, $menuItemSEOlink, $menuItemDescription, $menuItemKeywords, $menuItemAuthor);
        }
    }

    /**
     * Returns the definition of the application navigation menu. 
     * @return array An array of menu items.
     */
    static public function getMenuItems() {
        self::initMenuItems();
        $sortedMenuItems = self::$menuItems;
        ksort($sortedMenuItems);
        return array_values($sortedMenuItems);
    }

    /**
     * Returns the menu item that matches the SEO link of the current HTTP 
     * request URI (used when 'CFG_VIEW_PAGE_RELOAD' is set to TRUE).
     * If URI is ended by multiple SEO links separated by a slash, each parent
     * SEO link must exist and be a child of its parent in the menu hierarchy.
     * @return NULL|array Menu item properties as array or NULL if no menu item
     * is found in URI or if the path of SEO links is invalid.
     */
    static public function getMenuItemFromURI() {
        $urlPieces = \General::getExtraPartOfURI(FALSE);
        if (is_string($urlPieces) && $urlPieces === 'offline') {
            return array('offline');
        }
        if (\Parameters::isSetPageReload()) { 
            $urlPieces = is_string($urlPieces) ? [$urlPieces] : $urlPieces;
            $menuItem = NULL; $previousMenuItemId = NULL;
            foreach ($urlPieces as $seoLink) {
                $menuItem = self::getMenuItemByCriteria(4, $seoLink);
                $parentMenuItemId = is_array($menuItem) 
                        ? self::getParentMenuItem($menuItem[0]) : NULL;
                if (!is_array($menuItem) || ($parentMenuItemId !== $previousMenuItemId &&
                        self::getParentMenuItem($parentMenuItemId) !== $previousMenuItemId)) {
                    return NULL; // SEO link is invalid 
                }
                $previousMenuItemId = $menuItem[0];
            }
            return $menuItem; // Leaf SEO link is returned
        }
        return NULL;
    }
    
    /**
     * Returns as an array the menu item identifiers defined for the application
     * navigation menu.
     * @param array $childrenMenuItems Used by the method for its recursive calls.
     * This parameter is never directly specified when the method is called
     * externally.  
     * @return array Menu item identifiers
     */
    static public function getMenuItemIDs($childrenMenuItems = NULL) {
        $result = NULL;
        if (isset($childrenMenuItems)) {
            $menuItems = $childrenMenuItems;
        } else {
            $menuItems = self::getMenuItems();
        }
        foreach ($menuItems as $value) {
            $result[] = $value[0];
            if (isset($value[2])) { // children exist
                $result = array_merge($result, self::getMenuItemIDs($value[2]));
            }
        }
        return $result;
    }

    /**
     * Returns the menu item that matches the specified identifier 
     * @return array Specifications of the menu item.
     */
    static public function getMenuItem($menuItemID) {
        return self::getMenuItemByCriteria(0, $menuItemID); // Menu item ID is used to find the menu item
    }

    /**
     * Returns the first leaf menu item of the navigation menu 
     * @param array $childrenMenuItems Used by the method for its recursive calls.
     * This parameter is never directly specified when the method is called
     * externally. 
     * @return array Specifications of the menu item
     */
    static public function getFirstLeafMenuItem($childrenMenuItems = NULL) {
        if (isset($childrenMenuItems)) {
            $menuItems = $childrenMenuItems;
        } else {
            $menuItems = self::getMenuItems();
        }
        foreach ($menuItems as $value) {
            if (isset($value[2])) {
                $foundItem = self::getFirstLeafMenuItem($value[2]);
                if (isset($foundItem)) {
                    return $foundItem; // Menu item found
                }
            } else {
                return $value; // Menu item found
            }
        }
        return NULL;
    }

    /**
     * Returns the items of the navigation menu according a tree node format 
     * supported by the client side widget puitree. 
     * @param array $childrenMenuItems Used by the method for its recursive calls.
     * This parameter is never directly specified when the method is called
     * externally.
     * @return array An multi-dimension array of tree nodes 
     */
    static public function getMenuItemsAsTreeNodes($childrenMenuItems = NULL) {
        $result = NULL;
        if (isset($childrenMenuItems)) {
            $menuItems = $childrenMenuItems;
        } else {
            $menuItems = self::getMenuItems();
        }
        foreach ($menuItems as $value) {
            $leaf = true;
            $children = array();
            if (isset($value[2])) { // children exist
                $leaf = false;
                $children = self::getMenuItemsAsTreeNodes($value[2]);
            }
            $result[] = array("label" => $value[1], "data" => $value[0], "children" => $children);
        }
        return $result;
    }

    /**
     * Returns the identifiers of the menu items allowed to the connected user.
     * @return array Array of menu item Identifiers
     */
    static public function getAllowedMenuItems() {
        if (\Parameters::isAuthenticationRequired() && \UserSession::isAuthenticated(true)) {
            // Get menu items authorized for the authenticated user
            try {
                $allowedMenuItems = \MainController::execute('Security', 'getAllowedMenuItems');
            } catch (\Exception $e) {
                \General::writeErrorLog('ZNETDK ERROR', 'MNU-002: unable to get the menu items allowed to the user! (' .
                        $e->getCode() . ')', true);
                return FALSE;
            }
            if ($allowedMenuItems === "ALL") { // Full menu access
                return NULL;
            } else { // Menu access restrictions
                return $allowedMenuItems;
            }
        } elseif (\Parameters::isAuthenticationRequired()) {
            return FALSE;
        } else {
            return NULL;
        }
    }

    /**
     * Checks whether the specified menu is a leaf or not
     * @param string $menuItemID Identifier of the menu item
     * @return boolean
     */
    static public function isMenuItemAleaf($menuItemID) {
        $menuItem = self::getMenuItemByCriteria(0, $menuItemID);
        if (is_null($menuItem)) {
            return FALSE;
        } elseif (isset($menuItem[2])) { // children exist
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    /**
     * Get the parent menu item ID
     * @param String $menuItemID The child menu item ID
     * @param String $parentId The parent menu item ID
     * @param Array $childrenMenuItems The children menu items
     * @return String The parent menu item ID found of NULL if the no parent 
     * exists or if the specified child menu item is a root menu item.
     */
    static public function getParentMenuItem($menuItemID, $parentId = NULL, $childrenMenuItems = NULL) {
        if (isset($childrenMenuItems)) {
            $menuItems = $childrenMenuItems;
        } else {
            $menuItems = self::getMenuItems();
        }
        foreach ($menuItems as $value) {
            if ($value[0] === $menuItemID) {
                // Menu item found
                return $parentId;
            } else if (isset($value[2])) {
                $foundItem = self::getParentMenuItem($menuItemID, $value[0], $value[2]);
                if (isset($foundItem)) {
                    return $foundItem;
                }
            }
        }
        return NULL;
    }
    
    /**
     * Returns the parent menu items of the items specified as parameter.
     * @param array $menuItems The list of menu items
     * @return array Parent menu items that do not exist among menu items
     * specified in parameter.
     */
    static public function getParentMenuItems($menuItems) {
        $parents = array();
        foreach ($menuItems as $menuItemID) {            
            $parentMenuItemID = self::getParentMenuItem($menuItemID);
            if (!is_null($parentMenuItemID)
                    && array_search($parentMenuItemID, $menuItems, TRUE) === FALSE
                    && array_search($parentMenuItemID, $parents, TRUE) === FALSE) {
                $parents[] = $parentMenuItemID;
            }
        }
        return $parents;
    }

}
