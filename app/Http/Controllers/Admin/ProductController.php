<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Product List
    public function index(){
        $title = "Product List";
        $nav = [
            [
                'url' => route('admin.login.view'),
                'name' => 'Dashboard'
            ],
            [
                'name' => $title
            ]
        ];
        return view('admin.product.index', compact('title', 'nav'));

    }  

}
