<?php

declare(strict_types=1);

session_start();

use App\Core\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = require dirname(__DIR__) . '/bootstrap/app.php';

$router = new Router($container);

// Load all web routes
require dirname(__DIR__) . '/routes/web.php';

// Dispatch the current request
$router->dispatch();

