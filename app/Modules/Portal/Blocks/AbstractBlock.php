<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;
use App\Modules\Portal\Contracts\BlockInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

abstract class AbstractBlock implements BlockInterface
{
    abstract public function getType(): string;
    abstract public function getName(): string;
    abstract public function getDescription(): string;
    abstract public function getData(Block $block): array;
    abstract public function getTemplate(): string;

    public function render(Block $block): string
    {
        // Check if caching is enabled
        if ($block->cache_lifetime > 0) {
            $cacheKey = $this->getCacheKey($block);
            return Cache::remember($cacheKey, $block->cache_lifetime * 60, function () use ($block) {
                return $this->renderBlock($block);
            });
        }

        return $this->renderBlock($block);
    }

    protected function renderBlock(Block $block): string
    {
        $data = $this->getData($block);
        $template = $block->template ?: $this->getTemplate();

        if (!View::exists($template)) {
            return "<!-- Block template not found: {$template} -->";
        }

        $content = view($template, array_merge($data, [
            'block' => $block,
        ]))->render();

        // Wrap the block content
        return view('components.block-wrapper', [
            'block' => $block,
            'slot' => $content,
        ])->render();
    }

    protected function getCacheKey(Block $block): string
    {
        return "block:{$block->id}:{$block->updated_at->timestamp}";
    }

    public function clearCache(Block $block): void
    {
        Cache::forget($this->getCacheKey($block));
    }

    public function getConfigFields(): array
    {
        return [];
    }

    protected function getSetting(Block $block, string $key, mixed $default = null): mixed
    {
        return $block->getSetting($key, $default);
    }
}
