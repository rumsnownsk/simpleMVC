<?php

namespace app\core\base;

use app\core\Db;
use RedBeanPHP\R;

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $primaryKey = 'id';

    public function __construct()
    {
        $this->pdo = DB::instance();
    }

    /**
     * метод-обёртка над методом execute класса Db
     * @param $sql
     * @return bool
     */
    public function query($sql){
        return $this->pdo->execute($sql);
    }

    public function findAll(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }

    public function findOne($table, $id, $field = ''){
        $field = $field ? : $this->primaryKey;
        return R::findOne($table, "$field = ?",[$id]);
//        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
//        return $this->pdo->query($sql, [$id]);
    }

    public function findBySql($sql, $params = []){
        return $this->pdo->query($sql, $params);
    }

    public function findLike($str, $field, $table = ''){
        $table = $table ? : $this->table;
        $sql = "SELECT * FROM $table where $field LIKE ?";
        return $this->pdo->query($sql, ['%'. $str .'%']);
    }

}