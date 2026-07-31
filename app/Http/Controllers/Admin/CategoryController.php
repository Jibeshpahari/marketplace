<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $title = "Product Categories";
        $nav = [];

        $categories = Category::with('parent')->get();
        return view('admin.category.index', compact('title', 'nav', 'categories'));
    }

    public function add(){
        $title = "Add New Category";
        $nav = [
            [
                'name' => 'Dashboard',
                'url'  => route('admin.dashboard')
            ],
            [
                'name' => 'Category Listing',
                'url'  => route('admin.categories.index')
            ],
            [
                'name' => $title
            ]
        ];

        return view('admin.category.form', compact('title', 'nav'));
    }   
}
