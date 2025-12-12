<?php

namespace App\Policies;

use App\Models\Tournament;
use App\Models\User;

class TournamentPolicy
{
    /**
     * Determine if the user can create tournaments.
     */
    public function create(User $user): bool
    {
        // Allow all authenticated users to create tournaments
        // You can add more restrictions (e.g., role checks) here
        return true;
    }

    /**
     * Determine if the user can update the tournament.
     */
    public function update(User $user, Tournament $tournament): bool
    {
        return $user->id === $tournament->user_id || $user->hasRole('admin');
    }

    /**
     * Determine if the user can delete the tournament.
     */
    public function delete(User $user, Tournament $tournament): bool
    {
        return $user->id === $tournament->user_id || $user->hasRole('admin');
    }

    /**
     * Determine if the user can manage the tournament (approve participants, etc.).
     */
    public function manage(User $user, Tournament $tournament): bool
    {
        return $user->id === $tournament->user_id || 
               $user->hasRole('admin') ||
               $tournament->staff()->where('user_id', $user->id)->exists();
    }
}
