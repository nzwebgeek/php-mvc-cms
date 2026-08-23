<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\CsrfService;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Repositories\ImageRepository;
use App\Services\PasswordService;

class AdminController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly AdminRepository $adminRepository,
        private readonly UserRepository $userRepository,
        private readonly ImageRepository $imageRepository,
        private readonly CsrfService $csrf,
        private readonly PasswordService $passwords
    ) {
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    public function index(): void
    {
        $this->auth->requireAdmin();

        $stats = [
            'users' => $this->adminRepository->countUsers(),
            'posts' => $this->adminRepository->countPosts(),
            'pages' => $this->adminRepository->countPages(),
            'comments' => $this->adminRepository->countPendingComments(),
        ];

        $activity = $this->adminRepository->recentActivity();

        $this->view(
            'admin/dashboard/index',
            [
                'title' => 'Admin Dashboard',
                'stats' => $stats,
                'activity' => $activity,
                 'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Users
    |--------------------------------------------------------------------------
    */

    public function users(): void
    {
       
        $this->auth->requireAdmin();

        $users = $this->userRepository->all();

        $this->view(
            'admin/dashboard/users/index',
            [
                'title' => 'Manage Users',
                'users' => $users,
                'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    public function createUser(): void
    {
       
        $this->auth->requireAdmin();

        $this->view(
            'admin/dashboard/users/create',
            [
                'title' => 'Create User',
                'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    public function storeUser(): void
    {
        $this->auth->requireAdmin();

        $this->csrf->requireValidToken();

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? 'User';

        $passwordError = $this->passwords->validate($password);

        if ($passwordError !== null) {
            $_SESSION['error'] = $passwordError;

            header('Location: /admin/users/create');
            exit;
        }

        if ($this->userRepository->usernameExists($username)) {
            $_SESSION['error'] =
                'Username already exists. Please choose another.';

            header('Location: /admin/users/create');
            exit;
        }

        if ($this->userRepository->emailExists($email)) {
            $_SESSION['error'] =
                'Email address already exists.';

            header('Location: /admin/users/create');
            exit;
        }

        $roleId = $this->userRepository->findRoleIdByName($role);
        
        if ($roleId === null) {
            $_SESSION['error'] = 'Invalid role.';
        
            header('Location: /admin/users/create');
            exit;
        }
        
        $this->userRepository->createUser(
            $username,
            $email,
            $this->passwords->hash($password),
            $roleId,
            ''
        );

        $_SESSION['success'] =
            'User created successfully.';

        header('Location: /admin/users');
        exit;
    }

    public function editUser(): void
    {
        
        $this->auth->requireAdmin();

        $id = (int) ($_GET['id'] ?? 0);

        $user = $this->userRepository->findById($id);

        if (!$user) {
            header('Location: /admin/users');
            exit;
        }

        $this->view(
            'admin/dashboard/users/edit',
            [
                'title' => 'Edit User',
                'user' => $user,
                'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    public function updateUser(): void
    {
        $this->auth->requireSuperAdmin();

        $this->csrf->requireValidToken();

        $id = (int) ($_POST['id'] ?? 0);
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = $_POST['role'] ?? 'User';

        $roleId = $this->userRepository->findRoleIdByName($role);

        $this->userRepository->updateUser(
            $id,
            $username,
            $email,
            $roleId
        );

        $_SESSION['success'] =
            'User updated successfully.';

        header('Location: /admin/users');
        exit;
    }

    public function deleteUser(): void
    {
        $this->auth->requireSuperAdmin();

        $this->csrf->requireValidToken();

        $id = (int) ($_POST['id'] ?? 0);

        // Prevent deleting yourself.
        if ($id === $this->auth->currentUserId()) {
            header('Location: /admin/users');
            exit;
        }

        $this->userRepository->deleteUser($id);

        $_SESSION['success'] =
            'User deleted successfully.';

        header('Location: /admin/users');
        exit;
    }

    /*
    |--------------------------------------------------------------------------
    | Media
    |--------------------------------------------------------------------------
    */

    public function media(): void
    {
         $this->auth->requireAdmin();

        $images = $this->imageRepository->all();

        $this->view(
            'admin/dashboard/media/index',
            [
                'title' => 'Media Library',
                'images' => $images,
                'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    public function uploadMedia(): void
    {
       
        $this->auth->requireAdmin();
        
        $this->view(
            'admin/dashboard/media/upload',
            [
                'title' => 'Upload Image',
                'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    public function storeMedia(): void
    {
        $this->auth->requireAdmin();

        $this->csrf->requireValidToken();

        if (!isset($_FILES['image'])) {
            $_SESSION['error'] =
                'Please select an image.';

            header('Location: /admin/media/upload');
            exit;
        }

        try {
            $this->imageRepository->upload(
                $_FILES['image']
            );

            $_SESSION['success'] =
                'Image uploaded successfully.';
        } catch (\Throwable $e) {
            $_SESSION['error'] =
                'Image upload failed.';
        }

        header('Location: /admin/media');
        exit;
    }

    public function viewMedia(): void
    {
         $this->auth->requireAdmin();

         $id = (int) ($_GET['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] =
                'Invalid image.';

            header('Location: /admin/media');
            exit;
        }

        $image = $this->imageRepository->findById($id);

        if (!$image) {
            $_SESSION['error'] =
                'Image not found.';

            header('Location: /admin/media');
            exit;
        }

        $this->view(
            'admin/dashboard/media/view',
            [
                'title' => 'View Media',
                'image' => $image,
                'csrfToken' => $this->csrf->token(),
            ],
            'admin'
        );
    }

    public function deleteMedia(): void
    {
       
        $this->auth->requireAdmin();
        
        $this->csrf->requireValidToken();

        $id = (int) ($_POST['id'] ?? 0);

        if ($id <= 0) {
            $_SESSION['error'] =
                'Invalid image.';

            header('Location: /admin/media');
            exit;
        }

        try {
            $this->imageRepository->delete($id);

            $_SESSION['success'] =
                'Image deleted successfully.';
        } catch (\Throwable $e) {
            $_SESSION['error'] =
                'Unable to delete image.';
        }

        header('Location: /admin/media');
        exit;
    }
}
