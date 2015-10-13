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
 * Class Flagbit_Sso_Storage_Abstract
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Matthäus Müller <m.mueller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Storage_Abstract implements Flagbit_Sso_Storage_Interface
{

    protected $_data = array();


    /**
     * encode a string in base64
     *
     * @param string $str
     * @return string
     */
    protected function _encode($str)
    {
        return strtr(
            base64_encode($str),
            array('/' => '_', '+' => '-', '=' => '')
        );
    }


    /**
     * decode a base62 encoded string
     *
     * @param string $str
     * @return string
     */
    protected function _decode($str)
    {
        $str = strtr(
            $str,
            array(
                '_' => '/',
                '-' => '+',
            )
        );

        if (strlen($str) % 2 != 0) {
            $str .= '=';
        }

        return base64_decode($str);
    }


    /**
     * using the magic function __call to provide pseudo getter/setter
     *
     * @param string $func
     * @param array  $args
     * @return Flagbit_Sso_Storage_SimpleContainer|mixed
     */
    public function __call($func, $args)
    {
        if ((substr($func, 0, 3) === 'get')) {
            return $this->_get(substr($func, 3));
        } elseif ((substr($func, 0, 3) === 'set' )) {
            return $this->_set(substr($func, 3), $args[0]);
        } elseif ((substr($func, 0, 5) === 'unset' )) {
            return $this->_unset(substr($func, 5));
        }
    }


    /**
     * @param string $key
     * @param string $name
     * @return Flagbit_Sso_Storage_SimpleContainer
     */
    protected function _set($key, $name)
    {
        $this->_data[$key] = $name;
        return $this;
    }


    /**
     * @param string $key
     * @return Flagbit_Sso_Storage_SimpleContainer
     */
    protected function _unset($key)
    {
        unset($this->_data[$key]);
        return $this;
    }


    /**
     * @param string $key
     * @return mixed
     */
    protected function _get($key)
    {
        return $this->_data[$key];
    }


    /**
     * @param string $str
     * @return string
     */
    public function setContainerFromString($str)
    {
        $str = unserialize($this->_decode($str));

        $this->_data = $str;
        return $this;
    }


    /**
     * @return string
     */
    public function getContainerAsString()
    {
        $str = $this->_encode(serialize($this->_data));
        return $str;
    }


}