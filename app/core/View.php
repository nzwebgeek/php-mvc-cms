<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class View
{
    public static function render(
        string $view,
        array $data = []
    ): void {

        $path = dirname(__DIR__) . "/views/{$view}.php";

        if (!file_exists($path)) {
            throw new RuntimeException(
                "View '{$view}' not found."
            );
        }

        extract($data, EXTR_SKIP);

        require $path;
    }
}