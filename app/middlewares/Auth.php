<?php


namespace App\Middlewares;

use Core\Auth as AuthGuard;

use App\Models\User;

class Auth
{

    /**
     *  Check if the user is authorized
     */
    public function before()
    {
        if (!AuthGuard::user()) header('Location: login');
    }


}