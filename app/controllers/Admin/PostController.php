<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\PostRepository;

class PostController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly PostRepository $posts
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

        $status = $_GET['status'] ?? null;

        if (!in_array($status, ['published', 'draft'], true)) {
            $status = null;
        }

        $this->view(
            'admin/dashboard/posts/index',
            [
                'title' => 'Posts',
                'posts' => $this->posts->adminAll($status),
                'status' => $status
            ],
            'admin'
        );
    }
}