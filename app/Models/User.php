<?php

namespace App\Models;

use App\Models\Forum\ForumPost;
use App\Models\Forum\ForumThread;
use App\Models\User\ProfilePost;
use App\Models\User\UserAchievement;
use App\Models\User\UserBadge;
use App\Models\User\UserProfile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia as HasMediaInterface;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements MustVerifyEmail, HasMediaInterface, Searchable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'steam_id',
        'discord_id',
        'battlenet_id',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_active_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Get all threads created by the user.
     */
    public function threads(): HasMany
    {
        return $this->hasMany(ForumThread::class);
    }

    /**
     * Get all posts created by the user.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(ForumPost::class);
    }

    /**
     * Get all profile posts on the user's wall.
     */
    public function profilePosts(): HasMany
    {
        return $this->hasMany(ProfilePost::class, 'profile_user_id');
    }

    /**
     * Get the badges earned by the user.
     */
    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(UserBadge::class, 'badge_user', 'user_id', 'badge_id')
            ->withTimestamps()
            ->withPivot('awarded_at');
    }

    /**
     * Get the achievements earned by the user.
     */
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(UserAchievement::class, 'achievement_user', 'user_id', 'achievement_id')
            ->withTimestamps()
            ->withPivot(['progress', 'is_unlocked', 'unlocked_at']);
    }

    /**
     * Get the users that this user is following.
     */
    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id')
            ->withTimestamps();
    }

    /**
     * Get the users that are following this user.
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id')
            ->withTimestamps();
    }

    /**
     * Get the user's galleries.
     */
    public function galleries(): HasMany
    {
        return $this->hasMany(\App\Models\User\Gallery::class);
    }

    /**
     * Get the user's albums.
     */
    public function albums(): HasMany
    {
        return $this->hasMany(\App\Models\User\Album::class);
    }

    /**
     * Get subscribed forums
     */
    public function subscribedForums(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Forum\Forum::class, 'forum_subscriptions', 'user_id', 'forum_id')
            ->withTimestamps();
    }

    /**
     * Scope to get online users (active within last 15 minutes).
     */
    public function scopeOnline($query)
    {
        return $query->where('last_active_at', '>=', now()->subMinutes(15));
    }

    /**
     * Check if the user is online.
     */
    public function isOnline(): bool
    {
        return $this->last_active_at && $this->last_active_at->diffInMinutes(now()) <= 15;
    }

    /**
     * Register media collections for this model.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->useDisk('public')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    }

    /**
     * Register media conversions for this model.
     */
    public function registerMediaConversions(\Spatie\MediaLibrary\MediaCollections\Models\Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->optimize()
            ->performOnCollections('avatar');

        $this->addMediaConversion('profile')
            ->width(400)
            ->height(400)
            ->optimize()
            ->performOnCollections('avatar');
    }

    /**
     * Get the search result for this model.
     */
    public function getSearchResult(): SearchResult
    {
        return new SearchResult(
            $this,
            $this->name,
            route('profile.show', $this)
        );
    }
}
