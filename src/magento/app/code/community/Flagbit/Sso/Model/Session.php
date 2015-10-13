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
 * Class Flagbit_Sso_Model_Session
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Jörg Weller <weller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Model_Session extends Mage_Customer_Model_Session
{


    /**
     * set the customer as logged in and redirect to the account site
     *
     * @param Mage_Customer_Model_Customer $customer
     * @return void
     */
    protected function _setCustomerAsLoggedInBySso(Mage_Customer_Model_Customer $customer)
    {
        $this->setCustomerAsLoggedIn($customer);
        Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
    }


    /**
     * get a customer model and fill it with the given content
     *
     * @param string $identifier
     * @return void
     */
    public function loginBySso($identifier)
    {
        $customer = Mage::getModel('customer/customer');
        $customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        $customer->loadByEmail($identifier);

        $this->_setCustomerAsLoggedInBySso($customer);
    }


}
