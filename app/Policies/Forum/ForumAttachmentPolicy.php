<?php

namespace App\Policies\Forum;

use App\Models\Forum\ForumAttachment;
use App\Models\User;

class ForumAttachmentPolicy
{
    /**
     * Determine if the user can delete the attachment.
     */
    public function delete(User $user, ForumAttachment $attachment): bool
    {
        // User can delete their own attachments or admins can delete any
        return $user->id === $attachment->user_id || $user->is_admin;
    }
}
