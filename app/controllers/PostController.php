<?php

namespace app\controllers;

use app\core\base\Controller;

class PostController extends Controller
{

    public function indexAction()
    {
//        $this->getView();
        echo 'PostController::index()';
    }

    public function testAction()
    {
//        echo $this->view;
    }

    public function testPageAction()
    {
        echo 'PostController::testPage()';
    }

    public function before()
    {

    }
}