<?php
declare(strict_types=1);

namespace App\Controllers;
/*Loads Content*/
use App\Core\Controller;
use App\Repositories\UserRepository;
use App\Repositories\PostRepository;
use App\Repositories\ImageRepository;
class DashboardController extends Controller
{

    public function __construct(
        private UserRepository $users,
        private PostRepository $posts,
        private ImageRepository $images
    ) {
    }
/*-----------------Auth Helpers----------------------------------*/
    private function currentUser(): array
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->users->findById((int)$_SESSION['user_id']);

        if ($user === null) {
            session_destroy();
            header('Location: /login');
            exit;
        }

        return $user;
    }

 
   
/*--------------------------------------------------------------*/
public function index(): void
{
    
    $user = $this->currentUser();


    // Only show this user's posts
    $posts = $this->posts->findByUser(
        (int)$user['id']
    );


    $panel = $_GET['panel'] ?? 'home';



    // Inline post editor
    $editPost = null;


    if (isset($_GET['edit'])) {

        $editPost = $this->posts->findByIdAndUser(
            (int)$_GET['edit'],
            (int)$user['id']
        );

    }




    $this->view(
        'dashboard/index',
        [
            'user' => $user,
            'posts' => $posts,
            'panel' => $panel,
            'editPost' => $editPost
        ],
        'dashboard'
    );

}
    /*-------------New Color theme-----------------*/
    private function validColour(string $colour): bool
    {
        return preg_match('/^#[0-9A-Fa-f]{6}$/', $colour) === 1;
    }


    public function saveTheme(): void
    {
        $user = $this->currentUser();

        $theme = $_POST['theme_color'] ?? '#007bff';
        $background = $_POST['background_color'] ?? '#ffffff';
        $text = $_POST['text_color'] ?? '#000000';

        foreach ([$theme, $background, $text] as $colour) {

            if (!$this->validColour($colour)) {
                $_SESSION['message'] = 'Invalid colour selected.';
                header('Location: /dashboard');
                exit;
            }
        }

        $this->users->updateTheme(
            (int)$user['id'],
            $theme,
            $background,
            $text
        );

        $_SESSION['message'] = 'Theme updated successfully.';

        header('Location: /dashboard');
        exit;
    }
/*-----------------------------*/
    public function uploadImage(): void
    {

        $user = $this->currentUser();

        if (!isset($_FILES['image'])) {

            header(
                'Location: /dashboard'
            );

            exit;
        }

        $imageId = $this->images->upload(
            $_FILES['image']
        );

        $this->users->updateImage(
            (int)$user['id'],
            $imageId);

        $_SESSION['message'] = "Image uploaded successfully.";

        header(
            'Location: /dashboard'
        );

        exit;
    }

    public function editPost(): void
    {
        $user = $this->currentUser();

        $id = (int)($_GET['id'] ?? 0);
        
          $post = $this->posts->findByIdAndUser(
            $id,
            (int)$user['id']
        );

        if (!$post) {
            $_SESSION['message'] = "Post not found.";
            header('Location: /dashboard?panel=posts');
            exit;
        }

        $this->view(
            'dashboard/posts/edit',
            [
                'user' => $user,
                'post' => $post
            ],
            'dashboard'
        );
    }

    public function updatePost(): void
    {
        $user = $this->currentUser();

        $id = (int)($_GET['id'] ?? 0);

        $this->posts->update(
            $id,
            (int)$user['id'],
            $_POST
        );

        $_SESSION['message'] = "Post updated successfully.";

        header('Location: /dashboard?panel=posts');
        exit;
    }
}