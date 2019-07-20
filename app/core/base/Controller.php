<?php

namespace app\core\base;

use app\core\Registry;

abstract class Controller
{
    public $pathToView = [];

    /**
     * текущий маршрут и параметры (controller, action, params)
     * @var array
     */
    public $route = [];

    /**
     * вид
     * @var string
     */
    public $view;

    /**
     * текущий шаблон
     * @var string
     */
    public $layout;

    /**
     * данные для View
     * @var array
     */
    public $vars = array();

    public static $meta = array();

    public $app;


    public function __construct($route)
    {
        $this->route = $route;
        $this->view = $route['action'];
        $this->app = Registry::instance();
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
//        dd($this->vars);
        $vObj->render($this->vars);
    }

    public function set($data)
    {
        $this->vars = $data;
        $this->vars['meta'] = self::$meta;
    }

    public function setMeta($title='', $description='', $keywords=''){
        self::$meta['title'] = $title;
        self::$meta['description'] = $description;
        self::$meta['keywords'] = $keywords;
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function loadView($view, $vars = []){
        extract($vars);
        require APP."/views/{$this->route['controller']}/{$view}.php";
    }
}