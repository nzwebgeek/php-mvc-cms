<?php

declare(strict_types=1);

use App\Controllers\BlogController;
use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\VerifyController;
use App\Controllers\ContactController;
use App\Controllers\DashboardController;
use App\Controllers\AdminController;
use App\Controllers\AdminUserController;
use App\Controllers\Admin\PostController;
use App\Controllers\RoleController;
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
| Admin
|--------------------------------------------------------------------------
*/
$router->get(
    '/admin',
    [AdminController::class,'index']
);

$router->get(
    '/admin/users',
    [AdminController::class,'users']
);

$router->get(
    '/admin/users/create',
    [AdminController::class, 'createUser']
);

$router->post(
    '/admin/users/create',
    [AdminController::class, 'storeUser']
);

$router->get(
    '/admin/users/edit',
    [AdminController::class, 'editUser']
);


$router->post(
    '/admin/users/update',
    [AdminController::class, 'updateUser']
);


$router->post(
    '/admin/users/delete',
    [AdminController::class, 'deleteUser']
);

$router->get(
    '/admin/roles',
    [RoleController::class, 'index']
);

$router->get(
    '/admin/roles/create',
    [RoleController::class,'create']
);


$router->post(
    '/admin/roles/create',
    [RoleController::class,'store']
);

//------------------Roles

$router->get(
    '/admin/roles/edit',
    [RoleController::class,'edit']
);


$router->post(
    '/admin/roles/update',
    [RoleController::class,'update']
);



$router->post(
    '/admin/roles/delete',
    [RoleController::class,'delete']
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

$router->get(
    '/admin/posts',
    [PostController::class, 'index']
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

$router->post(
    '/dashboard/change-password',
    [
        DashboardController::class,
        'changePassword'
    ]
);