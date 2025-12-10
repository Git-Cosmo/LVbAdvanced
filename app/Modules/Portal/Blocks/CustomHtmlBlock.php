<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;

class CustomHtmlBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'custom_html';
    }

    public function getName(): string
    {
        return 'Custom HTML';
    }

    public function getDescription(): string
    {
        return 'Display custom HTML content';
    }

    public function getData(Block $block): array
    {
        return [
            'content' => $block->content ?? '',
        ];
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.custom-html';
    }

    public function getConfigFields(): array
    {
        return [
            'content' => [
                'type' => 'textarea',
                'label' => 'HTML Content',
                'required' => true,
            ],
        ];
    }
}
