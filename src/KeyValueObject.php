<?php namespace Zaltana\Support;

use JsonSerializable;

final class KeyValueObject implements JsonSerializable {

	private $key;
	private $value;

	public function __construct($key, $value)
	{
		$this->key = $key;
		$this->value = $value;
	}

	public static function make($key, $value)
	{
		return new static($key, $value);
	}

	public function key()
	{
		return $this->value;
	}

	public function value()
	{
		return $this->value;
	}

	public function equals(KeyValueObject $object)
	{
		return $this->key === $object->key && $this->value === $object->value;
	}

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}

	public function toArray()
	{
		return [ 'key' => $this->key, 'value' => $this->value ];
	}

	public function asJson()
	{
		return json_encode($this->toArray());
	}

	public function __toString()
	{
		return $this->asJson();
	}

}
