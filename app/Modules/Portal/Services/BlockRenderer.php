<?php

namespace App\Modules\Portal\Services;

use App\Models\Block;
use App\Models\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class BlockRenderer
{
    public function __construct(
        protected BlockRegistry $registry
    ) {}

    public function renderForPage(?Page $page, string $position): Collection
    {
        $blocks = $this->getBlocksForPosition($page, $position);
        
        return $blocks->map(function ($blockPosition) {
            return $this->renderBlock($blockPosition->block);
        })->filter();
    }

    public function renderBlock(Block $block): ?string
    {
        // Check if block is active
        if (!$block->is_active) {
            return null;
        }

        // Check visibility
        if (!$this->checkVisibility($block)) {
            return null;
        }

        // Get block handler from registry
        $handler = $this->registry->get($block->type);
        
        if (!$handler) {
            return "<!-- Block handler not found for type: {$block->type} -->";
        }

        try {
            return $handler->render($block);
        } catch (\Exception $e) {
            logger()->error("Error rendering block {$block->id}: " . $e->getMessage());
            return config('app.debug') 
                ? "<!-- Error rendering block: {$e->getMessage()} -->"
                : null;
        }
    }

    protected function getBlocksForPosition(?Page $page, string $position): Collection
    {
        $query = \App\Models\BlockPosition::with('block')
            ->where('position', $position)
            ->where('is_active', true)
            ->whereHas('block', function ($q) {
                $q->where('is_active', true);
            })
            ->orderBy('order');

        if ($page) {
            // Get blocks for this specific page or global blocks (page_id = null)
            $query->where(function ($q) use ($page) {
                $q->where('page_id', $page->id)
                  ->orWhereNull('page_id');
            });
        } else {
            // Only global blocks
            $query->whereNull('page_id');
        }

        return $query->get();
    }

    protected function checkVisibility(Block $block): bool
    {
        return match($block->visibility) {
            'public' => true,
            'auth' => Auth::check(),
            'guest' => !Auth::check(),
            'role' => $this->checkRoleVisibility($block),
            default => true,
        };
    }

    protected function checkRoleVisibility(Block $block): bool
    {
        if (!Auth::check()) {
            return false;
        }

        if (empty($block->visibility_roles)) {
            return true;
        }

        return Auth::user()->hasAnyRole($block->visibility_roles);
    }
}
