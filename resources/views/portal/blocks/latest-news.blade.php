<div class="block latest-news-block">
    @if($news->count() > 0)
        <div class="space-y-4">
            @foreach($news as $item)
                <article class="border-b border-gray-200 pb-4 last:border-0">
                    <h3 class="text-lg font-semibold text-gray-900 hover:text-primary-600">
                        <a href="#">{{ $item['title'] }}</a>
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">{{ $item['excerpt'] }}</p>
                    <div class="text-xs text-gray-500 mt-2 flex gap-4">
                        @if($showDate)
                            <span>{{ $item['date']->format('M d, Y') }}</span>
                        @endif
                        @if($showAuthor)
                            <span>By {{ $item['author'] }}</span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No news available.</p>
    @endif
</div>
