<?php
declare(strict_types=1);

namespace Devcompru;

use Devcompru\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    private static array $routes = [];
    private static array $route;

    private function __construct(){}
    public static function addRoutes(array $routes): bool
    {
        self::$routes[] = $routes;
        return true;
    }

    public static function addRoute(string $method, string $pattern, array $route): bool
    {
        // TODO: Implement addRoute() method.
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array
    {
        // TODO: Implement getRoute() method.
    }

    public static function matchRoute(string $uri): array
    {
        // TODO: Implement matchRoute() method.
    }
}