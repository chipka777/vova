<?php

namespace Core;

class Auth
{

    private static  $instance;

    public $user;

    private function __construct()
    {
        $this::$instance = $this;
    }

    public function userAuth($user = null)
    {
        if ($user != null) $this->user = $user[0];

        return $this->user;
    }

    public static function __callStatic ( string $name , array $arguments )
    {
        $class = __CLASS__;

        if (empty($class::$instance)) $obj = new $class; 

        $name .= "Auth";

        return $class::$instance->$name($arguments);
    }

}