<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Website {
	
	public static function create($name, $url, $apiKey) {
		$db = Database::connect();
		$stmt = $db->prepare("INSERT INTO websites (name, url, api_key) VALUES (:name, :url, :api_key)");
		return $stmt->execute([
			'name' => $name,
			'url' => $url,
			'api_key' => $apiKey
		]);
	}
	
	public static function getByApiKey($apiKey) {
		$db = Database::connect();
		$stmt = $db->prepare("SELECT * FROM websites WHERE api_key = :api_key");
		$stmt->execute(['api_key' => $apiKey]);
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}
