<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['postProcContent'] = 'EXT:fb_sso/Classes/class.tx_fbsso_felogin.php:&tx_fbsso_felogin->login_confirmed';

//
// Tx_Extbase_Utility_Extension::registerPlugin(
	// $_EXTKEY,
	// 'Pi1',
	// 'Flagbit Single Sign-On',
	// t3lib_extMgm::extRelPath($_EXTKEY).'Resources/Public/Icons/fb_sso.gif'
// );

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Infinigate SSO');