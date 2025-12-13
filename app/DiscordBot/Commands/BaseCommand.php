<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;

abstract class BaseCommand implements CommandInterface
{
    /**
     * Check if the user has permission to use this command.
     */
    public function hasPermission(Message $message): bool
    {
        $requiredRoles = $this->getRequiredRoles();

        // If no roles are required, everyone can use the command
        if (empty($requiredRoles)) {
            return true;
        }

        $member = $message->member;
        if (! $member) {
            return false;
        }

        // Check if user has any of the required roles
        foreach ($member->roles as $role) {
            if (in_array(strtolower($role->name), array_map('strtolower', $requiredRoles))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the required roles for this command.
     * Override this method to specify required roles.
     *
     * @return array
     */
    protected function getRequiredRoles(): array
    {
        return [];
    }
}
