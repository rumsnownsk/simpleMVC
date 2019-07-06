<?php

namespace app\core;

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

                self::$route = $route;

                return true;
            }
        }
        return false;
    }

    /**
     * @param string $url входящий URL
     * @return void
     */
    public static function dispatch($url)
    {
        $url = self::removeQueryString($url);

        if (Router::matchRoute($url)) {

            $controller = 'app\controllers\\' . self::upperCamelCase(self::$route['controller']);

            if (class_exists($controller)) {
                $cObj = new $controller(self::$route);
                $action = self::$route['action'] . "Action";

                if (method_exists($cObj, $action)) {

                    $cObj->$action();
                    $cObj->getView();


                } else {
                    echo "Экшен: $action у контроллера $controller - не найден";
                }


            } else {
                echo "Контроллер $controller не найден";
            }


        } else {
            http_response_code(404);
            include '../views/errors/404.html';
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