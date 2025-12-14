<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Get a specific user profile
     */
    public function show(User $user)
    {
        $user->load([
            'profile',
            'badges',
            'achievements',
        ]);

        return response()->json([
            'user' => $user,
            'stats' => [
                'threads' => $user->threads()->count(),
                'posts' => $user->posts()->count(),
                'followers' => $user->followers()->count(),
                'following' => $user->following()->count(),
            ],
        ]);
    }
}
