<?php

class Flagbit_Sso_Helper_Data extends Mage_Core_Helper_Abstract
{
	protected $_privateKey = NULL;
	protected $_publicKey = NULL;

	/**
	 * 
	 * @desc Load the stored privateKey and publicKey
	 */
	public function __construct()
	{
		$this->_privateKey = Mage::getStoreConfig('customer/sso/privateKey');
		$this->_publicKey = Mage::getStoreConfig('customer/sso/publicKey');
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
}