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
}
