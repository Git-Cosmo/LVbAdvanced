# LVbAdvanced - Modern Forum Platform in Laravel 12

A modern forum platform with integrated portal built with Laravel 12, inspired by the classic vBadvanced CMPS.

![Portal Homepage](https://github.com/user-attachments/assets/1cc6c754-78d9-4317-b3cf-d44465b5a060)

## Features

### Core System
- ✅ **Laravel 12** with PHP 8.4
- ✅ **Clean Architecture** - Standard Laravel structure with Blade templates
- ✅ **Shared Layout System** - Consistent UI across portal and forum
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
- ✅ **Clean Homepage** - Responsive homepage with feature showcase and stats
- ✅ **SEO Friendly** - Meta tags, clean URLs, sitemap support

### Admin Panel
- ✅ **Custom Admin Interface** - No external UI packages
- ✅ **Dashboard** - Forum statistics and quick actions
- ✅ **Forum Management** - Create and manage categories and forums
- ✅ **User Management** - Role-based permissions
- ✅ **Moderation Tools** - Handle reports, warnings, and bans
- ✅ **Activity Monitoring** - System logs

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

### Layout Structure
The application uses a shared Blade layout located at `resources/views/layouts/app.blade.php` that provides:
- Responsive navigation with dark/light mode toggle
- User authentication menu
- Search functionality
- Secondary navigation bar
- Footer with site information

All portal and forum pages extend this layout using standard Blade `@extends('layouts.app')` syntax.

### Portal
The portal homepage is a static Blade template (`resources/views/portal/home.blade.php`) that displays:
- Hero section with call-to-action
- Feature cards highlighting system capabilities
- Live statistics (users, forums, threads, posts)
- Registration/login prompts for guests

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
