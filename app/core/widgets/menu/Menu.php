<?php

namespace app\core\widgets\menu;


use App\core\libs\Cache;
use RedBeanPHP\R;

class Menu
{
    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;        // путь к шаблону, который нужен для построения html-кода меню
    protected $container = 'ul';
    protected $class = 'menu';
    protected $table = 'categories';
    protected $cache = 3600;    // Время кэширования меню
    protected $cacheKey = 'mvc_menu';

    public function __construct($options = [])
    {
        $this->tpl = __DIR__ . '/menu_tpl/menu.php';
//        $this->table = $table;
        $this->getOptions($options);
        $this->run();
    }

    protected function output()
    {
        echo "<{$this->container} class={$this->class}>";
        echo $this->menuHtml;
        echo "</{$this->container}>";

    }

    protected function run()
    {
        $cache = new Cache();
        $this->menuHtml = $cache->get($this->cacheKey);
        if (!$this->menuHtml){
            $this->data = R::getAssoc("SELECT * FROM {$this->table}");
            $this->tree = $this->getTree();

            $this->menuHtml = $this->getMenuHtml($this->tree);
            $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
        }

        $this->output();
    }

    protected function getOptions($options)
    {
        foreach ($options as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    protected function getTree()
    {
        $tree = array();
        $data = $this->data;

        foreach ($data as $id => &$node) {
            if (!$node['parent']) {
                $tree[$id] = &$node;
            } else {
                $data[$node['parent']]['childs'][$id] = &$node;
            }
        }
//        dd($tree);
        return $tree;
    }

    protected function getMenuHtml($tree, $tab = '')
    {
        $str = '';
        foreach ($tree as $id => $category) {
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab, $id)
    {
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }

    public function timeCache($time)
    {
        $this->cache = $time;
    }

}