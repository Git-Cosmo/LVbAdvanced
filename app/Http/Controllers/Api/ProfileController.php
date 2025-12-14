<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Get authenticated user's profile
     */
    public function show(Request $request)
    {
        $user = $request->user()->load([
            'profile',
            'badges',
            'achievements',
        ]);

        return response()->json($user);
    }

    /**
     * Update authenticated user's profile
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $request->user()->id,
            'about' => 'sometimes|string|max:1000',
            'location' => 'sometimes|string|max:255',
            'website' => 'sometimes|url|max:255',
        ]);

        $user = $request->user();
        $user->update($request->only(['name', 'email']));

        if ($request->has(['about', 'location', 'website'])) {
            $user->profile->update($request->only(['about', 'location', 'website']));
        }

        return response()->json($user->load('profile'));
    }

    /**
     * Follow a user
     */
    public function follow(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return response()->json(['message' => 'Cannot follow yourself'], 400);
        }

        $request->user()->following()->syncWithoutDetaching([$user->id]);

        return response()->json(['message' => 'User followed successfully']);
    }

    /**
     * Unfollow a user
     */
    public function unfollow(Request $request, User $user)
    {
        $request->user()->following()->detach($user->id);

        return response()->json(['message' => 'User unfollowed successfully']);
    }
}
