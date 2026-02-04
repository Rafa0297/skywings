<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SkyWings\Core\Router;
use SkyWings\Controllers\FlightController;
use SkyWings\Controllers\AuthController;
use SkyWings\Controllers\HomeController;
use SkyWings\Controllers\TripController;

$router = new Router();

/* ========= RUTAS ========= */

$router->add('GET', '/', HomeController::class, 'index');
$router->add('GET', '/flights', FlightController::class, 'index');
$router->add('GET', '/api/search-flights', FlightController::class, 'search');

$router->add('GET', '/login', AuthController::class, 'showLogin');
$router->add('POST', '/login', AuthController::class, 'login');

$router->add('GET', '/register', AuthController::class, 'showRegister');
$router->add('POST', '/register', AuthController::class, 'register');

$router->add('GET', '/logout', AuthController::class, 'logout');

$router->add('POST', '/save-trip', TripController::class, 'save');

/* ========= LIMPIAR URI ========= */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

/* quitar /skywings/public */
$basePath = '/skywings/public';

if (strpos($uri, $basePath) === 0) {
  $uri = substr($uri, strlen($basePath));
}

$uri = $uri ?: '/';

/* ========= DISPATCH ========= */

$router->dispatch($uri, $method);
