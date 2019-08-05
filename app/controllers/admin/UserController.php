<?php

namespace app\controllers\admin;


class UserConftroller extends AppController
{
    public function indexAction()
    {
        $this->view = 'admin/index';
    }

    public function testAction(){
        echo __METHOD__;
    }


}