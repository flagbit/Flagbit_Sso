<?php
// Exit, if script is called directly (must be included via eID in index_ts.php)
if (!defined ('PATH_typo3conf')) die ('Could not access this script directly!');

require_once(PATH_t3lib.'class.t3lib_userauth.php');

/* ToDo: Implement ZendLoader */
require_once(PATH_t3lib.'Flagbit/Sso.php');
require_once(PATH_t3lib.'Flagbit/Sso/Signature/Interface.php');
require_once(PATH_t3lib.'Flagbit/Sso/Signature/Openssl.php');
require_once(PATH_t3lib.'Flagbit/Sso/Storage/Interface.php');
require_once(PATH_t3lib.'Flagbit/Sso/Storage/Abstract.php');
require_once(PATH_t3lib.'Flagbit/Sso/Storage/Json.php');


class ssoAdapter extends t3lib_userauth
{
  protected $_data = NULL;
  protected $_sso = NULL;

  public function __construct()
  {
    $GLOBALS['TSFE']->fe_user = tslib_eidtools::initFeUser();
    tslib_eidtools::connectDB();
    $this->_data = t3lib_div::_GP('data');
    $this->_sso = new Flagbit_Sso;
  }

  protected function _getUserByEmail($email)
  {
	return $GLOBALS["TYPO3_DB"]->sql_fetch_assoc( $GLOBALS["TYPO3_DB"]->exec_SELECTquery( "*", "fe_users", "email='" . $email . "'" ) );
  }
  
  protected function _createUser($user)
  {
  	$GLOBALS['TSFE']->fe_user->createUserSession($user);
  }
  
  public function loginUser()
  {
	if( $this->_sso->loadContainer($this->_data)->verify( $this->_getPublicKey() ) === TRUE )
	{
		$user = $this->_getUserByEmail( $this->_sso->getContainer()->getValue('container/email') );
		if( $user )
		{
			$GLOBALS['TSFE']->fe_user->createUserSession($user);
			t3lib_utility_Http::redirect();
		} else {
			$user['mail'] = $this->_sso->getContainer()->getValue('container/email');
			$this->_createUser($user);
			$GLOBALS['TSFE']->fe_user->createUserSession($user);
			t3lib_utility_Http::redirect();
		}		
	} else {
		t3lib_utility_Http::redirect();
	}
  }

  protected function _getPublicKey()
  {
    return file_get_contents('/var/www/id_rsa.pub');
  }
}

$adapter = t3lib_div::makeInstance("ssoAdapter");
$adapter->loginUser();
?>