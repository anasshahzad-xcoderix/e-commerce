<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('home', compact('products', 'categories'));
    }
}