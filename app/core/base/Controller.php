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
        $vObj->render($this->vars);
    }

    public function set($data)
    {
        $this->vars = $data;
    }

}