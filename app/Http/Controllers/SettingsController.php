<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAccountRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SettingsController extends Controller
{
    /**
     * Display the user settings page.
     */
    public function index(): View
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
    public function updateAccount(UpdateAccountRequest $request): RedirectResponse
    {
        $user = auth()->user();

        $user->update($request->validated());

        return redirect()->route('settings.index')->with('success', 'Account settings updated successfully!');
    }

    /**
     * Update password.
     */
    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('settings.index')->with('success', 'Password changed successfully!');
    }

    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request): RedirectResponse
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
    public function updateNotifications(Request $request): RedirectResponse
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

    /**
     * Update user status.
     */
    public function updateStatus(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Ensure profile exists
        if (! $user->profile) {
            $user->profile()->create([
                'status' => 'online',
            ]);
        }

        $profile = $user->profile;

        $validated = $request->validate([
            'status' => 'required|in:online,away,busy,offline',
            'status_message' => 'nullable|string|max:140',
        ]);

        $profile->update([
            'status' => $validated['status'],
            'status_message' => $validated['status_message'],
            'status_updated_at' => now(),
        ]);

        return redirect()->route('settings.index')->with('success', 'Status updated successfully!');
    }
}
