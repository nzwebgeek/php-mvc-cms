<?php

declare(strict_types=1);
/*AuthController handles requests*/
namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly PageRepository $pages,
        private readonly SettingsRepository $settings
    ) {
    }
    public function authenticate(): void
{
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    $result = $this->auth->login(
        $username,
        $password
    );

    if ($result->success) {
        header('Location: /dashboard');
        exit;
    }

    $this->view('auth/login', [
        'message' => $result->message,
        'messageType' => $result->type,
        'username' => $username,
        'pages' => $this->pages->getAll(),
        'settings' => $this->settings->get()
    ]);
}

    public function logout(): void
{
    session_unset();
    session_destroy();

    header('Location: /login');
    exit;
}
    public function register(): void
    {
        $this->view('auth/register', [
            'message' => '',
            'messageType' => '',
            'username' => '',
            'email' => '',
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get()
        ]);
    }

    public function login(): void
    {
        $this->view('auth/login', [
            'message' => '',
            'messageType' => '',
            'username' => '',
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get()
        ]);
    }


    public function store(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');

        $result = $this->auth->register(
            $username,
            $email,
            $_POST['password'] ?? '',
            $_POST['confirm_password'] ?? ''
        );

        $this->view('auth/register', [
            'message' => $result->message,
            'messageType' => $result->type,
            'username' => $username,
            'email' => $email,
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get()
        ]);
    }
}