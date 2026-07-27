<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;

class PageController extends Controller
{
    public function __construct(
        private PageRepository $pages,
        private SettingsRepository $settings
    ) {
    }

    public function home(): void
    {
        $settings = $this->settings->get();

        $page = $this->pages->findBySlug('home');

        $this->view('pages/home', [
            'page' => $page,
            'settings' => $settings
        ]);
    }

    public function show(string $slug): void
    {
        $page = $this->pages->findBySlug($slug);

        if (!$page) {
            $this->view('errors/404');
            return;
        }

        $settings = $this->settings->get();

        $this->view('pages/page', [
            'page' => $page,
            'settings' => $settings
        ]);
    }
}