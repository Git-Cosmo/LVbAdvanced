<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(User $user): View
    {
        $user->load(['profile', 'threads', 'posts', 'badges', 'followers', 'following']);

        // Get recent activity
        $recentThreads = $user->threads()
            ->with('forum')
            ->latest()
            ->take(5)
            ->get();

        $recentPosts = $user->posts()
            ->with('thread.forum')
            ->latest()
            ->take(10)
            ->get();

        $profilePosts = $user->profilePosts()
            ->with('author')
            ->latest()
            ->paginate(10);

        return view('profile.show', compact('user', 'recentThreads', 'recentPosts', 'profilePosts'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(): View
    {
        $user = auth()->user();
        $user->load('profile');

        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'about_me' => 'nullable|string|max:1000',
            'location' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'steam_id' => 'nullable|string|max:100',
            'discord_id' => 'nullable|string|max:100',
            'battlenet_id' => 'nullable|string|max:100',
            'xbox_gamertag' => 'nullable|string|max:100',
            'psn_id' => 'nullable|string|max:100',
            'avatar' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $path;
        }

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $validated['cover_image'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $validated
        );

        return redirect()->route('profile.show', $user)
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Follow a user.
     */
    public function follow(User $user): RedirectResponse
    {
        auth()->user()->following()->attach($user->id);

        // Update follower counts
        auth()->user()->profile->increment('following_count');
        $user->profile->increment('followers_count');

        return back()->with('success', 'You are now following '.$user->name);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user): RedirectResponse
    {
        auth()->user()->following()->detach($user->id);

        // Update follower counts
        auth()->user()->profile->decrement('following_count');
        $user->profile->decrement('followers_count');

        return back()->with('success', 'You have unfollowed '.$user->name);
    }

    /**
     * Post on a user's profile wall.
     */
    public function postOnWall(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user->profilePosts()->create([
            'author_id' => auth()->id(),
            'content' => $validated['content'],
            'is_approved' => true,
        ]);

        return back()->with('success', 'Posted on profile wall!');
    }
}
