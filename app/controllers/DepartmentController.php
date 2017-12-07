<?php

namespace App\Controllers;

use Core\AController;
use App\Models\User;
use App\Models\Department;
use Core\Auth;

class DepartmentController extends AController
{

    /**
     * render view
     */
    public function showCreate()
    {
        $page = 'department';
        
        return $this->render('admin/department/create', ['layout' => 'admin', 'page' => $page]);
    }
    
    public function addNew($request)
    {
        $dep = new Department;

        foreach ($request as $key => $field) {
            if (!$field ) {
                $this->flashMsg('error', '<strong>' . ucfirst($key) . '</strong>' . ' is required field.');
                return $this->redirect('/department/create', true);
            }
        }
        
        $dep->name = $request['name'];

        $dep->phone = $request['phone'];

        $dep->address = $request['address'];

        if ($dep->create()){
            $this->flashMsg('succ', 'The department was successfully created');
            return $this->redirect('/department/create');
        }

        $this->flashMsg('error', 'Something wrong with the database');
        return $this->redirect('/department/create', true);
    }

    public function showList()
    {
        $page = 'department';

        $deps = Department::all();


        return $this->render('admin/department/list', ['layout' => 'admin', 'page' => $page, 'deps' => $deps]);
    }

    public function edit($request)
    {

        $dep = Department::find($request['id']);

        foreach ($request as $key => $field) {
            if (!$field ) {
                $this->flashMsg('error', '<strong>' . ucfirst($key) . '</strong>' . ' is required field.');
                return $this->redirect('/department/list');
            }
        }

        $dep->name = $request['name'];

        $dep->phone = $request['phone'];

        $dep->address = $request['address'];

        if ($dep->update()){
            $this->flashMsg('succ', 'The department was successfully updated');
            return $this->redirect('/department/list');
        }

        $this->flashMsg('error', 'Something wrong with the database');
        return $this->redirect('/department/list');
    }

    public function delete($request)
    {
        $dep = Department::find($request['id']);

        if ($dep->destroy()){
            $this->flashMsg('succ', 'The department was successfully deleted');
            return $this->redirect('/department/list');
        }

        $this->flashMsg('error', 'Something wrong with the database');
        return $this->redirect('/department/list');
    }


}
