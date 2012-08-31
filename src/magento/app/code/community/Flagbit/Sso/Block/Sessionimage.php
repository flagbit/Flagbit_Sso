<?php
class Flagbit_Sso_Block_Sessionimage extends Flagbit_Sso_Block_Abstract
{
    protected function _toHtml()
    {
     	$param = $this->_initParams();
     	$html = '';
		$session = Mage::getSingleton('core/session');
		$helper = Mage::helper('sso/data');

	    if(!empty($param)){
		     $url = $helper->getTarget();
		     $html = '<img src="'.$url.$param.'" width="1" height="1" border="0" />';
	    } elseif( true === $session->getCustomerLoggedOut() && $helper->getLogouturl() ) {
	     	$url = $helper->getLogouturl();
		     $html = '<img src="'.$url.'" width="1" height="1" border="0" />';
	    }
		 
		return $html;
    }
}