<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User\UserProfile;
use App\Models\User\UserAchievement;
use App\Models\User\UserBadge;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $query = User::with(['profile', 'roles']);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->has('role') && $request->role) {
            $query->role($request->role);
        }

        $users = $query->latest()->paginate(20);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(User $user): View
    {
        $user->load(['profile', 'roles', 'achievements', 'badges']);
        $roles = Role::all();
        $allAchievements = UserAchievement::where('is_active', true)->get();
        $allBadges = UserBadge::where('is_active', true)->get();

        return view('admin.users.edit', compact('user', 'roles', 'allAchievements', 'allBadges'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Sync roles
        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'User updated successfully.');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'xp' => 'nullable|integer|min:0',
            'level' => 'nullable|integer|min:1',
            'karma' => 'nullable|integer',
            'user_title' => 'nullable|string|max:255',
            'about_me' => 'nullable|string',
        ]);

        // Ensure user has a profile
        if (!$user->profile) {
            UserProfile::create(['user_id' => $user->id]);
            $user->load('profile');
        }

        $user->profile->update($validated);

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'User profile updated successfully.');
    }

    /**
     * Grant achievement to user.
     */
    public function grantAchievement(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'achievement_id' => 'required|exists:user_achievements,id',
        ]);

        $achievement = UserAchievement::find($validated['achievement_id']);
        
        if (!$user->achievements()->where('user_achievements.id', $achievement->id)->exists()) {
            $user->achievements()->attach($achievement->id, [
                'progress' => 100,
                'is_unlocked' => true,
                'unlocked_at' => now(),
            ]);

            // Award XP for achievement (ensure profile exists)
            if ($achievement->points > 0 && $user->profile) {
                $user->profile->addXp($achievement->points);
            }
        }

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Achievement granted successfully.');
    }

    /**
     * Revoke achievement from user.
     */
    public function revokeAchievement(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'achievement_id' => 'required|exists:user_achievements,id',
        ]);

        $user->achievements()->detach($validated['achievement_id']);

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Achievement revoked successfully.');
    }

    /**
     * Grant badge to user.
     */
    public function grantBadge(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'badge_id' => 'required|exists:user_badges,id',
        ]);

        $badge = UserBadge::find($validated['badge_id']);
        
        if (!$user->badges()->where('user_badges.id', $badge->id)->exists()) {
            $user->badges()->attach($badge->id, [
                'awarded_at' => now(),
            ]);
        }

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Badge granted successfully.');
    }

    /**
     * Revoke badge from user.
     */
    public function revokeBadge(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'badge_id' => 'required|exists:user_badges,id',
        ]);

        $user->badges()->detach($validated['badge_id']);

        return redirect()->route('admin.users.edit', $user)
            ->with('success', 'Badge revoked successfully.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}
