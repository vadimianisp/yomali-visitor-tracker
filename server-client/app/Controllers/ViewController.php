<?php
namespace App\Controllers;

class ViewController
{
	public static function load($view, $data = [])
	{
		$viewPath = __DIR__ . "/../Views/{$view}.php";
		error_log('DEBUG: Attempting to load view - Path: ' . $viewPath);
		
		if (file_exists($viewPath)) {
			error_log('DEBUG: View FOUND - Loading ' . $view);
			extract($data);
			require_once $viewPath;
		} else {
			error_log('DEBUG: View NOT FOUND - Serving 404');
			self::load404();
		}
	}
	
	public static function load404()
	{
		http_response_code(404);
		require_once __DIR__ . "/../Views/404.php";
		exit;
	}
}
