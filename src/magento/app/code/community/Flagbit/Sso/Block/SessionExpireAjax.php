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
 * Class Flagbit_Sso_Block_Sessionajax
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Jörg Weller <weller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Block_SessionExpireAjax extends Flagbit_Sso_Block_Abstract
{


    /**
     * @return string
     */
    protected function _initParams()
    {
        $customerSession = Mage::getSingleton('customer/session');

        $customer = $customerSession->getCustomer();
        $params = array(
            'Identifier' => $customer->getEmail(),
            'FirstName' => $customer->getFirstname(),
            'LastName' => $customer->getLastname(),
            'Password' => $customer->getPasswordHash(),
            'Action' => 'logout',
            'TimeStamp' => time(),
            'UUID' => uniqid('Flagbit')
        );

        return Mage::helper('sso')->createSsoString($params);
    }


    /**
     * @return string
     */
    protected function _toHtml()
    {
        $param = $this->_initParams();
        $html = '';

        if (!empty($param)) {
            $url = Mage::helper('sso/data')->getLogouturl();
            $ajaxRequest = 'new Ajax.Request(\'' . $url . '\', { method:\'post\', parameters:{sso: \''.$param.'\'} });';
            $html = '<script type="text/javascript">' . $ajaxRequest . '</script>';
        }

        return $html;
    }


}
