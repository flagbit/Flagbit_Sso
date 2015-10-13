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
 * Class Flagbit_Sso_Storage_Json
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Matthäus Müller <m.mueller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Storage_Json extends Flagbit_Sso_Storage_Abstract
{


    /**
     * serialize and encode an array
     *
     * @return string
     */
    public function getContainerAsString()
    {
        $str = $this->_encode(json_encode(serialize($this->_data)));
        return $str;
    }


    /**
     * unserialize and decode an string
     *
     * @param string $str
     * @return Flagbit_Sso_Storage_Json
     */
    public function setContainerFromString($str)
    {
        $str = unserialize(json_decode($this->_decode($str)));

        $this->_data = $str;
        return $this;
    }
}