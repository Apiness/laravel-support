<?php namespace Tests;

use PHPUnit_Framework_TestCase;
use Zaltana\Support\UUID;

class UUIDTest extends PHPUnit_Framework_TestCase {

	/** @test */
	public function it_generates_a_valid_uuid()
	{
		$uuid = UUID::generate()->value();

		$this->assertTrue($this->isValidUUID($uuid));
	}

	/** @test */
	public function it_generates_a_valid_version_3_uuid()
	{
		$uuid = UUID::version3()->value();

		$this->assertTrue($this->isValidUUID($uuid));
	}

	protected function isValidUUID($uuid)
	{
		return is_string($uuid) && (bool) preg_match('/^[a-f0-9]{8,8}-(?:[a-f0-9]{4,4}-){3,3}[a-f0-9]{12,12}$/i', $uuid);
	}

}
