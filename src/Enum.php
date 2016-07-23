<?php namespace Zaltana\Support;

abstract class Enum extends ValueObject {

	private static $cache = [ ];

	public function __construct($value)
	{
		if (!self::isValid($value)) {
			throw new \UnexpectedValueException("Value '$value' is not part of the enum ".get_called_class());
		}

		parent::__construct($value);
	}

	public function rawValue()
	{
		return $this->value();
	}

	public static function isValid($value)
	{
		return in_array($value, self::toArray(), true);
	}

	public function is($other)
	{
		if ($other instanceof ValueObject) {
			return $this->isEqualTo($other);
		}

		return $this->value() === $other;
	}

	public static function toArray()
	{
		$class = get_called_class();

		if (!array_key_exists($class, self::$cache)) {
			$reflection = new \ReflectionClass($class);
			self::$cache[ $class ] = $reflection->getConstants();
		}

		return self::$cache[ $class ];
	}

}
