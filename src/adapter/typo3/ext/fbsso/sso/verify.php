<?php
// Exit, if script is called directly (must be included via eID in index_ts.php)
if (!defined ('PATH_typo3conf')) die ('Could not access this script directly!');

require_once(PATH_t3lib.'class.t3lib_svbase.php');

/* ToDo: Implement ZendLoader */
require_once(PATH_t3lib.'Flagbit/Sso.php');
require_once(PATH_t3lib.'Flagbit/Sso/Signature/Interface.php');
require_once(PATH_t3lib.'Flagbit/Sso/Signature/Openssl.php');
require_once(PATH_t3lib.'Flagbit/Sso/Storage/Interface.php');
require_once(PATH_t3lib.'Flagbit/Sso/Storage/Abstract.php');
require_once(PATH_t3lib.'Flagbit/Sso/Storage/Json.php');


class sso_test extends tx_sv_authbase
{
  protected $_data = NULL;
  protected $_sso = NULL;

  public function __construct()
  {
    $this->_data = t3lib_div::_GP('data');
    $this->_sso = new Flagbit_Sso;
  }

  public function verify()
  {
   $OK = FALSE;
   if( $this->_sso->loadContainer($this->_data)->verify( $this->_getPublicKey() ) === TRUE ) {
    $OK = TRUE;
   } else {
    $OK = FALSE;
  }
   return $OK;
  }

  protected function _getPublicKey()
  {
    return file_get_contents('/var/www/id_rsa.pub');
  }
}

$output = t3lib_div::makeInstance("sso_test");

if( $output->verify() === TRUE ) {
	//ToDo: Implement authservice
} else {
	//ToDo: Implement redirection
}
?>
