<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class OnlineUsersBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'online_users';
    }

    public function getName(): string
    {
        return 'Online Users';
    }

    public function getDescription(): string
    {
        return 'Display currently online users';
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.online-users';
    }

    public function getData(Block $block): array
    {
        // Get users active in last 15 minutes
        $minutes = $block->settings['minutes'] ?? 15;
        $showAvatars = $block->settings['show_avatars'] ?? true;
        $maxDisplay = $block->settings['max_display'] ?? 10;
        
        $onlineUsers = User::where('last_active_at', '>=', now()->subMinutes($minutes))
            ->orderByDesc('last_active_at')
            ->take($maxDisplay)
            ->get();
        
        $totalOnline = User::where('last_active_at', '>=', now()->subMinutes($minutes))->count();
        
        // Get guest count from cache (would be updated by middleware)
        $guestCount = Cache::get('online_guests_count', 0);
        
        return [
            'online_users' => $onlineUsers,
            'total_online' => $totalOnline,
            'guest_count' => $guestCount,
            'show_avatars' => $showAvatars,
            'max_display' => $maxDisplay,
        ];
    }

    public function getDefaultSettings(): array
    {
        return [
            'minutes' => 15,
            'show_avatars' => true,
            'max_display' => 10,
        ];
    }
}
