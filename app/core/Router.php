<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];


    public function __construct(
        private Container $container
    ) {
    }


    public function get(
        string $route,
        array $action
    ): void {

        $this->routes['GET'][$route] = $action;
    }


    public function post(
        string $route,
        array $action
    ): void {

        $this->routes['POST'][$route] = $action;
    }


    public function dispatch(): void
    {
        $page = $_GET['page'] ?? 'home';

        $method = $_SERVER['REQUEST_METHOD'];


        $route = $this->routes[$method][$page] ?? null;


        if (!$route) {
            throw new RuntimeException(
                'Route not found.'
            );
        }


        [
            $controllerClass,
            $controllerMethod
        ] = $route;


        $controller = $this->container->get(
            $controllerClass
        );


        if (!method_exists(
            $controller,
            $controllerMethod
        )) {

            throw new RuntimeException(
                'Controller method not found.'
            );
        }


        $controller->$controllerMethod();
    }
}