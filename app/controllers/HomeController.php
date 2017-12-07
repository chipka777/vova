<?php

namespace App\Controllers;

use Core\AController;
use App\Models\User;
use App\Models\Department;
use Core\Auth;

class HomeController extends AController
{

    /**
     * render view
     */
    public function index()
    {
        $page = 'dashboard';
        
        
        return $this->render('admin/index', ['layout' => 'admin', 'page' => $page]);
    }


}
