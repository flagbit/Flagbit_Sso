<?php
class Flagbit_Sso_Block_Sessionajax extends Flagbit_Sso_Block_Abstract
{
    protected function _toHtml()
    {
    	$param = $this->_initParams();
    	$html = '';
    	
    	if(!empty($param)){
    		$url = Mage::helper('sso/data')->getTarget();
    		$ajaxRequest = 'new Ajax.Request(\''.$url.$param.'\', { method:\'get\' });';
    		$html = '<script type="text/javascript">' . $ajaxRequest . '</script>';
    	}
        return $html;
    }
}
