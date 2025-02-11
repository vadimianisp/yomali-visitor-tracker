<?php
	namespace App\Core;
	
	class Router {
		
		private static $routes = [];
		
		public function get($uri, $callback) {
			self::$routes['GET'][$uri] = $callback;
		}
		
		public function post($uri, $callback) {
			self::$routes['POST'][$uri] = $callback;
		}
		
		public function dispatch() {
			$requestMethod = $_SERVER['REQUEST_METHOD'];
			$requestUri = strtok($_SERVER["REQUEST_URI"], '?');
			
			error_log("DEBUG: Received Request: METHOD=$requestMethod, URI=$requestUri");
			
			$requestUri = '/' . ltrim($requestUri, '/');
			error_log("DEBUG: Normalized URI=$requestUri");
			
			if (isset(self::$routes[$requestMethod][$requestUri])) {
				$callback = self::$routes[$requestMethod][$requestUri];
				
				if (is_array($callback) && count($callback) === 2) {
					[$controller, $method] = $callback;
					if (method_exists($controller, $method)) {
						error_log("DEBUG: Dispatching $controller::$method");
						call_user_func([new $controller, $method]);
						exit;
					} else {
						error_log("DEBUG: Method $method not found in $controller");
					}
				}
			}
			
			if (strpos($requestUri, '/api/') === 0) {
				header("Content-Type: application/json");
				http_response_code(404);
				echo json_encode(["error" => "API route not found"]);
				exit;
			}
			
			
			if (file_exists(__DIR__ . "/../views/404.php")) {
				include __DIR__ . "/../views/404.php";
			} else {
				echo "404 Not Found";
			}
			http_response_code(404);
			exit;
		}
		
	}
