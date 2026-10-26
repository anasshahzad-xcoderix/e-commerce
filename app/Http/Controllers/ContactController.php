<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:5',
        ]);

        // Abhi message sirf confirm hota hai. Database ya email baad mein add karenge.
        return back()->with('success', 'Shukriya ' . $data['name'] . '! Aap ka message mil gaya hai.');
    }
}