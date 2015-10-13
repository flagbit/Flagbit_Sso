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
 * Class Flagbit_Sso_Block_Sessionimage
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Matthäus Müller <m.mueller@flagbit.de>
 * @author     Jörg Weller <weller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Block_Sessionimage extends Flagbit_Sso_Block_Abstract
{


    /**
     * @return string
     */
    protected function _toHtml()
    {
        $param = $this->_initParams();
        $html = '';
        $helper = Mage::helper('sso/data');

        /* @var $cookie Mage_Core_Model_Cookie */
        $cookie = Mage::getSingleton("core/cookie");

        if (!empty($param)) {
             $url = $helper->getTarget();
             $html = '<img src="'.$url.$param.'" width="1" height="1" border="0" />';
        } elseif ($cookie->get('logout') && $helper->getLogouturl()) {
             $cookie->delete('logout');
             $url = $helper->getLogouturl();
             $html = '<img src="'.$url.'" width="1" height="1" border="0" />';
        }

        return $html;
    }
}