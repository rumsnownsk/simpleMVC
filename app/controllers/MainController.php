<?php

namespace app\controllers;

use app\core\base\Controller;
use app\models\Main;

class MainController extends Controller
{
    public $layout = 'main';

    public function indexAction()
    {
        $model = new Main();
        $posts = $model->findAll();

        $title = 'PAGE TITLE';
        $this->set(compact('title', 'posts'));

        $this->view = 'myIndexView';
    }


    public function showAction(){
        $model = new Main();
        $post = $model->findOne(2);
        dd($post);
        $this->set(compact('title','post'));
    }

    public function testSqlAction(){
        $this->layout = false;
        $model = new Main;
        $sql = "SELECT * FROM {$model->table} ORDER BY id DESC";
        $res = $model->findBySql($sql);
        dump($res);
    }

    public function findLikeAction(){
        $this->layout = false;
        $model = new Main();
        $res = $model->findLike('asd', 'text', 'posts');
        dump($res);
    }

    public function testAction()
    {
        $this->layout = 'default';

        $name = 'MAX';
        $this->set([
            'name' => $name,
            'car' => 'toyota'
        ]);

        echo "это экшн - <b style='color: forestgreen;'>testAction</b> у контроллера MainController";
    }

    public function ajaxAction()
    {
        echo 1234123;
        $this->layout = false;
    }


}