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
 * Core Navigation menu renderer
 *
 * File version: 1.5
 * Last update: 06/09/2024
 */

/** ZnetDK core navigation menu renderer called by the \Layout class to generate
 * the navigation menu in HTML format */
Class MenuRenderer {
    /**
     * Renders the HTML navigation menu based on the TabView primeui widget. This
     * menu is rendered for the 'classic' layout.
     * @param int $level Hierarchical level of the menu set to the value 1 when
     * called the first time.
     * @param array $sortedMenuItems Menu items to render in the HTML menu
     * @param string $selectedMenuItem Menu item identifier to select in the
     *  menu when the configuration parameter CFG_VIEW_PAGE_RELOAD is set to TRUE.
     * @param array $allowedMenuItems Menu items which are granted to the connected
     * user thru its profile definition.
     */
    static public function renderTabViewMenu($level, $sortedMenuItems, $selectedMenuItem, $allowedMenuItems = null) {
        $menuId = 'zdk-classic-menu';
        $level2MenuClass = $menuId . '-level2';
        $pageReloadEnabled = \Parameters::isSetPageReload();
        $nbTabs = 3 * $level;
        $indent = $level === 1 ? str_repeat("\t", 3) : str_repeat("\t", 4 + $level);
        if ($level === 1) { // Level one menu
            // Class 'zdk-pagereload' added to menu if page reload is set.
            $pgReloadClass = $pageReloadEnabled ? ' class="zdk-pagereload"' : null;
            echo "$indent<div id=\"{$menuId}\"{$pgReloadClass}>" . PHP_EOL;
        } else { // Level two menu
            echo "$indent<div class=\"{$level2MenuClass}\">" . PHP_EOL;
        }
        // Menu tab labels
        echo str_repeat("\t", $nbTabs + 1) . "<ul>" . PHP_EOL;
        foreach ($sortedMenuItems as $value) {
            if (!is_array($allowedMenuItems) || (is_array($allowedMenuItems) && array_search($value[0], $allowedMenuItems) !== false)) {
                if ($pageReloadEnabled) {
                    // Page is reloaded each time the user clicks on a menu item
                    $mainScript = \General::getMainScript(TRUE);
                    if (isset($value[2])) {
                        // Sub-menu items exist, the menu link references the first sub-menu item
                        $hrefLink = isset($value[2][0][4]) ? "{$value[2][0][4]}" :
                            \General::addGetParameterToURI(
                                    \General::addGetParameterToURI($mainScript, 'control', $value[2][0][0]),
                                    'action','show');
                    } else {
                        // No sub-menu item exists, the menu link references the current menu item
                        $hrefLink = isset($value[4]) ? "$value[4]" :
                            \General::addGetParameterToURI(
                                    \General::addGetParameterToURI($mainScript, 'control', $value[0]),
                                    'action','show');
                    }
                } else {
                    // No page link, just an HTML anchor (view content loaded dynamically or fully loaded first time)
                    $hrefLink = "#$value[0]";
                }
                echo str_repeat("\t", $nbTabs + 2) . "<li><a href=\"$hrefLink\">$value[1]</a></li>" . PHP_EOL;
            }
        }
        echo str_repeat("\t", $nbTabs + 1) . "</ul>" . PHP_EOL;
        // Menu tab contents
        echo str_repeat("\t", $nbTabs + 1) . "<div>" . PHP_EOL;
        foreach ($sortedMenuItems as $value) {
            if (!is_array($allowedMenuItems) || (is_array($allowedMenuItems) && array_search($value[0], $allowedMenuItems) !== false)) {
                echo str_repeat("\t", $nbTabs + 2) . "<div id=\"menu-$value[0]\">" . PHP_EOL;
                if (isset($value[2]) && $level === 1) {
                    // Level two menu
                    self::renderTabViewMenu($level + 1, $value[2], $selectedMenuItem, $allowedMenuItems);
                } else {
                    if ($pageReloadEnabled && !isset($selectedMenuItem)) {
                        // The first menu item is loaded
                        $selectedMenuItem = $value[0];
                    }
                    if ($level === 1) {
                        // A panel is inserted if no level 2 menu item exists
                        echo str_repeat("\t", $nbTabs + 3) . "<div class='tab_panel' title=\"$value[1]\">" . PHP_EOL;
                    }
                    if ((CFG_VIEW_PRELOAD && !$pageReloadEnabled) || ($pageReloadEnabled && $selectedMenuItem === $value[0])) {
                        // View content loaded before access
                        echo str_repeat("\t", $nbTabs + 3 + ($level === 1 ? 1 : 0)) . '<div class="zdk-filled">' . PHP_EOL;
                        \MainController::renderView($value[0], 'show');
                        echo str_repeat("\t", $nbTabs + 3 + ($level === 1 ? 1 : 0)) . '</div>' . PHP_EOL;
                    } elseif (!CFG_VIEW_PRELOAD && !$pageReloadEnabled) {
                        // View content loaded on demand
                        echo str_repeat("\t", $nbTabs + 4) . "<div class=\"zdk-dynamic-content\"></div>" . PHP_EOL;
                    }
                    if ($level === 1) {
                        // Close panel insertion
                        echo str_repeat("\t", $nbTabs + 3) . "</div>" . PHP_EOL;
                    }
                }
                echo str_repeat("\t", $nbTabs + 2) . "</div>" . PHP_EOL;
            }
        }
        echo str_repeat("\t", $nbTabs + 1) . "</div>" . PHP_EOL;
        echo str_repeat("\t", $nbTabs) . "</div>" . PHP_EOL;
    }

    /**
     * Renders the HTML navigation menu based on the Vertical menu of the primeui
     * widget. This menu is rendered for the 'office' layout.
     * @param int $level Hierarchical level of the menu set to the value 1 when
     * called the first time.
     * @param array $sortedMenuItems Menu items to render in the HTML menu
     * @param string $selectedMenuItem Menu item identifier to select in the
     *  menu when the configuration parameter CFG_VIEW_PAGE_RELOAD is set to TRUE.
     * @param array $allowedMenuItems Menu items which are granted to the connected
     * user thru its profile definition.
     */
    static public function renderVerticalMenu($level, $sortedMenuItems, $selectedMenuItem, $allowedMenuItems = null) {
        $menuId = 'zdk-office-menu';
        $nbTabs = 3;
        if ($level === 1) {
            echo str_repeat("\t", $nbTabs) . '<div id="' . $menuId . '">' . PHP_EOL;
        }
        $nbTabs += $level;
        echo str_repeat("\t", $nbTabs) . '<ul>' . PHP_EOL;
        foreach ($sortedMenuItems as $value) {
            if (!is_array($allowedMenuItems) || (is_array($allowedMenuItems) && array_search($value[0], $allowedMenuItems) !== false)) {
                if (isset($value[3])) {
                    $iconAttr = " data-icon=\"$value[3]\"";
                } else {
                    $iconAttr = '';
                }
                echo str_repeat("\t", $nbTabs + 1) . "<li><a href=\"#$value[0]\"$iconAttr>$value[1]</a>";
                if (isset($value[2])) {
                    // submenu exists...
                    echo PHP_EOL;
                    self::renderVerticalMenu($level + 2, $value[2], $selectedMenuItem, $allowedMenuItems);
                    echo str_repeat("\t", $nbTabs + 1) . "</li>" . PHP_EOL;
                } else {
                    echo "</li>" . PHP_EOL;
                }
            }
        }
        echo str_repeat("\t", $nbTabs) . '</ul>' . PHP_EOL;
        if ($level === 1) {
            echo str_repeat("\t", $nbTabs) . '<div class="zdk-win-manager" title="' . LC_WINMGR_TITLE . '">' . PHP_EOL;
            echo str_repeat("\t", $nbTabs + 1) . '<span>' . LC_WINMGR_AUTOCLOSE . '</span>' . PHP_EOL;
            echo str_repeat("\t", $nbTabs + 1) . '<span>' . LC_WINMGR_ADJUST_HORIZ . '</span>' . PHP_EOL;
            echo str_repeat("\t", $nbTabs + 1) . '<span>' . LC_WINMGR_ADJUST_VERTI . '</span>' . PHP_EOL;
            echo str_repeat("\t", $nbTabs + 1) . '<span>' . LC_WINMGR_CLOSE_ALL . '</span>' . PHP_EOL;
            echo str_repeat("\t", $nbTabs) . '</div>' . PHP_EOL;
            echo str_repeat("\t", $nbTabs - 1) . '</div>' . PHP_EOL;
            echo str_repeat("\t", $nbTabs - 1) . '<div id="zdk-win-container"></div>' . PHP_EOL;
        }
    }

    /**
     * Renders the generic HTML navigation menu for the 'custom', 'mobile'
     * and other page layouts.
     * The 'is-selected' CSS class is added to the menu items which are selected
     * (parent and child items).
     * The 'has-sub' CSS class is added to the parent menu items which have
     * subitems.
     * For the 'mobile' layout, only two levels of menu item definition is taken
     * in account.
     * @param int $level Hierarchical level of the menu set to the value 1 when
     * called the first time.
     * @param array $sortedMenuItems Menu items to render in the HTML menu
     * @param string $selectedMenuItem Menu item identifier to select in the
     *  menu when the configuration parameter CFG_VIEW_PAGE_RELOAD is set to TRUE.
     * @param array $allowedMenuItems Menu items which are granted to the logged
     * in user thru its profile definition.
     */
    static public function renderCustomMenu($level, $sortedMenuItems, $selectedMenuItem, $allowedMenuItems = null) {
        $subMenuAllowed = \Parameters::getPageLayoutName() !== 'mobile' || $level === 1;
        $isSetPageReload = \Parameters::isSetPageReload();
        $menuId = 'id="zdk-custom-menu"';
        $nbTabs = 3 + $level;
        $mainScript = \General::getMainScript(TRUE);
        if ($level === 1) {
            // Menu container begin tag
            $cssClassPageReload = $isSetPageReload ? ' class="zdk-pagereload"' : null;
            echo "<div {$menuId}{$cssClassPageReload}>" . PHP_EOL;
            // Default selected menu item
            if (is_null($selectedMenuItem) && key_exists(0, $sortedMenuItems)) {
                $selectedMenuItem =  key_exists(2, $sortedMenuItems[0]) && isset($sortedMenuItems[0][2])
                    ? $sortedMenuItems[0][2][0][0] : $sortedMenuItems[0][0];
            }
        }
        echo str_repeat("\t", $nbTabs) . '<ul>' . PHP_EOL;
        foreach ($sortedMenuItems as $value) {
            if (!is_array($allowedMenuItems) || (is_array($allowedMenuItems) && array_search($value[0], $allowedMenuItems) !== false)) {
                $cssClasses = [];
                if ($subMenuAllowed && isset($value[2])) {
                    $cssClasses[] = 'has-sub';
                }
                if ($value[0] === $selectedMenuItem ||
                        (isset($value[2]) && in_array($selectedMenuItem, array_column($value[2], 0)))) {
                    $cssClasses[] = 'is-selected';
                }
                $itemCssClasses = count($cssClasses) > 0 ? ' class="' . implode(' ', $cssClasses) . '"' : '';
                $hrefLink = "#";
                if ($isSetPageReload) {
                    $retainedValue = $subMenuAllowed && isset($value[2])
                        ? $value[2][0] // Sub-menu items exist, the link correspond to the first sub-menu item
                        : $value; // leaf item
                    $isUrl = isset($retainedValue[4]) && preg_match('/^http(s)?:\/\//', $retainedValue[4]);
                    $hrefLink = isset($retainedValue[4])
                        ? ($isUrl ? $retainedValue[4] : General::getAbsoluteURI() . $retainedValue[4]) // SEO URI
                        : \General::addGetParameterToURI(\General::addGetParameterToURI( // URI with parameters control & action
                            $mainScript, 'control', $retainedValue[0]), 'action', 'show');
                }
                $viewID = "id=\"znetdk-{$value[0]}-menu\"";
                $iconAttr = isset($value[3]) ? " data-icon=\"$value[3]\"" : '';
                echo str_repeat("\t", $nbTabs + 1) . "<li " . $viewID . $itemCssClasses
                        . "><a href=\"{$hrefLink}\"{$iconAttr} title=\"{$value[1]}\">{$value[1]}</a>";
                if ($subMenuAllowed && isset($value[2])) { // submenu exists...
                    echo PHP_EOL;
                    self::renderCustomMenu($level + 2, $value[2], $selectedMenuItem, $allowedMenuItems);
                    echo str_repeat("\t", $nbTabs + 1) . "</li>" . PHP_EOL;
                } else { // leaf item
                    echo "</li>" . PHP_EOL;
                }
            }
        }
        echo str_repeat("\t", $nbTabs) . '</ul>' . PHP_EOL;
        if ($level === 1) { // Menu container end tag
            echo str_repeat("\t", $nbTabs - 1) . '</div>' . PHP_EOL;
        }
    }
}
