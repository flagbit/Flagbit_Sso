<?php

class Flagbit_Sso_Storage_Abstract
	implements Flagbit_Sso_Storage_Interface
{
	protected $_data = array();

	/*
	 * @descr encode a string in base62
	 * @param string $str
	 * @return string
	 */
	protected function _encode($str)
	{
		return strtr(
						base64_encode($str),
						array(	'/' => '_',
								'+' => '-',
								'=' => '',
						)
					);
	}
	
	/*
	 * @descr decode a base62 encoded string
	 * @param string $str
	 * @return string
	 */
	protected function _decode($str)
	{
		$str = strtr($str,
					array(
						'_' => '/',
						'-' => '+',
					)
				);

		if (strlen($str) % 2 != 0) {
			$str .= '=';
		}

		return base64_decode($str);
	}
}