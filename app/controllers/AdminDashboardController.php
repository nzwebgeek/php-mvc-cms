<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;

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
            'title' => 'Admin Dashboard',
            'stats' => [
                'users' => 0,
                'pages' => 0,
                'posts' => 0,
                'comments' => 0
            ]
        ],
        'admin'
    );
}