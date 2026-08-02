<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected array $data = [];

    protected function view(
        string $view,
        array $data = [],
         string $layout = 'front'
    ): void {

        View::render($view, $data,$layout);
    }
}