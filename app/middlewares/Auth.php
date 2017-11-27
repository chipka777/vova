<?php


namespace App\Middlewares;


class Auth
{

    /**
     *  Check if the user is authorized
     */
    public function before()
    {
        $user = require_once (__DIR__ . '/../../config/user.php');
        if(trim(strtolower($_SESSION['login']) != $user['auth']['login'])) {
            header('Location: /auth');
            exit;
        }
    }


}