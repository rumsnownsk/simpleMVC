<?php

namespace app\core;

use PDO;
use R;

class Db
{
    use TSingleton;

    protected $pdo;
    public static $countSql = 0;
    protected static $queries = [];

    protected function __construct(){

    }

}