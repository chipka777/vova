<?php

namespace App\Controllers;


use Core\AController;
use Core\Auth;
use App\Models\User;
use App\Models\Package;
use App\Models\Department;

class MainController extends AController
{

    public function index()
    {
        $packs = Package::all();

        foreach ($packs as $pack) {
            $pack->dep_name = Department::where('id', '=', $pack->dep_id)->first()->name;
        }

        $this->render('index', ['layout' => 'main', 'packs' => $packs]);
    }

}