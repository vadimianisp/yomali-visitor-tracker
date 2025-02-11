<?php
namespace App\Core;
use PDO;
use PDOException;

class Database {
	
	private static $connection = null;
	
	public static function connect() {
		if (self::$connection === null) {
			$host = getenv('DATABASE_HOST') ?: 'db';
			$dbname = getenv('DATABASE_NAME') ?: 'yomali_tracker';
			$user = getenv('DATABASE_USER') ?: 'yomali_admin';
			$pass = getenv('DATABASE_PASSWORD') ?: 'yomali_db_secret';
			
			try {
				self::$connection = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
				self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch (PDOException $e) {
				die("Database connection failed: " . $e->getMessage());
			}
		}
		return self::$connection;
	}
}
