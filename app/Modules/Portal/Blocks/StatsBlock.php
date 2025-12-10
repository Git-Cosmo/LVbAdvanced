<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;
use App\Models\User;

class StatsBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'stats';
    }

    public function getName(): string
    {
        return 'Statistics';
    }

    public function getDescription(): string
    {
        return 'Display site statistics';
    }

    public function getData(Block $block): array
    {
        return [
            'stats' => [
                'total_users' => User::count(),
                'total_pages' => \App\Models\Page::count(),
                'total_blocks' => \App\Models\Block::count(),
                'online_users' => 0, // Placeholder
            ],
        ];
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.stats';
    }
}
