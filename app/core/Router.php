<?php

class Router
{
    public function route()
    {
        $controller = new PageController();

        $slug = $_GET['page'] ?? 'home';

        if ($slug === 'home') {
            $controller->home();
        } else {
            $controller->show($slug);
        }
    }
}