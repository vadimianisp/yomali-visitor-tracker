<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\Visit;

class TrackerController {
	
	public function store() {
		
		header("Content-Type: application/json");
		header("Access-Control-Allow-Origin: *");
		header("Access-Control-Allow-Methods: POST, OPTIONS");
		header("Access-Control-Allow-Headers: Content-Type");
		
		if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
			http_response_code(200);
			exit;
		}
		
		$input = json_decode(file_get_contents("php://input"), true);
		
		if (!$input) {
			http_response_code(400);
			echo json_encode(["error" => "Invalid JSON or missing body"]);
			return;
		}
		
		$requiredFields = ['page_url', 'visitor_ip', 'browser', 'device', 'os', 'user_agent'];
		foreach ($requiredFields as $field) {
			if (!isset($input[$field])) {
				http_response_code(400);
				echo json_encode(["error" => "Missing required fields", "missing_field" => $field]);
				return;
			}
		}
		
		$visitData = [
			'url' => $input['page_url'],
			'referrer' => $input['referrer'] ?? null,
			'visitor_ip' => $input['visitor_ip'] ?? null, // Optional field
			'user_id' => $input['user_id'] ?? null, // Optional field
			'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',  // Extract from server
			'browser' => $input['browser'],
			'device' => $input['device'],
			'os' => $input['os'],
			'user_agent' => $input['user_agent'],
			'fingerprint' => $input['fingerprint'] ?? null, // Optional field
			'timestamp' => $input['timestamp']
		];
		
		
		$db = Database::connect();
		$success = Visit::store($db, $visitData);
		
		
		if ($success) {
			echo json_encode(["success" => true]);
		} else {
			http_response_code(500);
			echo json_encode(["error" => "Failed to store visit"]);
		}
	}
	
	public function getVisits() {
		
		header("Content-Type: application/json");
		
		$db = Database::connect();
		
		try {
			$stmt = $db->query("SELECT * FROM visits ORDER BY timestamp DESC");
			$visits = $stmt->fetchAll(\PDO::FETCH_ASSOC);
			
			
			echo json_encode(["success" => true, "data" => $visits]);
		} catch (PDOException $e) {
			http_response_code(500);
			echo json_encode(["error" => "Failed to fetch visits", "message" => $e->getMessage()]);
		}
	}
	
}
