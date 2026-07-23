<?php

class PageController extends Controller
{
    private Page $pageModel;

    public function __construct()
    {
        $this->pageModel = new Page();
    }

    public function home()
    {
        $pages = $this->pageModel->getAll();

        $this->view('home', [
            'pages' => $pages
        ]);
    }

    public function show(string $slug)
    {
        $page = $this->pageModel->getBySlug($slug);

        if (!$page) {
            die('404 Page Not Found');
        }

        $this->view('page', [
            'page' => $page
        ]);
    }
}