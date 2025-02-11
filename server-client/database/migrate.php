<?php
require_once __DIR__ . '/../app/Core/Autoloader.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Autoloader;
use App\Core\Database;

$db = Database::connect();

$migrations = [
	"001_create_websites_table.sql",
	"001_create_visits_table.sql",
];

foreach ($migrations as $migration) {
	$sql = file_get_contents(__DIR__ . "/migrations/$migration");
	try {
		$db->exec($sql);
		echo "Migration $migration applied successfully.\n";
	} catch (PDOException $e) {
		echo "Failed to apply $migration: " . $e->getMessage() . "\n";
	}
}
