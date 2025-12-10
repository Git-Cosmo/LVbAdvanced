<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Modules\Portal\Services\BlockRenderer;
use Illuminate\View\View;

class PortalController extends Controller
{
    public function __construct(
        protected BlockRenderer $blockRenderer
    ) {}

    public function home(): View
    {
        $page = Page::getHomepage();
        
        return view('portal.home', [
            'page' => $page,
            'leftBlocks' => $this->blockRenderer->renderForPage($page, 'left'),
            'centerBlocks' => $this->blockRenderer->renderForPage($page, 'center'),
            'rightBlocks' => $this->blockRenderer->renderForPage($page, 'right'),
            'fullWidthBlocks' => $this->blockRenderer->renderForPage($page, 'full-width'),
        ]);
    }

    public function show(string $slug): View
    {
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        return view('portal.home', [
            'page' => $page,
            'leftBlocks' => $this->blockRenderer->renderForPage($page, 'left'),
            'centerBlocks' => $this->blockRenderer->renderForPage($page, 'center'),
            'rightBlocks' => $this->blockRenderer->renderForPage($page, 'right'),
            'fullWidthBlocks' => $this->blockRenderer->renderForPage($page, 'full-width'),
        ]);
    }
}
