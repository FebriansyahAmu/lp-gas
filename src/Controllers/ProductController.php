<?php

namespace App\Controllers;
use App\Controller;

class ProductController extends Controller
{

    public function product($id)
    {
        $product = ProductModel::find($id);
        $this->render('/Product/index');
    }

}