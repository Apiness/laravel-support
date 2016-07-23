<?php namespace Tests;

use PHPUnit_Framework_TestCase;
use Zaltana\Support\Enum;

class EnumTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function it_is_validatable()
	{
		$this->assertTrue(TestEnum::isValid(TestEnum::OPTION_1));
		$this->assertTrue(TestEnum::isValid(1));
		$this->assertFalse(TestEnum::isValid(9));
	}

	/** @test */
	public function it_is_comparable()
	{
		$option1 = TestEnum::OPTION_1;
		$option2 = TestEnum::OPTION_2;

		$value1 = new TestEnum(TestEnum::OPTION_1);
		$value2 = new TestEnum(TestEnum::OPTION_2);

		$value3 = new TestEnum(TestEnum::OPTION_1);

		$this->assertEquals($option1, $value1->value());
		$this->assertEquals($option2, $value2->value());

		$this->assertNotEquals($option1, $option2);
		$this->assertNotEquals($value1, $value2);

		$this->assertTrue($option1 == $value1->value());
		$this->assertTrue($option1 === $value1->value());

		$this->assertEquals($value1, $value3);
	}

	/** @test */
	public function it_is_comparable_by_value()
	{
		$option1 = TestEnum::OPTION_1;
		$option2 = TestEnum::OPTION_2;

		$enum1 = new TestEnum(TestEnum::OPTION_1);
		$enum2 = new TestEnum(TestEnum::OPTION_2);

		$this->assertTrue($enum1->is($option1));
		$this->assertTrue($enum1->is(TestEnum::OPTION_1));

		$this->assertFalse($enum1->is($option2));
		$this->assertFalse($enum1->is(TestEnum::OPTION_2));

		$this->assertFalse($enum1->is($enum2));
	}

}

class TestEnum extends Enum {

	const OPTION_1 = 1;
	const OPTION_2 = 2;

}
