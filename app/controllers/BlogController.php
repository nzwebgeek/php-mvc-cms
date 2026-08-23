<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PostRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\PageRepository;
use App\Repositories\CommentRepository;
use App\Services\CsrfService;

class BlogController extends Controller
{
    public function __construct(
        private PostRepository $posts,
        private SettingsRepository $settings,
        private PageRepository $pages,
        private CommentRepository $comments,
        private CsrfService $csrf
    ) {
    }

    public function index(): void
    {
        $settings = $this->settings->get();

        $this->view('pages/blog/blog', [

            'posts' => $this->posts->all(),

            'settings' => $settings,

            'pages' => $this->pages->getAll(),

            'csrfToken' => $this->csrf->token(),

        ]);
    }

    public function show(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $post = $this->posts->findById($id);

        if (!$post) {
            $this->view('errors/404');
            return;
        }

        $comments = $this->comments->findApprovedByPost($id);

        $this->view('pages/blog/post', [
            'post' => $post,
            'comments' => $comments,
            'settings' => $this->settings->get(),
            'pages' => $this->pages->getAll(),
            'csrfToken' => $this->csrf->token(),
        ]);
    }
}