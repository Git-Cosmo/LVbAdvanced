<?php

namespace App\Modules\Portal\Contracts;

use App\Models\Block;

interface BlockInterface
{
    /**
     * Get the block type identifier
     */
    public function getType(): string;

    /**
     * Get the block name
     */
    public function getName(): string;

    /**
     * Get the block description
     */
    public function getDescription(): string;

    /**
     * Render the block content
     */
    public function render(Block $block): string;

    /**
     * Get the data to be passed to the view
     */
    public function getData(Block $block): array;

    /**
     * Get the default template path
     */
    public function getTemplate(): string;

    /**
     * Get configurable fields for this block type
     */
    public function getConfigFields(): array;
}
