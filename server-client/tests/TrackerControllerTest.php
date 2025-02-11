<?php
use PHPUnit\Framework\TestCase;
use App\Controllers\TrackerController;
use App\Core\Database;
use App\Models\Visit;

class TrackerControllerTest extends TestCase {
	private static $db;
	
	public static function setUpBeforeClass(): void {
		// Connect to the test database and clean visits table
		self::$db = Database::connect();
		self::$db->exec("DELETE FROM visits");
	}
	
	public function testTrackVisitSuccess() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		
		$payload = json_encode([
			'url' => 'https://example.com',
			'referrer' => 'https://google.com',
			'visitor_id' => 'visitor_test_123',
			'user_id' => null,
			'ip_address' => '192.168.1.10',
			'browser' => 'Chrome',
			'device' => 'Desktop',
			'os' => 'Windows',
			'user_agent' => 'Mozilla/5.0',
			'fingerprint' => 'xyz123',
			'timestamp' => time()
		]);
		
		// Mock PHP input stream using global variable override
		$GLOBALS['php://input'] = $payload;
		
		ob_start();
		$controller = new TrackerController();
		$controller->store();
		$output = ob_get_clean();
		
		$response = json_decode($output, true);
//		print_r($response); // Debugging line
		
		$this->assertArrayHasKey('success', $response, "Response should contain 'success'");
		$this->assertTrue($response['success'], "Visit should be successfully tracked");
	}
	
	public function testTrackVisitMissingFields() {
		$_SERVER['REQUEST_METHOD'] = 'POST';
		
		$payload = json_encode([
			'url' => 'https://example.com' // Missing required fields
		]);
		
		// Mock PHP input stream
		$GLOBALS['php://input'] = $payload;
		
		ob_start();
		$controller = new TrackerController();
		$controller->store();
		$output = ob_get_clean();
		
		$response = json_decode($output, true);
//		print_r($response); // Debugging line
		
		$this->assertArrayHasKey('error', $response, "Response should contain 'error'");
		$this->assertEquals("Missing required fields", $response['error'], "Should return a missing fields error");
	}
	
	public static function tearDownAfterClass(): void {
		self::$db->exec("DELETE FROM visits"); // Clean up test data
	}
}
