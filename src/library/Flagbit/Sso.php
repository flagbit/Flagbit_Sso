<?php

class Flagbit_Sso
{
	const DEFAULT_CONTAINER = 'Flagbit_Sso_Storage_Json';
	const DEFAULT_SIGNATURE = 'Flagbit_Sso_Signature_Openssl';

	protected $_container = NULL;
	protected $_signature = NULL;
	protected $_options = array();

	/**
	 * 
	 * @desc set the default container and signature object
	 * @param array $options
	 */
	public function __construct( $options = array() )
	{
		if( empty($options['containerObject']) ) {
			$options['containerObject'] = self::DEFAULT_CONTAINER;
		}

		if( empty($options['signatureObject']) ) {
			$options['signatureObject'] = self::DEFAULT_SIGNATURE;
		}
		$this->_options = $options;
	}

	/**
	 * @desc get the container object
	 * @return Flagbit_Sso_Storage_Interface
	 */
	public function getContainer()
	{
		if( !($this->_container instanceof Flagbit_Sso_Storage_Interface) ) {
			$this->_container = new $this->_options['containerObject'];
		}
		return $this->_container;
	}
	
	
	/**
	*
	* @desc get the signature object
	* @param string $type
	* @return Flagbit_Sso_Signature_Interface
	*/
	protected function _getSignatureObject($type)
	{
		if( !($this->_signature instanceof Flagbit_Sso_Signature_Interface) ) {
			$this->_signature = new $type;
		}
		return $this->_signature;
	}
	

	/**
	 * 
	 * @desc load the container by an encoded string
	 * @param string $jsonStr
	 */
	public function loadContainer($jsonStr)
	{
		$this->getContainer()->setContainerFromString($jsonStr);
		return $this;
	}

	/**
	 *
	 * @desc create a signature
	 * @param string $privateKey
	 * @param string $type
	 * @return string
	 */
	public function create($privateKey, $type = NULL)
	{
		if( is_null($type) ) {
			$type =  $this->_options['signatureObject'];
		}

		if( is_null($this->_container) ) {
			throw new Exception('Container must not be empty');
		}

		$data = $this->_container->getContainerAsString();

		$this->_container->setSignature(
										$this->_getSignatureObject($type)
										->createSign(
														$data,
														$privateKey
													)
										);
		return $this->_container->getContainerAsString();
	}

	/**
	 *
	 * verify a signature
	 * @param string $publicKey
	 * @param string $signature
	 * @param string $type
	 * @return boolean
	 */
	public function verify($publicKey, $type = NULL)
	{
		if( is_null($type) ) {
			$type = $this->_options['signatureObject'];
		}

		
		$signature = $this->_container->getSignature();
		
		$this->_container->unsetSignature();
		$data = $this->_container->getContainerAsString();
		$this->_container->setSignature($signature);
		
		
		
		$result = FALSE;
		
		if( $this->_getSignatureObject($type)->verifySign($data, $signature, $publicKey)) {
			$result = TRUE;
		}
		
		return $result;
	}
}