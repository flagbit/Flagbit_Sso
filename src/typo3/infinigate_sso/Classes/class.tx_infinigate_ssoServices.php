<?php
require_once __DIR__."/class.tx_infinigate_abstractSso.php";

class user_tx_infinigate_ssoServices extends tx_infinigate_abstractSso {

	public function __construct() {
		parent::__construct();
		$this->fetchTyposcriptConfiguration('service_providers.');
	}

	public function provideSpoofedImgTags($content, $conf) {
			// Do nothing if no user is logged in
		if (! $GLOBALS['TSFE']->fe_user->user) {
			return '';
		}

		$this->fbSsoLib->getContainer()
			->setIdentifier($GLOBALS['TSFE']->fe_user->user['email']);

		$ssoData = $this->fbSsoLib->create($this->privateKey);

		if (strlen($ssoData) > 255) {
			t3lib_div::devLog('Warning - SSOData might be too big for HTTP GET.', $this->extKey, 2);
		}

		$output = '';
		foreach ($this->registeredSsoServiceConfiguration as $serviceName => $conf) {
			$output .= '<img src="'.str_replace('{SSOData}', $ssoData, $conf['uriTemplate']).'" />';
		}

		return $output;
	}
}