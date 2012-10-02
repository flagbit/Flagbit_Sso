<?php
require_once __DIR__."/class.tx_infinigate_sso_abstract.php";

class tx_infinigate_sso_eIDLoginMechanism extends tx_infinigate_sso_abstract {

	protected $registeredSsoServiceConfiguration = array();

	public function __construct() {
		parent::__construct();
		$this->fetchTyposcriptConfiguration('auth_service.');
	}

	/**
	 * This method is called via eID, the alternative output engine of TYPO3.
	 * This script's output will, in case of successfull execution, ouput a
	 * blindgif which can be embedded into HTML while logging in the given FE
	 * user as a side-effect.
	 * In case of a malfunction this script will assemble the errors and return
	 * them as png image.
	 * 
	 * @return void
	 */
	public function main() {
		$errOutput = '';
		$ssoClientName = t3lib_div::_GP('name');
		if (empty($ssoClientName)) {
			$errOutput .= 'Providing the SSO client\'s name is mandatory. ';
		}

		$ssoClient = $this->registeredSsoServiceConfiguration[$ssoClientName];
		if (empty($ssoClient)) {
			$errOutput .= 'Given Single Sign-On client `'.$ssoClientName.'\' is not registered! Please set up the corresponding TS configuration. ';
		}

		$ssoData = t3lib_div::_GP('sso');

		if (empty($ssoData)) {
			$errOutput .= 'SSO data container not provided. This is mandatory! ';
		}


		if ($errOutput) {
			$this->createImage($errOutput);
			die($errOutput);
		}

		if (! $this->fbSsoLib->loadContainer($ssoData)->verify($ssoClient['publicKey'])) {
				// the given sso container has invalid signature
			$this->createImage("Security Intrusion");
				// we were already logged in by calling $this->initTSFE() so we need to log out!
			$this->tsfe->fe_user->removeSessionData();
			t3lib_div::devLog('Warning - Potential security breach! @'.time(), $this->extKey, 2);
			die();
		} else {
			$container = $this->fbSsoLib->getContainer();
				// signature okay. init fe_user and return blindgif
			t3lib_div::devLog('Granted SSO Login: @'.date('d.m.Y H:i:s').' for user "'.$container->getIdentifier().'"', $this->extKey);

			$this->tsfe->fe_user->checkPid = 0; // disable checking the PID

				// fetch according user from database ...
			$info = $this->tsfe->fe_user->getAuthInfoArray();
			$info['db_user']['username_column'] = 'email';
			$user = $this->tsfe->fe_user->fetchUserRecord($info['db_user'], $container->getIdentifier());
				// .. and finally create user session using TSFE
			$this->tsfe->fe_user->createUserSession($user);
			$this->tsfe->fe_user->loginSessionStarted = TRUE;

			header("Content-type: image/gif");
			header("Cache-Control: no-cache"); //HTTP/1.1
			header("Pragma: no-cache"); //HTTP/1.0
			die(base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw=='));
		}
	}

	/**
	 * This fetches the tx_infinigatesso TypoScript configuration
	 * 
	 * @param $key The subindex of the to-be-fetched TS configuration
	 * @return String TS configuration 
	 *
	protected function fetchTyposcriptConfiguration($key) {
		$tsConf = $this->tsfe->tmpl->setup['plugin.']['tx_infinigatesso.'][$key];
		foreach ($tsConf as $key => $conf) {
			$this->registeredSsoServiceConfiguration[$conf['name']] = $conf;
		}

		return $this->registeredSsoServiceConfiguration;
	}*/

	/**
	 * Creates an Images, sent to the client containing the given text.
	 *
	 * @param $text The text within the image
	 * @return void
	 */
	protected function createImage($text) {
		header("Content-Type: image/png");
		$im = @imagecreate(600, 20) or die("Cannot Initialize new GD image stream");
		$background_color = imagecolorallocate($im, 0, 0, 0);
		$text_color = imagecolorallocate($im, 233, 14, 91);
		imagestring($im, 1, 5, 5, $text, $text_color);
		imagepng($im);
		imagedestroy($im);
	}
}

$obj = t3lib_div::makeInstance('tx_infinigate_sso_eIDLoginMechanism');
$obj->main();
