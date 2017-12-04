<?php

namespace App\Controllers;

use Core\AController;
use App\Models\User;
use Core\Auth;

class HomeController extends AController
{

    /**
     * render view
     */
    public function index()
    {
        $page = 'dashboard';


        /*$user = new User;
        $user->password = password_hash("admin", PASSWORD_DEFAULT);
        $user->name = "Admin";
        $user->email = "Admin@gmail.com";
        

        $user->din();*/
 
       
        return $this->render('admin/index', ['layout' => 'admin', 'page' => $page]);
    }


}
