<?php namespace Apiness\Support;

use Illuminate\Support\Str;

class UUID extends ValueObject {

	/**
	 * Generate a random UUID.
	 *
	 * @return static A random UUID.
	 *
	 * @note The generated value is not RFC 4122 compliant (see https://tools.ietf.org/html/rfc4122).
	 */
	public static function generate()
	{
		$uuid = Str::random(32);

		return new static(bin2hex(substr($uuid, 0, 4)).'-'.bin2hex(substr($uuid, 4, 2)).'-'.bin2hex(substr($uuid, 6, 2)).'-'.bin2hex(substr($uuid, 8, 2)).'-'.bin2hex(substr($uuid, 10, 6)));
	}

	/**
	 * Generate a name based md5 UUID (version 3).
	 *
	 * @return static A name based md5 UUID.
	 *
	 * @see https://github.com/fzaninotto/Faker/blob/master/src/Faker/Provider/Uuid.php
	 */
	public static function version3()
	{
		// Fix for compatibility with 32bit architecture; seed range restricted to 62bit
		$seed = mt_rand(0, 2147483647).'#'.mt_rand(0, 2147483647);

		// Hash the seed and convert to a byte array
		$val = md5($seed, true);
		$byte = array_values(unpack('C16', $val));

		// Extract fields from byte array
		$tLo = ($byte[ 0 ] << 24) | ($byte[ 1 ] << 16) | ($byte[ 2 ] << 8) | $byte[ 3 ];
		$tMi = ($byte[ 4 ] << 8) | $byte[ 5 ];
		$tHi = ($byte[ 6 ] << 8) | $byte[ 7 ];
		$csLo = $byte[ 9 ];
		$csHi = $byte[ 8 ] & 0x3f | (1 << 7);

		// Correct byte order for big edian architecture
		if (pack('L', 0x6162797A) == pack('N', 0x6162797A)) {
			$tLo = (($tLo & 0x000000ff) << 24) | (($tLo & 0x0000ff00) << 8) | (($tLo & 0x00ff0000) >> 8) | (($tLo & 0xff000000) >> 24);
			$tMi = (($tMi & 0x00ff) << 8) | (($tMi & 0xff00) >> 8);
			$tHi = (($tHi & 0x00ff) << 8) | (($tHi & 0xff00) >> 8);
		}

		// Apply version number
		$tHi &= 0x0fff;
		$tHi |= (3 << 12);

		// Cast to string
		$uuid = sprintf('%08x-%04x-%04x-%02x%02x-%02x%02x%02x%02x%02x%02x', $tLo, $tMi, $tHi, $csHi, $csLo, $byte[ 10 ], $byte[ 11 ], $byte[ 12 ], $byte[ 13 ], $byte[ 14 ], $byte[ 15 ]);

		return new static($uuid);
	}

}