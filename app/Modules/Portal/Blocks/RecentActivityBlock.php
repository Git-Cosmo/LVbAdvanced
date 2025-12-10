<?php

namespace App\Modules\Portal\Blocks;

use App\Models\Block;
use Spatie\Activitylog\Models\Activity;

class RecentActivityBlock extends AbstractBlock
{
    public function getType(): string
    {
        return 'recent_activity';
    }

    public function getName(): string
    {
        return 'Recent Activity';
    }

    public function getDescription(): string
    {
        return 'Display recent activity logs from the system';
    }

    public function getData(Block $block): array
    {
        $limit = $this->getSetting($block, 'limit', 10);
        $showCauser = $this->getSetting($block, 'show_causer', true);
        $showTime = $this->getSetting($block, 'show_time', true);

        // Fetch recent activities
        $activities = Activity::query()
            ->with('causer')
            ->latest()
            ->take($limit)
            ->get()
            ->map(function ($activity) {
                return [
                    'id' => $activity->id,
                    'description' => $activity->description ?? 'Activity',
                    'subject_type' => $activity->subject_type ? class_basename($activity->subject_type) : null,
                    'subject_id' => $activity->subject_id,
                    'causer_name' => $activity->causer?->name ?? 'System',
                    'event' => $activity->event ?? 'action',
                    'created_at' => $activity->created_at,
                ];
            });

        return [
            'activities' => $activities,
            'showCauser' => $showCauser,
            'showTime' => $showTime,
        ];
    }

    public function getTemplate(): string
    {
        return 'portal.blocks.recent-activity';
    }

    public function getConfigFields(): array
    {
        return [
            'limit' => [
                'type' => 'number',
                'label' => 'Number of activities',
                'default' => 10,
                'min' => 1,
                'max' => 50,
            ],
            'show_causer' => [
                'type' => 'checkbox',
                'label' => 'Show who performed the action',
                'default' => true,
            ],
            'show_time' => [
                'type' => 'checkbox',
                'label' => 'Show time',
                'default' => true,
            ],
        ];
    }
}
