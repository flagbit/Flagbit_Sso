<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
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
 * Class Flagbit_Sso_Helper_Data
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Jörg Weller <weller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_privateKey = null;

    protected $_publicKey = null;

    protected $_target = null;

    protected $_logouturl = null;

    protected $_expirationFactor = null;


    /**
     *
     * @desc Load the stored privateKey and publicKey
     */
    public function __construct()
    {
        $this->_privateKey = Mage::getStoreConfig('customer/sso/privateKey');
        $this->_publicKey = Mage::getStoreConfig('customer/sso/publicKey');
        $this->_target = Mage::getStoreConfig('customer/sso/target');
        $this->_logouturl = Mage::getStoreConfig('customer/sso/logouturl');
        $this->_expirationFactor = Mage::getStoreConfig('customer/sso/expirationFactor');
    }


    /**
     *
     * @desc returns the stored privateKey
     * @return string $_privateKey
     */
    public function getPrivateKey()
    {
        return $this->_privateKey;
    }


    /**
     *
     * @desc returns the stored publicKey
     * @return string $_publicKey
     */
    public function getPublicKey()
    {
        return $this->_publicKey;
    }


    /**
     *
     * @desc returns the stored target
     * @return string $_target
     */
    public function getTarget()
    {
        return $this->_target;
    }


    /**
     *
     * @desc returns the stored logout url
     * @return string $_logouturl
     */
    public function getLogouturl()
    {
        return $this->_logouturl;
    }


    /**
     * Create an encrypted string of an data array
     *
     * @param array $data
     * @return string
     */
    public function createSsoString(array $data)
    {
        $libObj = new Flagbit_Sso();

        $container = $libObj->getContainer();
        foreach($data as $param => $value) {
            $container->{'set'.ucfirst($param)}($value);
        }

        return $libObj->create($this->_privateKey);
    }


}