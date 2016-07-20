<?php namespace Apiness\Support;

abstract class ValueObject {

	protected $value;

	public function __construct($value)
	{
		$this->value = $value;
	}

	public function value()
	{
		return $this->value;
	}

	public function equals(ValueObject $object)
	{
		return $this->value() === $object->value();
	}

	public function toString()
	{
		return $this->value;
	}

	public function __toString()
	{
		return $this->toString();
	}

}
