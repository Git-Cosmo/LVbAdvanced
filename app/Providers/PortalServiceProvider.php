<?php

namespace App\Providers;

use App\Modules\Portal\Blocks\CustomHtmlBlock;
use App\Modules\Portal\Blocks\LatestNewsBlock;
use App\Modules\Portal\Blocks\LinkListBlock;
use App\Modules\Portal\Blocks\StatsBlock;
use App\Modules\Portal\Services\BlockRegistry;
use App\Modules\Portal\Services\BlockRenderer;
use Illuminate\Support\ServiceProvider;

class PortalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register BlockRegistry as singleton
        $this->app->singleton(BlockRegistry::class);
        
        // Register BlockRenderer
        $this->app->singleton(BlockRenderer::class, function ($app) {
            return new BlockRenderer($app->make(BlockRegistry::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $registry = $this->app->make(BlockRegistry::class);
        
        // Register all available blocks
        $registry->register('custom_html', new CustomHtmlBlock());
        $registry->register('latest_news', new LatestNewsBlock());
        $registry->register('link_list', new LinkListBlock());
        $registry->register('stats', new StatsBlock());
    }
}
