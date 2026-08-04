<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\RoleRepository;


class RoleController extends Controller
{

    public function __construct(
        private readonly AuthService $auth,
        private readonly RoleRepository $roleRepository
    ) {
    }



    public function index(): void
    {

        /*Does both isLoggedIn and is Super Admin*/
        $this->checkAccess();

        $roles = $this->roleRepository->all();



        $this->view(
            'admin/dashboard/roles/index',
            [
                'title' => 'Manage Roles',
                'roles' => $roles
            ],
            'admin'
        );

    }

    public function create(): void
{

    $this->view(
        'admin/dashboard/roles/create',
        [
            'title' => 'Create Role'
        ],
        'admin'
    );

}



public function store(): void
{

    $name = trim($_POST['name']);
    $description = trim($_POST['description']);


    if ($this->roleRepository->exists($name)) {

        $_SESSION['error'] =
        'Role already exists.';

        header('Location: /admin/roles/create');
        exit;

    }


    $this->roleRepository->create(
        $name,
        $description
    );

    $_SESSION['success'] = 'Role created successfully.';


    header('Location: /admin/roles');
    exit;

}



public function edit(): void
{

    $id = (int)($_GET['id'] ?? 0);


    $role = $this->roleRepository->findById($id);


    if (!$role) {

        header('Location: /admin/roles');
        exit;

    }


    $this->view(
        'admin/dashboard/roles/edit',
        [
            'title' => 'Edit Role',
            'role' => $role
        ],
        'admin'
    );

}

public function update(): void
{

    $id = (int)$_POST['id'];


   $this->roleRepository->update(
    $id,
    trim($_POST['name']),
    trim($_POST['description'])
    );


    $_SESSION['success'] = 'Role updated successfully.';


    header('Location: /admin/roles');
    exit;

}



public function delete(): void
{

    $id = (int)$_POST['id'];


    if ($this->roleRepository->isSystemRole($id)) {

        $_SESSION['error'] =
        'This is a system role and cannot be deleted.';

        header('Location: /admin/roles');
        exit;
    }



    $users = $this->roleRepository
        ->usersUsingRole($id);



    if ($users > 0) {

        $_SESSION['error'] =
        'Cannot delete role. Users are assigned to this role.';

        header('Location: /admin/roles');
        exit;

    }



    $this->roleRepository->delete($id);


    $_SESSION['success'] =
    'Role deleted successfully.';


    header('Location: /admin/roles');
    exit;

}

 private function checkAccess(): void
    {

        if (!$this->auth->isLoggedIn()) {

            header('Location: /login');
            exit;

        }


        if (!$this->auth->isSuperAdmin()) {

            header('Location: /admin');
            exit;

        }

    }


}