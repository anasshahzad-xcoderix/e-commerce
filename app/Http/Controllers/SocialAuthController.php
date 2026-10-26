<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function showLogin()
    {           
        return view('auth.login');
    }

    public function redirect()
    {
        return Socialite::driver('github')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::firstOrCreate(
            ['email' => $githubUser->getEmail()],
            [
                'name'     => $githubUser->getName() ?? $githubUser->getNickname(),
                'password' => Hash::make(Str::random(24)),
            ]
        );

        session(['github_token' => $githubUser->token]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $accessToken = $request->session()->get('github_token');

        if ($accessToken) {
            $clientId = config('services.github.client_id');
            $clientSecret = config('services.github.client_secret');

            if ($clientId && $clientSecret) {
                Http::withBasicAuth($clientId, $clientSecret)
                    ->withHeaders([
                        'Accept' => 'application/vnd.github+json',
                    ])
                    ->delete("https://api.github.com/applications/{$clientId}/grant", [
                        'access_token' => $accessToken,
                    ]);
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}

