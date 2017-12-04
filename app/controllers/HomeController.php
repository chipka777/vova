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
        $user = User::find(1);

        $user->name = "Admin";
        
        $user->update();

        /*$user = new User;
        $user->password = password_hash("admin", PASSWORD_DEFAULT);
        $user->name = "Admin";
        $user->email = "Admin@gmail.com";
        

        $user->din();*/
 
       
        return $this->render('admin/index', ['layout' => 'admin']);
    }


}
