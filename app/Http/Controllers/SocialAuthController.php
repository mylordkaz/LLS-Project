<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $user = User::where('email', $googleUser->getEmail())->first();

        if($user) {
            $user->update(['google_id' => $googleUser->getId()]);
        } else {
            $user = User::create(
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getName(),
                    'password' => Hash::make(uniqid()), // create random
                    'google_id' => $googleUser->getId()
                ]
            );
        }


        Auth::login($user);

        return redirect()->intended('dashboard');
    }

    // GitHub callback
    public function HandleGitHubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::where('email', $githubUser->getEmail())->first();

        if($user) {
            $user->update(['google_id' => $githubUser->getId()]);
        } else {
            $user = User::create(
                [
                    'name' => $githubUser->getName(),
                    'email' => $githubUser->getName(),
                    'password' => Hash::make(uniqid()), // create random
                    'google_id' => $githubUser->getId()
                ]
            );
        }
        Auth::login($user);

        return redirect()->intended('dashboard');
    }
}
