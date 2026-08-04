<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CategoryController extends Controller
{
    public function index()
    {
        $title = "Product Categories";
        $nav = [];

        $categories = Category::with('parent')->get();
        return view('admin.category.index', compact('title', 'nav', 'categories'));
    }

    public function add()
    {
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

        $par_categories = Category::whereNull('parent_id')->select('id', 'name')->get();

        return view('admin.category.form', compact('title', 'nav', 'par_categories'));
    }


    public function edit()
    {
        // 
    }

    public function save(Request $request, $id = null) {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'type'             => 'required|in:parent,child',
            'parent_category'  => 'required_if:type,child|nullable|exists:categories,id',
            'slug'             => 'required|string|max:255|unique:categories,slug' . ($id ? ",$id" : ''),
            'status'           => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try{
            $category = Category::updateOrCreate(
                ['id' => $id],
                [
                    'name'      => $validated['name'],
                    'parent_id' => $validated['type'] == 'parent' ? $validated['parent_category'] : null,
                    'slug'      => $validated['slug'],
                    'status'    => $validated['status'] == 'active' ? 1 : 0,
                ]
            );

            DB::commit();

            return redirect()->route('admin.categories.index')->with('success', 'Category saved successfully.');
        } catch (Throwable $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong, no changes were saved.')->withInput();
        }
    }
}
