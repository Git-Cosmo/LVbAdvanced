# FPSociety - Ultimate Gaming Community Platform

**FPSociety** is a feature-rich gaming community platform built with Laravel 12, designed for gamers who love Counter Strike 2, GTA V, Fortnite, Call of Duty, and more. Download custom maps, share mods, compete in tournaments, and connect with gamers worldwide!

![Login Page](https://github.com/user-attachments/assets/24376722-0e09-440c-940d-fea8d8165b76)
![Registration Page](https://github.com/user-attachments/assets/8c1b9fa8-af5b-470a-af57-409ad8917b0f)

## Features

### Core System
- ✅ **Laravel 12** with PHP 8.4
- ✅ **Clean Architecture** - Standard Laravel structure with Blade templates
- ✅ **Shared Layout System** - Consistent UI across portal and forum
- ✅ **Role-Based Access Control** - Using Spatie Permission with 8 gaming community roles
- ✅ **Comprehensive Permissions** - 52 granular permissions for complete access control
- ✅ **Activity Logging** - Track admin actions with Spatie Activity Log
- ✅ **Media Library** - File management with Spatie Media Library

### SEO & Branding
- ✅ **FPSociety Branding** - Gaming-focused community identity
- ✅ **Comprehensive SEO** - Open Graph, Twitter Cards, structured data (JSON-LD)
- ✅ **Gaming Keywords** - Optimized for Counter Strike 2, GTA V, Fortnite, Call of Duty searches
- ✅ **Dynamic Meta Tags** - SEO service for customizable page metadata
- ✅ **Search Engine Ready** - Built-in sitemap support and clean URLs

### Authentication & Security
- ✅ **User Registration** - Modern registration page with validation
- ✅ **Email Verification** - Verify user email addresses after registration
- ✅ **Password Reset** - Secure password reset via email
- ✅ **OAuth Authentication** - Login with Steam, Discord, or Battle.net
- ✅ **Two-Factor Authentication (2FA)** - Google Authenticator support for enhanced security
- ✅ **Modern UI/UX** - Beautiful, responsive authentication pages matching site design

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
- ✅ **Follow System** - Follow other users
- ✅ **Wall Posts** - Post on user profiles
- 🚧 **Search** - Full-text search (coming soon)
- 🚧 **Private Messaging** - Direct messages between users (coming soon)
- 🚧 **Real-time Notifications** - WebSocket notifications (coming soon)

### Reputation & Gamification System
- ✅ **XP & Leveling** - Earn experience points for all community activities
- ✅ **Karma System** - Track reputation based on likes and reactions
- ✅ **Level Progression** - Dynamic level calculation with XP thresholds
- ✅ **Custom Titles** - Automatic titles based on user level
- ✅ **Achievements** - Unlock achievements for milestones and special actions
- ✅ **Badges System** - Earn and display badges on your profile
- ✅ **Daily Streaks** - Rewards for consecutive daily logins
- ✅ **Posting Streaks** - Track and reward consistent posting
- ✅ **Leaderboards** - All-time, seasonal, and category-based rankings
- ✅ **XP Actions**:
  - Create Thread: 15 XP
  - Create Post: 10 XP
  - Receive Like: 5 XP
  - Daily Login: 5 XP
  - First Post: 25 XP (one-time)
  - Poll Creation: 10 XP
  - Poll Vote: 2 XP

### Activity Feeds
- ✅ **What's New** - Global feed of latest community activity
- ✅ **Trending** - Hot topics based on recent engagement
- ✅ **Recent Posts** - Latest replies across all forums
- ✅ **Recommended Content** - Personalized content based on user interests
- ✅ **Activity Caching** - Optimized feed performance with smart caching

### Media & Gallery System
- ✅ **Gaming Gallery** - GameBanana-style resource sharing
- ✅ **Game Resources** - Download custom maps, skins, mods, and textures
- ✅ **Supported Games**:
  - Counter Strike 2 (CS2) - Maps, skins, configs
  - GTA V - Mods, vehicles, scripts, textures
  - Fortnite - Skins, maps, creative content
  - Call of Duty - Custom maps and mods
  - Minecraft, Valorant, and more
- ✅ **Media Types**:
  - Images (JPG, PNG, GIF, WebP) with automatic optimization
  - Videos (MP4, WebM, MOV, AVI)
  - Audio (MP3, WAV, OGG, AAC)
  - Game Files (BSP, VPK, RPF, ZIP, RAR)
- ✅ **Image Optimization** - Automatic compression and thumbnail generation
- ✅ **Albums & Collections** - Organize media into albums
- ✅ **Download Tracking** - Track views and downloads
- ✅ **User Galleries** - Personal media libraries
- ✅ **Comments & Ratings** - Community feedback on content

### Frontend
- ✅ **TailwindCSS** - Modern, responsive design
- ✅ **Alpine.js** - Lightweight JavaScript framework
- ✅ **Clean Homepage** - Responsive homepage with feature showcase and stats
- ✅ **SEO Friendly** - Meta tags, clean URLs, sitemap support
- ✅ **Dark Mode** - Modern dark theme throughout the application

### Admin Panel
- ✅ **Custom Admin Interface** - No external UI packages
- ✅ **Modern Design** - Consistent with main site design aesthetic
- ✅ **Dashboard** - Forum statistics and quick actions
- ✅ **Forum Management** - Create and manage categories and forums
- ✅ **User Management** - Role-based permissions with badges and achievements
- ✅ **Moderation Tools** - Handle reports, warnings, and bans
- ✅ **Activity Monitoring** - System logs with Spatie Activity Log
- ✅ **Reputation Management**:
  - View top users by XP, karma, and posts
  - Award or deduct XP manually
  - Reset user levels and stats
  - Recalculate karma for all users
- ✅ **Media Management**:
  - Approve/reject uploaded content
  - Feature content on homepage
  - Delete inappropriate media
  - Monitor downloads and views
- ✅ **Gamification Controls**:
  - View seasonal leaderboards
  - Configure XP reward amounts
  - Reset seasonal rankings
  - Manage achievement criteria

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
   
   Update `.env` with your database and mail configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=lvbadvanced
   DB_USERNAME=root
   DB_PASSWORD=
   
   MAIL_MAILER=smtp
   MAIL_HOST=mailhog
   MAIL_PORT=1025
   MAIL_USERNAME=null
   MAIL_PASSWORD=null
   MAIL_FROM_ADDRESS="hello@example.com"
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
   - Gallery: http://localhost:8000/media
   - What's New: http://localhost:8000/activity/whats-new
   - Leaderboard: http://localhost:8000/leaderboard
   - Admin: http://localhost:8000/admin
   - Credentials: admin@example.com / password

## OAuth Configuration

The application supports authentication via Steam, Discord, and Battle.net. To enable OAuth:

### Steam
1. Get your Steam API key from https://steamcommunity.com/dev/apikey
2. Add to `.env`:
   ```env
   STEAM_API_KEY=your_steam_api_key_here
   ```

### Discord
1. Create an application at https://discord.com/developers/applications
2. Add OAuth2 redirect URI: `http://your-domain.com/auth/discord/callback`
3. Add to `.env`:
   ```env
   DISCORD_CLIENT_ID=your_client_id
   DISCORD_CLIENT_SECRET=your_client_secret
   ```

### Battle.net
1. Create an application at https://develop.battle.net/
2. Add OAuth2 redirect URI: `http://your-domain.com/auth/battlenet/callback`
3. Add to `.env`:
   ```env
   BATTLENET_CLIENT_ID=your_client_id
   BATTLENET_CLIENT_SECRET=your_client_secret
   BATTLENET_REGION=us
   ```

## Two-Factor Authentication (2FA)

Users can enable 2FA from their profile settings:

1. Navigate to Profile > Edit Profile
2. Click "Enable 2FA" in the Two-Factor Authentication section
3. Scan the QR code with Google Authenticator or any TOTP app
4. Enter the verification code to confirm setup
5. Save recovery codes in a secure location

To disable 2FA, users must enter their password for security confirmation.

## Roles & Permissions System

The platform includes a comprehensive role-based access control system inspired by vBulletin, with 8 predefined roles and 52 granular permissions.

### Gaming Community Roles

1. **Administrator** - Full system access (52 permissions)
   - Complete control over forums, users, and system settings
   - Access to admin panel and all moderation tools
   - Default credentials: `admin@example.com` / `password`

2. **Super Moderator** - Advanced moderation (38 permissions)
   - Full moderation capabilities across all forums
   - Can ban users, handle reports, and manage content
   - Cannot access system settings or manage roles

3. **Moderator** - Standard moderation (35 permissions)
   - Moderate specific forums and handle reports
   - Lock/pin threads and manage user warnings
   - Limited to assigned forum sections

4. **VIP Member** - Premium features (23 permissions)
   - Enhanced posting and profile features
   - Clan and tournament management
   - Special badges and privileges

5. **Clan Leader** - Clan management (22 permissions)
   - Create and manage gaming clans
   - Standard member permissions plus clan tools

6. **Tournament Organizer** - Event management (23 permissions)
   - Create and manage tournaments
   - Leaderboard and scoring access

7. **Registered** - Standard member (21 permissions)
   - Post, reply, and interact with content
   - Profile customization and social features
   - Default role for new users

8. **Guest** - Read-only access (7 permissions)
   - View forums and profiles
   - No posting or interaction capabilities

### Permission Categories

- **Forum Permissions**: View, create, edit, delete threads/posts
- **User Permissions**: Profile management, bans, warnings
- **Moderation**: Reports, mod queue, content approval
- **Admin**: System settings, roles, backups
- **Community**: Polls, reactions, messaging, follows
- **Gaming**: Clans, tournaments, leaderboards, scores

### Assigning Roles

```php
// Assign role to user
$user->assignRole('Moderator');

// Check permissions
if ($user->hasPermissionTo('edit any post')) {
    // User can edit any post
}

// Check role
if ($user->hasRole('Administrator')) {
    // User is an admin
}
```

## Email Configuration

For email verification and password reset functionality, configure your email settings in `.env`:

### Development (Mailhog)
```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```

### Production (SMTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
```

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

### FPSociety Architecture
The application is built using standard Laravel architecture with specialized gaming community features:

- **Models**: 
  - Forum: `app/Models/Forum/` (ForumThread, ForumPost, ForumReaction, etc.)
  - User: `app/Models/User/` (UserProfile, UserBadge, UserAchievement, Gallery, Album, Media)
- **Controllers**: 
  - Forum: `app/Http/Controllers/Forum/`
  - Auth: `app/Http/Controllers/Auth/`
  - Admin: `app/Http/Controllers/Admin/`
  - Activity: `app/Http/Controllers/ActivityFeedController.php`
  - Media: `app/Http/Controllers/MediaController.php`
- **Services**: 
  - Forum: `app/Services/Forum/`
  - Core: `app/Services/` (SeoService, ReputationService, GamificationService, ActivityFeedService, MediaService)
- **Policies**: `app/Policies/Forum/`
- **Views**: 
  - Forum: `resources/views/forum/`
  - Activity: `resources/views/activity/`
  - Media: `resources/views/media/`
  - Admin: `resources/views/admin/`
- **Migrations**: `database/migrations/`

#### Key Services:

**SeoService** - Manages SEO metadata and structured data
```php
$seoService->generateMetaTags([
    'title' => 'Counter Strike 2 Maps - FPSociety',
    'description' => 'Download custom CS2 maps...',
]);
```

**ReputationService** - Handles XP, levels, karma, and badges
```php
$reputationService->awardXP($user, 50, 'achievement_unlock');
$reputationService->getLeaderboard('xp', 'seasonal', 10);
```

**GamificationService** - Manages streaks, achievements, and rewards
```php
$gamificationService->awardActionXP($user, 'create_thread');
$gamificationService->checkStreaks($user, 'daily_login');
```

**ActivityFeedService** - Powers activity feeds and recommendations
```php
$feed = $activityFeedService->getWhatsNew(20);
$trending = $activityFeedService->getTrending(10);
```

**MediaService** - Handles file uploads, optimization, and management
```php
$mediaService->uploadImage($file, 'images', $gallery);
$mediaService->uploadGameResource($file, 'cs2', 'map');
```

### Authentication System
The authentication system includes:

- **Registration**: `app/Http/Controllers/Auth/RegisterController.php`
- **Login**: `app/Http/Controllers/Auth/LoginController.php`
- **Email Verification**: `app/Http/Controllers/Auth/EmailVerificationController.php`
- **Password Reset**: `app/Http/Controllers/Auth/PasswordResetController.php`
- **OAuth**: `app/Http/Controllers/Auth/OAuthController.php`
- **Two-Factor Auth**: `app/Http/Controllers/Auth/TwoFactorController.php`

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
- `users` - User accounts with OAuth and 2FA support
- `user_profiles` - Extended profiles with XP, level, karma, streaks
- `user_follows` - User following system
- `user_badges` - Achievement badges
- `user_achievements` - User achievements
- `user_warnings` - Moderation warnings
- `user_bans` - User bans
- `profile_posts` - Profile wall posts
- `private_messages` - Direct messages

### Media Tables
- `galleries` - Game resource galleries (maps, mods, skins)
- `media` - Uploaded files (images, videos, audio, game files)
- `gallery_comments` - Comments on galleries
- `albums` - User photo albums
- `album_photos` - Photos in albums

## Spatie Packages
- laravel-permission
- laravel-settings
- laravel-medialibrary
- laravel-sitemap
- laravel-backup
- laravel-activitylog
- laravel-menu

## Additional Packages
- laravel-socialite - OAuth authentication
- socialiteproviders/steam - Steam OAuth
- socialiteproviders/discord - Discord OAuth
- socialiteproviders/battlenet - Battle.net OAuth
- pragmarx/google2fa-laravel - Two-Factor Authentication

## Gaming Community Features

### SEO Optimization for Gaming
The platform is optimized for gaming-related searches with:
- **Game-specific Keywords**: CS2, Counter Strike 2, GTA V mods, Fortnite skins, Call of Duty maps
- **Content Categories**: Maps, mods, skins, textures, game resources
- **Rich Snippets**: Enhanced search results with structured data
- **Gaming Site Schema**: Properly marked up for gaming content indexing

### Supported Game Content
- **Counter Strike 2 (CS2)**: Maps (.bsp), configs, skins
- **GTA V**: Vehicle mods, scripts, texture packs, RPF files
- **Fortnite**: Creative maps, skin concepts, gameplay content
- **Call of Duty**: Custom maps, weapon skins, mods
- **Minecraft**: Resource packs, worlds, mods
- **Generic**: ZIP, RAR, 7Z archives for any game

### Community Engagement
- **Tournaments**: Organize and manage gaming tournaments
- **Leaderboards**: Compete for top spots in seasonal rankings
- **Achievements**: Unlock special badges and titles
- **Streaks**: Daily login and posting streaks with rewards
- **Recommendations**: AI-powered content suggestions
- **Activity Feeds**: Stay updated with community activity

## Configuration

### Gaming-Specific Settings

Add these to your `.env` for optimal gaming community experience:

```env
APP_NAME=FPSociety

# SEO Settings (optional, uses defaults if not set)
SEO_SITE_NAME="FPSociety - Gaming Community"
SEO_DEFAULT_DESCRIPTION="Join FPSociety for Counter Strike 2, GTA V, Fortnite gaming content"
SEO_KEYWORDS="gaming, cs2, gta5, fortnite, mods, maps, skins"

# Gamification Settings (optional)
XP_CREATE_THREAD=15
XP_CREATE_POST=10
XP_RECEIVE_LIKE=5
XP_DAILY_LOGIN=5
```

## Contributing

We welcome contributions! Whether it's:
- New game support
- Bug fixes
- Feature enhancements
- Documentation improvements

## Support

For issues, questions, or feature requests, please open an issue on GitHub.

## License
Open-source software.
