<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;
use App\Models\Forum\ForumThread;

class LatestThreadsBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'latest_threads';
    }

    public function getName(): string
    {
        return 'Latest Forum Threads';
    }

    public function getDescription(): string
    {
        return 'Display the latest threads from the forum';
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.latest-threads';
    }

    public function getData(Block $block): array
    {
        $limit = $block->settings['limit'] ?? 5;
        
        $threads = ForumThread::with(['user.profile', 'forum'])
            ->where('is_hidden', false)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return [
            'threads' => $threads,
            'limit' => $limit,
        ];
    }

    public function getDefaultSettings(): array
    {
        return [
            'limit' => 5,
            'show_forum' => true,
            'show_author' => true,
        ];
    }
}
