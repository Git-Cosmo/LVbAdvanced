# LVbAdvanced - vBadvanced-Style Portal System in Laravel 12

A modern, modular, block-based portal system with integrated forum platform built with Laravel 12, inspired by the classic vBadvanced CMPS.

![Portal Homepage](https://github.com/user-attachments/assets/1cc6c754-78d9-4317-b3cf-d44465b5a060)

## Features

### Core System
- ✅ **Laravel 12** with PHP 8.4
- ✅ **Modular Architecture** - Clean separation of concerns
- ✅ **Block Engine** - Flexible, extensible block system with caching
- ✅ **Three-Column Layout** - Left/Center/Right column support + full-width blocks
- ✅ **Role-Based Access Control** - Using Spatie Permission
- ✅ **Activity Logging** - Track admin actions with Spatie Activity Log
- ✅ **Media Library** - File management with Spatie Media Library

### Forum System
- ✅ **Categories & Forums** - Hierarchical forum structure with subforums
- ✅ **Threads & Posts** - Full-featured discussion system
- ✅ **User Profiles** - Extended profiles with XP, levels, and karma
- ✅ **Reactions System** - Like and react to posts
- ✅ **Polls** - Create polls in threads
- ✅ **Subscriptions** - Subscribe to threads and forums
- ✅ **Attachments** - Upload files to posts
- ✅ **BBCode Support** - Rich text formatting
- ✅ **Moderation Tools** - Report system, warnings, bans
- ✅ **Gamification** - XP, levels, badges, achievements
- 🚧 **Search** - Full-text search (coming soon)
- 🚧 **Private Messaging** - Direct messages between users (coming soon)
- 🚧 **Real-time Notifications** - WebSocket notifications (coming soon)

### Frontend
- ✅ **TailwindCSS** - Modern, responsive design
- ✅ **Alpine.js** - Lightweight JavaScript framework
- ✅ **Block-Based Layout** - Dynamic homepage with configurable blocks
- ✅ **SEO Friendly** - Meta tags, clean URLs, sitemap support

### Admin Panel
- ✅ **Custom Admin Interface** - No external UI packages
- ✅ **Dashboard** - Statistics and quick actions
- ✅ **Page Management** - Full CRUD operations
- ✅ **Block Management** - Create and configure blocks
- ✅ **User Management** - Role-based permissions
- ✅ **Activity Monitoring** - System logs

### Block Types
- ✅ Custom HTML Block - Display custom HTML content
- ✅ Latest News Block - Display latest news articles
- ✅ Latest Threads Block - Display latest forum threads
- ✅ Link List Block - Display a list of links with icons
- ✅ Stats Block - Display site statistics with colorful cards
- ✅ Recent Activity Block - Display recent system activity logs
- ✅ Advertisement Block - Display advertisements (image, text, or ad code)

## Installation

1. **Clone repository**
   ```bash
   git clone https://github.com/Git-Cosmo/LVbAdvanced.git
   cd LVbAdvanced
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run migrations**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start server**
   ```bash
   php artisan serve
   ```

7. **Access**
   - Portal: http://localhost:8000
   - Forums: http://localhost:8000/forum
   - Admin: http://localhost:8000/login
   - Credentials: admin@example.com / password

## Architecture

### Forum System
The forum system is built using standard Laravel architecture:

- **Models**: `app/Models/Forum/` and `app/Models/User/`
- **Controllers**: `app/Http/Controllers/Forum/`
- **Services**: `app/Services/Forum/`
- **Policies**: `app/Policies/Forum/`
- **Views**: `resources/views/forum/`
- **Migrations**: `database/migrations/`

#### Key Features:
- **Forum Categories** - Organize forums into categories
- **Forums** - Create unlimited forums with subforums
- **Threads** - Users can create threads in forums
- **Posts** - Reply to threads with rich content
- **User Profiles** - Extended profiles with gamification
- **Reactions** - React to posts with emojis
- **Polls** - Create polls in threads
- **Subscriptions** - Get notified of new posts
- **Moderation** - Report, warn, and ban users

### Block System
Blocks are modular components that can be placed on pages. Create new blocks by:

1. Extending `AbstractBlock` class
2. Registering in `PortalServiceProvider`
3. Creating a Blade template

Example:
```php
class MyBlock extends AbstractBlock {
    public function getType(): string { return 'my_block'; }
    public function getName(): string { return 'My Block'; }
    public function getData(Block $block): array { return []; }
    public function getTemplate(): string { return 'portal.blocks.my-block'; }
}
```

## Database Structure

### Forum Tables
- `forum_categories` - Forum categories
- `forums` - Forums and subforums
- `forum_threads` - Discussion threads
- `forum_posts` - Post replies
- `forum_polls` - Thread polls
- `forum_poll_options` - Poll options
- `forum_poll_votes` - Poll votes
- `forum_reactions` - Reactions (likes, etc.)
- `forum_subscriptions` - Thread/forum subscriptions
- `forum_attachments` - File attachments
- `forum_reports` - Moderation reports

### User Tables
- `user_profiles` - Extended user profiles
- `user_follows` - User following system
- `user_badges` - Achievement badges
- `user_achievements` - User achievements
- `user_warnings` - Moderation warnings
- `user_bans` - User bans
- `profile_posts` - Profile wall posts
- `private_messages` - Direct messages

## Spatie Packages
- laravel-permission
- laravel-settings
- laravel-medialibrary
- laravel-sitemap
- laravel-backup
- laravel-activitylog
- laravel-menu

## License
Open-source software.
