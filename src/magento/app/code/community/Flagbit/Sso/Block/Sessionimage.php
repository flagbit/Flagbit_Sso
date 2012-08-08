<?php
class Flagbit_Sso_Block_Sessionimage extends Flagbit_Sso_Block_Abstract
{
    protected function _toHtml()
    {
    	$param = $this->_initParams();
		$url = Mage::helper('sso/data')->getTarget();
		$html = '<img src="'.$url.$param.'" width="1" height="1" border="0">';
	        
		return $html;
    }
}