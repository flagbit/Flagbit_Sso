<?php

class Flagbit_Sso_Storage_Json extends Flagbit_Sso_Storage_Abstract
{
	public function getDataAsString($path)
	{
		$str = $this->_encode(json_encode( serialize($this->getValue($path))) );
		return $str;
	}

	public function getContainerAsString()
	{
		$str = $this->_encode(json_encode( serialize($this->_data) ) );
		return $str;
	}

	public function setContainerFromString( $str )
	{
		$str = unserialize(json_decode( $this->_decode($str) ));
		$this->_data = $str;
	}
}