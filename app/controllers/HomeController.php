<?php

namespace App\Controllers;

use Core\AController;
use App\Models\User;
use App\Models\Department;
use App\Models\Package;
use Core\Auth;

class HomeController extends AController
{

    /**
     * render view
     */
    public function index()
    {
        $page = 'dashboard';

        $pCount = Package::count();

        $dCount = Department::count();
        
        return $this->render('admin/index', ['layout' => 'admin', 'page' => $page, 'pCount' => $pCount, 'dCount' => $dCount]);
    }


}
