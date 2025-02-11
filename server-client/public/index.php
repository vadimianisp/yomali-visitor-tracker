<?php
require_once __DIR__ . '/../app/Core/Autoloader.php';
require_once __DIR__ . '/../app/Core/Router.php';

use App\Core\Autoloader;
use App\Core\Router;

Autoloader::register();

global $router;

if (!isset($router)) {
	error_log("DEBUG: Router instance NOT found in index.php, creating a new one.");
	$router = new Router();
} else {
	error_log("DEBUG: Using existing Router instance.");
}
$GLOBALS['router'] = $router;

require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../routes/api.php';

$router->dispatch();
exit;
