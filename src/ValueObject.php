<?php namespace Zaltana\Support;

abstract class ValueObject implements Equatable {

	protected $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * Returns the value.
	 *
	 * @return mixed The value.
	 */
	public function value()
	{
		return $this->value;
	}

	/**
	 * Returns a boolean value that indicates whether the instance is equal to another given object.
	 *
	 * @param mixed $other The value object with which to compare the receiver.
	 *
	 * @return bool `true` if both objects are equal, otherwise `false`.
	 */
	public function isEqualTo($other)
	{
		if (! $other instanceof static) {
			return false;
		}

		return $this->value() === $other->value();
	}

	/**
	 * Returns a string that represents the object value.
	 *
	 * @return string A string that represents the object value.
	 */
	public function toString()
	{
		return $this->value;
	}

	/**
	 * Converts the value object to its string representation.
	 *
	 * @return string A string that represents the value object.
	 */
	public function __toString()
	{
		return $this->toString();
	}

}
