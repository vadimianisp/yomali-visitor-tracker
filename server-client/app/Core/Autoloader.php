<?php
namespace App\Core;

class Autoloader {
	
	public static function register() {
		spl_autoload_register(function ($class) {
			$prefix = 'App\\';
			$baseDir = __DIR__ . '/../';
			
			// Only autoload classes within the "App\" namespace
			if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
				return;
			}
			
			// Convert namespace to file path
			$relativeClass = substr($class, strlen($prefix));
			$file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
			
			if (file_exists($file)) {
				require_once $file;
			}
		});
	}
}
