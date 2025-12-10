<div class="block link-list-block">
    @if($links->count() > 0)
        <ul class="space-y-2">
            @foreach($links as $link)
                <li>
                    <a href="{{ $link['url'] }}" 
                       target="{{ $link['target'] }}"
                       class="flex items-center text-gray-700 hover:text-primary-600 transition">
                        @if($link['icon'])
                            <span class="mr-2">{!! $link['icon'] !!}</span>
                        @endif
                        <span>{{ $link['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No links available.</p>
    @endif
</div>
