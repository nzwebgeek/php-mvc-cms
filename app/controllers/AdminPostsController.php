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

    $this->csrf->requireValidToken();

    $userId = (int) ($_POST['user_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $content = $_POST['content'] ?? '';
    $status = $_POST['status'] ?? 'draft';
    

    $featuredMediaId = !empty($_POST['featured_media_id'])
        ? (int) $_POST['featured_media_id']
        : null;
    

    /*
    |--------------------------------------------------------------------------
    | Validate basic fields
    |--------------------------------------------------------------------------
    */

    if ($userId <= 0) {
        $_SESSION['error'] = 'Invalid author.';

        header('Location: /admin/posts/create');
        exit;
    }


    if ($title === '') {
        $_SESSION['error'] = 'Title is required.';

        header('Location: /admin/posts/create');
        exit;
    }


    if ($slug === '') {
        $_SESSION['error'] = 'Slug is required.';

        header('Location: /admin/posts/create');
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate status
    |--------------------------------------------------------------------------
    */

    $allowedStatuses = [
        'draft',
        'published',
    ];


    if (!in_array($status, $allowedStatuses, true)) {
        $_SESSION['error'] = 'Invalid post status.';

        header('Location: /admin/posts/create');
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate author exists
    |--------------------------------------------------------------------------
    */

    $user = $this->userRepository->findById($userId);

    if (!$user) {
        $_SESSION['error'] = 'Selected author does not exist.';

        header('Location: /admin/posts/create');
        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate featured media
    |--------------------------------------------------------------------------
    */

    if ($featuredMediaId !== null) {

        $image = $this->imageRepository->findById(
            $featuredMediaId
        );

        if (!$image) {
            $_SESSION['error'] =
                'Selected image does not exist.';

            header('Location: /admin/posts/create');
            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Build post data
    |--------------------------------------------------------------------------
    */

    $data = [

        'user_id' => $userId,

        'title' => $title,

        'slug' => $slug,

        'content' => $content,

        'status' => $status,

        'featured_media_id' => $featuredMediaId,

        'hero_title' => trim(
            $_POST['hero_title'] ?? ''
        ) ?: null,

        'hero_subtitle' => trim(
            $_POST['hero_subtitle'] ?? ''
        ) ?: null,

        'hero_image_alt' => trim(
            $_POST['hero_image_alt'] ?? ''
        ) ?: null,
        

        'main_heading' => trim(
            $_POST['main_heading'] ?? ''
        ) ?: null,

        'main_content' => $_POST['main_content'] ?? null,

        'column1_title' => trim(
            $_POST['column1_title'] ?? ''
        ) ?: null,

        'column1_content' => $_POST['column1_content'] ?? null,

        'column2_title' => trim(
            $_POST['column2_title'] ?? ''
        ) ?: null,

        'column2_content' => $_POST['column2_content'] ?? null,

        'column3_title' => trim(
            $_POST['column3_title'] ?? ''
        ) ?: null,

        'column3_content' => $_POST['column3_content'] ?? null,

        'column4_title' => trim(
            $_POST['column4_title'] ?? ''
        ) ?: null,

        'column4_content' => $_POST['column4_content'] ?? null,

        'column5_title' => trim(
            $_POST['column5_title'] ?? ''
        ) ?: null,

        'column5_content' => $_POST['column5_content'] ?? null,

        'seo_title' => trim(
            $_POST['seo_title'] ?? ''
        ) ?: null,

        'seo_description' => trim(
            $_POST['seo_description'] ?? ''
        ) ?: null,
    ];


    /*
    |--------------------------------------------------------------------------
    | Create post
    |--------------------------------------------------------------------------
    */
try {

    $this->postRepository->adminCreate($data);

    $_SESSION['success'] =
        'Post created successfully.';

} catch (\Throwable $e) {

    error_log(
        'AdminPostsController::store() failed: '
        . $e->getMessage()
    );

    error_log(
        'SQL error code: '
        . $e->getCode()
    );

    $_SESSION['error'] =
        'Unable to create post.';
}


    header('Location: /admin/posts');
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

    $this->csrf->requireValidToken();


    $id = (int) ($_POST['id'] ?? 0);

    $userId = (int) ($_POST['user_id'] ?? 0);

    $title = trim($_POST['title'] ?? '');

    $slug = trim($_POST['slug'] ?? '');

    $content = $_POST['content'] ?? '';

    $status = $_POST['status'] ?? 'draft';


    $featuredMediaId = !empty($_POST['featured_media_id'])
        ? (int) $_POST['featured_media_id']
        : null;


    /*
    |--------------------------------------------------------------------------
    | Validate post ID
    |--------------------------------------------------------------------------
    */

    if ($id <= 0) {

        $_SESSION['error'] =
            'Invalid post.';

        header('Location: /admin/posts');

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate author
    |--------------------------------------------------------------------------
    */

    if ($userId <= 0) {

        $_SESSION['error'] =
            'Invalid author.';

        header(
            'Location: /admin/posts/edit?id=' . $id
        );

        exit;
    }


    $user = $this->userRepository->findById($userId);

    if (!$user) {

        $_SESSION['error'] =
            'Selected author does not exist.';

        header(
            'Location: /admin/posts/edit?id=' . $id
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate basic fields
    |--------------------------------------------------------------------------
    */

    if ($title === '') {

        $_SESSION['error'] =
            'Title is required.';

        header(
            'Location: /admin/posts/edit?id=' . $id
        );

        exit;
    }


    if ($slug === '') {

        $_SESSION['error'] =
            'Slug is required.';

        header(
            'Location: /admin/posts/edit?id=' . $id
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate status
    |--------------------------------------------------------------------------
    */

    $allowedStatuses = [
        'draft',
        'published',
    ];


    if (!in_array($status, $allowedStatuses, true)) {

        $_SESSION['error'] =
            'Invalid post status.';

        header(
            'Location: /admin/posts/edit?id=' . $id
        );

        exit;
    }


    /*
    |--------------------------------------------------------------------------
    | Validate featured media
    |--------------------------------------------------------------------------
    */

    if ($featuredMediaId !== null) {

        $image = $this->imageRepository->findById(
            $featuredMediaId
        );

        if (!$image) {

            $_SESSION['error'] =
                'Selected image does not exist.';

            header(
                'Location: /admin/posts/edit?id=' . $id
            );

            exit;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Build post data
    |--------------------------------------------------------------------------
    */

    $data = [

        'id' => $id,

        'user_id' => $userId,

        'title' => $title,

        'slug' => $slug,

        'content' => $content,

        'status' => $status,

        'featured_media_id' => $featuredMediaId,

        'hero_title' => trim(
            $_POST['hero_title'] ?? ''
        ) ?: null,

        'hero_subtitle' => trim(
            $_POST['hero_subtitle'] ?? ''
        ) ?: null,

        'main_heading' => trim(
            $_POST['main_heading'] ?? ''
        ) ?: null,

        'main_content' => $_POST['main_content'] ?? null,

        'column1_title' => trim(
            $_POST['column1_title'] ?? ''
        ) ?: null,

        'column1_content' => $_POST['column1_content'] ?? null,

        'column2_title' => trim(
            $_POST['column2_title'] ?? ''
        ) ?: null,

        'column2_content' => $_POST['column2_content'] ?? null,

        'column3_title' => trim(
            $_POST['column3_title'] ?? ''
        ) ?: null,

        'column3_content' => $_POST['column3_content'] ?? null,

        'column4_title' => trim(
            $_POST['column4_title'] ?? ''
        ) ?: null,

        'column4_content' => $_POST['column4_content'] ?? null,

        'column5_title' => trim(
            $_POST['column5_title'] ?? ''
        ) ?: null,

        'column5_content' => $_POST['column5_content'] ?? null,

        'seo_title' => trim(
            $_POST['seo_title'] ?? ''
        ) ?: null,

        'seo_description' => trim(
            $_POST['seo_description'] ?? ''
        ) ?: null,
    ];


    /*
    |--------------------------------------------------------------------------
    | Update post
    |--------------------------------------------------------------------------
    */

    try {

        $this->postRepository->adminUpdate($data);

        $_SESSION['success'] =
            'Post updated successfully.';

    } catch (\Throwable $e) {

        $_SESSION['error'] =
            'Unable to update post.';
    }


    header('Location: /admin/posts');

    exit;
}
public function delete(): void
{
    $this->authService->requireAdmin();

    $this->csrf->requireValidToken();


    $id = (int) ($_POST['id'] ?? 0);


    if ($id <= 0) {

        $_SESSION['error'] =
            'Invalid post.';

        header('Location: /admin/posts');

        exit;
    }


    try {

        $this->postRepository->adminDelete($id);

        $_SESSION['success'] =
            'Post deleted successfully.';

    } catch (\Throwable $e) {

        $_SESSION['error'] =
            'Unable to delete post.';
    }


    header('Location: /admin/posts');

    exit;
}
}