<?php
// fine keep for template for every new admin module
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PostRepository;
use App\Services\AuthService;
use App\Repositories\UserRepository;
use App\Repositories\ImageRepository;
use App\Services\CsrfService;


class AdminPostsController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private PostRepository $postRepository,
        private UserRepository $userRepository,
        private ImageRepository $imageRepository,
        private readonly CsrfService $csrf
        
    ) {
    }

   public function index(): void {
    // Ensure only authenticated admins can access this page.
    $this->authService->requireAdmin();

    $status = $_GET['status'] ?? null;

    $posts = $this->postRepository->adminAll($status);

        $this->view('admin/dashboard/posts/list', [
            'title'  => 'Posts',
            'posts'  => $posts,
            'status' => $status,
            'csrfToken' => $this->csrf->token(),

        ], 'admin');
    }

public function create(): void
{
    $this->authService->requireAdmin();

    $users = $this->userRepository->all();

    $images = $this->imageRepository->all();

    $this->view(
        'admin/dashboard/posts/create',
        [
            'title' => 'Create Post',
            'users' => $users,
            'images' => $images,
            'csrfToken' => $this->csrf->token(),

        ],
        'admin'
    );
}

public function store(): void
{
    $this->authService->requireAdmin();


    $data = [

        'user_id' => $_POST['user_id'],

        'title' => $_POST['title'],

        'slug' => $_POST['slug'],

        'content' => $_POST['content'],

        'status' => $_POST['status'],


        'featured_media_id' => !empty($_POST['featured_media_id'])
            ? $_POST['featured_media_id']
            : null,


        'hero_title' => $_POST['hero_title'] ?? null,

        'hero_subtitle' => $_POST['hero_subtitle'] ?? null,


        'main_heading' => $_POST['main_heading'] ?? null,

        'main_content' => $_POST['main_content'] ?? null,


        'column1_title' => $_POST['column1_title'] ?? null,

        'column1_content' => $_POST['column1_content'] ?? null,


        'column2_title' => $_POST['column2_title'] ?? null,

        'column2_content' => $_POST['column2_content'] ?? null,


        'column3_title' => $_POST['column3_title'] ?? null,

        'column3_content' => $_POST['column3_content'] ?? null,


        'column4_title' => $_POST['column4_title'] ?? null,

        'column4_content' => $_POST['column4_content'] ?? null,


        'column5_title' => $_POST['column5_title'] ?? null,

        'column5_content' => $_POST['column5_content'] ?? null,


        'seo_title' => $_POST['seo_title'] ?? null,

        'seo_description' => $_POST['seo_description'] ?? null

    ];


    $this->postRepository->adminCreate($data);


    header('Location: /admin/posts?success=created');

    exit;
}

    public function edit(): void
{
    $this->authService->requireAdmin();

    $id = (int)($_GET['id'] ?? 0);


    $post = $this->postRepository->adminFindById($id);


    if (!$post) {
        header('Location: /admin/posts');
        exit;
    }


    $users = $this->userRepository->all();

    $images = $this->imageRepository->all();


    $this->view(
        'admin/dashboard/posts/edit',
        [
            'title' => 'Edit Post',
            'post' => $post,
            'users' => $users,
            'images' => $images,
            'csrfToken' => $this->csrf->token(),

        ],
        'admin'
    );
}
public function update(): void
{
    $this->authService->requireAdmin();


    $data = [

        'id' => $_POST['id'],

        'user_id' => $_POST['user_id'],

        'title' => $_POST['title'],

        'slug' => $_POST['slug'],

        'content' => $_POST['content'],

        'status' => $_POST['status'],


        'featured_media_id' => !empty($_POST['featured_media_id'])
            ? $_POST['featured_media_id']
            : null,


        'hero_title' => $_POST['hero_title'] ?? null,

        'hero_subtitle' => $_POST['hero_subtitle'] ?? null,


        'main_heading' => $_POST['main_heading'] ?? null,

        'main_content' => $_POST['main_content'] ?? null,


        'column1_title' => $_POST['column1_title'] ?? null,

        'column1_content' => $_POST['column1_content'] ?? null,


        'column2_title' => $_POST['column2_title'] ?? null,

        'column2_content' => $_POST['column2_content'] ?? null,


        'column3_title' => $_POST['column3_title'] ?? null,

        'column3_content' => $_POST['column3_content'] ?? null,


        'column4_title' => $_POST['column4_title'] ?? null,

        'column4_content' => $_POST['column4_content'] ?? null,


        'column5_title' => $_POST['column5_title'] ?? null,

        'column5_content' => $_POST['column5_content'] ?? null,


        'seo_title' => $_POST['seo_title'] ?? null,

        'seo_description' => $_POST['seo_description'] ?? null

    ];


    $this->postRepository->adminUpdate($data);


    header('Location: /admin/posts?success=updated');

    exit;
}
public function delete(): void
{
    $this->authService->requireAdmin();


    $id = (int)$_POST['id'];


    $this->postRepository->adminDelete($id);


    header('Location: /admin/posts?success=deleted');

    exit;
}
}