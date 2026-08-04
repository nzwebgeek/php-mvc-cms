<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\AdminRepository;
use App\Repositories\UserRepository;

class AdminController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly AdminRepository $adminRepository,
        private readonly UserRepository $userRepository
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
            'title' => 'Create User'
        ],
        'admin'
    );
    }

    public function storeUser(): void{
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
            'user' => $user
        ],
        'admin'
    );
    }

  public function updateUser(): void
{
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
        $_POST['username'],
        $_POST['email'],
        $roleId
    );


    $_SESSION['success'] = 'User updated successfully.';


    header('Location: /admin/users');
    exit;
    }

    public function deleteUser(): void{
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
}