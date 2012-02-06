<?php

class Flagbit_Sso_Signature_Openssl implements Flagbit_Sso_Signature_Interface
{

	public function createSign($data, $privateKey)
	{
		$signature = NULL;
		openssl_sign($data, $signature, $privateKey);
		return base64_encode($signature);
	}

	public function verifySign($data, $signature, $publicKey)
	{
		$result = NULL;

		$result = openssl_verify($data,  base64_decode($signature), $publicKey);

		switch($result)
		{
			case -1: // error caused while trying to verify
				$result=FALSE;
				break;

			case 0: // invalid signature
				$result=FALSE;
				break;

			case 1:	// valid signature
				$result=TRUE;
				break;

			default: // handle unknown
				$result=FALSE;
			break;
		}
		return $result;
	}

}