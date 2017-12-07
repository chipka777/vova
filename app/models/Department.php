<?php

namespace App\Models;

class Department extends AModel
{
  protected  $tableName = 'departments';

  protected  $fillable = [
     'id', 'name', 'address', 'phone'
  ];

}