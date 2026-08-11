<?php

declare(strict_types=1);

//session_start();
$isHttps = !empty($_SERVER['HTTPS'])
    && $_SERVER['HTTPS'] !== 'off';

ini_set('session.use_strict_mode', '1');

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $isHttps,
    'httponly' => true, //JavaScript cannot directly read the session cookie
    'samesite' => 'Lax', //useful additional CSRF defense
]);

session_start();


use App\Core\ErrorHandler;
use App\Core\Router;


require dirname(__DIR__) . '/vendor/autoload.php';

$container = require dirname(__DIR__) . '/bootstrap/app.php';

$config = require dirname(__DIR__) . '/config/config.php';

$errorHandler = new ErrorHandler($config);

$errorHandler->register();

$router = new Router($container);

// Load all web routes
require dirname(__DIR__) . '/routes/web.php';

// Dispatch the current request
$router->dispatch();

