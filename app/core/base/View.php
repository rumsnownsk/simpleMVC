<?php

namespace app\core\base;

class View
{
    /**
     * текущий маршрут и параметры (controller, action, params)
     * @var array
     */
    public $route = [];

    /**
     * текущий вид
     * @var string
     */
    public $view;

    /**
     * текущий шаблон
     * @var string
     */
    public $layout = 'default';

    public $scripts;

    public function __construct($route, $layout = '', $view = '')
    {
        $this->route = $route;

        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: $this->layout;
        }

        $this->view = $view;
    }

    public function render($data)
    {
        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";

        if (is_array($data)) {
            extract($data);
        }
//        dd($data);

        ob_start();

        if (file_exists($file_view)) {
            require $file_view;
        } else {
            dump("файл ВИДА <b>$file_view</b> - not found ");
        }

        $content = $this->getScript(ob_get_clean());


        if (false !== $this->layout) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";

            if (is_file($file_layout)) {
//                dd($content);
//                $scripts = [];
                if (!empty($this->scripts[0])){
                    $scripts = $this->scripts[0];
                }
                include $file_layout;

            } else {
                dump("файл ШАБЛОНА <b>{$file_layout}</b> - not found ");
            }
        }
    }

    protected function getScript($content){
        $pattern = "#<script.*?>.*?</script>#si";
        preg_match_all($pattern, $content, $this->scripts);
//        dd(!empty($this->scripts));
        if(!empty($this->scripts)){
            $content = preg_replace($pattern, '', $content);
        }
        return $content;
    }
}