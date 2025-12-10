<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;

class LinkListBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'link_list';
    }

    public function getName(): string
    {
        return 'Link List';
    }

    public function getDescription(): string
    {
        return 'Display a list of links';
    }

    public function getData(Block $block): array
    {
        $links = $block->config['links'] ?? [];
        
        return [
            'links' => collect($links)->map(function ($link) {
                return [
                    'title' => $link['title'] ?? '',
                    'url' => $link['url'] ?? '#',
                    'target' => $link['target'] ?? '_self',
                    'icon' => $link['icon'] ?? null,
                ];
            }),
        ];
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.link-list';
    }

    public function getConfigFields(): array
    {
        return [
            'links' => [
                'type' => 'repeater',
                'label' => 'Links',
                'fields' => [
                    'title' => [
                        'type' => 'text',
                        'label' => 'Title',
                    ],
                    'url' => [
                        'type' => 'text',
                        'label' => 'URL',
                    ],
                    'target' => [
                        'type' => 'select',
                        'label' => 'Target',
                        'options' => [
                            '_self' => 'Same window',
                            '_blank' => 'New window',
                        ],
                    ],
                ],
            ],
        ];
    }
}
