<?php 
class Flagbit_Sso_Block_Abstract extends Mage_Core_Block_Template {
	
	protected  function _initParams()
	{
		$customerSession = Mage::getSingleton('customer/session');

		if($customerSession->isLoggedIn()) {
			$customer = $customerSession->getCustomer();
			$params = array(
				'Identifier'	=> $customer->getEmail()
			);
			return Mage::helper('sso')->createSsoString($params);			
		}
		
		return '';
	}
}