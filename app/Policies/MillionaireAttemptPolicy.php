<?php

namespace App\Policies;

use App\Models\MillionaireAttempt;
use App\Models\User;

class MillionaireAttemptPolicy
{
    public function view(User $user, MillionaireAttempt $attempt): bool
    {
        return $user->id === $attempt->user_id;
    }
}
