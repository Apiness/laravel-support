<?php namespace Tests;

use stdClass;
use PHPUnit_Framework_TestCase;
use Zaltana\Support\ValueObject;

class ValueObjectTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function it_contains_a_nonnull_value()
	{
		$int = new ConcreteValue(7);
		$string = new ConcreteValue('Hello there');
		$object = new ConcreteValue(new StdClass);

		$this->assertNotNull($int, 'Created value object should not be null');
		$this->assertNotNull($string, 'Created value object should not be null');
		$this->assertNotNull($object, 'Created value object should not be null');
	}

	/** @test */
	public function it_returns_a_correct_value()
	{
		$instance = new StdClass;

		$int = new ConcreteValue(7);
		$string = new ConcreteValue('Hello there');
		$object = new ConcreteValue($instance);

		$this->assertEquals($int->value(), 7);
		$this->assertEquals($string->value(), 'Hello there');
		$this->assertEquals($object->value(), $instance);
	}

	/** @test */
	public function it_returns_a_correct_string_format()
	{
		$int = new ConcreteValue(7);

		$this->assertEquals($int->value(), $int->toString());
	}

	/** @test */
	public function it_is_comparable()
	{
		$anInt = new ConcreteValue(7);
		$anotherInt = new ConcreteValue(7);

		$this->assertEquals($anInt, $anotherInt);
		$this->assertTrue($anInt->isEqualTo($anotherInt));

		$aString = new ConcreteValue('Hello there');
		$anotherString = new ConcreteValue('Hello there');

		$this->assertEquals($aString, $anotherString);
		$this->assertTrue($aString->isEqualTo($anotherString));

		$instance = new StdClass;
		$anObject = new ConcreteValue($instance);
		$anotherObject = new ConcreteValue($instance);

		$this->assertEquals($anObject, $anotherObject);
		$this->assertTrue($anObject->isEqualTo($anotherObject));
	}

}

class ConcreteValue extends ValueObject {
}
