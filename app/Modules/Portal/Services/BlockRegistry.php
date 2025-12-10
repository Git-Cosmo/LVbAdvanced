<?php

namespace App\Modules\Portal\Services;

use App\Modules\Portal\Contracts\BlockInterface;

class BlockRegistry
{
    protected array $blocks = [];

    public function register(string $type, BlockInterface $block): void
    {
        $this->blocks[$type] = $block;
    }

    public function get(string $type): ?BlockInterface
    {
        return $this->blocks[$type] ?? null;
    }

    public function all(): array
    {
        return $this->blocks;
    }

    public function has(string $type): bool
    {
        return isset($this->blocks[$type]);
    }

    public function getTypes(): array
    {
        return array_keys($this->blocks);
    }

    public function getOptions(): array
    {
        $options = [];
        foreach ($this->blocks as $type => $block) {
            $options[$type] = $block->getName();
        }
        return $options;
    }
}
