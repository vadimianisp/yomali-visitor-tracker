<?php
namespace App\Models;
use PDO;

class Visit {
	
	public static function store($db, $data) {
		// Ensure all required fields exist
		$data = array_merge([
			"url" => null,
			"referrer" => null,
			"visitor_id" => uniqid(), // If not provided, generate a unique visitor ID
			"user_id" => null,
			"ip_address" => $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN', // Capture IP if missing
			"browser" => null,
			"device" => null,
			"os" => null,
			"user_agent" => null,
			"fingerprint" => null,
			"timestamp" => time()
		], $data);
		
		// Debug: Log the request data
		error_log("DEBUG: Visit Data - " . print_r($data, true));
		
		$stmt = $db->prepare("INSERT INTO visits
		(url, referrer, visitor_id, user_id, ip_address, browser, device, os, user_agent, fingerprint, timestamp)
		VALUES
		(:url, :referrer, :visitor_id, :user_id, :ip_address, :browser, :device, :os, :user_agent, :fingerprint, :timestamp)");
		
		// Bind parameters manually to ensure no mismatch
		$stmt->bindParam(':url', $data['url']);
		$stmt->bindParam(':referrer', $data['referrer']);
		$stmt->bindParam(':visitor_id', $data['visitor_id']);
		$stmt->bindParam(':user_id', $data['user_id']);
		$stmt->bindParam(':ip_address', $data['ip_address']);
		$stmt->bindParam(':browser', $data['browser']);
		$stmt->bindParam(':device', $data['device']);
		$stmt->bindParam(':os', $data['os']);
		$stmt->bindParam(':user_agent', $data['user_agent']);
		$stmt->bindParam(':fingerprint', $data['fingerprint']);
		$stmt->bindParam(':timestamp', $data['timestamp'], PDO::PARAM_INT);
		
		// Debug: Log what is being inserted
		error_log("DEBUG: Executing Query - " . $stmt->queryString);
		
		return $stmt->execute();
	}
	
	public static function getStats($db) {
		$stmt = $db->query("SELECT url, COUNT(DISTINCT visitor_id) AS unique_visitors, COUNT(*) AS total_visits FROM visits GROUP BY url ORDER BY total_visits DESC");
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
