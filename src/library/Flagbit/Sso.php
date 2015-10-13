<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
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
 * Class Flagbit_Sso
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Matthäus Müller <m.mueller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso
{

    const DEFAULT_CONTAINER = 'Flagbit_Sso_Storage_Json';

    const DEFAULT_SIGNATURE = 'Flagbit_Sso_Signature_Openssl';

    /**
     * @var Flagbit_Sso_Storage_Interface
     */
    protected $_container = null;

    /**
     * @var Flagbit_Sso_Signature_Interface
     */
    protected $_signature = null;

    protected $_options = array();


    /**
     * set the default container and signature object
     *
     * @param array $options
     */
    public function __construct( $options = array() )
    {
        if (empty($options['containerObject'])) {
            $options['containerObject'] = self::DEFAULT_CONTAINER;
        }

        if (empty($options['signatureObject'])) {
            $options['signatureObject'] = self::DEFAULT_SIGNATURE;
        }

        $this->_options = $options;
    }


    /**
     * get the container object
     *
     * @return Flagbit_Sso_Storage_Interface
     */
    public function getContainer()
    {
        if(!($this->_container instanceof Flagbit_Sso_Storage_Interface)) {
            $this->_container = new $this->_options['containerObject'];
        }

        return $this->_container;
    }


    /**
    * get the signature object
     *
    * @param string $type
    * @return Flagbit_Sso_Signature_Interface
    */
    protected function _getSignatureObject($type)
    {
        if(!($this->_signature instanceof Flagbit_Sso_Signature_Interface)) {
            $this->_signature = new $type;
        }

        return $this->_signature;
    }


    /**
     * load the container by an encoded string
     * @param string $jsonStr
     * @return $this
     */
    public function loadContainer($jsonStr)
    {
        $this->getContainer()->setContainerFromString($jsonStr);
        return $this;
    }


    /**
     * @param string $privateKey
     * @param string $type
     * @return string
     * @throws Exception
     */
    public function create($privateKey, $type = null)
    {
        if($type == null) {
            $type =  $this->_options['signatureObject'];
        }

        if($this->_container == null) {
            throw new Exception('Container must not be empty');
        }

        $data = $this->_container->getContainerAsString();

        $this->_container->setSignature(
            $this->_getSignatureObject($type)->createSign($data, $privateKey)
        );

        return $this->_container->getContainerAsString();
    }


    /**
     * verify a signature
     *
     * @param string $publicKey
     * @param string $type
     * @return boolean
     */
    public function verify($publicKey, $type = null)
    {
        if($type == null) {
            $type = $this->_options['signatureObject'];
        }

        $signature = $this->_container->getSignature();

        $this->_container->unsetSignature();
        $data = $this->_container->getContainerAsString();
        $this->_container->setSignature($signature);

        $result = false;

        if($this->_getSignatureObject($type)->verifySign($data, $signature, $publicKey)) {
            $result = true;
        }

        return $result;
    }
}