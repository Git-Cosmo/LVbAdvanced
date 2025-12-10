# LVbAdvanced - Modern Forum Platform in Laravel 12

A modern forum platform with integrated portal built with Laravel 12, inspired by the classic vBadvanced CMPS.

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
- ✅ **Gamification** - XP, levels, badges, achievements
- ✅ **Follow System** - Follow other users
- ✅ **Wall Posts** - Post on user profiles
- 🚧 **Search** - Full-text search (coming soon)
- 🚧 **Private Messaging** - Direct messages between users (coming soon)
- 🚧 **Real-time Notifications** - WebSocket notifications (coming soon)

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
   - Admin: http://localhost:8000/login
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

### Forum System
The forum system is built using standard Laravel architecture:

- **Models**: `app/Models/Forum/` and `app/Models/User/`
- **Controllers**: `app/Http/Controllers/Forum/` and `app/Http/Controllers/Auth/`
- **Services**: `app/Services/Forum/`
- **Policies**: `app/Policies/Forum/`
- **Views**: `resources/views/forum/` and `resources/views/auth/`
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

## Additional Packages
- laravel-socialite - OAuth authentication
- socialiteproviders/steam - Steam OAuth
- socialiteproviders/discord - Discord OAuth
- socialiteproviders/battlenet - Battle.net OAuth
- pragmarx/google2fa-laravel - Two-Factor Authentication

## License
Open-source software.
