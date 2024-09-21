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

    public function indexGas(){
        $data = [];
        $this->render('Admin-lgas/index', $data, 'Layout/dashLayout');
    }
}