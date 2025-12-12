<?php

namespace App\Policies\Forum;

use App\Models\Forum\ForumPoll;
use App\Models\User;

class ForumPollPolicy
{
    /**
     * Determine if the user can vote on the poll.
     */
    public function vote(?User $user, ForumPoll $poll): bool
    {
        // Must be authenticated
        if (! $user) {
            return false;
        }

        // Poll must be active
        if (! $poll->isActive()) {
            return false;
        }

        return true;
    }
}
