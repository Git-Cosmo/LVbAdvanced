<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Display the user settings page.
     */
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile;

        return view('settings.index', [
            'user' => $user,
            'profile' => $profile,
            'page' => (object) [
                'title' => 'Account Settings - FPSociety',
                'meta_title' => 'Account Settings | FPSociety',
                'meta_description' => 'Manage your FPSociety account settings',
            ],
        ]);
    }

    /**
     * Update account settings.
     */
    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('settings.index')->with('success', 'Account settings updated successfully!');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('settings.index')->with('success', 'Password changed successfully!');
    }

    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $profile = auth()->user()->profile;

        $privacySettings = [
            'profile_visibility' => $request->input('profile_visibility', 'public'),
            'show_email' => $request->boolean('show_email'),
            'show_online_status' => $request->boolean('show_online_status'),
            'allow_messages' => $request->boolean('allow_messages'),
            'allow_profile_posts' => $request->boolean('allow_profile_posts'),
        ];

        $profile->update([
            'privacy_settings' => $privacySettings,
        ]);

        return redirect()->route('settings.index')->with('success', 'Privacy settings updated successfully!');
    }

    /**
     * Update email preferences.
     */
    public function updateNotifications(Request $request)
    {
        $profile = auth()->user()->profile;

        $customFields = $profile->custom_fields ?? [];
        $customFields['email_notifications'] = [
            'replies' => $request->boolean('email_replies'),
            'mentions' => $request->boolean('email_mentions'),
            'follows' => $request->boolean('email_follows'),
            'messages' => $request->boolean('email_messages'),
            'digest' => $request->boolean('email_digest'),
        ];

        $profile->update([
            'custom_fields' => $customFields,
        ]);

        return redirect()->route('settings.index')->with('success', 'Notification preferences updated successfully!');
    }
}
