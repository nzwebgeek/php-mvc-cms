<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use App\Services\CsrfService;

class ErrorController extends Controller
{
    public function __construct(
        private PageRepository $pages,
        private SettingsRepository $settings,
        private CsrfService $csrf
    ) {
    }

    public function notFound(): void
    {
        http_response_code(404);

        $this->view('errors/404', [
            'pages' => $this->pages->getAll(),
            'settings' => $this->settings->get(),
            'csrfToken' => $this->csrf->token(),
        ]);
    }
}