<?php
class Flagbit_Sso_Model_Observer
{
	public function bindCustomerLogout($observer)
	{
		Mage::getSingleton("core/session")->setCustomerLoggedOut(true);
		return $this;
	}
}