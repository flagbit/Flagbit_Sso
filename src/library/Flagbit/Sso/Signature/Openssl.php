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
 * Class Flagbit_Sso_Signature_Interface
 *
 * @category   Flagbit
 * @package    Flagbit_Sso
 * @author     Matthäus Müller <m.mueller@flagbit.de>
 * @author     David Paz <david.paz@flagbit.de>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link       http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Flagbit_Sso_Signature_Openssl implements Flagbit_Sso_Signature_Interface
{


    /**
     * create a signature
     *
     * @param mixed  $data
     * @param string $privateKey
     * @return string
     */
    public function createSign($data, $privateKey)
    {
        $signature = null;
        openssl_sign($data, $signature, $privateKey);

        return base64_encode($signature);
    }


    /**
     * verify a signature
     *
     * @param mixed  $data
     * @param string $signature
     * @param string $publicKey
     * @return bool
     */
    public function verifySign($data, $signature, $publicKey)
    {
        $result = null;
        $result = openssl_verify($data, base64_decode($signature), $publicKey);

        // possible return values:
        // -1: error caused while trying to verify
        // 0:  invalid signature
        // 1:  valid signature
        // handle unknown == false
        return $result == 1;
    }


}