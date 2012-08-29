<?php

class Flagbit_Sso_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_privateKey = NULL;
	protected $_publicKey = NULL;
	protected $_target = NULL;
	protected $_logouturl = NULL;
	protected $_expirationFactor = NULL;
	
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
	
	public function getLogouturl()
	{
		return $this->_logouturl;
	}
	
	/**
	 * Create an encrypted string of an data array
	 * 
	 * @param array $data
	 */
	public function createSsoString(array $data) {
		
		$libObj = new Flagbit_Sso();
		
		$container = $libObj->getContainer();
		foreach($data as $param => $value) {
			$container->{'set'.ucfirst($param)}($value);
		}
		return $libObj->create($this->_privateKey);
		
	}
	
}