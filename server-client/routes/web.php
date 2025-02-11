<?php
require_once __DIR__ . '/../app/Controllers/ViewController.php';

use App\Controllers\ViewController;

global $router;

if (!isset($router)) {
	error_log("DEBUG: Router instance NOT found in web.php, using existing one.");
} else {
	error_log("DEBUG: Router instance found in web.php.");
}

// Define web routes
$router->get('/', function () {
	error_log("DEBUG: Serving / route");
	ViewController::load('website');
});

// Fix favicon issue to prevent unnecessary 404 logs
$router->get('/favicon.ico', function () {
	header("Content-Type: image/x-icon");
	echo "";
	exit;
});

