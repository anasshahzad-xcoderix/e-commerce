<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $g = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $g->getEmail()],
            [
                'name'      => $g->getName(),
                'google_id' => $g->getId(),
                'avatar'    => $g->getAvatar(),
            ]
        );

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}