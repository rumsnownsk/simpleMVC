<?php

use app\core\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);


$query = trim($_SERVER['REQUEST_URI'], '/');

define('WWW', __DIR__);                                 // /var/www/simplemvc.ru/public
define('CORE', dirname(__DIR__).'/vendor/core');   // "/var/www/simplemvc.ru/vendor/core"
define('ROOT', dirname(__DIR__));                  // "/var/www/simplemvc.ru"
define('APP', dirname(__DIR__).'/app');            // "/var/www/simplemvc.ru/app"

require_once "../vendor/autoload.php";

spl_autoload_register(function ($class){
    $file = ROOT.'/'. str_replace('\\', '/', $class).'.php';

    if (is_file($file)){
        require_once $file;
    }
});


Router::addRoutes('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller'=> 'page']);
Router::addRoutes('^page/(?P<alias>[a-z-]+)$', ['controller'=> 'page', 'action' => 'view']);

Router::addRoutes('^$', ['controller'=> 'main', 'action'=>'index']);
Router::addRoutes('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');


Router::dispatch($query);
