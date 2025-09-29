<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller 
{
    // Redirect the user to Google's OAuth page 
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    // Handle callback from Google
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists with this email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // User doesn't exist - redirect with error
                return redirect()->route('login')->with('error', 
                    "This email isn't associated with an existing account. Please register first."
                );
            }

            // User exists - update Google ID if not already set
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                ]);
            }

            // Log the user in
            Auth::login($user, remember: true);

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin!');
            }

            return redirect()->route('home')->with('success', 'Successfully signed in!');
            
        } catch (\Exception $e) {
            return redirect()
                ->route('login')
                ->with('error', 'Something went wrong with Google authentication. Please try again.');
        }
    }
}
