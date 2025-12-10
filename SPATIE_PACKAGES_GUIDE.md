# Spatie Packages Implementation Guide

This document provides comprehensive information about all Spatie packages used in FPSociety, their implementation details, and usage examples.

## Table of Contents
1. [laravel-permission](#1-laravel-permission)
2. [laravel-activitylog](#2-laravel-activitylog)
3. [laravel-medialibrary](#3-laravel-medialibrary)
4. [laravel-sluggable](#4-laravel-sluggable)
5. [laravel-tags](#5-laravel-tags)
6. [laravel-sitemap](#6-laravel-sitemap)
7. [laravel-image-optimizer](#7-laravel-image-optimizer)
8. [laravel-cookie-consent](#8-laravel-cookie-consent)

---

## 1. laravel-permission

### Overview
Role-based access control (RBAC) system with 8 predefined gaming community roles and 52 granular permissions.

### Configuration
**File:** `config/permission.php`

### Models Using This Package
- `App\Models\User`

### Implementation Details

#### Roles
1. **Administrator** - 52 permissions (full access)
2. **Super Moderator** - 38 permissions
3. **Moderator** - 35 permissions
4. **VIP Member** - 23 permissions
5. **Clan Leader** - 22 permissions
6. **Tournament Organizer** - 23 permissions
7. **Registered** - 21 permissions (default)
8. **Guest** - 7 permissions (read-only)

#### Usage Examples

```php
// Assign role to user
$user->assignRole('Moderator');

// Check if user has permission
if ($user->hasPermissionTo('edit any post')) {
    // User can edit any post
}

// Check if user has role
if ($user->hasRole('Administrator')) {
    // User is an admin
}

// Sync multiple roles
$user->syncRoles(['Moderator', 'VIP Member']);

// Get all permissions for user
$permissions = $user->getAllPermissions();
```

#### Middleware Usage

```php
// In routes/web.php
Route::middleware(['auth', 'role:Administrator'])->group(function () {
    // Admin routes
});

Route::middleware(['auth', 'permission:edit posts'])->group(function () {
    // Routes requiring specific permission
});
```

### Database Tables
- `roles` - Stores role definitions
- `permissions` - Stores permission definitions
- `model_has_roles` - Pivot table for user-role relationships
- `model_has_permissions` - Pivot table for direct user permissions
- `role_has_permissions` - Pivot table for role-permission relationships

---

## 2. laravel-activitylog

### Overview
Comprehensive activity logging and audit trail system tracking all admin actions.

### Configuration
**File:** `config/activitylog.php`

### Implementation Locations

#### Admin Controllers
- `app/Http/Controllers/Admin/UserManagementController.php`
  - User updates and role changes
  - Profile updates
  - Achievement grants
- `app/Http/Controllers/Admin/ForumManagementController.php`
  - Forum category creation
  - Forum creation
- `app/Http/Controllers/Admin/NewsManagementController.php`
  - News creation, updates, and deletion

#### Services
- `app/Services/ReputationService.php`
  - XP awards
  - Level ups

### Usage Examples

```php
// Log a simple activity
activity()->log('User logged in');

// Log with causer and subject
activity()
    ->causedBy(auth()->user())
    ->performedOn($forum)
    ->log('forum_created');

// Log with additional properties
activity()
    ->causedBy(auth()->user())
    ->performedOn($user)
    ->withProperties(['old_role' => 'Member', 'new_role' => 'Moderator'])
    ->log('role_changed');

// Retrieve activities
$activities = Activity::all();
$userActivities = Activity::causedBy($user)->get();
$forumActivities = Activity::forSubject($forum)->get();
```

### Logged Actions
- `user_updated` - User account changes
- `user_profile_updated` - Profile modifications
- `achievement_granted` - Achievement awards
- `forum_category_created` - New categories
- `forum_created` - New forums
- `news_created` - News article creation
- `news_updated` - News article updates
- `news_deleted` - News article deletion
- `xp_awarded` - XP grants
- `level_up` - User level increases

### Database Tables
- `activity_log` - Stores all activity records

---

## 3. laravel-medialibrary

### Overview
Advanced media management with automatic conversions and image optimization.

### Configuration
**File:** `config/media-library.php`

### Models Using This Package
- `App\Models\User`
- `App\Models\User\Gallery`
- `App\Models\News`

### Implementation Details

#### User Model
**Collections:**
- `avatar` - User profile pictures
  - Single file collection
  - Conversions: thumb (150x150), profile (400x400)
  - Optimized on upload

```php
// Add avatar
$user->addMedia($file)
    ->toMediaCollection('avatar');

// Get avatar URL
$avatarUrl = $user->getFirstMediaUrl('avatar');
$thumbUrl = $user->getFirstMediaUrl('avatar', 'thumb');
```

#### Gallery Model
**Collections:**
- `gallery-images` - Gallery photos
  - Multiple images
  - Conversions: thumb (300x300), preview (800x600)
  - Optimized on upload
- `downloads` - Downloadable files

```php
// Add gallery image
$gallery->addMedia($file)
    ->toMediaCollection('gallery-images');

// Get all gallery images
$images = $gallery->getMedia('gallery-images');

// Add downloadable file
$gallery->addMedia($file)
    ->toMediaCollection('downloads');
```

#### News Model
**Collections:**
- `featured-image` - News article images
  - Single file collection
  - Conversions: thumb (400x300), large (1200x630)
  - Optimized on upload

```php
// Add featured image
$news->addMedia($file)
    ->toMediaCollection('featured-image');

// Get featured image
$imageUrl = $news->getFirstMediaUrl('featured-image', 'large');
```

### Database Tables
- `media` - Stores media file records
- Standard polymorphic relationships via `model_type` and `model_id`

---

## 4. laravel-sluggable

### Overview
Automatic SEO-friendly URL slug generation for content models.

### Models Using This Package
- `App\Models\Forum\Forum`
- `App\Models\Forum\ForumThread`
- `App\Models\User\Gallery`
- `App\Models\News`

### Implementation Details

#### Forum Model
```php
public function getSlugOptions(): SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('name')
        ->saveSlugsTo('slug');
}
```

#### ForumThread Model
```php
public function getSlugOptions(): SlugOptions
{
    return SlugOptions::create()
        ->generateSlugsFrom('title')
        ->saveSlugsTo('slug')
        ->doNotGenerateSlugsOnUpdate(); // Preserve original slug
}
```

### Usage Examples

```php
// Automatic slug generation on create
$forum = Forum::create([
    'name' => 'Counter Strike 2 Discussion'
]);
// slug: counter-strike-2-discussion

$thread = ForumThread::create([
    'title' => 'Best Maps for Competitive Play'
]);
// slug: best-maps-for-competitive-play

// Access via slug in routes
Route::get('/forum/{forum:slug}', [ForumController::class, 'show']);
```

### Route Model Binding
All models use slug as route key:

```php
public function getRouteKeyName(): string
{
    return 'slug';
}
```

---

## 5. laravel-tags

### Overview
Flexible polymorphic tagging system for content organization.

### Configuration
**File:** `config/tags.php`

### Models Using This Package
- `App\Models\Forum\ForumThread`
- `App\Models\User\Gallery`
- `App\Models\News`

### Usage Examples

```php
// Attach single tag
$thread->attachTag('cs2');

// Attach multiple tags
$thread->attachTags(['cs2', 'competitive', 'maps']);

// Sync tags (removes old, adds new)
$thread->syncTags(['cs2', 'competitive']);

// Get all tags
$tags = $thread->tags;

// Get items with specific tag
$cs2Threads = ForumThread::withAnyTags(['cs2'])->get();
$competitiveContent = ForumThread::withAllTags(['cs2', 'competitive'])->get();

// Remove tags
$thread->detachTag('cs2');
$thread->detachTags(['competitive', 'maps']);

// Tag with type
$thread->attachTag('featured', 'special');
```

### Auto-Tagging
RSS news imports automatically extract and attach tags from feed content.

### Database Tables
- `tags` - Stores tag definitions
- `taggables` - Polymorphic pivot table

---

## 6. laravel-sitemap

### Overview
Automatic XML sitemap generation for search engine optimization.

### Configuration
**File:** `config/sitemap.php`

### Implementation
**Controller:** `app/Http/Controllers/SitemapController.php`  
**Route:** `/sitemap.xml`

### Sitemap Contents

1. **Homepage** - Priority: 1.0, Daily updates
2. **Static Pages** - Priority: 0.7-0.9
   - Forum index
   - Media gallery
   - Activity feed
   - Leaderboard
3. **Forums** - Priority: 0.8, Hourly updates
   - All active forum categories
4. **Threads** - Priority: 0.6, Daily updates
   - 1000 most recent threads
   - Excludes hidden threads
5. **News** - Priority: 0.7, Weekly updates
   - 500 most recent published articles
6. **Galleries** - Priority: 0.6, Weekly updates
   - 500 most recent galleries

### Usage Examples

```php
// Access sitemap
// https://yoursite.com/sitemap.xml

// Manual generation (if needed)
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

$sitemap = Sitemap::create()
    ->add(Url::create('/page')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(0.8))
    ->writeToFile(public_path('sitemap.xml'));
```

### SEO Benefits
- Automatic discovery of all public content
- Proper priority and update frequency signals
- Search engine indexing optimization
- Better crawl efficiency

---

## 7. laravel-image-optimizer

### Overview
Automatic image optimization on upload to reduce file sizes.

### Configuration
**File:** `config/image-optimizer.php`

### Integration
Works seamlessly with laravel-medialibrary to optimize all uploaded images automatically.

### Optimizers Used
- **JpegOptim** - JPEG optimization
- **Pngquant** - PNG optimization
- **Optipng** - PNG optimization (lossless)
- **Svgo** - SVG optimization
- **Gifsicle** - GIF optimization
- **WebP** - WebP optimization

### Configuration Options

```php
// config/image-optimizer.php
return [
    'optimizers' => [
        Jpegoptim::class => [
            '--max=85',
            '--strip-all',
            '--all-progressive',
        ],
        Pngquant::class => [
            '--force',
            '--quality=85-100',
        ],
        // ... other optimizers
    ],
];
```

### Usage
Optimization happens automatically when using Media Library:

```php
// Images are automatically optimized on upload
$user->addMedia($file)->toMediaCollection('avatar');
$gallery->addMedia($image)->toMediaCollection('gallery-images');
```

### Benefits
- Reduced bandwidth usage
- Faster page load times
- Better user experience
- Reduced storage costs
- No quality loss with proper settings

---

## 8. laravel-cookie-consent

### Overview
GDPR-compliant cookie consent banner.

### Configuration
**File:** `config/cookie-consent.php`

### Customization
**Views:** `resources/views/vendor/cookie-consent/`

### Implementation
Added to main layout: `resources/views/layouts/app.blade.php`

```blade
@include('cookie-consent::index')
```

### Configuration Options

```php
// config/cookie-consent.php
return [
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),
    'cookie_name' => 'laravel_cookie_consent',
    'cookie_lifetime' => 365 * 20, // 20 years
];
```

### Customization

The cookie consent dialog has been customized to match the dark theme:

```blade
<!-- Dark theme styling -->
<div class="bg-gray-800 border border-gray-700 shadow-lg">
    <p class="text-gray-300">
        {!! trans('cookie-consent::texts.message') !!}
    </p>
    <button class="bg-indigo-600 hover:bg-indigo-700">
        {{ trans('cookie-consent::texts.agree') }}
    </button>
</div>
```

### Translation
Update cookie consent text in `resources/lang/*/cookie-consent.php`:

```php
return [
    'message' => 'We use cookies to enhance your gaming experience. By using our site, you agree to our use of cookies.',
    'agree' => 'I Agree',
];
```

---

## Best Practices

### 1. Activity Logging
- Log all admin actions that modify data
- Include relevant context in properties
- Use meaningful log names
- Always specify causer and subject

### 2. Media Library
- Define clear media collections for each model
- Always optimize images on upload
- Create appropriate conversions for different use cases
- Use descriptive collection names

### 3. Tagging
- Use lowercase tags for consistency
- Sync instead of attach when updating all tags
- Implement tag suggestion/autocomplete in UI
- Periodically clean unused tags

### 4. Slugs
- Never change slug generation rules after launch
- Use `doNotGenerateSlugsOnUpdate()` for content that should keep original slugs
- Ensure slugs are unique within their context

### 5. Sitemap
- Keep sitemap size under 50,000 URLs
- Update lastmod accurately
- Set appropriate change frequencies
- Use priority values consistently

### 6. Permissions
- Follow principle of least privilege
- Group related permissions logically
- Document permission purposes
- Regularly audit role permissions

---

## Maintenance Tasks

### Activity Log
```bash
# Clean old activity logs (older than 90 days)
php artisan activitylog:clean
```

### Media Library
```bash
# Regenerate media conversions
php artisan media-library:regenerate

# Clean deleted media
php artisan media-library:clean
```

### Sitemap
```bash
# Manually generate sitemap (if using command instead of route)
php artisan sitemap:generate
```

### Permissions
```bash
# Cache permissions
php artisan permission:cache-reset
```

---

## Troubleshooting

### Media Library Issues
- Ensure storage is linked: `php artisan storage:link`
- Check disk configuration in `config/filesystems.php`
- Verify directory permissions (storage/app/public)

### Permission Issues
- Clear permission cache: `php artisan permission:cache-reset`
- Verify role and permission seeding
- Check middleware configuration

### Image Optimizer
- Install optimizer binaries on server
- Check paths in config if using custom locations
- Verify file permissions for optimizer execution

### Cookie Consent
- Clear browser cookies to test
- Check JavaScript console for errors
- Verify blade directive is in layout

---

## Package Versions

```json
{
    "spatie/laravel-permission": "^6.23",
    "spatie/laravel-activitylog": "^4.10",
    "spatie/laravel-medialibrary": "^11.17",
    "spatie/laravel-sluggable": "^3.7",
    "spatie/laravel-tags": "^4.10",
    "spatie/laravel-sitemap": "^7.3",
    "spatie/laravel-image-optimizer": "^1.8",
    "spatie/laravel-cookie-consent": "^3.3"
}
```

---

## Additional Resources

- [Spatie Documentation](https://spatie.be/docs)
- [Laravel Documentation](https://laravel.com/docs)
- Project README: `README.md`
- Implementation Summary: `IMPLEMENTATION_COMPLETE.md`
