<?php
use PHPUnit\Framework\TestCase;
use App\Core\Database;

class DatabaseTest extends TestCase {
	public function testDatabaseConnection() {
		$db = Database::connect();
		$this->assertNotNull($db, "Database connection should not be null");
	}
}
