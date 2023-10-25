<?php
/**
* ZnetDK, Starter Web Application for rapid & easy development
* See official website https://www.znetdk.fr 
* Copyright (C) 2022 Pascal MARTINEZ (contact@znetdk.fr)
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
* Core Http maintenance view
*
* File version: 1.0
* Last update: 08/29/2022
*/

echo \General::getFilledMessage(LC_MSG_ERR_MAINTENANCE, \General::getAbsoluteURI(TRUE));
