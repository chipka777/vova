<?php

namespace App\Controllers;

use Core\AController;


class HomeController extends AController
{

    /**
     * render view
     */
    public function index()
    {
        echo "qweqw";
        $this->render('index');
    }


}
