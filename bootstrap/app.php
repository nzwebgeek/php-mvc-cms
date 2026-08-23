<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

require dirname(__DIR__) . '/vendor/autoload.php';

use App\Controllers\PasswordResetController;
use App\Services\PasswordResetService;
use App\Repositories\RoleRepository;
use App\Controllers\AdminController;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Repositories\ImageRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\BlogSettingsRepository;
use App\Controllers\AuthController;
use App\Controllers\VerifyController;
use App\Controllers\BlogController;
use App\Controllers\SettingsController;
use App\Controllers\ErrorController;

use App\Core\Container;
use App\Core\Database;
use App\Repositories\UserRepository;

use App\Services\AuthService;
use App\Services\CsrfService;
use App\Services\Mailer;
use App\Services\PasswordService;

use App\Repositories\AdminRepository;
use App\Controllers\RoleController;
use App\Controllers\AdminPostsController;
use App\Controllers\AdminPagesController;
use App\Repositories\CommentRepository;
use App\Controllers\CommentController;
use App\Core\Environment;
use App\Controllers\ContactController;


Environment::load(
    dirname(__DIR__) . '/.env'
);

$config = require dirname(__DIR__) . '/config/config.php';
$container = new Container();


$db = Database::connect(
    $config['database']
);


// Repositories
$userRepository = new UserRepository($db);
$postRepository = new PostRepository($db);
$commentRepository = new CommentRepository($db);
$imageRepository = new ImageRepository($db);
$settingsRepository = new SettingsRepository($db);
$pageRepository = new PageRepository($db);
$blogSettingsRepository = new BlogSettingsRepository($db);
$adminRepository = new AdminRepository($db);
$roleRepository = new RoleRepository($db);
$passwordService = new PasswordService();

// Models


// Services

$csrfService = new CsrfService();

$passwordService = new PasswordService();

$mailer = new Mailer(
    $config['app']['url'],
    $config['mail']['from']
);

$passwordResetService = new PasswordResetService(
    $userRepository,
    $mailer,
    $passwordService
);


$authService = new AuthService(
    $userRepository,
    $mailer,
    $passwordService
);
$authController = new AuthController(
    $authService,
    $pageRepository,
    $settingsRepository,
    $csrfService
);

$passwordResetController = new PasswordResetController(
    $passwordResetService,
    $pageRepository,
    $settingsRepository,
    $csrfService
);

$verifyController = new VerifyController(
    $userRepository
);

$adminController = new AdminController(
    $authService,
    $adminRepository,
    $userRepository,
    $imageRepository,
    $csrfService,
    $passwordService
);


$roleController = new RoleController(
    $authService,
    $roleRepository,
     $csrfService
);

$blogController = new BlogController(
    $postRepository,
    $settingsRepository,
    $pageRepository,
    $commentRepository,
    $csrfService
);

$errorController = new ErrorController(
    $pageRepository,
    $settingsRepository,
    $csrfService
);

$contactController = new ContactController(
    $settingsRepository,
    $pageRepository,
    $mailer
);

// Bind services
$container->set(
    PasswordResetController::class,
    $passwordResetController
);

$container->set(
    ContactController::class,
    $contactController
);
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
    ErrorController::class,
    $errorController
);

$adminPostsController = new AdminPostsController(
    $authService,
    $postRepository,
    $userRepository,
     $imageRepository,
      $csrfService
);

$adminPagesController = new AdminPagesController(
    $authService,
    $pageRepository,
    $imageRepository,
    $csrfService
);


$commentController = new CommentController(
    $authService,
    $commentRepository,
    $csrfService
);

$settingsController = new SettingsController(
    $authService,
    $settingsRepository,
    $blogSettingsRepository,
    $imageRepository,
    $csrfService
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
    CsrfService::class,
    $csrfService
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
    RoleController::class,
    $roleController
);

$container->set(
    AdminRepository::class,
    $adminRepository
);


$container->set(
    RoleRepository::class,
    $roleRepository
);

$container->set(
    AdminPostsController::class,
     $adminPostsController
);

$container->set(
    AdminPagesController::class,
    $adminPagesController
);

$container->set(
    CommentRepository::class,
    $commentRepository
);

$container->set(
    CommentController::class,
    $commentController
);

$container->set(
    BlogController::class,
    $blogController
);

$container->set(
    SettingsController::class,
    $settingsController
);
return $container;
