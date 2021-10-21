<?php
declare(strict_types=1);

namespace devcompru;


class Router
{

    const L_SEPARATOR = '<';
    const R_SEPARATOR = '>';

    private array $routes = [];
    private  array $route = [];
    private  array $params = [];

    public function __construct($routes)
    {
            if(is_array($routes))
                $this->parseFromArray($routes);
            $this->getUri();
            $this->parseRoute();
            unset($this->routes);
    }


    public function parseFromArray(array $array)
    {
        $this->addRoutes($array);
    }

    public function addRoutes($array)
    {
            foreach ($array as $route)
            {
                $this->routes[$route['method']][] = [
                    'pattern'=>$route['pattern'],
                    'controller'=>$route['controller'],
                    'action'=>$route['action'],
                ];


            }

    }

    public function getUri(): string
    {
        return isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI'])[0] : '/';
    }

    public function parseRoute(): array|bool
    {
        $uri = self::getUri();

        $method = $_SERVER['REQUEST_METHOD'] ??= 'GET';
        $match = false;

        if (isset($this->routes[$method]))
            foreach ($this->routes[$method] as $route) {

                if ($match = self::getCurrentRoute($uri, $route)) {

                    break;
                }
            }

        return $this->route;
    }
    public function getCurrentRoute(string $uri, array $route): bool
    {
        $pattern = $route['pattern'];
        $uri = trim($uri, '/');
        $preg_pattern = "/([\/])|([:])/";

        $result = preg_split($preg_pattern, str_replace(['<', '>'], ['|', ''], $pattern));

        $uri_pattern = [];
        $uri_params = [];
        $i = 0;
        foreach ($result as $key => $match) {

            if ($match[0] === '|') {
                $name = str_replace('|', '', $match);
                $uri_params[$name] = $i;;
            } elseif ($key >= 0 && prev($result) != '|') {
                $uri_pattern[] = $match;
                $i++;
            }
        }

        $search_pattern = '/^' . implode('\/', $uri_pattern) . '$/si';

        if (preg_match($search_pattern, $uri, $matches)) {

            $route['uri'] = $uri;
            $route['preg_pattern'] = $search_pattern;
            $params = explode('/', $uri);
            $this->params = $route['params'] = array_map(fn($el) => $params[$el], $uri_params);
            $this->route = $route;

            return true;

        }


        return false;
    }

    public function getParams():array|bool
    {
        return ($this->params)? $this->params : false;
    }
    public function getRoute():array|bool
    {
        return ($this->route)? $this->route : false;
    }

    public function __destruct()
    {
          //  MOX($this);
    }

}
