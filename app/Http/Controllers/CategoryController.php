<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        // this should be done using validation request
        $data['slug'] = Str::slug($data['name']);

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category has been added.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validateData($request, $category->id);
        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category has been updated.');
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