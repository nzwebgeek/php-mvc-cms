<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class View
{
    public static function render(
        string $view,
        array $data = [],
        string $layout = 'front'
    ): void {

        $basePath = dirname(__DIR__) . '/Views';

        $viewPath = "{$basePath}/{$view}.php";



        if (!file_exists($viewPath)) {
            throw new RuntimeException("View '{$view}' not found.");
        }

        extract($data, EXTR_SKIP);

        if (!isset($data['csrfToken'])) {

            $csrfService = new \App\Services\CsrfService();

            $csrfToken = $csrfService->token();
        }


        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        // Determine which layout folder to use
    if ($layout === 'admin') {
        $layoutPath = "{$basePath}/admin/layout";
    } else {
        $layoutPath = "{$basePath}/layouts/{$layout}";
    }

    // Header
    require "{$layoutPath}/header.php";

    // Optional sidebar (only loaded if it exists)
    if (file_exists("{$layoutPath}/sidebar.php")) {
        require "{$layoutPath}/sidebar.php";
    }

    // Main page content
    echo $content;

    // Footer
    require "{$layoutPath}/footer.php";
        }
}