<?php
class Flagbit_Sso_Block_Sessionajax extends Mage_Core_Block_Template
{
    protected function _toHtml()
    {
		$param = Mage::getSingleton('core/session')->getSsoParams();
		$url = Mage::helper('sso/data')->getTarget().'/eID=sso';
		$ajaxRequest = "new Ajax.Request( '$url', { method:'post', parameters: {d: '$param' } } );";
		$html = '<script type="text/javascript">' . $ajaxRequest . '</script>';
        return $html;
    }
}
