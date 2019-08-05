<?php
/**
 * Created by PhpStorm.
 * User: rum
 * Date: 27.07.19
 * Time: 15:47
 */

namespace app\controllers\admin;

use app\core\base\Controller;

class AppController extends Controller
{
    public $layout = 'admin';

    public function __construct($route)
    {
        parent::__construct($route);
    }

}