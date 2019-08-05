<?php

namespace app\core;

use Exception;

class Router
{

    // Массив. В нем содержится массив всех возможных маршрутов
    protected static $routes = [

    ];

    protected static $route = [];       // Текущий маршрут, который запрашивается пользователем

    public static function addRoutes($regexp, $route = [])
    {
        self::$routes[$regexp] = $route;
    }

    public static function getRoutes()
    {
        return self::$routes;
    }

    public static function getRoute()
    {
        return self::$route;
    }

    private static function matchRoute($url)
    {
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {

                foreach ($matches as $k => $v) {
                    if (is_string($k)){
                        $route[$k] = $v;
                    }
                }

                if (!isset($route['action'])){
                    $route['action'] = 'index';
                }

                // prefix for admin controllers
                if (!isset($route['prefix'])){
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }

                self::$route = $route;

                return true;
            }
        }
        return false;
    }

    /**
     * @param string $url входящий URL
     * @return void
     * @throws Exception
     */
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);

        if (Router::matchRoute($url)) {

            $controller = 'app\controllers\\'.self::$route['prefix'] . self::upperCamelCase(self::$route['controller']);
            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::$route['action'] . "Action";

                if (method_exists($cObj, $action)) {

                    $cObj->$action();
                    $cObj->getView();

                } else {
                    throw new Exception("Метод $action у контроллера $controller - не найден", 404);
                }

            } else {
                throw new Exception("Контроллер $controller не найден", 404);
            }

        } else {
            throw new Exception("Страница не найдена", 404);
        };
    }

    protected static function upperCamelCase($name)
    {
        return ucwords($name) . "Controller";
    }

    protected static function removeQueryString($url){
        if ($url){
            $params = explode('?', $url, 2);
            if (false === strpos($params[0], '=')){
                return rtrim($params[0], '/');
            } else {
                return '';
            }
        } return $url;
    }

}