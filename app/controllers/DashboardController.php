<?php

declare(strict_types=1);

namespace App\Controllers;

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


    public function index(): void
    {

        if (!isset($_SESSION['user_id'])) {

            header('Location: ?page=login');
            exit;
        }


        $user = $this->users->findById(
            (int) $_SESSION['user_id']
        );


        $posts = $this->posts->all();


        $this->view(
            'dashboard/index',
            [
                'user' => $user,
                'posts' => $posts
            ]
        );
    }



    public function saveTheme(): void
    {

        if (!isset($_SESSION['user_id'])) {

            header('Location: ?page=login');
            exit;
        }


        $this->users->updateTheme(
            (int) $_SESSION['user_id'],
            $_POST['theme_color'] ?? '#007bff',
            $_POST['background_color'] ?? '#ffffff',
            $_POST['text_color'] ?? '#000000'
        );


        header(
            'Location: ?page=dashboard'
        );

        exit;
    }



    public function uploadImage(): void
    {

        if (!isset($_SESSION['user_id'])) {

            header('Location: ?page=login');
            exit;
        }


        if (!isset($_FILES['image'])) {

            header(
                'Location: ?page=dashboard'
            );

            exit;
        }


        $imageId = $this->images->upload(
            $_FILES['image']
        );


        $this->users->updateImage(
            (int) $_SESSION['user_id'],
            $imageId
        );


        header(
            'Location: ?page=dashboard'
        );

        exit;
    }
}