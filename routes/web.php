<?php

declare(strict_types=1);

use App\Controllers\BlogController;
use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\VerifyController;
use App\Controllers\ContactController;
use App\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
*/

$router->get(
    '/',
    [PageController::class, 'home']
);


$router->get(
    '/blog',
    [BlogController::class, 'index']
);

$router->get(
    '/blog/post',
    [BlogController::class, 'show']
);

$router->get(
    '/contact',
    [PageController::class, 'show']
);
/*
|--------------------------------------------------------------------------
|Dashboard
|-------------------------------------------------------------------------
*/
$router->get(
    '/dashboard',
    [DashboardController::class, 'index']
);

$router->get(
    '/dashboard/posts/edit',
    [DashboardController::class, 'editPost']
);


$router->post(
    '/dashboard/posts/update',
    [DashboardController::class, 'updatePost']
);

$router->post(
    '/dashboard/posts/store',
    [DashboardController::class, 'storePost']
);
/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

$router->get(
    '/login',
    [AuthController::class, 'login']
);

$router->post(
    '/login',
    [AuthController::class, 'authenticate']
);

$router->get(
    '/logout',
    [AuthController::class, 'logout']
);

$router->get(
    '/register',
    [AuthController::class, 'register']
);

$router->post(
    '/register',
    [AuthController::class, 'store']
);

$router->get(
    '/verify',
    [VerifyController::class, 'verify']
);

$router->get(
    '/contact',
    [ContactController::class, 'index']
);

$router->post(
    '/contact',
    [ContactController::class, 'send']
);

$router->post(
    '/dashboard/upload-image',
    [DashboardController::class, 'uploadImage']
);

$router->post(
    '/dashboard/save-theme',
    [DashboardController::class, 'saveTheme']
);