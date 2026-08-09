<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\CsrfService;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;
use App\Repositories\ImageRepository;


class AdminController extends Controller
{
    public function __construct(
    private readonly AuthService $auth,
    private readonly AdminRepository $adminRepository,
    private readonly UserRepository $userRepository,
    private readonly ImageRepository $imageRepository,
    private readonly CsrfService $csrf
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
            'activity' => $activity
        ],
        'admin'
    );
    }

    public function users(): void {
        
    if (!$this->auth->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    if (!$this->auth->isAdmin()) {
        header('Location: /dashboard');
        exit;
    }


    $users = $this->userRepository->all();


    $this->view(
        'admin/dashboard/users/index',
        [
            'title' => 'Manage Users',
            'users' => $users
        ],
        'admin'
     );
    }

    public function createUser(): void{

    if (!$this->auth->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    if (!$this->auth->isAdmin()) {
        header('Location: /dashboard');
        exit;
    }


    $this->view(
        'admin/dashboard/users/create',
        [
            'title' => 'Create User',
            'csrfToken' => $this->csrf->token()
        ],
        'admin'
    );
    }

    public function storeUser(): void{
    
    $this->csrf->requireValidToken();
    
    if (!$this->auth->isAdmin()) {
        header('Location: /dashboard');
        exit;
    }

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'User';

    /*--------------Use Exists--------------------------*/
    if ($this->userRepository->usernameExists($username)) {

    $_SESSION['error'] = 'Username already exists. Please choose another.';

    header('Location: /admin/users/create');
    exit;
    }



    if ($this->userRepository->emailExists($email)) {

    $_SESSION['error'] = 'Email address already exists.';

    header('Location: /admin/users/create');
    exit;
    }
    /*--------------------------------------------------*/


    $roleId = $this->userRepository
        ->findRoleIdByName($role);


    $this->userRepository->createUser(
        $username,
        $email,
        password_hash(
            $password,
            PASSWORD_DEFAULT
        ),
        $roleId,
        ''
    );

    $_SESSION['success'] = 'User created successfully.';

    header('Location: /admin/users');

    exit;
    }

    public function editUser(): void{
    if (!$this->auth->isAdmin()) {
        header('Location: /dashboard');
        exit;
    }


    $id = (int)($_GET['id'] ?? 0);


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
            'csrfToken' => $this->csrf->token()
        ],
        'admin'
    );
    }

  public function updateUser(): void
{
    $this->csrf->requireValidToken();

    if (!$this->auth->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    if (!$this->auth->isSuperAdmin()) {
        header('Location: /admin/users');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);

    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'User';

    $roleId = $this->userRepository->findRoleIdByName($_POST['role']);

    $this->userRepository->updateUser(
        $id,
        $username,
        $email,
        $roleId
    );


    $_SESSION['success'] = 'User updated successfully.';


    header('Location: /admin/users');
    exit;
    }

    public function deleteUser(): void{

     $this->csrf->requireValidToken();

    if (!$this->auth->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    if (!$this->auth->isSuperAdmin()) {
        header('Location: /admin/users');
        exit;
    }

    $id = (int) ($_POST['id'] ?? 0);

    // Prevent deleting yourself
    if ($id === $this->auth->currentUserId()) {
        header('Location: /admin/users');
        exit;
    }

    $this->userRepository->deleteUser($id);

    $_SESSION['success'] = 'User deleted successfully.';

    header('Location: /admin/users');
    exit;
   
    }

    public function media(): void
{
    if (!$this->auth->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    if (!$this->auth->isAdmin()) {
        header('Location: /dashboard');
        exit;
    }

    $images = $this->imageRepository->all();

    $this->view(
        'admin/dashboard/media/index',
        [
            'title' => 'Media Library',
            'images' => $images,
            'csrfToken' => $this->csrf->token()
        ],
        'admin'
    );
}

public function uploadMedia(): void
{
    $this->csrf->requireValidToken();

    if (!$this->auth->isLoggedIn()) {
        header('Location: /login');
        exit;
    }

    if (!$this->auth->isAdmin()) {
        header('Location: /dashboard');
        exit;
    }

    if (
        !isset($_FILES['image']) ||
        $_FILES['image']['error'] !== UPLOAD_ERR_OK
    ) {
        $_SESSION['error'] = 'Please select a valid image.';
        header('Location: /admin/media');
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
public function createMedia(): void
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
        'admin/dashboard/media/upload',
        [
            'title' => 'Upload Image',
            'csrfToken' => $this->csrf->token()
        ],
        'admin'
    );
}

}