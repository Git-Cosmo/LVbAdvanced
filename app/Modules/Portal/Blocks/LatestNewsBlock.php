<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;

class LatestNewsBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'latest_news';
    }

    public function getName(): string
    {
        return 'Latest News';
    }

    public function getDescription(): string
    {
        return 'Display latest news articles';
    }

    public function getData(Block $block): array
    {
        $limit = $this->getSetting($block, 'limit', 5);
        
        // Placeholder data - in real implementation, this would fetch from a News model
        $news = collect([
            [
                'id' => 1,
                'title' => 'Welcome to vBadvanced Portal',
                'excerpt' => 'This is a sample news article to demonstrate the portal system.',
                'date' => now()->subDays(1),
                'author' => 'Admin',
            ],
            [
                'id' => 2,
                'title' => 'New Features Released',
                'excerpt' => 'Check out the latest features in our portal system.',
                'date' => now()->subDays(3),
                'author' => 'Admin',
            ],
        ])->take($limit);

        return [
            'news' => $news,
            'showDate' => $this->getSetting($block, 'show_date', true),
            'showAuthor' => $this->getSetting($block, 'show_author', true),
        ];
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.latest-news';
    }

    public function getConfigFields(): array
    {
        return [
            'limit' => [
                'type' => 'number',
                'label' => 'Number of items',
                'default' => 5,
            ],
            'show_date' => [
                'type' => 'checkbox',
                'label' => 'Show date',
                'default' => true,
            ],
            'show_author' => [
                'type' => 'checkbox',
                'label' => 'Show author',
                'default' => true,
            ],
        ];
    }
}
