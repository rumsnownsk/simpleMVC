<?php

namespace app\controllers;

use app\core\base\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
//        dd('test admin');
        $this->layout = "admin/defaultAdmin";
    }
}