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
    $method = $_SERVER['REQUEST_METHOD'];

    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $uri = rtrim($uri, '/');

    if ($uri === '') {
        $uri = '/';
    }


    $route = $this->routes[$method][$uri] ?? null;


    if ($route === null) {

        $errorController = $this->container->get(
            \App\Controllers\ErrorController::class
        );

        $errorController->notFound();

        return;
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


    // Pass slug for dynamic pages
    if ($controllerMethod === 'show') {

        $slug = trim($uri, '/');

        $controller->$controllerMethod($slug);

        return;
    }

    $controller->$controllerMethod();
    }
}