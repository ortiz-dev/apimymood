<?php
namespace Core;

class Router
{
    private static $routes = [];

    public static function get(string $uri, $action){
        $uri = self::clearUri($uri);
        self::$routes['GET'][$uri] = $action; 
    }

    public static function post(string $uri, $action){
        $uri = self::clearUri($uri);
        self::$routes['POST'][$uri] = $action; 
    }

    public static function put(string $uri, $action){
        $uri = self::clearUri($uri);
        self::$routes['PUT'][$uri] = $action; 
    }

    public static function delete(string $uri, $action){
        $uri = self::clearUri($uri);
        self::$routes['DELETE'][$uri] = $action; 
    }

    private static function clearUri($uri)
    {
        $uri = trim($uri,'/');
        $uri = empty($uri) ? '/' : $uri;
        return $uri; 
    }

    public static function dispatch()
    {
        $request = new Request();
        $response = new Response();
        $uri = self::clearUri($request->uri());
        $method = $request->method();
        
        if(isset(self::$routes[$method])){
            foreach(self::$routes[$method] as $route => $action){
                $pattern = preg_replace('#\{\w+\}#','([^\/]+)',$route);
                if(preg_match("#^$pattern$#", $uri, $matches)){
                    array_shift($matches);
                    $controller = new $action[0]();
                    $controller->{$action[1]}(...$matches);
                }
            }
            $response->error('No encontrado');
        }
        
        $response->error('El método de la solicitud no está permitido', 405);
    }
}