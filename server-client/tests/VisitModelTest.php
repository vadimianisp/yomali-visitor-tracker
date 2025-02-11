<?php
use PHPUnit\Framework\TestCase;
use App\Core\Database;
use App\Models\Visit;

class VisitModelTest extends TestCase {
	private static $db;
	
	public static function setUpBeforeClass(): void {
		// Connect to the test database
		self::$db = Database::connect();
		self::$db->exec("DELETE FROM visits"); // Clean visits table before running tests
	}
	
	public function testStoreVisit() {
		$visitData = [
			'url' => 'https://example.com',
			'referrer' => 'https://google.com',
			'visitor_id' => 'visitor_123',
			'user_id' => null,
			'ip_address' => '192.168.1.1',
			'browser' => 'Chrome',
			'device' => 'Desktop',
			'os' => 'Windows',
			'user_agent' => 'Mozilla/5.0',
			'fingerprint' => 'abc123',
			'timestamp' => time()
		];
		
		$result = Visit::store(self::$db, $visitData);
		$this->assertTrue($result, "Visit should be stored successfully");
		
		// Verify it was inserted correctly
		$stmt = self::$db->query("SELECT * FROM visits WHERE visitor_id = 'visitor_123'");
		$storedVisit = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->assertNotEmpty($storedVisit, "Stored visit should exist in the database");
		$this->assertEquals($visitData['url'], $storedVisit['url'], "URL should match the stored data");
	}
	
	public function testGetStats() {
		// Insert additional visits to check stats
		self::$db->exec("
        INSERT INTO visits (url, visitor_id, ip_address, browser, device, os, user_agent, fingerprint, timestamp)
        VALUES
        ('https://example.com', 'visitor_456', '192.168.1.2', 'Firefox', 'Mobile', 'Android', 'Mozilla/5.0', 'def456', UNIX_TIMESTAMP()),
        ('https://example.com/about', 'visitor_789', '192.168.1.3', 'Safari', 'Tablet', 'iOS', 'Mozilla/5.0', 'ghi789', UNIX_TIMESTAMP())
    ");
		
		$stats = Visit::getStats(self::$db);
		
		$this->assertNotEmpty($stats, "Stats should return data");
		$this->assertEquals(2, count($stats), "There should be stats for two different URLs");
		
		// Ensure unique visitor count is correct
		foreach ($stats as $stat) {
			if ($stat['url'] === 'https://example.com') {
				$this->assertEquals(2, $stat['unique_visitors'], "https://example.com should have 2 unique visitors");
			}
		}
	}
	
	public static function tearDownAfterClass(): void {
		self::$db->exec("DELETE FROM visits"); // Clean visits table after tests
	}
}
