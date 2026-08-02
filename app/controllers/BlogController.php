<?php

declare(strict_types=1);
/*responsibility is to display blog posts to visitors*/
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PostRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\PageRepository;

class BlogController extends Controller
{
    public function __construct(
        private PostRepository $posts,
        private SettingsRepository $settings,
        private PageRepository $pages,
    ) {
    }


public function index(): void
{
    $this->view('pages/blog/blog', [

        'posts' => $this->posts->all(),

        'featuredImages' => [
        ],

        'settings' => $this->settings->get(),

        'pages' => $this->pages->getAll()

    ]);
}
  public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        $post = $this->posts->findById($id);


        if (!$post) {
            $this->view('errors/404');
            return;
        }


        $this->view('pages/blog/post', [
            'post' => $post,
            'settings' => $this->settings->get(),
            'pages' => $this->pages->getAll(),
        ]);
    }
}