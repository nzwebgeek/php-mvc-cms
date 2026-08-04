<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;

class AdminController extends Controller
{
    public function __construct(
        private readonly AuthService $auth
    ) {
    }

    public function index(): void
    {
        if (!$this->auth->isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        if (!$this->auth->isAdmin()) {
            header('Location: /dashboard');
            exit;
        }

        $this->view(
            'admin/dashboard/index',
            [
                'title' => 'Admin Dashboard'
            ],
            'admin'
        );
    }
}