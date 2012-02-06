<?php

interface Flagbit_Sso_Signature_Interface
{
	public function createSign($data, $privateKey);
	public function verifySign($data, $signature, $publicKey);
}