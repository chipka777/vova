<?php

namespace App\Models;

class User extends AModel
{
  protected  $tableName = 'users';

  protected  $fillable = [
     'id', 'name', 'email', 'password'
  ];

}