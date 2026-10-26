<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class StoreController extends Controller
{
    private function page(string $section, string $title)
    {
        $products = Product::with('category')->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('pages.section', compact('section', 'title', 'products', 'categories'));
    }

    public function shop()
    {
        return $this->page('shop', 'Shop');
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