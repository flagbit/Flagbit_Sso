<?php
require_once __DIR__."/class.tx_infinigate_sso_abstract.php";

class user_tx_infinigate_sso_registeredServices extends tx_infinigate_sso_abstract {

	public function __construct() {
		parent::__construct();
		$this->fetchTyposcriptConfiguration('service_providers.');
	}

	/**
	 * Generates the spoofed <img> tags for login to the registered sso services 
	 * 
	 * @return String Spoofed <img>'s
	 */
	public function provideSpoofedLoginImgTags($content, $conf) {
			// Do nothing if no user is logged in
		if (! $GLOBALS['TSFE']->fe_user->user) {
			return '';
		}

		$this->fbSsoLib->getContainer()
			->setIdentifier($GLOBALS['TSFE']->fe_user->user['email'])
			->setUUID(uniqid('Flagbit'))
			->setTimeStamp(time())
			->setAction('login');

		$ssoData = $this->fbSsoLib->create($this->privateKey);

		if (strlen($ssoData) > 255) {
			t3lib_div::devLog('Warning - SSOData might be too big for HTTP GET.', $this->extKey, 2);
		}

		$output = '';
		foreach ($this->registeredSsoServiceConfiguration as $serviceName => $conf) {
			$output .= '<img src="'.str_replace('{SSOData}', $ssoData, $conf['loginUriTemplate']).'" />';
		}

		return $output;
	}
	
	/**
	 * Generates the spooed <img> tags for logout from the registered sso services
	 */
	public function provideSpoofedLogoutImageTags($params, &$pObj) {
		$sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'infinigate_sso');			
		if ($sessionData['ssoLogout'] === 'true') {		
			foreach ($this->registeredSsoServiceConfiguration as $serviceName => $conf) {
				$imgTags[] = '<img src="'.$conf['logoutUri'].'" width="1" height="1" />';
			}
		
			$pObj->content = str_replace('</body>', implode(LF, $imgTags).LF.'</body>', $pObj->content);
			
			unset($sessionData['ssoLogout']);	
			$GLOBALS['TSFE']->fe_user->setKey('ses', 'infinigate_sso', $sessionData);
			$GLOBALS['TSFE']->fe_user->storeSessionData();
		}
	}
}