<?php

class Flagbit_Sso_Model_Session extends Mage_Customer_Model_Session
{
	
	/**
	 * 
	 * set the customer as logged in and redirect to the account site
	 * @param Mage_Customer_Model_Customer $customer
	 */
	protected function _setCustomerAsLoggedInBySso( Mage_Customer_Model_Customer $customer )
	{
		$this->setCustomerAsLoggedIn( $customer );
		Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
	}
	
	/**
	
	 * 
	 * get a customer model and fill it with the given content
	 * @param string $firstname
	 * @param string $lastname
	 * @param string $email
	 */
	public function loginBySso($identifier)
	{
		$customer = Mage::getModel('customer/customer');
		$customer->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
		$customer->loadByEmail($identifier);
		
		$this->_setCustomerAsLoggedInBySso($customer);
	}
}
