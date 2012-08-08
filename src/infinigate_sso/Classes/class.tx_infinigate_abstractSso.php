<?php
require_once __DIR__.'/Utility/Flagbit_Sso/src/library/Flagbit/Sso.php';

class tx_infinigate_abstractSso {

	protected $extKey = 'infinigate_sso';

	protected $tsfe = NULL;

	protected $fbSsoLib = NULL;

	protected $registeredSsoServiceConfiguration = array();

	protected $privateKey = NULL;

	protected $publicKey = NULL;

	public function __construct() {
		$this->fbSsoLib = t3lib_div::makeInstance('Flagbit_Sso');
		$this->initTSFE();
		$this->fetchSslKeys();
	}

	protected function initTSFE() {
		$this->tsfe = &$GLOBALS['TSFE'];
		if ($this->tsfe === NULL) {
			$this->tsfe = t3lib_div::makeInstance(
				'tslib_fe',
				$GLOBALS['TYPO3_CONF_VARS'],
				intval(t3lib_div::_GP('id')),
				''
			);

			$this->tsfe->connectToDB();
			$this->tsfe->initFEuser();

			$this->tsfe->determineId();
			$this->tsfe->getCompressedTCarray();
			$this->tsfe->initTemplate();
			$this->tsfe->getConfigArray();
		}
	}

	protected function fetchTyposcriptConfiguration($key) {
		$tsConf = $this->tsfe->tmpl->setup['plugin.']['tx_infinigatesso.'][$key];
		foreach ($tsConf as $key => $conf) {
			$this->registeredSsoServiceConfiguration[$conf['name']] = $conf;
		}

		return $this->registeredSsoServiceConfiguration;
	}

	protected function fetchSslKeys() {
		$_extConfig = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['infinigate_sso']);

		if (! file_exists($_extConfig['PrivateKey'])) {
			t3lib_div::devLog('Could not find Private or Public Keyfile. Please review your configuration settings in Extension Manager for Public/Private Key.', $this->extKey, 3);
		}

		$this->privateKey = @file_get_contents($_extConfig['PrivateKey']);
	}
}
