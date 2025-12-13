<?php

namespace App\Traits;

use App\Models\User;

trait EnsuresUserProfile
{
    /**
     * Ensure that a user has a profile record.
     * Creates a profile with default values if it doesn't exist.
     *
     * @param  User  $user
     * @return void
     */
    protected function ensureUserProfile(User $user): void
    {
        if (! $user->profile) {
            $user->profile()->create([
                'xp' => 0,
                'level' => 1,
                'karma' => 0,
                'login_streak' => 0,
                'posting_streak' => 0,
            ]);

            // Refresh the relationship to ensure it's loaded
            $user->load('profile');
        }
    }
}
