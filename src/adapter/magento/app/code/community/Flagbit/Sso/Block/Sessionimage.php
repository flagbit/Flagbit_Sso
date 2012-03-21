<?php
class Flagbit_Sso_Block_Sessionimage extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
		$param = Mage::getSingleton('core/session')->getSsoParams();
		$url = Mage::helper('sso/data')->getTarget();
		$html = '<img src="'.$url.'/index.php'.'?eID=sso&d='.$param.'" width="1" height="1" border="0">';
        return $html;
    }
}