<?php
declare(strict_types=1);


namespace Devcompru\Interfaces;


interface RouterInterface
{
    public static function addRoutes(array $routes): bool;
    public static function addRoute(string $method, string $pattern, array $route): bool;

    public static function getRoutes(): array;
    public static function getRoute(): array|bool;
    public static function getUri(): string;
    public static function getCurrentRoute(string $uri, array $route): bool;
    public static function getParams(): array;

}