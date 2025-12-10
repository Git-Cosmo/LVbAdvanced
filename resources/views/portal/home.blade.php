@extends('portal.layouts.app')

@section('content')
<div class="grid grid-cols-12 gap-6">
    <!-- Left Column -->
    @if($leftBlocks->count() > 0)
        <aside class="col-span-12 lg:col-span-3 space-y-6">
            @foreach($leftBlocks as $blockHtml)
                {!! $blockHtml !!}
            @endforeach
        </aside>
    @endif

    <!-- Center Column -->
    <div @class([
        'col-span-12',
        'lg:col-span-6' => $leftBlocks->count() > 0 && $rightBlocks->count() > 0,
        'lg:col-span-9' => ($leftBlocks->count() > 0 && $rightBlocks->count() == 0) || ($leftBlocks->count() == 0 && $rightBlocks->count() > 0),
    ])>
        <div class="space-y-6">
            <!-- Full Width Blocks -->
            @if($fullWidthBlocks->count() > 0)
                <div class="space-y-6">
                    @foreach($fullWidthBlocks as $blockHtml)
                        {!! $blockHtml !!}
                    @endforeach
                </div>
            @endif

            <!-- Center Blocks -->
            @if($centerBlocks->count() > 0)
                <div class="space-y-6">
                    @foreach($centerBlocks as $blockHtml)
                        {!! $blockHtml !!}
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Welcome to vBadvanced Portal</h2>
                    <p class="text-gray-600">This is a modern Laravel-based portal system inspired by vBadvanced CMPS.</p>
                    <p class="text-gray-600 mt-2">Configure blocks in the admin panel to customize this page.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Right Column -->
    @if($rightBlocks->count() > 0)
        <aside class="col-span-12 lg:col-span-3 space-y-6">
            @foreach($rightBlocks as $blockHtml)
                {!! $blockHtml !!}
            @endforeach
        </aside>
    @endif
</div>
@endsection
