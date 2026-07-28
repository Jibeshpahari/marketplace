<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        return view('admin.product.products', compact('title', 'nav'));

    }

    public function form($id = null)
    {
        $product = $id ? Product::findOrFail($id) : new Product();

        return view('admin.product.product-form', compact('product'));
    }

    public function save(Request $request, $id = null)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
            // ...
        ]);

        // $product = $id ? Product::findOrFail($id) : new Product();
        // $product->fill($data)->save();

        // return redirect()->route('products.index')
        //     ->with('success', $id ? 'Product updated.' : 'Product created.');
    }

}
