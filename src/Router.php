<?php
declare(strict_types=1);

namespace Devcompru;



class Router
{

    const L_SEPARATOR = '<';
    const R_SEPARATOR = '>';

    private static array $routes = [];
    private static array $route = [];
    private static array $params =[];

    public function __construct(){}
    public  function addRoutes(array $routes): bool
    {

        foreach ($routes as $route)
            self::addRoute($route['method'], $route['pattern'], $route['route']);

        return true;
    }

    public  function addRoute(string $method, string $pattern, array $route): bool
    {
        self::$routes[$method][] = [
            'pattern'=>$pattern,
            'route'=>$route
        ];

        return true;
    }
    public  function getRoutes(): array
    {
        return self::$routes;
    }
    public  function getRoute(): array|bool
    {
        $uri = self::getUri();
        $method = $_SERVER['REQUEST_METHOD'] ??='GET';
        $match = false;
        foreach (self::$routes[$method] as $route) {
            $match = self::getCurrentRoute($uri, $route);
            if($match)
                break;
        }

        return self::$route;
    }
    public  function getParams(): array
    {
        return self::$params;
    }

    public  function getUri(): string
    {
        return isset($_SERVER['REQUEST_URI'])?explode('?', $_SERVER['REQUEST_URI'])[0]:'/';
    }
    public  function getCurrentRoute(string $uri, array $route): bool
    {
        $pattern = $route['pattern'];
        $uri = trim ($uri, '/');
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

        $search_pattern = '/^'.implode('\/', $uri_pattern). '$/si';
        if(preg_match($search_pattern, $uri, $matches))
        {
            $route['uri'] = $uri;
            $route['preg_pattern'] = $search_pattern;
            $params= explode('/', $uri);
            self::$params = $route['params'] = array_map(fn($el)=>$params[$el], $uri_params);

            self::$route = $route;

           return  true;

        }


        return false;
    }

/**
 * TEST METHODS FOR PERFORMANCE
 */

    public  function getRoute2(): array|bool
    {
        $uri = self::getUri();
        $method = $_SERVER['REQUEST_METHOD'] ??='GET';
        $match = false;
        foreach (self::$routes as $route) {
            if($route['method'] === $method)
            $match = self::getCurrentRoute($uri, $route);
            if($match)
                break;
        }

        return self::$route;
    }
    public  function addRoutes2(array $routes): bool
    {

        self::$routes = $routes;

        return true;
    }
}