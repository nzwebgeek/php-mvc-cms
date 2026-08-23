<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\PasswordResetService;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use App\Services\CsrfService;

class PasswordResetController extends Controller
{
    public function __construct(
        private readonly PasswordResetService $passwordReset,
        private readonly PageRepository $pages,
        private readonly SettingsRepository $settings,
        private readonly CsrfService $csrf
    ) {
    }

    public function requestForm(): void
    {
        $this->view('auth/forgot-password', [
            'message' => '',
            'messageType' => '',
            'email' => '',
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get(),
            'csrfToken' => $this->csrf->token(),
        ]);
    }

    public function request(): void
    {
        $this->csrf->requireValidToken();

        $email = trim($_POST['email'] ?? '');

        $result = $this->passwordReset->requestReset($email);

        $this->view('auth/forgot-password', [
            'message' => $result->message,
            'messageType' => $result->type,
            'email' => $email,
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get(),
            'csrfToken' => $this->csrf->token(),
        ]);
    }

    public function resetForm(): void
    {
        $token = trim($_GET['token'] ?? '');

        $this->view('auth/reset-password', [
            'message' => '',
            'messageType' => '',
            'token' => $token,
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get(),
            'csrfToken' => $this->csrf->token(),
        ]);
    }

public function reset(): void
{
  
    $this->csrf->requireValidToken();

    $token = trim($_POST['token'] ?? '');

    $tokenHash = hash('sha256', $token);

     die(
        "CONTROLLER TOKEN LENGTH: " . strlen($token) .
        "<br>CONTROLLER HASH: " . $tokenHash
    );
}
}