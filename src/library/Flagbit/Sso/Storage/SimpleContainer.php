<?php
class Flagbit_Sso_Storage_SimpleContainer
	extends Flagbit_Sso_Storage_Abstract
	implements Flagbit_Sso_Storage_Interface
{
	
	/**
	 * @desc	using the magic function __call to provide pseudo getter/setter
	 * @param	string $func
	 * @param	array $args
	 */
    public function __call($func, $args)
    {
		if( (substr($func, 0, 3) === 'get' ) )
		{
			return $this->_get(substr($func, 3));
		}
		elseif( (substr($func, 0, 3) === 'set' ) )
		{
			return $this->_set(substr($func, 3), $args[0] );
		}
    	elseif( (substr($func, 0, 5) === 'unset' ) )
		{
			return $this->_unset(substr($func, 5));
		}
    }
	
	
	/**
	 * @param string $key
	 * @param string $name
	 * @return Flagbit_Sso_Storage_SimpleContainer 
	 */
	protected function _set($key, $name)
	{
		$this->_data[$key] = $name;
		return $this;
	}
	
	/**
	* @param string $key
	* @param string $name
	* @return Flagbit_Sso_Storage_SimpleContainer
	*/
	protected function _unset($key)
	{
		unset($this->_data[$key]);
		return $this;
	}	
	
	/**
	 * @param string $key 
	 * @return mixed
	 */	
	protected function _get($key)
	{
		return $this->_data[$key];
	}
}