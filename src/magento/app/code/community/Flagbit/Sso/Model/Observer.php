<?php
class Flagbit_Sso_Model_Observer
{

    /**
     * @param $observer
     * @return Flagbit_Sso_Model_Observer
     */
    public function bindCustomerLogout($observer)
    {
        /* @var $cookie Mage_Core_Model_Cookie */
        $cookie = Mage::getSingleton("core/cookie");
        $cookie->set('logout', true);

        return $this;
    }
}