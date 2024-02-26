# Php TDES Cipher

Php TDES Cipher using openssl.

## Dependencies:

* php >=8.1 **REQUIRED IN YOUR PROJECT**

## Installation

```shell
composer require mphpmaster/tdes
```

## Usage:

Default cipher_algo is: `des-ede3-cbc`

```php
$cipher = \MPhpMaster\TDES\TDESCipher::make('ABCDEFGHIJKLMNOPQRSTUVWX', '12345678', 'des-ede3-cbc'); // new instance
$cipher->encrypt('Test!'); // encrypt
$cipher->decrypt('RZ4wZaGE7qGNZ1'); // decrypt
```

---

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Stand with Palestine 🇵🇸 <i>#FreePalestine</i>