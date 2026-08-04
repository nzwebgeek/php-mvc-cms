<?php

declare(strict_types=1);

use App\Controllers\AdminController;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\ImageRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\BlogSettingsRepository;
use App\Controllers\AuthController;
use App\Controllers\VerifyController;

use App\Core\Container;
use App\Core\Database;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\Mailer;
use App\Repositories\AdminRepository;



$config = require dirname(__DIR__) . '/config/config.php';

$container = new Container();


$db = Database::connect(
    $config['database']
);


// Repositories
$userRepository = new UserRepository($db);
$postRepository = new PostRepository($db);
$imageRepository = new ImageRepository($db);
$settingsRepository = new SettingsRepository($db);
$pageRepository = new PageRepository($db);
$blogSettingsRepository = new BlogSettingsRepository($db);
$adminRepository = new AdminRepository($db); // add here 1st
$postRepository = new PostRepository($db);
// 2nd; Update AdminController

// Models


// Services
$mailer = new Mailer(
    $config['app']['url'],
    $config['mail']['from']
);

$authService = new AuthService(
    $userRepository,
    $mailer
);

$authController = new AuthController(
    $authService,
    $pageRepository,
    $settingsRepository
);

$verifyController = new VerifyController(
    $userRepository
);

$adminController = new AdminController(
    $authService,
    $adminRepository,
    $userRepository
);

$postController = new \App\Controllers\Admin\PostController(
    $authService,
    $postRepository
);

// Bind services
$container->set(
    UserRepository::class,
    $userRepository
);

$container->set(
    PostRepository::class,
    $postRepository
);

$container->set(
    ImageRepository::class,
    $imageRepository
);

$container->set(
    SettingsRepository::class,
    $settingsRepository
);

$container->set(
    PageRepository::class,
    $pageRepository
);

$container->set(
    BlogSettingsRepository::class,
    $blogSettingsRepository
);

$container->set(
    AuthService::class,
    $authService
);

$container->set(
    AuthController::class,
    $authController
);

$container->set(
    Mailer::class,
    $mailer
);

$container->set(
    VerifyController::class,
    $verifyController
);
/*------Admin----------------*/
$container->set(
    AdminController::class,
    $adminController
);

$container->set(
    AdminRepository::class,
    $adminRepository
);

$container->set(
    \App\Controllers\Admin\PostController::class,
    $postController
);

return $container;