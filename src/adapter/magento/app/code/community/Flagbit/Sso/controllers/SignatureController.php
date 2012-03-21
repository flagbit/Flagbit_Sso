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
			
			$email = $libObj->getContainer()->getEmail();
			$firstname = $libObj->getContainer()->getFirstname();
			$lastname = $libObj->getContainer()->getLastname();
			
			Mage::getModel('Flagbit_Sso_Model_Session')->loginBySso($firstname, $lastname, $email );
		} else {
			Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
		}
	}
	
	public function tunitAction()
	{
		$libObj = new Flagbit_Sso();
		
		$libObj->getContainer()->setEmail('m.mueller@flagbit.de')->setFirstname('Matthaeus')->setLastname('Mueller');
		
		$container = $libObj->create( Mage::Helper('sso/data')->getPrivateKey() );
		
		echo '<a href="localhost:8080/magento/sso/signature/verify/d/'.$container.'">Login</a>';
	}
}
