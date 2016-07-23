<?php namespace Tests;

use PHPUnit_Framework_TestCase;
use Zaltana\Support\Code;

class CodeTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function it_has_correct_length()
	{
		$this->assertTrue(strlen(Code::random(2)) == 2, 'Created code has wrong length');
		$this->assertTrue(strlen(Code::random(10)) == 10, 'Created code has wrong length');
		$this->assertTrue(strlen(Code::random(32)) == 32, 'Created code has wrong length');
	}

	/** @test */
	public function it_is_created_as_string()
	{
		$code = Code::random(10);

		$this->assertTrue(is_string($code), 'Created code should be a string');
	}

	/** @test */
	public function it_is_generated_as_value_object()
	{

		$code = Code::generate(10);

		$this->assertNotNull($code, 'Generated code should not be null');
		$this->assertTrue(is_object($code), 'Generated code should be an object');
		$this->assertTrue(strlen($code->value()) == 10, 'Generated code has wrong length');
		$this->assertTrue(is_string($code->value()), 'Generated code value should be a string');
	}

	/** @test */
	public function it_is_random()
	{
		$aCode = Code::random();
		$anotherCode = Code::random();

		$this->assertFalse($aCode == $anotherCode, 'Randomly generated codes must be different');
	}

}
