<?php

namespace app\controllers\admin;

use app\core\base\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        echo __METHOD__;
//        $this->layout = "admin/defaultAdmin";
    }
}