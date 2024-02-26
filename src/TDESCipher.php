<?php

namespace MPhpMaster\TDES;

/**
 *
 */
class TDESCipher
{
	public static string $cipher_algo = 'des-ede3-cbc';

	/**
	 * @param string|null $key
	 * @param string|null $iv
	 *
	 * @throws \Exception
	 */
	public function __construct(private ?string $key = null, private ?string $iv = null, string $cipher_algo = 'des-ede3-cbc')
	{
		static::$cipher_algo = $cipher_algo;
		$this->loadTDESCipherInfo();
	}

	/**
	 * @return $this
	 */
	public function loadTDESCipherInfo(array $data = [ 'key' => 'ABCDEFGHIJKLMNOPQRSTUVWX', 'iv' => '12345678' ]): static
	{
		$config = is_null($data) ? [] : (is_array($data) ? $data : [ $data ]);
		$this->key ??= $config['key'] ?? $this->key;
		$this->iv ??= $config['iv'] ?? $this->iv;

		if(!$this->key || strlen($this->key) != 24) {
			throw new \Exception("Wrong KEY length, the length must be 24");
		}

		if(!$this->iv || strlen($this->iv) != 8) {
			throw new \Exception("IV length error, length should be 8");
		}

		return $this;
	}

	public static function e(string $string): string
	{
		return static::make()->encrypt($string);
	}

	public function encrypt(string $input, string $key = '', string $iv = ''): string
	{
		$this->key = $key ?: $this->key;
		$this->iv = $iv ?: $this->iv;

		$payload =
			openssl_encrypt(
				$input,
				static::$cipher_algo ?: "des-ede3-cbc",
				$this->key,
				OPENSSL_RAW_DATA,
				$this->iv,
			);

		return static::prepareString(
			str_rot13(
				base64_encode(
					$payload,
				),
			),
			false,
		);
	}

	private static function prepareString(string $input, bool $flip = false): string
	{
		$tokens = [
			'Z1' => '=',
			'='  => 'Z1',
			'/'  => 'Z2',
			'\\' => 'Z3',
			'+'  => 'Z4',
		];

		foreach($tokens as $key => $value) {
			$input = str_ireplace($flip ? $value : $key, $flip ? $key : $value, $input);
		}

		return $input;
	}

	/**
	 * Create a new class.
	 *
	 * @return static
	 */
	public static function make(...$arguments)
	{
		return new static(...$arguments);
	}

	public static function d(string $string): string
	{
		return static::make()->decrypt($string);
	}

	public function decrypt(string $encrypted, string $key = '', string $iv = ''): bool|string
	{
		$this->key = $key ?: $this->key;
		$this->iv = $iv ?: $this->iv;

		return
			openssl_decrypt(
				base64_decode(
					str_rot13(
						static::prepareString($encrypted, true),
					),
				),
				static::$cipher_algo ?: "des-ede3-cbc",
				$this->key,
				OPENSSL_RAW_DATA,
				$this->iv,
			);
	}
}
