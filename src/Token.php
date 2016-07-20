<?php namespace Apiness\Support;

class Token extends ValueObject {

	public static function random($length = 42)
	{
		$bytes = openssl_random_pseudo_bytes($length * 2);

		if ($bytes === false) {
			throw new \RuntimeException('Unable to generate random token.');
		}

		return substr(str_replace([ '/', '+', '=' ], '', base64_encode($bytes)), 0, $length);
	}

	public static function generate($length = 42)
	{
		return new static(self::random($length));
	}

}
