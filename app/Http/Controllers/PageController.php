<?php

namespace App\Http\Controllers;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class PageController extends Controller
{
public function home()
    {
        return view('home');
    }

public function shop()
    {
        return view('shop');
    }

      public function categories()
    {
        return view('categories');
    }

      public function dailySale()
    {
        return view('daily-sale');
    }

     public function makers()
    {
        return view('makers');
    }

       public function help()
    {
        return view('help');
    }

       public function contact()
    {
        return view('contact');
    }
    
 public function sendContactForm(Request $request)
{
    $validated = $request->validate([
        'name'    => 'required|string|max:100',
        'email'   => 'required|email',
        'subject' => 'nullable|string|max:150',
        'message' => 'required|string|max:2000',
    ]);

    ContactMessage::create($validated);

    return back()->with('success', 'Thank you! Your message has been received.');
}

public function dashboard()
    {
        return view('dashboard');
    }

}


