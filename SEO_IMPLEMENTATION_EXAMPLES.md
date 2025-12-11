# SEO Implementation Examples

This document provides practical examples of how to use the enhanced SeoService throughout the application.

---

## Table of Contents

1. [Basic Meta Tags](#basic-meta-tags)
2. [Article Pages (News, Blog)](#article-pages)
3. [Event Pages](#event-pages)
4. [Video Pages (Clips)](#video-pages)
5. [Breadcrumbs](#breadcrumbs)
6. [Forum Threads](#forum-threads)
7. [User Profiles](#user-profiles)
8. [Category/Index Pages](#category-pages)

---

## Basic Meta Tags

### Controller Example
```php
use App\Services\SeoService;

public function index()
{
    $seoService = app(SeoService::class);
    $seoData = $seoService->generateMetaTags([
        'title' => 'Gaming Community | FPSociety',
        'description' => 'Join the ultimate gaming community for CS2, GTA V, and more.',
        'keywords' => 'gaming, community, fps, counter strike',
    ]);

    return view('home', compact('seoData'));
}
```

### Blade Template
```blade
@extends('layouts.app')

{{-- SEO data is automatically handled by layout --}}

@section('content')
    <!-- Your content -->
@endsection
```

---

## Article Pages

### News Article Example

**Controller:**
```php
public function show(News $news)
{
    $seoService = app(\App\Services\SeoService::class);
    
    $seoData = $seoService->generateMetaTags([
        'title' => $news->title . ' | Gaming News',
        'description' => $news->excerpt ?? substr(strip_tags($news->content), 0, 160),
        'keywords' => $news->tags ?? 'gaming news, esports',
        'image' => $news->featured_image ?? asset('images/og-image-news.jpg'),
        'type' => 'article',
        'schema_type' => 'Article',
        'author' => $news->user->name,
        'datePublished' => $news->published_at->toIso8601String(),
        'dateModified' => $news->updated_at->toIso8601String(),
    ]);

    return view('news.show', [
        'news' => $news,
        'seoData' => $seoData,
        'canonicalUrl' => route('news.show', $news),
    ]);
}
```

**Or using the dedicated method:**
```php
public function show(News $news)
{
    $seoService = app(\App\Services\SeoService::class);
    
    // Use the Article-specific method
    $articleData = $seoService->generateArticleStructuredData([
        'headline' => $news->title,
        'description' => $news->excerpt,
        'author' => $news->user->name,
        'datePublished' => $news->published_at->toIso8601String(),
        'dateModified' => $news->updated_at->toIso8601String(),
        'image' => $news->featured_image ?? asset('images/og-image-news.jpg'),
        'url' => route('news.show', $news),
    ]);

    return view('news.show', [
        'news' => $news,
        'articleStructuredData' => $articleData,
    ]);
}
```

**Blade Template:**
```blade
@extends('layouts.app')

@section('content')
<article>
    <h1>{{ $news->title }}</h1>
    
    <div class="article-meta">
        <span>By {{ $news->user->name }}</span>
        <time datetime="{{ $news->published_at->toIso8601String() }}">
            {{ $news->published_at->format('F j, Y') }}
        </time>
    </div>

    <div class="article-content">
        {!! $news->content !!}
    </div>
</article>

{{-- Optional: Add extra structured data if not using $seoData --}}
@if(isset($articleStructuredData))
<script type="application/ld+json">
    {!! json_encode($articleStructuredData) !!}
</script>
@endif
@endsection
```

---

## Event Pages

### Gaming Event Example

**Controller:**
```php
use App\Services\SeoService;

public function show(Event $event)
{
    $seoService = app(SeoService::class);
    
    $eventData = $seoService->generateEventStructuredData([
        'name' => $event->title,
        'description' => $event->description,
        'startDate' => $event->start_date->toIso8601String(),
        'endDate' => $event->end_date->toIso8601String(),
        'location' => $event->url ?? route('events.show', $event),
        'image' => $event->banner ?? asset('images/og-image.jpg'),
        'url' => route('events.show', $event),
    ]);

    $seoData = $seoService->generateMetaTags([
        'title' => $event->title . ' | Gaming Events',
        'description' => $event->description,
        'type' => 'website',
        'image' => $event->banner ?? asset('images/og-image.jpg'),
    ]);

    return view('events.show', [
        'event' => $event,
        'seoData' => $seoData,
        'eventStructuredData' => $eventData,
    ]);
}
```

**Blade Template:**
```blade
@extends('layouts.app')

@section('content')
<div class="event-page">
    <h1>{{ $event->title }}</h1>
    
    <div class="event-details">
        <div class="event-date">
            <strong>When:</strong>
            <time datetime="{{ $event->start_date->toIso8601String() }}">
                {{ $event->start_date->format('F j, Y g:i A') }}
            </time>
            @if($event->end_date)
                to
                <time datetime="{{ $event->end_date->toIso8601String() }}">
                    {{ $event->end_date->format('F j, Y g:i A') }}
                </time>
            @endif
        </div>
        
        <div class="event-description">
            {!! $event->description !!}
        </div>
    </div>
</div>

{{-- Add Event structured data --}}
<script type="application/ld+json">
    {!! json_encode($eventStructuredData) !!}
</script>
@endsection
```

---

## Video Pages

### Gaming Clips Example

**Controller:**
```php
public function show(RedditPost $post)
{
    $seoService = app(\App\Services\SeoService::class);
    
    $videoData = $seoService->generateVideoStructuredData([
        'name' => $post->title,
        'description' => $post->selftext ?? $post->title,
        'thumbnailUrl' => $post->thumbnail,
        'uploadDate' => $post->created_at->toIso8601String(),
        'contentUrl' => $post->url,
        'embedUrl' => $post->url,
    ]);

    $seoData = $seoService->generateMetaTags([
        'title' => $post->title . ' | Gaming Clips',
        'description' => substr($post->selftext ?? $post->title, 0, 160),
        'image' => $post->thumbnail,
        'type' => 'video.other',
    ]);

    return view('reddit.show', [
        'post' => $post,
        'seoData' => $seoData,
        'videoStructuredData' => $videoData,
    ]);
}
```

**Blade Template:**
```blade
@extends('layouts.app')

@section('content')
<div class="video-page">
    <h1>{{ $post->title }}</h1>
    
    <div class="video-player">
        {{-- Your video embed code --}}
    </div>
    
    <div class="video-meta">
        <div>👁️ {{ number_format($post->score) }} views</div>
        <div>📅 {{ $post->created_at->diffForHumans() }}</div>
    </div>
</div>

<script type="application/ld+json">
    {!! json_encode($videoStructuredData) !!}
</script>
@endsection
```

---

## Breadcrumbs

### Implementation Example

**Controller:**
```php
public function show(Forum $forum, ForumThread $thread)
{
    $seoService = app(\App\Services\SeoService::class);
    
    // Build breadcrumb trail
    $breadcrumbs = [
        ['name' => 'Home', 'url' => route('home')],
        ['name' => 'Forums', 'url' => route('forum.index')],
        ['name' => $forum->name, 'url' => route('forum.show', $forum)],
        ['name' => $thread->title, 'url' => route('forum.thread.show', [$forum, $thread])],
    ];
    
    $breadcrumbData = $seoService->generateBreadcrumbStructuredData($breadcrumbs);

    return view('forum.thread.show', [
        'forum' => $forum,
        'thread' => $thread,
        'breadcrumbs' => $breadcrumbs,
        'breadcrumbStructuredData' => $breadcrumbData,
    ]);
}
```

**Blade Template:**
```blade
@extends('layouts.app')

@section('content')
{{-- Visual Breadcrumbs --}}
<nav aria-label="Breadcrumb" class="breadcrumbs">
    <ol class="flex items-center space-x-2">
        @foreach($breadcrumbs as $index => $crumb)
            <li>
                @if($index > 0)
                    <span class="text-gray-400">/</span>
                @endif
                
                @if($index === count($breadcrumbs) - 1)
                    <span class="text-gray-600">{{ $crumb['name'] }}</span>
                @else
                    <a href="{{ $crumb['url'] }}" class="text-blue-600 hover:underline">
                        {{ $crumb['name'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>

{{-- Your content --}}

{{-- Breadcrumb structured data --}}
<script type="application/ld+json">
    {!! json_encode($breadcrumbStructuredData) !!}
</script>
@endsection
```

---

## Forum Threads

### Example with Author and Comments

**Controller:**
```php
public function show(Forum $forum, ForumThread $thread)
{
    $seoService = app(\App\Services\SeoService::class);
    
    $seoData = $seoService->generateMetaTags([
        'title' => $thread->title . ' | ' . $forum->name,
        'description' => substr(strip_tags($thread->content), 0, 160),
        'type' => 'article',
        'schema_type' => 'Article',
        'author' => $thread->user->name,
        'datePublished' => $thread->created_at->toIso8601String(),
        'dateModified' => $thread->updated_at->toIso8601String(),
    ]);

    return view('forum.thread.show', [
        'forum' => $forum,
        'thread' => $thread,
        'seoData' => $seoData,
    ]);
}
```

---

## User Profiles

### Profile Page SEO

**Controller:**
```php
public function show(User $user)
{
    $seoService = app(\App\Services\SeoService::class);
    
    $seoData = $seoService->generateMetaTags([
        'title' => $user->name . ' - FPSociety Member Profile',
        'description' => $user->profile?->about_me 
            ?? "{$user->name} is a member of the FPSociety gaming community. View their profile, posts, and gaming activity.",
        'image' => $user->profile?->avatar 
            ? Storage::url($user->profile->avatar) 
            : asset('images/og-image.jpg'),
        'type' => 'profile',
    ]);

    return view('profile.show', [
        'user' => $user,
        'seoData' => $seoData,
        'canonicalUrl' => route('profile.show', $user),
    ]);
}
```

**Blade Template:**
```blade
@extends('layouts.app')

@section('content')
<div class="profile-page">
    <h1>{{ $user->name }}</h1>
    
    @if($user->profile?->user_title)
        <p class="user-title">{{ $user->profile->user_title }}</p>
    @endif
    
    {{-- Profile content --}}
</div>

{{-- Person structured data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "{{ $user->name }}",
    "url": "{{ route('profile.show', $user) }}",
    @if($user->profile?->avatar)
    "image": "{{ Storage::url($user->profile->avatar) }}",
    @endif
    @if($user->profile?->about_me)
    "description": "{{ $user->profile->about_me }}",
    @endif
    "memberOf": {
        "@type": "Organization",
        "name": "FPSociety"
    }
}
</script>
@endsection
```

---

## Category Pages

### Index/Listing Pages

**Controller:**
```php
public function index()
{
    $seoService = app(\App\Services\SeoService::class);
    
    $seoData = $seoService->generateMetaTags([
        'title' => 'Gaming News | FPSociety',
        'description' => 'Stay updated with the latest gaming news, updates, and announcements for Counter Strike 2, GTA V, Fortnite, and more.',
        'keywords' => 'gaming news, esports news, game updates, cs2 news, gta news',
    ]);

    $news = News::published()
        ->orderBy('published_at', 'desc')
        ->paginate(15);

    return view('news.index', [
        'news' => $news,
        'seoData' => $seoData,
    ]);
}
```

**Blade Template with Pagination:**
```blade
@extends('layouts.app')

@section('content')
<div class="news-index">
    <h1>Latest Gaming News</h1>
    
    <div class="news-grid">
        @foreach($news as $article)
            <article class="news-card">
                <h2>
                    <a href="{{ route('news.show', $article) }}">
                        {{ $article->title }}
                    </a>
                </h2>
                <p>{{ $article->excerpt }}</p>
            </article>
        @endforeach
    </div>
    
    {{ $news->links() }}
</div>

{{-- ItemList structured data --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "itemListElement": [
        @foreach($news as $index => $article)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "url": "{{ route('news.show', $article) }}",
            "name": "{{ $article->title }}"
        }{{ $loop->last ? '' : ',' }}
        @endforeach
    ]
}
</script>
@endsection
```

---

## Organization Schema

### Home Page or Site-wide

**Add to main layout or home controller:**

```php
public function home()
{
    $seoService = app(\App\Services\SeoService::class);
    
    $organizationData = $seoService->generateOrganizationStructuredData();
    
    return view('portal.home', [
        'organizationStructuredData' => $organizationData,
    ]);
}
```

**Or add directly to layout footer:**
```blade
{{-- In layouts/app.blade.php footer --}}
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "FPSociety",
    "url": "{{ config('app.url') }}",
    "logo": "{{ asset('images/logo.png') }}",
    "description": "FPSociety is the ultimate gaming community for Counter Strike 2, GTA V, Fortnite, Call of Duty and more.",
    "sameAs": [
        "https://twitter.com/fpsociety",
        "https://facebook.com/fpsociety"
    ]
}
</script>
```

---

## Testing Your Implementation

### 1. Rich Results Test
```
https://search.google.com/test/rich-results
```
Paste your URL and validate all structured data.

### 2. Schema Validator
```
https://validator.schema.org/
```
Paste your JSON-LD to validate syntax.

### 3. Facebook Debugger
```
https://developers.facebook.com/tools/debug/
```
Test Open Graph tags.

### 4. Twitter Card Validator
```
https://cards-dev.twitter.com/validator
```
Test Twitter Card tags.

---

## Best Practices

### 1. Always Provide Fallbacks
```php
'image' => $news->featured_image ?? asset('images/og-image-news.jpg'),
```

### 2. Validate Dates
```php
'datePublished' => $news->published_at->toIso8601String(),
```

### 3. Sanitize Descriptions
```php
'description' => substr(strip_tags($news->content), 0, 160),
```

### 4. Use Appropriate Types
- News articles → `Article`
- Events → `Event`
- Videos → `VideoObject`
- Profiles → `Person`
- Products/Deals → `Product`

### 5. Keep Keywords Relevant
```php
'keywords' => implode(', ', $news->tags ?: ['gaming', 'news']),
```

### 6. Set Canonical URLs
```php
'canonicalUrl' => route('news.show', $news),
```

---

## Troubleshooting

### Issue: Structured Data Not Showing
**Solution:** 
- Clear cache: `php artisan cache:clear`
- Check JSON syntax with validator
- Ensure data is being passed to view

### Issue: Wrong Image Showing
**Solution:**
- Verify image path is absolute URL
- Check image exists and is accessible
- Minimum size: 200x200px recommended

### Issue: Duplicate Schema
**Solution:**
- Only include structured data once per page
- Check if layout already includes schema
- Use `@once` directive if needed

---

## Quick Reference

### Controller Pattern
```php
$seoService = app(\App\Services\SeoService::class);
$seoData = $seoService->generateMetaTags([...]);
return view('...', compact('seoData'));
```

### View Pattern
```blade
@extends('layouts.app')
{{-- seoData automatically used by layout --}}
```

### Additional Schema
```blade
<script type="application/ld+json">
    {!! json_encode($structuredData) !!}
</script>
```

---

**Last Updated:** December 11, 2024  
**Version:** 1.0
