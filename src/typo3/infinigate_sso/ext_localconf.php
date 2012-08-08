<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


// $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['postProcContent'] = 'Classes/class.tx_fbsso_authSsoServices.php->getSpoofedImgTags';
//$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['login_confirmed'] = array('EXT:fb_sso/Classes/class.tx_infinigate_ssoServices.php:&tx_infinity_feloginHook->provideSpoofedImgTags');

$TYPO3_CONF_VARS['FE']['eID_include']['infinigate_sso'] = 'EXT:infinigate_sso/Classes/class.tx_infinigate_feloginHook.php';

//$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_alwaysFetchUser'] = TRUE;
//$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_alwaysAuthUser'] = TRUE;
//$TYPO3_CONF_VARS['SVCONF']['auth']['setup']['FE_fetchUserIfNoSession'] = TRUE;


?>
