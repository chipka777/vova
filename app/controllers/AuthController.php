<?php

namespace App\Controllers;


use Core\AController;
use Core\Auth;
use App\Models\User;

class AuthController extends AController
{

    public function show()
    {
        $this->render('login', ['layout' => 'auth']);
    }

    public function login($request)
    {
       $user = User::where('email', '=' , $request['email'])->first();

       
       if (password_verify($request['password'], $user->password)) {
           Auth::user($user);
           var_dump(Auth::user()->name);
       } else {
           echo "no login";
       }
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