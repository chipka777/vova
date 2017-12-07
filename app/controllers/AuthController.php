<?php

namespace App\Controllers;


use Core\AController;
use Core\Auth;
use App\Models\User;

class AuthController extends AController
{

    public function show()
    {
        if (Auth::user()) return $this->redirect('/');

        $this->render('login', ['layout' => 'auth']);
    }

    public function login($request)
    {
    
       $user = User::where('email', '=' , $request['email'])->first();

       if (password_verify($request['password'], $user->password)) {
           Auth::user($user);
           return $this->redirect('/');
       } else {
           
           $this->flashMsg('error', 'User with such data does not exist');
           return $this->redirect('login');
       }
    }


    public function logout()
    {
        Auth::logout();

        return $this->redirect('login');
    }
    


}