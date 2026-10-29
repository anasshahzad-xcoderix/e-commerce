<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
class StoreController extends Controller
{   
    private function page(string $section, string $title)
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('pages.section', compact('section', 'title', 'products', 'categories'));
    }
public function shop(Request $request)
{
    $categories = Category::orderBy('name')->get();

    $products = Product::with('category')
        ->when($request->filled('cat'), function ($q) use ($request) {
            $q->whereHas('category', fn ($c) => $c->where('slug', $request->cat));
        })
        ->when($request->filled('q'), fn ($q) => $q->where('name', 'like', '%' . $request->q . '%'))
        ->when($request->sort === 'low', fn ($q) => $q->orderBy('price'))
        ->when($request->sort === 'high', fn ($q) => $q->orderByDesc('price'))
        ->when(!in_array($request->sort, ['low', 'high']), fn ($q) => $q->latest())
        ->get();

    return view('pages.section', [
        'section'    => 'shop',
        'title'      => 'Shop',
        'products'   => $products,
        'categories' => $categories,
    ]);
}

    public function categories()
    {
        return $this->page('categories', 'Categories');
    }

    public function dailySale()
    {
        return $this->page('daily-sale', 'Daily sale');
    }

    public function makers()
    {
        return $this->page('makers', 'Makers');
    }

    public function help()
    {
        return $this->page('faq', 'Help');
    }

    public function contact()

    {
        return $this->page('contact', 'Contact');
    }
}

