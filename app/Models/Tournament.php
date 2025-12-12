<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Spatie\Tags\HasTags;

class Tournament extends Model
{
    use HasSlug, SoftDeletes, LogsActivity, HasTags;

    protected $fillable = [
        'user_id',
        'game_server_id',
        'name',
        'slug',
        'description',
        'game',
        'format',
        'type',
        'team_size',
        'max_participants',
        'current_participants',
        'status',
        'prize_pool',
        'prize_currency',
        'prize_distribution',
        'registration_opens_at',
        'registration_closes_at',
        'check_in_starts_at',
        'check_in_ends_at',
        'starts_at',
        'ends_at',
        'rules',
        'settings',
        'is_public',
        'is_featured',
        'requires_approval',
        'cover_image',
    ];

    protected function casts(): array
    {
        return [
            'prize_distribution' => 'array',
            'rules' => 'array',
            'settings' => 'array',
            'is_public' => 'boolean',
            'is_featured' => 'boolean',
            'requires_approval' => 'boolean',
            'registration_opens_at' => 'datetime',
            'registration_closes_at' => 'datetime',
            'check_in_starts_at' => 'datetime',
            'check_in_ends_at' => 'datetime',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gameServer(): BelongsTo
    {
        return $this->belongsTo(GameServer::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(TournamentParticipant::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(TournamentMatch::class);
    }

    public function brackets(): HasMany
    {
        return $this->hasMany(TournamentBracket::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(TournamentAnnouncement::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(TournamentStaff::class);
    }

    public function checkIns(): HasMany
    {
        return $this->hasMany(TournamentCheckIn::class);
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
            ->orWhere('status', 'registration_open')
            ->where('starts_at', '>', now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Helper methods
    public function canRegister(): bool
    {
        if ($this->status !== 'registration_open') {
            return false;
        }

        if ($this->registration_closes_at && $this->registration_closes_at->isPast()) {
            return false;
        }

        return $this->current_participants < $this->max_participants;
    }

    public function canCheckIn(): bool
    {
        if (!$this->check_in_starts_at || !$this->check_in_ends_at) {
            return false;
        }

        return now()->between($this->check_in_starts_at, $this->check_in_ends_at);
    }

    public function isRegistrationOpen(): bool
    {
        return $this->status === 'registration_open' &&
            ($this->registration_closes_at === null || $this->registration_closes_at->isFuture());
    }

    public function incrementParticipants(): void
    {
        $this->increment('current_participants');
    }

    public function decrementParticipants(): void
    {
        $this->decrement('current_participants');
    }

    /**
     * Get tournament statistics.
     */
    public function getStatistics(): array
    {
        $matches = $this->matches;
        $participants = $this->participants;

        return [
            'total_matches' => $matches->count(),
            'completed_matches' => $matches->where('status', 'completed')->count(),
            'pending_matches' => $matches->where('status', 'pending')->count(),
            'ready_matches' => $matches->where('status', 'ready')->count(),
            'total_participants' => $participants->count(),
            'checked_in' => $participants->where('status', 'checked_in')->count(),
            'approved' => $participants->where('status', 'approved')->count(),
            'pending' => $participants->where('status', 'pending')->count(),
            'completion_percentage' => $matches->count() > 0 
                ? round(($matches->where('status', 'completed')->count() / $matches->count()) * 100, 1)
                : 0,
        ];
    }

    /**
     * Get tournament progress.
     */
    public function getProgress(): string
    {
        $stats = $this->getStatistics();
        
        if ($this->status === 'upcoming' || $this->status === 'registration_open') {
            return "Registration: {$stats['total_participants']}/{$this->max_participants} participants";
        }
        
        if ($this->status === 'in_progress') {
            return "Matches: {$stats['completed_matches']}/{$stats['total_matches']} completed ({$stats['completion_percentage']}%)";
        }
        
        if ($this->status === 'completed') {
            return "Tournament completed with {$stats['total_participants']} participants";
        }
        
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Activity log configuration.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'status', 'format', 'type', 'max_participants', 'prize_pool', 'starts_at'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => "Tournament '{$this->name}' was created",
                'updated' => "Tournament '{$this->name}' was updated",
                'deleted' => "Tournament '{$this->name}' was deleted",
                default => "Tournament '{$this->name}' was {$eventName}",
            });
    }
}
