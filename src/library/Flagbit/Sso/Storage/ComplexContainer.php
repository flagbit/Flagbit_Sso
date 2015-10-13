<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP Version 5.5
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Jörg Weller <weller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @copyright  2015 Flagbit
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php
 */


/**
 * Class Flagbit_Sso_Storage_ComplexContainer
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Matthäus Müller <m.mueller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Storage_ComplexContainer extends Flagbit_Sso_Storage_Abstract
{

    protected $_pathDelimiter = '/';


    /**
     * @param string $path
     * @param array  $value
     * @return $this|Flagbit_Sso_Storage_ComplexContainer
     * @throws Exception
     */
    public function setValue($path, $value)
    {
        return $this->_set($path, $value);
    }


    /**
     * @param string $path
     * @return array
     * @throws Exception
     */
    public function getValue($path)
    {
        return $this->_get($path);
    }


    /**
     * @param string $path
     * @param array  $value
     * @return $this
     * @throws Exception
     */
    protected function _set($path, $value)
    {
        if (empty($path)) {
            throw new Exception('Path cannot be empty');
        }

        if (!is_string($path)) {
            throw new Exception('Path must be a string');
        }

        if(empty($value)) {
            throw new Exception('Value must be set');
        }

        $path = trim($path, $this->_pathDelimiter);

        $parts = explode($this->_pathDelimiter, $path);

        $pointer =& $this->_data;

        foreach ($parts as $part) {
            if (empty($part)) {
                throw new Exception('Invalid path specified: ' . $path);
            }

            if (!isset($pointer[$part])) {
                $pointer[$part] = array();
            }

            $pointer =& $pointer[$part];
        }

        $pointer = $value;
        return $this;
    }


    /**
     * @param string $path
     * @return array
     * @throws Exception
     */
    protected function _get($path)
    {
        if (empty($path)) {
            throw new Exception('Path cannot be empty');
        }

        $path = trim($path, $this->_pathDelimiter);
        $container = $this->_data;

        $parts = explode($this->_pathDelimiter, $path);

        foreach ($parts as $part) {
            if (isset($container[$part])) {
                $container = $container[$part];
            } else {
                throw new Exception('Path: ' . $part . ' is empty');
            }
        }

        $value = $container;
        return $value;
    }
}