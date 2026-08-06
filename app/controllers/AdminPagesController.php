<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\PageRepository;

class AdminPagesController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly PageRepository $pageRepository
    ) {
    }


    public function index(): void
    {
        $this->auth->requireAdmin();


       $pages = $this->pageRepository->adminAll();


        $this->view(
            'admin/dashboard/pages/index',
            [
                'title' => 'Manage Pages',
                'pages' => $pages
            ],
            'admin'
        );
    }

public function create(): void
{
    $this->auth->requireAdmin();


    $this->view(
        'admin/dashboard/pages/create',
        [
            'title' => 'Create Page'
        ],
        'admin'
    );
}


public function store(): void
{
    $this->auth->requireAdmin();


    $data = [

        'title' => trim($_POST['title'] ?? ''),

        'slug' => trim($_POST['slug'] ?? ''),

        'hero_title' => trim($_POST['hero_title'] ?? ''),

        'hero_subtitle' => trim($_POST['hero_subtitle'] ?? ''),

        'main_heading' => trim($_POST['main_heading'] ?? ''),

        'main_content' => trim($_POST['main_content'] ?? ''),

        'status' => $_POST['status'] ?? 'draft',

        'seo_title' => trim($_POST['seo_title'] ?? ''),

        'seo_description' => trim($_POST['seo_description'] ?? '')

    ];


    $this->pageRepository->create($data);


    header('Location: /admin/pages');

    exit;
}


public function edit(): void
{
    $this->auth->requireAdmin();

    echo "Edit Page";
}


public function update(): void
{
    $this->auth->requireAdmin();

    echo "Update Page";
}


public function delete(): void
{
    $this->auth->requireAdmin();

    echo "Delete Page";
}
}