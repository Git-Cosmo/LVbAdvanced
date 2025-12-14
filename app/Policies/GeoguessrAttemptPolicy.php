<?php

namespace App\Policies;

use App\Models\GeoguessrAttempt;
use App\Models\User;

class GeoguessrAttemptPolicy
{
    public function view(User $user, GeoguessrAttempt $attempt): bool
    {
        return $user->id === $attempt->user_id;
    }
}
