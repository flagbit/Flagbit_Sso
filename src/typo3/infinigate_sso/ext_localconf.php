<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

	// register eID login mechanism 
$TYPO3_CONF_VARS['FE']['eID_include']['infinigate_sso'] = 'EXT:infinigate_sso/Classes/class.tx_infinigate_sso_eIDLoginMechanism.php';

	// handle logout event
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['logoff_pre_processing'][] = 'EXT:infinigate_sso/Classes/class.tx_infinigate_sso_logoutObserver.php:tx_infinigate_sso_logoutObserver->logoff';

	// if logout even was registered, this hook cares for adding spoofed <img>'s to the page's body 
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['hook_eofe'][] = 'EXT:infinigate_sso/Classes/class.user_tx_infinigate_sso_registeredServices.php:user_tx_infinigate_sso_registeredServices->provideSpoofedLogoutImageTags';

// force usage of SSO Request Cache
$TYPO3_CONF_VARS['SYS']['caching']['cacheConfigurations']['flagbitsso_requestCache'] = array();
?>
