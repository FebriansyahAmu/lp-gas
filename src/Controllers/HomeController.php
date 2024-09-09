<?php

namespace App\Controllers;
use App\Controller;

class HomeController extends Controller
{
    public function index()
    {

        $this->render('/Home/index');
    }

    public function About()
    {

        $this->render('/About/index');
    }
}