<?php
declare(strict_types=1);

namespace Devcompru;

use Devcompru\Interfaces\RouterInterface;

class Router implements RouterInterface
{
    const L_SEPARATOR = '<';
    const R_SEPARATOR = '>';

    private static array $routes = [];
    private static array $route = [];
    private static array $params;

    private function __construct(){}
    public static function addRoutes(array $routes, bool $clean=false): bool
    {

        $uri = self::getUri();

        $match = false;

        foreach ($routes as $route) {
         self::addRoute($route['method'], $route['pattern'], $route['route']);
            $match = self::getCurrentRoute($uri, $route);
            if($match)
                break;
        }

        return true;
    }

    public static function addRoute(string $method, string $pattern, array $route): bool
    {
        self::$routes[$method][] = [
            'pattern'=>$pattern,
            'route'=>$route
        ];

        return true;
    }

    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function getRoute(): array|bool
    {
        return self::$route;
    }

    public static function matchRoute(string $uri): array
    {
        // TODO: Implement matchRoute() method.
    }
    public static function getUri(): string
    {
        return isset($_SERVER['REQUEST_URI'])?explode('?', $_SERVER['REQUEST_URI'])[0]:'/';
    }
    public static function getCurrentRoute(string $uri, array $route): array|bool
    {
        $pattern = $route['pattern'];

        $preg_pattern = "/([\/])|([:])/";

        $result = preg_split($preg_pattern, $pattern);
        $uri_pattern = [];
        $uri_params = [];
        foreach ($result as $key=>$match)
        {
            if($match[0]!==self::L_SEPARATOR)
            {
                $uri_pattern[] = rtrim($match, self::R_SEPARATOR);
            }
            else
            {
                $uri_params[trim($match, self::L_SEPARATOR)] = $key;
            }
        }

        $search_pattern = '/\/'.implode('\/', $uri_pattern). '/si';
        if($data = preg_match($search_pattern, $uri, $matches))
        {
            print_r(['search'=>$search_pattern, 'uri'=>$uri, 'match'=>$matches]);
            echo "<hr>";
            exit;

        }


        echo "<pre>";
       // print_r($data);
        return false;
    }




}