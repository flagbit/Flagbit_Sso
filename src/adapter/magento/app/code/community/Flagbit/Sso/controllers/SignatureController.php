<?php

class Flagbit_Sso_SignatureController extends Mage_Core_Controller_Front_Action
{
	/**
	 * 
	 * @author Matthäus Müller
	 * @desc controllerAction to verify the given datas
	 */
	public function verifyAction()
	{
		$libObj = new Flagbit_Sso();
		$validator = new Zend_Validate_EmailAddress();
		$param = Mage::app()->getRequest()->getParam('data');
		
		
		if( $libObj->loadContainer($param)->verify( Mage::Helper('sso/data')->getPublicKey() ) === TRUE  )
		{
			$email = $object->getContainer()->getValue('container/email');
			if( empty($email) || !( $validator->isValid($email) ) {
				Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
			}
			
			$firstname = $object->getContainer()->getValue('container/firstname');
			if( empty($firstname) )	{
				$firstname = 'John';
			}
			
			$lastname = $object->getContainer()->getValue('container/lastname');
			if( empty($lastname) )	{
				$lastname = 'Doe';
			}			
			Mage::getModel('Flagbit_Sso_Model_Session')->loginBySso($firstname, $lastname, $email );
		} else {
			Mage::app()->getResponse()->setRedirect(Mage::getUrl('customer/account'));
		}
	}
}