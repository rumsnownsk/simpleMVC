<?php

namespace app\controllers;

use app\core\base\Controller;

class PageController extends Controller
{

    public function indexAction(){
        echo "это Экшен - <b style='color: forestgreen;'>indexAction</b> у контроллера PageController";
    }

    public function viewAction()
    {
        echo __CLASS__."/ghjf:".__METHOD__;
    }

}