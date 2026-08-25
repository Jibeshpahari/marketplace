<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //Product List
    public function index(Request $request){
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
        $products = Product::query()
            ->paginate($request->integer('per_page', 20));
        return view('admin.product.index', compact('title', 'nav', 'products'));

    }

    public function add() {
        $title = "Add Product";
        $nav = [
            [
                'url'  => route('admin.products.index'),
                'name' => 'Product Listing' 
            ],
            [
                'name' => $title
            ]
        ];

        $categories = Category::active()->get();
        return view('admin.product.form', compact('title', 'nav', 'categories'));
    }

}
