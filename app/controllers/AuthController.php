<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $auth
    ) {
    }


    public function register(): void
    {
        $this->view('auth/register', [
            'message' => '',
            'messageType' => '',
            'username' => '',
            'email' => ''
        ]);
    }

    public function login(): void
    {
        $this->view('auth/login', [
            'message' => '',
            'messageType' => '',
            'username' => ''
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
            'email' => $email
        ]);
    }
}