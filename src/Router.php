<?php
declare(strict_types=1);

namespace Devcompru;

use Devcompru\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    private array $routes = [];
    private array $route;

    public function addRoutes(array $routes): bool
    {
        // TODO: Implement addRoutes() method.
    }

    public function addRoute(string $method, string $pattern, array $route): bool
    {
        // TODO: Implement addRoute() method.
    }

    public function getRoutes(): array
    {
        // TODO: Implement getRoutes() method.
    }

    public function getRoute(): array
    {
        // TODO: Implement getRoute() method.
    }

    public function matchRoute(string $uri): array
    {
        // TODO: Implement matchRoute() method.
    }
}