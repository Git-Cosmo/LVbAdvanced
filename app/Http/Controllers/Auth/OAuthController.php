<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\UserProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    /**
     * Redirect to the OAuth provider.
     */
    public function redirect(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the OAuth provider callback.
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors(['oauth' => 'Unable to authenticate with ' . ucfirst($provider) . '. Please try again.']);
        }

        // Find or create user
        $user = User::where($provider . '_id', $socialUser->getId())->first();

        if (!$user) {
            // Check if email exists
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Link OAuth account to existing user
                $user->update([
                    $provider . '_id' => $socialUser->getId(),
                ]);
            } else {
                // For OAuth users without email, we need to handle this edge case
                $email = $socialUser->getEmail();
                if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // Redirect back with error if no valid email provided
                    return redirect()->route('login')->withErrors([
                        'oauth' => 'Unable to get valid email from ' . ucfirst($provider) . '. Please use email registration.'
                    ]);
                }

                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'User' . bin2hex(random_bytes(4)),
                    'email' => $email,
                    'password' => Hash::make(Str::random(32)),
                    $provider . '_id' => $socialUser->getId(),
                    'email_verified_at' => now(), // OAuth providers verify email
                ]);

                // Create user profile
                UserProfile::create([
                    'user_id' => $user->id,
                    'avatar' => $socialUser->getAvatar(),
                    'xp' => 0,
                    'level' => 1,
                    'karma' => 0,
                ]);
            }
        }

        // Update avatar if not set
        if ($user->profile && !$user->profile->avatar && $socialUser->getAvatar()) {
            $user->profile->update(['avatar' => $socialUser->getAvatar()]);
        }

        Auth::login($user, true);

        return redirect()->route('home')->with('status', 'Welcome back! You have been logged in via ' . ucfirst($provider) . '.');
    }

    /**
     * Validate the OAuth provider.
     */
    protected function validateProvider(string $provider): void
    {
        if (!in_array($provider, ['steam', 'discord', 'battlenet'])) {
            abort(404);
        }
    }
}
