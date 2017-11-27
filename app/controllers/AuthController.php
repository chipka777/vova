<?php

namespace App\Controllers;


use Core\AController;

class AuthController extends AController
{

    public function auth()
    {
        $this->render('auth');
    }

    public function authCheck($post)
    {
        $user = require_once (__DIR__ . '/../../config/user.php');
        $user = $user['auth'];

        if($user['login'] == trim(strtolower($post['login'])) && $user['password'] == trim(strtolower($post['password']))) {
            $_SESSION['login'] = $user['login'];
            header('Location: /');
        } else {
            header('Location: /auth');
        }
        exit;
    }

    public function logout()
    {
        unset($_SESSION['login']);
        session_destroy();

        header('Location: /auth');
        exit;
    }
}