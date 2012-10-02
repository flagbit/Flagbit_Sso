<?php

class Flagbit_Sso_SignatureController extends Mage_Core_Controller_Front_Action
{
	public function verifyAction()
	{
	    
	    if(!Mage::getSingleton('customer/session')->isLoggedIn()){
    		$libObj = new Flagbit_Sso();
    		$param = Mage::app()->getRequest()->getParam('d');
    
    		if( $libObj->loadContainer($param)->verify( Mage::Helper('sso/data')->getPublicKey() ) === TRUE  )
    		{
    			Mage::getSingleton('core/session')->setSsoParams($param);
    			
    			$identifier = $libObj->getContainer()->getIdentifier();
    			
    			Mage::getModel('Flagbit_Sso_Model_Session')->loginBySso($identifier);
    		}
    		header("Content-type: image/gif");
    		header("Cache-Control: no-cache"); //HTTP/1.1
    		header("Pragma: no-cache"); //HTTP/1.0
    		die(base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw=='));
	    }
	}
}
