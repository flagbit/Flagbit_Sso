<?php

class Flagbit_Sso_Storage_Json
	extends Flagbit_Sso_Storage_SimpleContainer
{
	/**
	 * @desc	serialize and encode an array
	 * @return	string
	 */
	public function getContainerAsString()
	{
		$str = $this->_encode(
							json_encode( 
								serialize($this->_data)
							)
						);
		return $str;
	}

	/**
	 * @desc	unserialize and decode an string
	 * @param	string $str
	 * @return	Flagbit_Sso_Storage_Json
	 */
	public function setContainerFromString($str)
	{
		$str = unserialize(
					json_decode( 
						$this->_decode($str) 
					)
				);
				
		$this->_data = $str;
		return $this;
	}
}