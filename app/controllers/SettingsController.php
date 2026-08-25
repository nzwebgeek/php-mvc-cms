<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Services\CsrfService;
use App\Repositories\SettingsRepository;
use App\Repositories\BlogSettingsRepository;
use App\Repositories\ImageRepository;

class SettingsController extends Controller
{
    public function __construct(
        private readonly AuthService $auth,
        private readonly SettingsRepository $settingsRepository,
        private readonly BlogSettingsRepository $blogSettingsRepository,
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

        $settings = $this->settingsRepository->get();

        $blogSettings = $this->blogSettingsRepository->get();

        $images = $this->imageRepository->all();

        $this->view(
            'admin/dashboard/settings/index',
            [
                'title' => 'Settings',
                'settings' => $settings,
                'blogSettings' => $blogSettings,
                'images' => $images,
                'csrfToken' => $this->csrf->token()
            ],
            'admin'
        );
    }

    public function update(): void
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

        $siteName = trim(
            $_POST['site_name'] ?? ''
        );

        $contactEmail = trim(
            $_POST['contact_email'] ?? ''
        );

        $contactPhone = trim(
            $_POST['contact_phone'] ?? ''
        );

        $copyrightText = trim(
            $_POST['copyright_text'] ?? ''
        );

        $theme = trim(
            $_POST['theme'] ?? 'Light'
        );

        $maintenanceMode =
            isset($_POST['maintenance_mode'])
                ? 1
                : 0;

        $adminEmail = trim(
            $_POST['admin_email'] ?? ''
        );

        $seoTitle = trim(
            $_POST['seo_title'] ?? ''
        );

        $seoDescription = trim(
            $_POST['seo_description'] ?? ''
        );

        /*
         * Featured blog images
         */

        $featuredImage1Id =
            !empty($_POST['featured_image_1_id'])
                ? (int) $_POST['featured_image_1_id']
                : null;

        $featuredImage2Id =
            !empty($_POST['featured_image_2_id'])
                ? (int) $_POST['featured_image_2_id']
                : null;

        try {
            $this->settingsRepository->update(
                $siteName,
                $contactEmail,
                $contactPhone,
                $copyrightText,
                $theme,
                $maintenanceMode,
                $adminEmail,
                $seoTitle,
                $seoDescription,
                $featuredImage1Id,
                $featuredImage2Id
            );

            $_SESSION['success'] =
                'Settings saved successfully.';
        } catch (\Throwable $e) {
            $_SESSION['error'] =
                'Unable to save settings.';
        }

        header('Location: /admin/settings');
        exit;
    }
}
