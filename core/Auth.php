<?php

namespace Core;

class Auth
{

    private static  $instance;

    public $user = null;

    private function __construct()
    {
        $this::$instance = $this;
    }

    public function userAuth($user = null)
    {
        if ($user != null) {
            $this->user = $user[0];

            $_SESSION['user'] = [
                'name' => $this->user->name,
                'id'   => $this->user->id
            ];
        }

        return $this->user;
    }

    public function logoutAuth()
    {
        $this->user = null;

        unset($_SESSION['user']);
    }

    public static function __callStatic ( $name ,  $arguments )
    {
        $class = __CLASS__;

        if (empty($class::$instance)) $obj = new $class; 

        $name .= "Auth";

        return $class::$instance->$name($arguments);
    }

}