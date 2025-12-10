<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;

class AdvertisementBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'advertisement';
    }

    public function getName(): string
    {
        return 'Advertisement';
    }

    public function getDescription(): string
    {
        return 'Display advertisements or promotional content';
    }

    public function getData(Block $block): array
    {
        $adType = $this->getSetting($block, 'ad_type', 'image');
        $imageUrl = $this->getSetting($block, 'image_url', '');
        $linkUrl = $this->getSetting($block, 'link_url', '');
        $title = $this->getSetting($block, 'title', '');
        $description = $this->getSetting($block, 'description', '');
        $ctaText = $this->getSetting($block, 'cta_text', 'Learn More');
        $adCode = $this->getSetting($block, 'ad_code', '');
        $openInNewTab = $this->getSetting($block, 'open_in_new_tab', true);
        
        return [
            'adType' => $adType,
            'imageUrl' => $imageUrl,
            'linkUrl' => $linkUrl,
            'title' => $title,
            'description' => $description,
            'ctaText' => $ctaText,
            'adCode' => $adCode,
            'target' => $openInNewTab ? '_blank' : '_self',
        ];
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.advertisement';
    }

    public function getConfigFields(): array
    {
        return [
            'ad_type' => [
                'type' => 'select',
                'label' => 'Advertisement Type',
                'options' => [
                    'image' => 'Image Banner',
                    'text' => 'Text Ad',
                    'code' => 'Ad Code (HTML/JavaScript)',
                ],
                'default' => 'image',
            ],
            'title' => [
                'type' => 'text',
                'label' => 'Title',
                'help' => 'For text ads',
            ],
            'description' => [
                'type' => 'textarea',
                'label' => 'Description',
                'help' => 'For text ads',
            ],
            'image_url' => [
                'type' => 'text',
                'label' => 'Image URL',
                'help' => 'For image ads',
            ],
            'link_url' => [
                'type' => 'text',
                'label' => 'Link URL',
                'help' => 'Where the ad should link to',
            ],
            'cta_text' => [
                'type' => 'text',
                'label' => 'Call to Action Text',
                'default' => 'Learn More',
                'help' => 'Button text for text ads',
            ],
            'open_in_new_tab' => [
                'type' => 'checkbox',
                'label' => 'Open link in new tab',
                'default' => true,
            ],
            'ad_code' => [
                'type' => 'textarea',
                'label' => 'Ad Code',
                'help' => 'HTML or JavaScript code for third-party ads (Google AdSense, etc.)',
            ],
        ];
    }
}
