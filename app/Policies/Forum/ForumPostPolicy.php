<?php

namespace App\Policies\Forum;

use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Models\User;

class ForumPostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Everyone can view posts
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, ForumPost $forumPost): bool
    {
        // Hidden posts only visible to moderators/admins
        if ($forumPost->is_hidden) {
            return $user && ($user->hasRole('admin') || $user->hasRole('moderator'));
        }

        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, ?ForumThread $thread = null): bool
    {
        // Check if thread is locked
        if ($thread && $thread->is_locked) {
            return $user->hasRole('admin') || $user->hasRole('moderator');
        }

        return true; // All authenticated users can create posts
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForumPost $forumPost): bool
    {
        // User can edit their own post within 15 minutes or moderators/admins can edit any
        if ($user->id === $forumPost->user_id) {
            // Allow edit within 15 minutes or if moderator/admin
            return $forumPost->created_at->diffInMinutes(now()) <= 15
                || $user->hasRole('admin')
                || $user->hasRole('moderator');
        }

        return $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForumPost $forumPost): bool
    {
        // User can delete their own post or moderators/admins can delete any
        return $user->id === $forumPost->user_id
            || $user->hasRole('admin')
            || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ForumPost $forumPost): bool
    {
        return $user->hasRole('admin') || $user->hasRole('moderator');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ForumPost $forumPost): bool
    {
        return $user->hasRole('admin');
    }
}
