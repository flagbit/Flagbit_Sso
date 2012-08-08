<?php

class Flagbit_Sso_SignatureController extends Mage_Core_Controller_Front_Action
{
	public function verifyAction()
	{
		$libObj = new Flagbit_Sso();
		$param = Mage::app()->getRequest()->getParam('d');

		if( $libObj->loadContainer($param)->verify( Mage::Helper('sso/data')->getPublicKey() ) === TRUE  )
		{
			Mage::getSingleton('core/session')->setSsoParams($param);
			
			$identifier = $libObj->getContainer()->getIdentifier();
			
			Mage::getModel('Flagbit_Sso_Model_Session')->loginBySso($identifier);
		} else {
			Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
		}
	}
}
