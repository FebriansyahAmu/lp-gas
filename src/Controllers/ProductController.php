<?php

namespace App\Controllers;
use App\Controller;

class ProductController extends Controller
{

    public function product()
    {
        $data = [];
        $this->render('/Product/index', $data, null);
    }

}