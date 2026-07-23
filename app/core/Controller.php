<?php

abstract class Controller
{
    protected function view(string $file, array $data = [])
    {
        extract($data);

        require __DIR__ . "/../views/$file.php";
    }
}