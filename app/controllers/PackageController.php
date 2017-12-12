<?php

namespace App\Controllers;

use Core\AController;
use App\Models\User;
use App\Models\Package;
use App\Models\Department;
use Core\Auth;

class PackageController extends AController
{

    /**
     * render view
     */
    public function index($request)
    {
        $dep_id = 'all';

        $page = 'package';


        if ($request['dep'] != 0) {
            $dep_id = $request['dep'];

            $packs = Package::where('dep_id', '=', $dep_id)->get(\PDO::FETCH_OBJ);
        }


        if (empty($packs)) $packs = Package::all();

        $deps = Department::all();

        foreach ($packs as $pack) {
            $pack->dep_name = Department::where('id', '=', $pack->dep_id)->first()->name;
        }
        
        return $this->render('admin/package/index', ['layout' => 'admin', 'page' => $page, 'packs' => $packs, 'deps' => $deps]);
    }

    public function addNew($request)
    {
        $pack = new Package;

        foreach ($request as $key => $field) {
            if (!$field ) {
                echo json_encode('<strong>' . ucfirst($key) . '</strong>' . ' is required field.');
                return false;
            }

        }

        $pack->dep_id = $request['dep_id'];

        $pack->title = $request['title'];

        $pack->from_address = $request['from'];

        $pack->to_address = $request['to'];

        $pack->description = $request['description'];



        if ($pack->create()) {
            echo 1;
            return 1;
        }

        echo json_encode('<strong> Error! </strong> Some problems with database');
        return 1;

    }

    public function changeStatus($request)
    {
        $pack = Package::find($request['id']);

        var_dump($pack);

        $pack->status = $request['status'];

        return $pack->update();
    }

    public function edit($request)
    {
        $pack = Package::find($request['id']);

        foreach ($request as $key => $field) {
            if (!$field ) {
                $this->flashMsg('error', '<strong>' . ucfirst(substr($key, 0, -2)) . '</strong>' . ' is required field.');
                return $this->redirect('/packages');
            }
        }


        $pack->dep_id = $request['dep_id-e'];

        $pack->title = $request['title-e'];

        $pack->from_address = $request['from-e'];

        $pack->to_address = $request['to-e'];

        $pack->description = $request['description-e'];

        if ($pack->update()){
            $this->flashMsg('succ', 'The package was successfully updated');
            return $this->redirect('/packages');
        }

        $this->flashMsg('error', 'Something wrong with the database');
        return $this->redirect('/packages');


    }

    public function delete($request)
    {
        $pack= Package::find($request['id']);

        if ($pack->destroy()){
            $this->flashMsg('succ', 'The package was successfully deleted');
            return $this->redirect('/packages');
        }

        $this->flashMsg('error', 'Something wrong with the database');
        return $this->redirect('/packages');
    }

}
