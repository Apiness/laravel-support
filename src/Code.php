<?php namespace Zaltana\Support;

class Code extends ValueObject {

	public static function random($length = 6)
	{
		return str_pad(rand(0, (int) pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
	}

	public static function generate($length = 6)
	{
		return new static(self::random($length));
	}

}
