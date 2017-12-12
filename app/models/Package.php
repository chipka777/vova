<?php

namespace App\Models;

class Package extends AModel
{
  protected  $tableName = 'packages';

  protected  $fillable = [
     'id', 'title', 'dep_id', 'from_address', 'to_address', 'description', 'status'
  ];

}