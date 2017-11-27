<?php

namespace Core\Database;

class MyPDOStatment extends \PDOStatement
{
    function execute($data = array())
    {
        parent::execute($data);
        return $this;
    }
}