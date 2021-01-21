<?php
declare(strict_types=1);


namespace Devcompru\Interfaces;


interface RouterInterface
{
    public function addRoutes(array $routes): bool;
    public function addRoute(string $method, string $pattern, array $route): bool;

    public function getRoutes(): array;
    public function getRoute(): array;

    public function matchRoute(string $uri):array;




}