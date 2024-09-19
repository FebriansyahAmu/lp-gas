<?php

namespace App\Controllers;
use App\Controller;

class AdminController extends Controller
{

    public function dashboard()
    {
        $data = [];
         $this->render('Dashboard/index', ['title' => 'Dashboard'], 'Layout/dashLayout');
    }

    


}