TYPO3 Single Sign-On (infinigate_sso)

The infinigate_sso extension for TYPO3 provides Single Sign-On (SSO) functionalities. Therefore, it serves with a provider for registered SSO 
services which basically output an <img src="..." /> tag for each registered service which will lead to a GET request (containing "sso" and
"name" as parameters) to the authentication server which then proceeds with the authentication procedure.
This extension also provides the authentication infrastructure expecting aforementioned GET request for initiating a Frontend User (FEuser) session
within TYPO3.

This depends on Flagbit_SSO library which is included within EXT:infinigate_sso/Classes/Utility.

INSTALLATION



a) SSO REGISTRATION PROVIDER

TS constants:
ThisTYPO3InstancesName = MyFancyTYPO3Instance # this needs to be in sync with the authentication provider's Client-PublicKey-Settings
root_pid = 12 # this is the page containing the TS settings below (each subpagetree can hold its own SSO Authentication Server configuration)

TS setup:
This simply includes the userfunc providing <img /> tags for each authentication server 
set up via TypoScript. Service Providers are registered via name (sent to the auth provider for getting the right public key) and via an
uriTemplate (URI to the auth provider containing markers which will get replaced). You can of course register several service providers per sub-
page tree. (see TS examples below)
### =====================================================
###	Appends <img> to <body> when user is logged in.
###	This will lead to the client downloading the 
###	cookies hidden behind the <img src=""> url.
### =====================================================
[loginUser = *]
includeLibs.user_tx_infinigate_ssoServices= EXT:infinigate_sso/Classes/class.tx_infinigate_ssoServices.php
page.stdWrap.postCObject = USER
page.stdWrap.postCObject {
	userFunc = user_tx_infinigate_ssoServices->provideSpoofedImgTags
}

### ===================================================
###	Registers the to-be authenticated SSO Services 
### ===================================================
[PIDinRootline = {$root_pid_fr}]
plugin.tx_infinigatesso.service_providers {
	1 {
		name = Service #1
		uriTemplate = //web4.dev.flagbit.com/index.php?id=1&eID=infinigate_sso&name={$ThisTYPO3InstancesName}&sso={SSOData}
	}
	2 {
		name = Magento (de)
		uriTemplate = //web4.dev.flagbit.com/index.php?id=1&eID=infinigate_sso&name={$ThisTYPO3InstancesName}&sso={SSOData}
	}
}
[PIDinRootline = {$root_pid_en}]
plugin.tx_infinigatesso.service_providers {
	1 {
		name = Magento (en)
		uriTemplate = http://web4.dev.flagbit.com/index.php?id=1&eID=infinigate_sso&name={$ThisTYPO3InstancesName}&sso={SSOData}
	}
}
[PIDinRootline = {$root_pid_de}]
plugin.tx_infinigatesso.service_providers {
	1 {
		name = Magento (int)
		uriTemplate = //web4.dev.flagbit.com/index.php?id=1&eID=infinigate_sso&name={$ThisTYPO3InstancesName}&sso={SSOData}
	}
}
[global]



b) SSO AUTHENTICATION SERVICE
Private Key:
Set it within the Extension Manager's Configuration (path to keyfile)

TS constants: 
see "a) SSO REGISTRATION PROVIDER"

TS setup:
This simply registers SSO client names with their corresponding SSL public keys.
### ===========================================
###	Provides SSO Authentication via eID
### ===========================================
plugin.tx_infinigatesso.auth_service {
	1 {
		name = {$ThisTYPO3InstancesName}
		publicKey (
-----BEGIN PUBLIC KEY-----
[...]
-----END PUBLIC KEY-----
		)
	}
	2 {
		name = {$ThisTYPO3InstancesName}
		publicKey (
-----BEGIN PUBLIC KEY-----
[...]
-----END PUBLIC KEY-----
		)
	}
}

 
EXPERT ADVICES
- installing TYPO3s devlog extension will reward you with sweet debug sugar
- do not forget the BEGIN/END parts of the ssl keys since openssl_* seems to rely on them
- the authentication service provides debug "images" instead of a blindgif if the given sso container is invalid/broken or something bad happened
