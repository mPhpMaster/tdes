<?php
/*
 * Copyright © 2024. Mohammad Al-Safadi(https://github.com/mphpmaster) All rights reserved.
 */

use MPhpMaster\TDES\TDESCipher;

if(!function_exists('tdes_cipher')) {
	/**
	 * @param string|null $key
	 * @param string|null $iv
	 * @param string      $cipher_algo
	 *
	 * @return \MPhpMaster\TDES\TDESCipher
	 */
	function tdes_cipher(?string $key = null, ?string $iv = null, string $cipher_algo = 'des-ede3-cbc'): TDESCipher
	{
		return TDESCipher::make($key, $iv, $cipher_algo);
	}
}
