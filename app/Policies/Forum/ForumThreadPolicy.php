<?php

namespace App\Policies\Forum;

use App\Models\Forum\Forum;
use App\Models\Forum\ForumThread;
use App\Models\User;

class ForumThreadPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view threads
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, ForumThread $forumThread): bool
    {
        // Hidden threads only visible to moderators/admins
        if ($forumThread->is_hidden) {
            return $user && ($user->hasRole('admin') || $user->hasRole('moderator'));
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?Forum $forum = null): bool
    {
        // Check if forum is locked
        if ($forum && $forum->is_locked) {
            return $user->hasRole('admin') || $user->hasRole('moderator');
        }

        return true; // All authenticated users can create threads
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumThread $forumThread): bool
    {
        // User can edit their own thread or moderators/admins can edit any
        return $user->id === $forumThread->user_id
            || $user->hasRole('admin')
            || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumThread $forumThread): bool
    {
        // Only moderators and admins can delete threads
        return $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumThread $forumThread): bool
    {
        return $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumThread $forumThread): bool
    {
        return $user->hasRole('admin');
    }
}
