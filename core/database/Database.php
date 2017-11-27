<?php

namespace Core\Database;

class Database
{
    protected static $instance = null;
    final private function __construct() {}
    final private function __clone() {}

    public static function instance()
    {
        $config = require_once('../config/db.php');

        if (self::$instance === null)
        {
            $opt  = array(
                \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES   => TRUE,
                \PDO::ATTR_STATEMENT_CLASS    => array('\Core\Database\MyPDOStatment'),
            );
            $dsn = 'mysql:host=' . $config['host'] . ':' . $config['port'] . ';dbname=' . $config['db_name'] . ';charset=utf8';
            self::$instance = new \PDO($dsn, $config['db_user'], $config['db_pass'], $opt);
        }
        return self::$instance;
    }

    public static function __callStatic($method, $args) {
        return call_user_func_array(array(self::instance(), $method), $args);
    }
}