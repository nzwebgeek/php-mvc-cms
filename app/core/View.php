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

        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        require "{$basePath}/layouts/{$layout}/header.php";

        echo $content;

        require "{$basePath}/layouts/{$layout}/footer.php";
    }
}