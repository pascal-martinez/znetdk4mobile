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
 * ZnetDK core exception class  
 *
 * File version: 1.3
 * Last update: 12/06/2024
 */

/**
 * Exceptions thrown by ZnetDK
 */
class ZDKException extends \Exception {

    protected $code = '';
    protected $messageWithoutCode = '';

    /**
     * Instantiates a ZDKException object.
     * @param string $message The error message. The first seven characters are
     * used to specify the exception ID. 
     * For example: 'ABC-001: text of my exception' 
     * @param \Exception $previous The previous exception used for the exception
     * chaining.
     */
    public function __construct($message, ?\Exception $previous = NULL) {
        if (is_string($message) && strlen($message) > 7) {
            $this->code = substr($message, 0, 7);
            $this->messageWithoutCode = trim(substr($message, 8));
        }
        parent::__construct($message, 0, $previous);
    }

    /**
     * Returns the exception message without the error code 
     * @return string Exception message without the error code
     */
    public function getMessageWithoutCode() {
        return $this->messageWithoutCode;
    }
}
