<?php

namespace app\controllers;

use app\core\App;
use app\core\base\Controller;
use app\models\Main;
use RedBeanPHP\R;

//use R;

class MainController extends Controller
{
    public $layout = 'main';

    public function indexAction()
    {
        $this->view = 'myIndexView';

//        $posts = App::$app->cache->get('posts');
//        dump($posts);
//        if(!$posts){
//            dump('non');
//            $posts = R::findAll('posts');
//            App::$app->cache->set('posts', $posts, 3600*24);
//        }
        $posts = R::findAll('posts');
        $title = 'MAIN page';
        $menu = R::findAll('category');
        $this->setMeta('Main Page', 'mydesc', 'mykeywords');
        $this->set(compact('title', 'posts', 'menu'));
//        dd($this->vars);

    }


    public function showAction(){
        $post = $this->app->main->findOne('posts', 1);
        App::$app->cache->set('post', $post);

//        $post = $model->findOne('posts', 1);
        $title = 'Показать одну запись - (showAction)';
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
//        $this->layout = false;

        if ($this->isAjax()){
            $model = new Main();
//            $data = [
//                'answer' => 'ответ с сервера',
//                'code' => 200
//            ];
//            echo json_encode($data);
            $post = R::findOne('posts', "id = {$_POST['id']}");
            $this->loadView('_test', compact('post'));
            exit;
        }
        echo '404';
    }


}