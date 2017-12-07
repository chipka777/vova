<?php

namespace App\Models;

class Package extends AModel
{
  protected  $tableName = 'packages';

  protected  $fillable = [
     'id', 'title', 'from_address', 'to_address', 'description'
  ];

}