<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Core\Container;
use App\Core\Database;
use App\Repositories\UserRepository;
use App\Models\Page;
use App\Services\AuthService;
use App\Services\Mailer;
use App\Services\PasswordResetService;
use App\Repositories\PostRepository;
use App\Repositories\ImageRepository;
use App\Repositories\SettingsRepository;

$config = require __DIR__ . '/config/config.php';


$container = new Container();


$db = Database::connect(
    $config['database']
);


// Repositories

$userRepository = new UserRepository($db);
$postRepository = new PostRepository($db);
$imageRepository = new ImageRepository($db);
$settingsRepository = new SettingsRepository($db);

// Models

$pageModel = new Page($db);


// Services

$mailer = new Mailer(
    $config['app']['url'],
    $config['mail']['from']
);


$authService = new AuthService(
    $userRepository
);


$passwordResetService = new PasswordResetService(
    $userRepository,
    $mailer
);


// Bind services

$container->set(
    UserRepository::class,
    $userRepository
);


$container->set(
    Page::class,
    $pageModel
);


$container->set(
    Mailer::class,
    $mailer
);


$container->set(
    AuthService::class,
    $authService
);


$container->set(
    PasswordResetService::class,
    $passwordResetService
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


return $container;