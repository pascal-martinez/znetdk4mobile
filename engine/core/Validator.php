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
 * Core Data validation API 
 *
 * File version: 1.3
 * Last update: 03/22/2023
 */

/**
 * Data validator applied to values transmitted to the received HTTP request
 * This class must be extended by the custom validator
 */
abstract class Validator {

    // properties declaration
    private $variables;
    private $request;
    private $optionalVariables;
    private $errorMessage;
    private $errorVariable;
    private $values = array();
    private $checkMissingValues = FALSE;

    // Abstract methods
    abstract protected function initVariables();

    // Optionnal child method
    protected function initOptionalVariables() {
        return array();
    }

    // methods declaration
    public function __construct($checkAuthentication = TRUE) {
        $this->request = new \Request($checkAuthentication);
        $this->variables = $this->initVariables();
        if (!is_array($this->variables)) {
            $message = "VAL-001: the method ".get_class($this)."::initVariables() must return an array!";
            \General::writeErrorLog('ZNETDK ERROR', $message, true);
            throw new \ZDKException($message);
        } else if (count($this->variables) === 0) {
            $message = "VAL-002: the array returned by the method ".get_class($this)."::initVariables() is empty!";
            \General::writeErrorLog('ZNETDK ERROR', $message, true);
            throw new \ZDKException($message);
        }
        $this->optionalVariables = $this->initOptionalVariables();
        $unknownVariable = NULL;
        if (!$this->doOptionalVariablesExist($unknownVariable)) {
            $message = "VAL-003: the array returned by the method ".get_class($this).
                    "::initOptionalVariables() contains the unknown variable '{$unknownVariable}'!";
            \General::writeErrorLog('ZNETDK ERROR', $message, true);
            throw new \ZDKException($message);
        }
    }

    public function setValues($values) {
        if (is_array($values) && count($values) > 0) {
            $this->values = $values;
        } else {
            $message = "VAL-005: the value passed to the method ".get_class($this).
                    "::setValues() is invalid!";
            \General::writeErrorLog('ZNETDK ERROR', $message, true);
            throw new \ZDKException($message);
        }
    }
    
    /**
     * Forces the checking by the derived validation methods
     * @param boolean $option TRUE by default
     */
    public function setCheckingMissingValues($option = TRUE) {
        $this->checkMissingValues = $option;
    }
    
    /**
     * Returns the value for the specified variable which has been transmitted
     * in the HTTP request
     * @param string $variable Variable name
     * @return mixed Value of the variable
     */
    public function getValue($variable) {
        if (count($this->values) > 0) {
            return key_exists($variable, $this->values) ? $this->values[$variable] : NULL;
        } else {
            return $this->request->$variable;
        }
    }

    /**
     * Returns the values which have been checked by the custom validator
     * @return array Map of values where the key matches the variable name
     */
    public function getValues() {
        if (count($this->values) > 0) {
            return $this->values;
        } else {
            return $this->request->getArrayAsMap($this->variables);
        }
    }

    /**
     * Returns the error message set by the custom validator method which
     * has detected an error on the data.
     * @return string Error message label
     */
    public function getErrorMessage() {
        return $this->errorMessage;
    }

    /**
     * Returns the first variable name for which an error has been detected. 
     * @return string Variable name
     */
    public function getErrorVariable() {
        return $this->errorVariable;
    }

    /**
     * Validate data specified in the custom validator 
     * @return boolean TRUE if data have been validated successfully else FALSE.
     */
    public function validate() {
        // Control each column value...
        foreach ($this->variables as $variable) {
            $value = $this->getValue($variable);
            if ((isset($value) ||
                    (!isset($value) && $this->checkMissingValues)) &&
                    $this->validateData($variable, $value) === FALSE) {
                // Specific controls for the value
                $this->setErrorVariable($variable);
                return FALSE;
            } elseif (!isset($value) && $this->isVariableRequired($variable)) {
                // Variable is mandatory and nevertheless no value is set
                $this->setErrorMessage($this->getMessageEmptyValue($variable));
                $this->errorVariable = $variable;
                return FALSE;
            } 
        }
        return TRUE;
    }

    /**
     * Indicates whether a checking method exists or not 
     * @param string $variable Name of the variable for which the existence of
     * a checking method is tested
     * @return mixed FALSE if no checking method exist, otherwise the name of
     * the existing method.
     */
    private function doesCheckingMethodExist($variable) {
        $method = 'check_' . $variable;
        if (!method_exists($this, $method)) {
            return FALSE;
        } else {
            return $method;
        }
    }
    
    /**
     * Validates the $value of the specified variable
     * @param string $variable Variable name
     * @param mixed $value Value to check
     * @return boolean TRUE if value is valid else FALSE
     */
    private function validateData($variable, $value) {
        $method = $this->doesCheckingMethodExist($variable);
        if ($method) {
            $status = $this->$method($value);
            if (!$status) {
                $this->checkIfmessageIsSet($method);
                return FALSE;
            }
        }
        return TRUE;
    }
    
    /**
     * Checks if an error message has been set by the specified checking method
     * @param string $method Last method name called to check variable value
     */
    private function checkIfmessageIsSet($method) {
        $message = $this->getErrorMessage();
        if (!isset($message)) {
            $message = "VAL-004: the error message has not be set by the method ".get_class($this)."::".$method."()!";
            \General::writeErrorLog('ZNETDK ERROR', $message, TRUE);
            throw new \ZDKException($message);
        }
    }
    
    /**
     * Sets the error message matching the error detected from a custom validator
     * method
     * @param string $errorMessage Error message label
     */
    protected function setErrorMessage($errorMessage) {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Sets the variable in error from a custom validator method
     * @param string $variable Variable name
     */
    protected function setErrorVariable($variable) {
        if (!isset($this->errorVariable)) {
            $this->errorVariable = $variable;
        }
    }
    /**
     * Indicates whether a variable is mandatory or not.
     * @param string $variable Variable name
     * @return boolean TRUE if the specified variable is mandatory 
     */
    private function isVariableRequired($variable) {
        if (is_array($this->optionalVariables) && count($this->optionalVariables) > 0) {
            if (array_search($variable, $this->optionalVariables) === FALSE) {
                // Variable is required
                return TRUE;
            } else {
                // Variable is optional
                return FALSE;
            }
        }
    }

    /**
     * Returns the error message defined for the constant LC_MSG_ERR_MISSING_VALUE
     * filled with the variable name for a which a value is mandatory.
     * @param string $variable Variable name
     * @return string Error message label
     */
    private function getMessageEmptyValue($variable) {
        return \General::getFilledMessage(LC_MSG_ERR_MISSING_VALUE_FOR,$variable);
    }
    
    /**
     * Checks whether the optional variables defined for the validator match the
     * variables to be controled by the validator
     * @param string $unknownVariable
     * @return boolean TRUE if all optional variables (property 'optionalVariables')
     * exist amoung the variables to check by the validator (property 'variables').
     * Return FALSE otherwise;
     */
    private function doOptionalVariablesExist(&$unknownVariable) {
        if (is_array($this->optionalVariables) && count($this->optionalVariables) > 0) {
            foreach ($this->optionalVariables as $variable) {
                if (array_search($variable, $this->variables) === FALSE) {
                    $unknownVariable = $variable;
                    return FALSE;
                }
            }
            return TRUE;
        } else {
            return TRUE;
        }
    }

}
