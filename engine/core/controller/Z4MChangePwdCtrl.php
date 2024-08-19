<?php
/**
 * ZnetDK, Starter Web Application for rapid & easy development
 * See official website https://mobile.znetdk.fr
 * Copyright (C) 2024 Pascal MARTINEZ (contact@znetdk.fr)
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
 * Core application controller for loading change password view on mobile
 *
 * File version: 1.0
 * Last update: 06/01/2024
 */

namespace controller;
/**
 * Display of the Change password view on mobile
 */
class Z4MChangePwdCtrl extends \AppController {

    static protected function action_show() {
        $response = new \Response(FALSE); // FALSE --> no authentication required
        if (CFG_AUTHENT_REQUIRED === TRUE) {
            $response->setView('z4mchangepwd', 'view');
        } else {
            $response->doHttpError(403, LC_MSG_ERR_FORBIDDEN_ACTION_SUMMARY,
                    LC_MSG_ERR_FORBIDDEN_ACTION_MESSAGE);
        }
        return $response;
    }

}
