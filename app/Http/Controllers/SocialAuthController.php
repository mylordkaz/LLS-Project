<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Redirect to GitHub
    public function redirectToGitHub()
    {
        return Socialite:: driver('github')->redirect();
    }

    // Google callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            ['email' => $googleUser->getName()],
            [
                'name' => $googleUser->getName(),
                'password' => Hash::make(uniqid()), // create random
                'google_id' => $googleUser->getId()
            ]
        );

        Auth::login($user);

        return redirect()->intended('dashboard');
    }

    // GitHub callback
    public function HandleGitHubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate(
            ['email' => $githubUser->getName()],
            [
                'name' => $githubUser->getName(),
                'password' => Hash::make(uniqid()), // create random
                'github_id' => $githubUser->getId()
            ]
        );
        Auth::login($user);

        return redirect()->intended('dashboard');
    }
}
