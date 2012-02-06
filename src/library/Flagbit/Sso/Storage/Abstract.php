<?php

class Flagbit_Sso_Storage_Abstract implements Flagbit_Sso_Storage_Interface
{

	protected $_pathDelimiter = '/';
	protected $_data = array();

	protected function _encode($str)
	{
		return strtr(
		base64_encode($str),
		array(	'/' => '_',
							'+' => '-',
							'=' => '',
		));
	}

	protected function _decode($str)
	{
		$str = strtr($str,
		array(
						'_' => '/',
						'-' => '+',
		));

		if (strlen($str) % 2 != 0) {
			$str .= '=';
		}

		return base64_decode($str);
	}

	public function setValue($path, $value)
	{
		if (empty($path)) {
			throw new Exception('Path cannot be empty');
		}
			
		if (!is_string($path)) {
			throw new Exception('Path must be a string');
		}

		if( empty($value) ) {
			throw new Exception('Value must be set');
		}

		$path = trim($path, $this->_pathDelimiter);

		$parts = explode($this->_pathDelimiter, $path);

		$pointer =& $this->_data;

		foreach ($parts as $part) {

			if (empty($part)) {
				throw new Exception('Invalid path specified: ' . $path);
			}

			if (!isset($pointer[$part])) {
				$pointer[$part] = array();
			}

			$pointer =& $pointer[$part];
		}

		$pointer = $value;
		return $this;
	}
	
	public function getValue($path)
	{
		if (empty($path)) {
			throw new Exception('Path cannot be empty');
		}

		$path = trim($path, $this->_pathDelimiter);
		$container = $this->_data;

		$parts = explode($this->_pathDelimiter, $path);

		foreach ($parts as $part) {

			if (isset($container[$part])) {
				$container = $container[$part];
			} else {
				throw new Exception("Path $part is empty");
			}
		}

		$value = $container;
		return $value;
	}
}