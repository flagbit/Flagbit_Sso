<?php

class tx_infinigate_sso_logoutObserver {
	
	/**
	 * This method is called when the fe user logged out and saves this event within the TYPO3 session. 
	 */
	public function logoff($params, &$pObj) {
		if (t3lib_div::_GP('logintype') !== 'logout' || $pObj->loginType !== 'FE') {
			return;
		}

		$sessionData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'infinigate_sso');
		$sessionData['ssoLogout'] = 'true';
				
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'infinigate_sso', $sessionData);
		$GLOBALS['TSFE']->fe_user->storeSessionData();
				
	}
}	
