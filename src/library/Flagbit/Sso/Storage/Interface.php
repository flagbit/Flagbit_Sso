<?php

interface Flagbit_Sso_Storage_Interface
{
	public function getValue($path);
	public function setValue($path, $value);
}