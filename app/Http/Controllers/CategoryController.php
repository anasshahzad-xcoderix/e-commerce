<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

   public function store(StoreCategoryRequest $request)
{
    $data = $request->validated();
    $data['slug'] = Str::slug($data['name']);

    Category::create($data);

    return redirect()->route('admin.categories.index')->with('success', 'Collection add ho gaya.');
}

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

   public function update(UpdateCategoryRequest $request, Category $category)
{
    $data = $request->validated();
    $data['slug'] = Str::slug($data['name']);

    $category->update($data);

    return redirect()->route('admin.categories.index')->with('success', 'Collection update ho gaya.');
}

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'products already in the category. first deleted.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Collection has been deleted.');
    }

    private function validateData(Request $request, $id = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:500',
        ]);
    }
}