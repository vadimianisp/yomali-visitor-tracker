<?php
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

// Set test environment variables (Docker-compatible)
putenv('DATABASE_HOST=db'); // Use Docker service name, not 127.0.0.1
putenv('DATABASE_NAME=test_yomali_tracker');
putenv('DATABASE_USER=yomali_user');
putenv('DATABASE_PASSWORD=yomali_db_secret');

// Connect to MySQL (not directly to a database)
try {
	$db = new \PDO(
		"mysql:host=" . getenv('DATABASE_HOST'),
		getenv('DATABASE_USER'),
		getenv('DATABASE_PASSWORD'),
		[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
	);
} catch (PDOException $e) {
	die("Failed to connect to MySQL: " . $e->getMessage());
}

// Ensure test database exists
$db->exec("CREATE DATABASE IF NOT EXISTS test_yomali_tracker");
$db->exec("USE test_yomali_tracker");

// Run migrations for the test database
$migrations = [
	"001_create_websites_table.sql",
	"001_create_visits_table.sql",
];

foreach ($migrations as $migration) {
	$sql = file_get_contents(__DIR__ . "/../database/migrations/$migration");
	try {
		$db->exec($sql);
		echo "Migration $migration applied to test database.\n";
	} catch (PDOException $e) {
		echo "Failed to apply $migration: " . $e->getMessage() . "\n";
	}
}

// Set up a proper database connection for tests
Database::connect();
