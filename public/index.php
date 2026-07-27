<?php
session_start();
declare(strict_types=1);

use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Core\Router;
use App\Controllers\DashboardController;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = require dirname(__DIR__) . '/bootstrap.php';


$router = new Router($container);



/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
*/

$router->get(
    'home',
    [PageController::class, 'home']
);

$router->get(
    'dashboard',
    [DashboardController::class,'index']
);


$router->post(
    'dashboard-theme',
    [DashboardController::class,'saveTheme']
);


$router->post(
    'dashboard-image',
    [DashboardController::class,'uploadImage']
);


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

$router->get(
    'login',
    [AuthController::class, 'login']
);


$router->get(
    'register',
    [AuthController::class, 'register']
);


$router->post(
    'register',
    [AuthController::class, 'store']
);



$router->dispatch();