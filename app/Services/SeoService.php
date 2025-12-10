<?php

namespace App\Services;

class SeoService
{
    /**
     * Generate SEO meta tags for a page
     */
    public function generateMetaTags(array $data = []): array
    {
        $defaults = [
            'title' => 'FPSociety - Ultimate Gaming Community for Counter Strike 2, GTA V, Fortnite & More',
            'description' => 'Join FPSociety, the premier online gaming community. Download custom maps, skins, and mods for Counter Strike 2, GTA V, Fortnite, Call of Duty. Share gameplay, connect with gamers, compete in tournaments.',
            'keywords' => 'gaming community, FPSociety, Counter Strike 2, CS2, GTA V, Fortnite, Call of Duty, gaming forum, game mods, custom maps, game skins, gaming tournaments, esports, multiplayer games, gaming community online',
            'image' => asset('images/og-image.jpg'),
            'url' => url()->current(),
            'type' => 'website',
            'site_name' => 'FPSociety',
        ];

        $meta = array_merge($defaults, $data);

        return [
            // Basic Meta Tags
            'basic' => [
                'title' => $meta['title'],
                'description' => $meta['description'],
                'keywords' => $meta['keywords'],
            ],
            
            // Open Graph
            'og' => [
                'og:title' => $meta['title'],
                'og:description' => $meta['description'],
                'og:image' => $meta['image'],
                'og:url' => $meta['url'],
                'og:type' => $meta['type'],
                'og:site_name' => $meta['site_name'],
            ],
            
            // Twitter Card
            'twitter' => [
                'twitter:card' => 'summary_large_image',
                'twitter:title' => $meta['title'],
                'twitter:description' => $meta['description'],
                'twitter:image' => $meta['image'],
            ],
            
            // Structured Data (JSON-LD)
            'structured' => $this->generateStructuredData($meta),
        ];
    }

    /**
     * Generate structured data for rich snippets
     */
    protected function generateStructuredData(array $meta): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => 'FPSociety',
            'url' => config('app.url'),
            'description' => $meta['description'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => config('app.url') . '/forum/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * Generate gaming-specific meta tags for thread/post
     */
    public function generateGamingContentMeta(string $game, string $title, string $description): array
    {
        return $this->generateMetaTags([
            'title' => $title . ' - ' . $game . ' | FPSociety Gaming Community',
            'description' => $description,
            'keywords' => $game . ', gaming, mods, custom maps, skins, ' . strtolower($title) . ', FPSociety',
            'type' => 'article',
        ]);
    }
}
