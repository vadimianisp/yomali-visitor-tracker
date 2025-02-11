<?php
require_once __DIR__ . '/../app/Core/Autoloader.php';
require_once __DIR__ . '/../app/Core/Router.php';
require_once __DIR__ . '/../app/Controllers/TrackerController.php';

use App\Core\Autoloader;
use App\Core\Router;
use App\Controllers\TrackerController;
use App\Controllers\StatsController;

Autoloader::register();

// Use global router instance
global $router;

if (!isset($router)) {
	error_log("DEBUG: Router instance NOT found in api.php, using existing one.");
} else {
	error_log("DEBUG: Router instance found in api.php.");
}

// Define API routes
$router->post('/api/track', [TrackerController::class, 'store']);
$router->get('/api/visits', [TrackerController::class, 'getVisits']);

error_log("DEBUG: API routes successfully registered.");
