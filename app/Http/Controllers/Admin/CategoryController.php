<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Throwable;


// TODO - Check access authority before action
// TODO - DELECT ACTION IS ON PENDING
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Product Categories';
        $nav = [];

        $categories = Category::with('parent', 'children')
            ->when($request?->start_date, fn($query, $date) => $query->where('created_at', '>=', $date))
            ->when($request?->end_date, fn($query, $date) => $query->where('created_at', '<=', $date))
            ->when( true, fn($query) => match ($request?->date_sort) {
                    'date_asc'  => $query->orderBy('updated_at'),
                    'date_desc' => $query->orderByDesc('updated_at'),
                    'name_asc'  => $query->orderBy('name'),
                    'name_desc' => $query->orderByDesc('name'),
                    default     => $query->orderByDesc('updated_at'),
                }
            )
            ->paginate($request->integer('per_page', 20));

            // dd($categories);
        return view('admin.category.index', compact('title', 'nav', 'categories'));
    }

    public function add()
    {
        $title = 'Add New Category';
        $nav = [
            [
                'name' => 'Dashboard',
                'url' => route('admin.dashboard'),
            ],
            [
                'name' => 'Category Listing',
                'url' => route('admin.categories.index'),
            ],
            [
                'name' => $title,
            ],
        ];

        $par_categories = Category::whereNull('parent_id')->select('id', 'name')->get();
        $category = new Category;

        return view('admin.category.form', compact('title', 'nav', 'par_categories', 'category'));
    }

    public function edit(Category $category)
    {
        $title = "Edit '{$category->name}' Category";
        $nav = [
            [
                'name' => 'Dashboard',
                'url' => route('admin.dashboard'),
            ],
            [
                'name' => 'Category Listing',
                'url' => route('admin.categories.index'),
            ],
            [
                'name' => $title,
            ],
        ];

        $par_categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->select('id', 'name')->get();

        return view('admin.category.form', compact('title', 'nav', 'par_categories', 'category'));
    }

    public function save(Request $request, ?Category $category = null)
    {

        // dd($category);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:parent,child',
            'parent_category' => 'required_if:type,child|nullable|exists:categories,id',
            'slug' => ['required', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category?->id),],
            'status' => 'required|in:active,inactive',
        ]);

        DB::beginTransaction();

        try {
            $category = Category::updateOrCreate(
                ['id' => $category?->id],
                [
                    'name' => $validated['name'],
                    'parent_id' => $validated['type'] == 'child' ? $validated['parent_category'] : null,
                    'slug' => $validated['slug'],
                    'is_active' => $validated['status'] == 'active' ? 1 : 0,
                ]
            );

            DB::commit();

            return redirect()->back()->with('success', 'Category saved successfully.');
        } catch (Throwable $e) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong, no changes were saved.')->withInput();
        }
    }

    public function toggleStatus(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|exists:categories,slug',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();

        try {
            $category = Category::where('slug', $validated['slug'])->firstOrFail();

            $category->update([
                'is_active' => $validated['status'],
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => "Category {$category->name} status updated to " . ($validated['status'] ? 'Active' : 'Inactive') . '.' ]);

        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update category status.'], 422);
        }
    }

    public function subcategories(Category $category)
    {
        $subcategories = $category->children()->get(['name', 'slug', 'is_active']);

        return response()->json([
            'subcategories' => $subcategories,
        ]);
    }

    public function delete(Category $category)
    {
        DB::beginTransaction();

        try {
            $category->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Category deleted successfully.');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong, category could not be deleted.');
        }
    }










}
