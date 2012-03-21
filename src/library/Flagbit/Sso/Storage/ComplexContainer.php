<?php

class Flagbit_Sso_Storage_ComplexContainer
	extends Flagbit_Sso_Storage_Abstract
{

	protected $_pathDelimiter = '/';
	
	public function setValue($path, $value)
	{
		return $this->_set($path, $value);
	}
	
	public function getValue($path)
	{
		return $this->_get($path);
	}
	
	protected function _set($path, $value)
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
	
	protected function _get($path)
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