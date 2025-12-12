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
        $structuredData = [
            '@context' => 'https://schema.org',
            '@type' => $meta['schema_type'] ?? 'WebSite',
            'name' => 'FPSociety',
            'url' => $meta['url'] ?? url()->current(),
            'description' => $meta['description'],
        ];

        // Add search action for website type
        if (! isset($meta['schema_type']) || $meta['schema_type'] === 'WebSite') {
            $structuredData['potentialAction'] = [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => config('app.url').'/search?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ];
        }

        // Add additional properties based on type
        if (isset($meta['author'])) {
            $structuredData['author'] = [
                '@type' => 'Person',
                'name' => $meta['author'],
            ];
        }

        if (isset($meta['datePublished'])) {
            $structuredData['datePublished'] = $meta['datePublished'];
        }

        if (isset($meta['dateModified'])) {
            $structuredData['dateModified'] = $meta['dateModified'];
        }

        if (isset($meta['image'])) {
            $structuredData['image'] = $meta['image'];
        }

        return $structuredData;
    }

    /**
     * Generate gaming-specific meta tags for thread/post
     */
    public function generateGamingContentMeta(string $game, string $title, string $description): array
    {
        return $this->generateMetaTags([
            'title' => $title.' - '.$game.' | FPSociety Gaming Community',
            'description' => $description,
            'keywords' => $game.', gaming, mods, custom maps, skins, '.strtolower($title).', FPSociety',
            'type' => 'article',
        ]);
    }

    /**
     * Generate Article structured data (for news, blog posts, forum threads)
     */
    public function generateArticleStructuredData(array $data): array
    {
        $defaults = [
            'headline' => '',
            'description' => '',
            'author' => '',
            'datePublished' => now()->toIso8601String(),
            'dateModified' => now()->toIso8601String(),
            'image' => asset('images/og-image.jpg'),
            'url' => url()->current(),
        ];

        $article = array_merge($defaults, $data);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $article['headline'],
            'description' => $article['description'],
            'author' => [
                '@type' => 'Person',
                'name' => $article['author'],
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'FPSociety',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png'),
                ],
            ],
            'datePublished' => $article['datePublished'],
            'dateModified' => $article['dateModified'],
            'image' => $article['image'],
            'url' => $article['url'],
        ];
    }

    /**
     * Generate BreadcrumbList structured data
     */
    public function generateBreadcrumbStructuredData(array $items): array
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    /**
     * Generate Organization structured data
     */
    public function generateOrganizationStructuredData(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'FPSociety',
            'url' => config('app.url'),
            'logo' => asset('images/logo.png'),
            'description' => 'FPSociety is the ultimate gaming community for Counter Strike 2, GTA V, Fortnite, Call of Duty and more.',
            'sameAs' => [
                // Add social media links here when available
            ],
        ];
    }

    /**
     * Generate VideoObject structured data
     */
    public function generateVideoStructuredData(array $data): array
    {
        $defaults = [
            'name' => '',
            'description' => '',
            'thumbnailUrl' => '',
            'uploadDate' => now()->toIso8601String(),
            'contentUrl' => '',
            'embedUrl' => '',
        ];

        $video = array_merge($defaults, $data);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'VideoObject',
            'name' => $video['name'],
            'description' => $video['description'],
            'thumbnailUrl' => $video['thumbnailUrl'],
            'uploadDate' => $video['uploadDate'],
            'contentUrl' => $video['contentUrl'],
            'embedUrl' => $video['embedUrl'],
        ];
    }

    /**
     * Generate Event structured data
     */
    public function generateEventStructuredData(array $data): array
    {
        $defaults = [
            'name' => '',
            'description' => '',
            'startDate' => '',
            'endDate' => '',
            'location' => '',
            'image' => asset('images/og-image.jpg'),
            'url' => url()->current(),
        ];

        $event = array_merge($defaults, $data);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Event',
            'name' => $event['name'],
            'description' => $event['description'],
            'startDate' => $event['startDate'],
            'endDate' => $event['endDate'],
            'location' => [
                '@type' => 'VirtualLocation',
                'url' => $event['location'],
            ],
            'image' => $event['image'],
            'url' => $event['url'],
            'organizer' => [
                '@type' => 'Organization',
                'name' => 'FPSociety',
                'url' => config('app.url'),
            ],
        ];
    }
}
