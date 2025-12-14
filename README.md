# FPSociety - Ultimate Gaming Community Platform

**FPSociety** is a feature-rich gaming community platform built with Laravel 12, designed for gamers who love Counter Strike 2, GTA V, Fortnite, Call of Duty, and more. Download custom maps, share mods, compete in tournaments, and connect with gamers worldwide!

![Login Page](https://github.com/user-attachments/assets/24376722-0e09-440c-940d-fea8d8165b76)
![Registration Page](https://github.com/user-attachments/assets/8c1b9fa8-af5b-470a-af57-409ad8917b0f)

## ✅ Feature Implementation Status

**FPSociety is a comprehensive, production-ready gaming community platform** with all major vBulletin-style features implemented. See [FEATURE_AUDIT_ISSUE.md](FEATURE_AUDIT_ISSUE.md) for detailed audit.

### Implementation Overview (23 Fully Complete, 1 Partially Complete)

| Category | Status | Key Features |
|----------|--------|--------------|
| **User Accounts** | ✅ 100% | Registration, Login, Email Verification, Password Reset, OAuth (Steam/Discord/BattleNet), 2FA |
| **User Profiles** | ✅ 100% | Avatar, Cover Photo, Custom Fields, About Me, Social Links, Activity Feed, Stats, Badges, Titles, Privacy, Follow/Unfollow, Wall Posts |
| **Reputation System** | ✅ 100% | Likes, Reactions, Karma, XP/Leveling, Custom Titles, Achievements, Leaderboards |
| **Forums & Threads** | ✅ 100% | Categories, Subforums, Thread Lists, Pinned/Locked/Hidden Threads, Sorting, BBCode/Markdown, Attachments, Polls, Tags, Slugs, Drafts, Subscriptions, Bookmarks |
| **Posts & Replies** | ✅ 100% | Quoting, Multi-quote, Inline Images, Files, Embeds (YouTube/Twitch), Edit History, Post Reporting |
| **Private Messaging** | ✅ 100% | Direct Messages, Group Chats, Attachments, Reactions, Typing Indicator, Online/Offline Status, Search |
| **Notifications** | ✅ 100% | Real-time Alerts, Push Notifications, Email Notifications, Mentions, Likes, Replies, Quotes, Follows |
| **Who's Online** | ✅ 100% | Live Users Online, Guest Count, User Activity Tracking, Last Active, Session Tracking |
| **Activity & Feeds** | ✅ 100% | Global Feed, "What's New", Trending Threads, Recent Posts, Recommended Content, Polls, Wall Posts |
| **Media System** | ✅ 100% | Image/Video/Audio Uploads, File Manager, Albums, Auto Optimization, CDN Support, Galleries |
| **Moderation Tools** | ✅ 100% | Approve/Deny Posts, Soft/Hard Delete, Ban/Suspend Users, Warnings, Merge/Move Threads, Edit Logs, Reports Queue, Spam Cleaner, IP Logs |
| **Admin Control Panel** | ✅ 100% | User Management, Role Manager, Forum Builder, Theme Manager, Email Templates, Cron Jobs, Backups, Plugin Manager, Navigation Editor, Announcements |
| **Permissions System** | ✅ 100% | User Groups, Role-Based Access, Per-Forum Rules, Per-Thread Rules, Attachment Limits, Moderator Permissions (52 granular permissions) |
| **Widgets/Blocks** | ✅ 100% | Latest Posts, Latest Threads, Online Users, Top Members, Polls, Random Images, Game Offers, Custom HTML Blocks |
| **Search System** | ✅ 100% | Full-Text Search, Fuzzy Search, Filters, Search by User/Date/Forum/Tag, Image Search, Meilisearch/Elasticsearch Compatible |
| **Gamification** | ✅ 100% | XP, Leveling, Badges, Achievements, Daily Streaks, Posting Streaks, Seasonal Leaderboards |
| **Gamer Integrations** | ✅ 100% | Steam/Xbox/PSN Sync, Game Library, Recently Played, Player Stats, Clans/Guilds, Clan Forums, Event Calendar |
| **File Sharing** | ✅ 100% | Mods, Patches, Config Files, Screenshots, Recordings, Download Counters, Versioning |
| **News & Content** | ✅ 100% | CMS Pages, Blog/News Posting, RSS Imports, Game News Aggregation |
| **API** | ⚠️ Partial | Webhooks implemented, Rate Limiting active, Permissions system ready - Full REST API endpoints for forums/users/content pending development |
| **System Architecture** | ✅ 100% | Queues, Redis Caching, S3/MinIO Support, CDN Ready, Multisite, Load-Balancing, Logging, Rate Limits |
| **Security** | ✅ 100% | CSRF Protection, Rate Limiting, Password Hashing, Audit Logs, Session Management, Ban Rules |
| **Themes/Styles** | ✅ 100% | Custom Themes, Dark Mode, Template Editor, Component Overrides |
| **Analytics & Metrics** | ✅ 100% | User Stats, Thread Statistics, Pageviews, Real-Time Activity, Search Logs, User Growth Metrics |

### Bonus Features (Beyond Requirements)

In addition to all required features, FPSociety includes these advanced integrations:

- 🤖 **Discord Bot Integration** - Full-featured bot with commands, announcements, real-time sync
- 🎮 **Gaming Events System** - OpenWebNinja API integration for real-world gaming events, tournaments, expos
- 💰 **CheapShark Integration** - Live game deals from 30+ stores with price tracking
- 📱 **Reddit Content Scraping** - Automated content from r/LivestreamFail and r/AITAH
- 📊 **StreamerBans Integration** - Streamer ban tracking and statistics
- 📝 **Automated Patch Notes** - Multi-game patch notes scraper (CS2, GTA V, Fortnite, COD, Valorant, etc.)
- 🎵 **Radio Streaming** - Icecast/AzuraCast integration with song requests and now playing
- 🏆 **Tournaments System** - Complete tournament management with brackets, matches, check-ins, betting
- 🎲 **Casual Games** - Trivia, predictions, daily challenges
- 🖥️ **Game Servers Dashboard** - Dynamic game server status with live player counts
- 📡 **Real-time WebSockets** - Laravel Reverb for instant notifications and live updates
- 🔍 **Schedule Monitoring** - Spatie Schedule Monitor for cron job tracking and alerts

## Features

### Core System
- ✅ **Laravel 12** with PHP 8.4
- ✅ **Clean Architecture** - Standard Laravel structure with Blade templates
- ✅ **Shared Layout System** - Consistent UI across portal and forum
- ✅ **Role-Based Access Control** - Using Spatie Permission with 8 gaming community roles
- ✅ **Comprehensive Permissions** - 52 unique granular permissions distributed across 8 roles for complete access control
- ✅ **Activity Logging** - Track admin actions with Spatie Activity Log
- ✅ **Media Library** - File management with Spatie Media Library

### SEO & Branding
- ✅ **FPSociety Branding** - Gaming-focused community identity
- ✅ **Comprehensive SEO** - Open Graph, Twitter Cards, structured data (JSON-LD)
- ✅ **Gaming Keywords** - Optimized for Counter Strike 2, GTA V, Fortnite, Call of Duty searches
- ✅ **Dynamic Meta Tags** - SEO service for customizable page metadata
- ✅ **Search Engine Ready** - Built-in sitemap support and clean URLs
- ✅ **SEO-Friendly URLs** - Automatic slug generation for forums, threads, and content using Spatie Sluggable
- ✅ **Content Tagging** - Tag system for better content organization and discovery using Spatie Tags

### Authentication & Security
- ✅ **User Registration** - Modern registration page with validation
- ✅ **Email Verification** - Verify user email addresses after registration
- ✅ **Password Reset** - Secure password reset via email
- ✅ **OAuth Authentication** - Login with Steam, Discord, or Battle.net
- ✅ **Two-Factor Authentication (2FA)** - Google Authenticator support for enhanced security
- ✅ **Modern UI/UX** - Beautiful, responsive authentication pages matching site design
- ✅ **User Settings Page** - Comprehensive account, privacy, and notification preferences
- ✅ **IP Logging** - Track user IP addresses for security and moderation
- ✅ **Edit History** - Track all content edits with timestamps and reasons

### Legal & Static Pages
- ✅ **Terms of Service** - Comprehensive terms page covering user agreements, content policies, and legal disclaimers
- ✅ **Privacy Policy** - Detailed privacy policy covering data collection, usage, and user rights (GDPR-compliant)
- ✅ **Contact Page** - Full-featured contact form with subject categories and success messaging
- ✅ **Footer Integration** - All static pages accessible via footer links

### Forum System
- ✅ **Categories & Forums** - Hierarchical forum structure with subforums
- ✅ **Threads & Posts** - Full-featured discussion system
- ✅ **User Profiles** - Extended profiles with XP, levels, and karma
- ✅ **Reactions System** - Like and react to posts
- ✅ **Polls** - Create polls in threads
- ✅ **Subscriptions** - Subscribe to threads and forums
- ✅ **Attachments** - Upload files to posts
- ✅ **BBCode Support** - Rich text formatting
- ✅ **Moderation Tools** - Report system, warnings, bans, thread merge/move, approval queue
- ✅ **Follow System** - Follow other users
- ✅ **Wall Posts** - Post on user profiles
- ✅ **Universal Search** - Spatie Searchable integration searching across all models (threads, posts, news, downloads, users)
- ✅ **Real-time Notifications** - Database notifications with interactive dropdown
- ✅ **Online Members Tracking** - Live count of active users (15-minute activity window)
- 🚧 **Private Messaging** - Direct messages between users (coming soon)

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

### Downloads System
- ✅ **Downloads Section** - GameBanana-style resource sharing (formerly Gallery)
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
- ✅ **User Downloads** - Personal media libraries for each user
- ✅ **Comments & Ratings** - Community feedback on content
- ✅ **Upload Interface** - Intuitive file upload with drag-and-drop support
- ✅ **Content Tagging** - Tag media for better discoverability
- ✅ **URL Structure** - Clean `/downloads` URLs for all download-related pages

### News & Content System
- ✅ **Gaming News** - Dedicated news section for gaming updates
- ✅ **Admin News Management** - Full CRUD interface for creating, editing, and managing news articles
- ✅ **RSS Feed Imports** - Automatic news import from RSS feeds with deduplication
- ✅ **Scheduled Imports** - Configurable refresh intervals for RSS feeds (15 min to 24 hours)
- ✅ **Featured Stories** - Highlight important news articles
- ✅ **Rich Content** - Support for images, excerpts, and full articles
- ✅ **Source Attribution** - Track news sources for aggregated content
- ✅ **Article Tagging** - Organize news by topics and games with auto-tagging from RSS feeds
- ✅ **View Tracking** - Monitor article popularity
- ✅ **Related Articles** - Automatic related content suggestions
- ✅ **SEO Optimized** - Full meta tags and structured data for news articles
- ✅ **Game Patch Notes** - Comprehensive patch notes system with admin management
  - Track patch notes for multiple games (CS2, GTA V, Fortnite, etc.)
  - Version tracking and release dates
  - Featured patch notes highlighting
  - Filter by game and search functionality
  - Related patch notes suggestions
  - SEO-optimized patch note pages

### Gaming Events System (OpenWebNinja API)
- ✅ **Real-Time Events API** - Powered by OpenWebNinja Real-Time Events Search API
- ✅ **Complete Event Data Storage** - ALL fields from API stored including event_id, name, description, dates, publisher info
- ✅ **Normalized Venue Data** - Separate venues table with Google Place ID deduplication
- ✅ **Multiple Ticket Vendors** - Stores all ticket purchase options (Spotify, Ticketmaster, StubHub, etc.) with favicons
- ✅ **Rich Venue Information** - Full address, coordinates, ratings, phone, website, timezone, venue types
- ✅ **Google Maps Integration** - Direct links to venue locations with coordinates
- ✅ **Publisher Attribution** - Event source tracking with publisher name, favicon, and domain
- ✅ **UTC & Local Times** - Both local and UTC timestamps with precision indicators
- ✅ **Virtual & In-Person Events** - Support for both formats with clear visual indicators
- ✅ **Event Types** - Automatically categorized as expos, tournaments, releases, updates, and general events
- ✅ **Event Status** - Track upcoming, ongoing, and past events with automatic status calculation
- ✅ **Featured Events** - Highlight important events on the events page
- ✅ **Automatic Deduplication** - Prevent duplicate events and venues using unique identifiers
- ✅ **Admin Management** - Feature, publish/unpublish, and delete events from admin panel
- ✅ **Hourly Scheduled Imports** - Automatic event updates every hour via Laravel scheduler
- ✅ **Manual Import** - Trigger event import manually via admin panel or CLI command (`php artisan events:import`)
- ✅ **Rich Event Detail Pages** - Comprehensive display with all data including venue section, ticket sidebar, info links
- ✅ **Filter & Sort** - Filter by event type (expos, tournaments, releases, updates) and status (upcoming, ongoing, past)
- ✅ **Related Events** - Smart suggestions based on event type
- ✅ **DRY & SMART Database** - Normalized schema with venues, ticket links, and info links in separate tables
- ✅ **Error Handling** - Comprehensive logging and error handling for API failures

### Frontend & Portal UI
- ✅ **TailwindCSS** - Modern, responsive design
- ✅ **Alpine.js** - Lightweight JavaScript framework
- ✅ **Dynamic Homepage** - Real-time content from News, Deals, Downloads, and Forum sections
- ✅ **Enhanced User Sidebar** - Display user stats, role, XP, level, and karma for logged-in users
- ✅ **Universal Search** - Powerful search across all content with attractive result grouping
- ✅ **SEO Friendly** - Meta tags, clean URLs, sitemap support
- ✅ **Dark Mode** - Modern dark theme throughout the application
- ✅ **Tabbed Settings Interface** - Easy-to-navigate settings with multiple tabs
- ✅ **Enhanced Popout Radio Player**:
  - Sleek, modern UI with gradient background
  - Album artwork display with animations
  - Advanced volume controls with visual feedback
  - Keyboard shortcuts (Space to play/pause, Arrow keys for volume)
  - Responsive design with smooth transitions
- ✅ **Game Servers Section** (Portal Left Sidebar):
  - FiveM Server placeholder with status badges
  - Counter Strike 2 Server placeholder
  - Minecraft Server placeholder
  - Attractive server cards with game-specific branding
  - Coming soon indicators
- ✅ **Latest Game Deals** (Portal Middle Section):
  - Replaced "Latest Downloads" with game deals display
  - Shows current deals from CheapShark API
  - Game thumbnails with price comparisons
  - Savings percentage badges
  - Store attribution
- ✅ **Upcoming Events** (Portal Right Sidebar):
  - Displays next 3 upcoming gaming events
  - Date badges with month and day
  - Event type indicators (tournaments, expos, releases)
  - Virtual/In-person badges
  - Compact, attractive card layout
- ✅ **Enhanced Navbar**:
  - Search replaced with expandable search icon
  - Beautiful dropdown search interface
  - Live clock displaying current time
  - Auto-updating every second
  - Keyboard shortcuts (ESC to close search)
  - Responsive design
  - **Radio Dropdown**: Home, Radio Player (popout), Song Requests
  - **Streamers Dropdown**: Streamers, Clips, Bans
  - Organized navigation structure for better UX

### Admin Panel
- ✅ **Custom Admin Interface** - No external UI packages
- ✅ **Modern Dark Theme** - Fully themed dark mode admin panel matching site design
- ✅ **Dashboard** - Forum statistics and quick actions
- ✅ **Forum Management** - Create and manage categories and forums
- ✅ **User Management** - Role-based permissions with badges and achievements
- ✅ **Advanced Moderation Tools** - Handle reports, warnings, and bans
  - Thread merge functionality to combine multiple threads
  - Thread move to relocate discussions between forums
  - Content approval queue for reviewing pending submissions
  - Approve/deny actions for threads and posts
- ✅ **News Management** - Complete CRUD interface for news articles with image upload
- ✅ **RSS Feed Management** - Configure and manage RSS feeds for automatic news imports
- ✅ **Events Management** - Manage gaming events, feature/publish control, manual import trigger
- ✅ **Activity Monitoring** - System logs with Spatie Activity Log
- ✅ **Reputation Management**:
  - View top users by XP, karma, and posts
  - Award or deduct XP manually
  - Reset user levels and stats
  - Recalculate karma for all users
- ✅ **Downloads Management**:
  - Approve/reject uploaded content
  - Feature content on homepage
  - Delete inappropriate media
  - Monitor downloads and views
- ✅ **Gamification Controls**:
  - View seasonal leaderboards
  - Configure XP reward amounts
  - Reset seasonal rankings
  - Manage achievement criteria

### Reddit Content Integration
- ✅ **Reddit API Integration** - Automatic scraping from Reddit using OAuth authentication
- ✅ **Gaming Clips** - Video clips from r/LivestreamFail (YouTube, Twitch, Kick, Reddit embeds)
- ✅ **AITAH Stories** - Text-based stories from r/AITAH (Am I The A**hole)
- ✅ **Automatic Scraping** - Scheduled imports every 2 hours via Laravel scheduler
- ✅ **Admin Controls** - Enable/disable subreddits, configure scrape limits, manual triggers
- ✅ **Content Management** - Publish/unpublish, feature, and delete scraped posts
- ✅ **Deduplication** - Prevents duplicate posts using unique Reddit IDs
- ✅ **Rich Metadata** - Stores scores, comments, authors, flairs, and timestamps
- ✅ **Media Support** - Full support for videos, images, and embedded content
- ✅ **Dedicated Pages**:
  - Clips page (`/clips`) - Grid layout with video thumbnails
  - AITAH page (`/aitah`) - List layout with story previews
  - Individual post pages with full content and Reddit links
- ✅ **Navigation Integration** - Reddit dropdown in main navigation

### Game Deals & Stores (CheapShark)
- ✅ **Games Dropdown Navigation** - Dedicated dropdown menu in navbar for game-related features
- ✅ **Live Deals Feed** - CheapShark API integration for stores, deals, and games
- ✅ **Stores Directory** - Browse all gaming stores at `/games/stores` with:
  - Store logos and branding
  - Deal count statistics per store
  - Search and filter functionality
  - Sort by name or deal count
  - Active/inactive store filtering
  - Beautiful card-based layout with hover effects
  - Direct links to view deals from each store
- ✅ **Deals Page** - Comprehensive deals listing at `/games/deals` with:
  - Search functionality
  - Store filtering
  - Price comparisons
  - Savings percentages
  - Direct purchase links
- ✅ **Database-Backed** - Stores data in `cheap_shark_stores`, `cheap_shark_games`, `cheap_shark_deals`, and `cheap_shark_sync_logs` with upserts to prevent duplicates
- ✅ **Hourly Sync** - `php artisan cheapshark:sync` scheduled every hour; manual trigger available in Admin > Game Deals
- ✅ **Batch Game Lookups** - Uses multi-ID `/games` endpoint to hydrate titles, thumbnails, and cheapest prices in batches
- ✅ **Admin Monitoring** - Sync history, counts, and manual run from `/admin/deals`
- ✅ **Configurable** - Override CheapShark base URL with `CHEAPSHARK_BASE_URL` if needed

## Installation

### Docker Deployment (Recommended for Production)

The easiest way to deploy FPSociety is using Docker and Docker Compose. See [DOCKER.md](DOCKER.md) for complete documentation.

**Quick Start:**
```bash
# Clone repository
git clone https://github.com/Git-Cosmo/LVbAdvanced.git
cd LVbAdvanced

# Create Docker environment configuration
cp .env.docker.example .env.docker
# Edit .env.docker with your settings (APP_KEY, DB_PASSWORD, etc.)

# Start services
docker compose up -d

# Access the application at http://localhost:8067
```

The Docker setup includes:
- ✅ PHP 8.4 with all required extensions
- ✅ Nginx web server
- ✅ MySQL 8.0 database
- ✅ Redis for caching and queues
- ✅ Supervisor for queue workers and cron
- ✅ Health checks for all services
- ✅ Automatic migrations on startup
- ✅ Built-in Laravel scheduler

For detailed Docker documentation, troubleshooting, and production deployment, see [DOCKER.md](DOCKER.md).

---

### Manual Installation

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
   
   Update `.env` with your database, mail, and API configuration:
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
   
   # OpenWebNinja API for events (required for events feature)
   OPEN_WEB_NINJA_API_KEY=your_api_key_here
    
    # Reddit API for content scraping (optional)
    REDDIT_CLIENT_ID=your_client_id
    REDDIT_CLIENT_SECRET=your_client_secret
    REDDIT_USERNAME=your_reddit_username
    REDDIT_PASSWORD=your_reddit_password
    
    # Icecast streaming (optional)
    ICECAST_STREAM_URL=http://your-icecast-server.com:8000/stream
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

7. **Set up RSS feed imports (optional)**
   ```bash
   # Import RSS feeds manually
   php artisan rss:import
   
   # Import specific feed
   php artisan rss:import --feed=1
   
   # Add to cron for automatic imports
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

8. **Set up events import (optional)**
   ```bash
   # Import events manually
   php artisan events:import
   
   # Imports are scheduled hourly along with RSS and CheapShark syncs
   # Add to cron for automatic imports
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```

9. **Access**
   - Portal: http://localhost:8000
   - Forums: http://localhost:8000/forum
   - Downloads: http://localhost:8000/downloads
   - Events: http://localhost:8000/events
   - Search: http://localhost:8000/search
   - What's New: http://localhost:8000/activity/whats-new
   - Leaderboard: http://localhost:8000/leaderboard
    - **Reddit Content:**
      - Clips: http://localhost:8000/clips
      - AITAH: http://localhost:8000/aitah
   - **Games:**
     - Game Deals: http://localhost:8000/games/deals
     - Game Stores: http://localhost:8000/games/stores
     - Patch Notes: http://localhost:8000/patch-notes
   - **Radio:**
     - Live Radio: http://localhost:8000/radio
     - Popout Player: http://localhost:8000/radio/popout
    - **StreamerBans:**
      - Browse Streamers: http://localhost:8000/streamerbans
      - Streamer Details: http://localhost:8000/streamerbans/{username}
    - **Static Pages:**
      - Terms of Service: http://localhost:8000/terms
      - Privacy Policy: http://localhost:8000/privacy
      - Contact Us: http://localhost:8000/contact
   - **Admin:**
     - Admin Panel: http://localhost:8000/admin
     - Admin News: http://localhost:8000/admin/news
     - Admin Patch Notes: http://localhost:8000/admin/patch-notes
     - Admin RSS: http://localhost:8000/admin/rss
     - Admin Deals: http://localhost:8000/admin/deals
     - Admin Events: http://localhost:8000/admin/events
      - Admin Reddit: http://localhost:8000/admin/reddit
      - Admin StreamerBans: http://localhost:8000/admin/streamerbans
     - Credentials: admin@example.com / password

## CheapShark Deals & Stores Workflow

### Accessing the Features

**Games Dropdown (Navbar):**
- Click "Games" in the main navigation bar
- Select "Deals" to browse game deals
- Select "Stores" to view all gaming stores

**Frontend Routes:**
- Deals listing: `/games/deals` (also available at `/deals` for backward compatibility)
- Stores directory: `/games/stores`
- Game detail with all offers: `/game/{slug}`

### Syncing Data from CheapShark

1. **Manual sync** anytime:
   ```bash
   php artisan cheapshark:sync
   ```

2. **Automatic syncs** run hourly via `routes/console.php`:
   - Ensure your scheduler runs: `php artisan schedule:run`
   - Syncs stores, games, and deals automatically

3. **Admin management**:
   - Navigate to **Admin → Game Deals** (`/admin/deals`)
   - View sync history and statistics
   - Trigger manual syncs from the admin panel

### Store Features

**Browse Stores at `/games/stores`:**
- View all CheapShark stores with logos
- See deal counts for each store
- Filter by active/inactive stores
- Search stores by name
- Sort by name or deal count
- Click "View Deals" to see all deals from a specific store

**Statistics Dashboard:**
- Total stores tracked
- Active stores count
- Total deals available across all stores

## Game Patch Notes System

### Overview
The patch notes system allows you to track, manage, and display game updates and patch notes for all the games your community plays. It includes both manual management and automated scraping capabilities.

### Features

**Frontend Features:**
- Browse all patch notes at `/patch-notes`
- Filter by game (Counter Strike 2, GTA V, Fortnite, etc.)
- Featured patch notes highlighting
- Related patch notes suggestions
- SEO-optimized individual patch note pages
- View counters for tracking popularity
- Responsive card-based layout

**Admin Features:**
- Full CRUD interface at `/admin/patch-notes`
- Create, edit, and delete patch notes
- Publish/unpublish control
- Feature/unfeature toggle
- Version tracking (e.g., "1.2.3", "Season 5")
- Rich text content support
- Source URL attribution
- Statistics dashboard showing:
  - Total patch notes
  - Published count
  - Featured count
  - Number of games covered

**Automated Scraping:**
- ✅ **Hourly automated scraper** - Automatically fetches patch notes from official game sources
- ✅ **Multi-game support** - Covers Counter Strike 2, GTA V, Fortnite, Call of Duty, Valorant, Apex Legends, League of Legends, Dota 2
- ✅ **RSS/Atom feed parsing** - Intelligent feed detection and parsing
- ✅ **HTML scraping fallback** - Uses advanced HTML parsing when RSS feeds aren't available
- ✅ **Deduplication** - Prevents duplicate patch notes using external IDs
- ✅ **Version extraction** - Automatically extracts version numbers from titles
- ✅ **Keyword detection** - Identifies patch notes using intelligent keyword matching
- ✅ **Scheduled execution** - Runs hourly via Laravel scheduler

### Creating Patch Notes

**Via Admin Panel:**
1. Navigate to **Admin → Patch Notes** (`/admin/patch-notes`)
2. Click "Create Patch Note"
3. Fill in the details:
   - **Game Name** - e.g., "Counter Strike 2", "GTA V"
   - **Version** (optional) - e.g., "1.2.3", "Season 5"
   - **Title** - Patch note title
   - **Description** - Brief summary
   - **Content** - Full patch notes (supports HTML and markdown)
   - **Source URL** (optional) - Link to official patch notes
   - **Release Date** - When the patch was released
   - **Publish** - Make it visible to users
   - **Feature** - Highlight on the patch notes page
4. Click "Create Patch Note"

**Via Automated Scraping:**
1. **Automatic (Hourly):**
   - Patch notes are automatically scraped every hour
   - No manual intervention required
   - Scheduler runs `php artisan patch-notes:scrape` automatically

2. **Manual Trigger:**
   ```bash
   # Scrape all games
   php artisan patch-notes:scrape
   
   # View results with statistics
   # The command displays a table showing patch notes found per game
   ```

**Supported Games for Scraping:**
- Counter Strike 2 (CS2)
- GTA V (Rockstar Games)
- Fortnite (Epic Games)
- Call of Duty (Activision)
- Valorant (Riot Games)
- Apex Legends (EA)
- League of Legends (Riot Games)
- Dota 2 (Valve)

**Automation Details:**
- **Hourly Execution**: Runs automatically every hour via Laravel scheduler
- **RSS/HTML Fallback**: Intelligent feed detection with HTML scraping as backup
- **No API Keys Required**: Uses free RSS feeds and public web scraping
- **Reliable & Sustainable**: Built-in error handling and retry logic
- **Automatic Deduplication**: Prevents duplicate patch notes using external IDs
- **Version Extraction**: Automatically detects version numbers from titles
- **Keyword Detection**: Smart filtering to identify actual patch notes vs regular news

**Managing Patch Notes:**
- **View All** - See all patch notes with statistics
- **Filter** - Filter by game name
- **Quick Actions** - Publish/unpublish, feature/unfeature from listing page
- **Edit** - Update any patch note details (even scraped ones)
- **Delete** - Remove outdated patch notes

### Accessing Patch Notes

**Frontend:**
- Main listing: `/patch-notes`
- Individual patch note: `/patch-notes/{slug}`
- Filter by game: `/patch-notes?game=Counter%20Strike%202`
- Available in Games dropdown menu

**Admin:**
- Management interface: `/admin/patch-notes`
- Create new: `/admin/patch-notes/create`
- Edit existing: `/admin/patch-notes/{id}/edit`

### Database Structure

The `patch_notes` table includes:
- `game_name` - Game this patch belongs to
- `version` - Version number or identifier (auto-extracted)
- `title` - Patch title
- `slug` - SEO-friendly URL slug (auto-generated)
- `description` - Brief summary
- `content` - Full patch notes
- `source_url` - Official patch notes URL
- `external_id` - External ID for deduplication (scraper use)
- `released_at` - Release date
- `is_published` - Visibility control
- `is_featured` - Featured status
- `views_count` - View counter

### Scraper Architecture

**How It Works:**
1. **RSS/Atom Detection** - Attempts to find and parse RSS/Atom feeds
2. **HTML Fallback** - If RSS unavailable, uses HTML parsing with Symfony DomCrawler
3. **Keyword Matching** - Identifies patch-related content using keywords (patch, update, notes, changelog, etc.)
4. **Version Extraction** - Extracts version numbers from titles (v1.2.3, Season 5, etc.)
5. **Deduplication** - Checks `external_id` to prevent duplicates
6. **Auto-Publishing** - All scraped patch notes are automatically published

**Configuration:**
The scraper is pre-configured with base URLs for each game. No additional configuration needed unless you want to customize the sources in `app/Services/PatchNotesScraperService.php`.

**Scheduling:**
The scraper runs hourly via Laravel scheduler. Ensure `php artisan schedule:run` is set up in your cron:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Best Practices

- Use consistent game names across patch notes
- Include version numbers for easy reference
- Add source URLs to official patch notes
- Feature major updates to increase visibility
- Use clear, descriptive titles
- Include release dates for historical tracking
- Organize content with headings and lists
- Let the automated scraper run for continuous updates
- Review scraped content periodically in admin panel
- Edit or enhance scraped content as needed

## Gaming Events Workflow (OpenWebNinja API Integration)

### Overview
The gaming events system now integrates with **OpenWebNinja Real-Time Events API** to automatically fetch and display real-world gaming events including conventions, tournaments, expos, game launches, and more.

### Quick Setup

**For detailed setup instructions and troubleshooting, see [EVENTS_SETUP.md](EVENTS_SETUP.md)**

1. **Get your API key** from [OpenWebNinja](https://www.openwebninja.com/api/real-time-events-search/)
2. Copy `.env.example` to `.env` if you haven't already:
   ```bash
   cp .env.example .env
   ```
3. Add your API key to `.env`:
   ```env
   OPEN_WEB_NINJA_API_KEY=your_api_key_here
    
    # Reddit API for content scraping (optional)
    REDDIT_CLIENT_ID=your_client_id
    REDDIT_CLIENT_SECRET=your_client_secret
    REDDIT_USERNAME=your_reddit_username
    REDDIT_PASSWORD=your_reddit_password
   ```
4. Clear configuration cache:
   ```bash
   php artisan config:clear
   ```

**⚠️ Common Issue:** If you get a "Missing Authentication Token" error, your API key is not configured correctly. See [EVENTS_SETUP.md](EVENTS_SETUP.md) for troubleshooting.

### Realtime, Notifications & Monitoring

1. **Redis**: A Redis service is included in `docker-compose.yml`. Ensure it is running (`docker compose up -d redis`) and that `REDIS_HOST=redis` is set in `.env`.
2. **Laravel Reverb (WebSockets)**:
   - Set `BROADCAST_CONNECTION=reverb` and populate `REVERB_APP_ID/KEY/SECRET` along with `REVERB_HOST/PORT/SCHEME`.
   - Frontend uses Vite envs (`VITE_REVERB_*`) to connect; defaults match the `.env.example`.
   - Reverb is started via Supervisor inside the container (`php artisan reverb:start`).
3. **Notifications**:
   - Notifications now broadcast over WebSockets with a global `global-notifications` channel (guests can listen) and user private channels.
   - Navbar dropdown updates in real time and allows marking notifications as read.
4. **Schedule Monitoring**:
   - The Spatie Schedule Monitor package is installed with migrations; run `php artisan schedule-monitor:sync` after deploys to register tasks.
   - Admin dashboard: `/admin/schedule-monitor` (requires admin middleware).
5. **Status Page**: Visit `/status` for a live service overview (DB, cache, Redis, Reverb) with auto-refresh every 5 minutes.

### Import Events

Run a manual import anytime:
```bash
php artisan events:import
```

The command is scheduled to run hourly via `routes/console.php` (ensure your scheduler runs `php artisan schedule:run`).

### Event Data

Events imported from OpenWebNinja API include comprehensive information:

**Core Event Data:**
- **Event ID** - Unique identifier from API for deduplication
- **Name & Description** - Full event information
- **Link** - Direct link to event page
- **Language** - Event language code (e.g., "en")
- **Thumbnail** - Event image/poster

**Date & Time Information:**
- **Human-readable date** - Formatted date string (e.g., "Fri, Feb 14, 10:00 – 11:30 PM PST")
- **Start time** - Local and UTC timestamps with precision indicators
- **End time** - Local and UTC timestamps with precision indicators

**Venue Information (Normalized):**
- **Venue name** - Name of the event location
- **Google ID** - Unique Google Place ID for deduplication
- **Ratings** - Review count and average rating from Google
- **Contact** - Phone number and website
- **Address** - Full address with coordinates (latitude/longitude)
- **Location details** - City, state, country, zipcode, timezone
- **Venue types** - Primary type and all subtypes (e.g., "Live music venue", "Event venue")

**Ticket & Information Links:**
- **Multiple ticket vendors** - Links to purchase from various platforms (Spotify, Ticketmaster, StubHub, etc.)
- **Vendor favicons** - Visual identification of ticket sources
- **Info links** - Additional sources for event information and reviews

**Publisher Attribution:**
- **Publisher name** - Source of the event data
- **Publisher favicon** - Visual branding
- **Publisher domain** - Website domain

**Classification:**
- **Event type** - Automatically categorized (expo, tournament, release, update, general)
- **Virtual/In-Person** - Clear indicator of event format
- **Automatic Deduplication** - Prevents duplicate imports using API event_id

### API Parameters

The system searches for events using multiple queries:
- Gaming conventions
- Esports tournaments
- Game developer conferences
- Video game expos
- Gaming festivals
- Game launches
- General gaming events

You can customize search parameters in `app/Services/EventsService.php`.

### Database Schema

Events are stored in a normalized, DRY database structure with the following tables:

**`events` table (main event data):**
- Core fields: `event_id` (API ID), `name`, `slug`, `link`, `description`, `language`
- Date/time fields: `date_human_readable`, `start_time`, `start_time_utc`, `start_time_precision_sec`, `end_time`, `end_time_utc`, `end_time_precision_sec`
- Media: `thumbnail`, `publisher`, `publisher_favicon`, `publisher_domain`
- Classification: `event_type` (expo, tournament, release, update, general), `is_virtual`
- Management: `is_featured`, `is_published`, `views_count`

**`event_venues` table (normalized venue data to avoid duplication):**
- Identification: `google_id` (unique), `name`, `phone_number`, `website`
- Ratings: `review_count`, `rating`
- Types: `subtype`, `subtypes` (JSON array)
- Address: `full_address`, `latitude`, `longitude`, `district`, `street_number`, `street`, `city`, `zipcode`, `state`, `country`, `timezone`, `google_mid`
- Venues are reused across multiple events via pivot table

**`event_venue` table (pivot):**
- Many-to-many relationship between events and venues
- Allows multiple events at the same venue without data duplication

**`event_ticket_links` table:**
- Stores all ticket purchase options: `event_id`, `source`, `link`, `fav_icon`
- Each event can have multiple ticket vendors (Spotify, Ticketmaster, etc.)

**`event_info_links` table:**
- Additional information sources: `event_id`, `source`, `link`
- Links to articles, reviews, and event information pages

**`event_imported_items` table:**
- Tracks imports: `source`, `external_id`, `event_id`
- Prevents duplicates with unique constraint on `source` + `external_id`

### Frontend Features

**Events listing** (`/events`):
- Filter by type: All, Releases, Tournaments, Expos, Updates
- Filter by status: Upcoming, Ongoing, Past, All
- Virtual event indicator badge on each card
- Featured events showcase section
- Event thumbnails and human-readable dates
- Pagination support

**Event detail page** (`/events/{slug}`):
- **Rich event header**: Thumbnail, event name, badges (type, status, virtual/in-person, featured)
- **Date display**: Human-readable date and separate local/UTC time sections
- **Full venue information**:
  - Venue name with Google ratings and review count
  - Complete address with Google Maps integration link
  - Phone number and website links
  - Venue type and subtypes
- **Ticket purchasing sidebar**:
  - Multiple ticket vendor options with source favicons
  - Direct links to purchase from various platforms (Spotify, Ticketmaster, etc.)
- **Additional information sidebar**:
  - Links to event articles and reviews
  - Publisher attribution with favicon
- **Related events**: Suggests similar events by type
- **View count tracking**: Increments on each page view

### Admin Controls

Admin panel at **Admin → Events Management** (`/admin/events`):
- View all imported events
- Statistics dashboard (total, upcoming, ongoing, featured)
- Manual import trigger
- Feature/unfeature events
- Publish/unpublish events
- Delete events
- Event filtering and pagination

### Event Types

Events are automatically categorized based on content:
- **Expos** - Gaming conventions, trade shows, conferences
- **Tournaments** - Esports competitions, championships
- **Releases** - Game launches, debuts, premieres
- **Updates** - Game patches, DLC, expansions
- **General** - Other gaming-related events

### Event Status

Events are automatically tracked by status:
- **Upcoming** - Future events (start date is in the future)
- **Ongoing** - Currently active (started but not ended)
- **Past** - Completed events (end date has passed)

### API Integration Details

**Endpoint:** `https://api.openwebninja.com/realtime-events-data`

**Authentication:** API key sent via `x-api-key` HTTP header

**Rate Limiting:** Respects API rate limits with proper error handling

**Error Handling:** Comprehensive logging for debugging issues

### Data Flow & Architecture

**Import Process:**
```
OpenWebNinja API → EventsService → Database (normalized) → Frontend Views
```

1. **API Request**: EventsService queries OpenWebNinja API with search terms (gaming conventions, esports tournaments, etc.)
2. **Data Processing**: 
   - Event records created with all API fields
   - Venues extracted and deduplicated by `google_id`
   - Ticket links created for each vendor
   - Info links created for additional sources
3. **Storage**: Data stored in normalized tables to avoid duplication
4. **Display**: Frontend loads events with eager-loaded relationships (venues, ticket links, info links)

**Key Architecture Decisions:**

**DRY (Don't Repeat Yourself):**
- Venues stored in separate table and reused across events
- Same venue (identified by Google Place ID) referenced by multiple events
- No duplicate venue data in database

**SMART Storage:**
- Normalized database structure with proper foreign keys
- Indexed fields for optimal query performance (event_id, start_time, google_id, etc.)
- JSON arrays for venue subtypes (preserves array structure from API)
- Separate tables for ticket links and info links (one-to-many relationships)

**Error Handling:**
- API failures logged with full context
- Missing required fields (event_id) handled gracefully
- Duplicate imports prevented at database level (unique constraints)
- All API responses validated before storage

**Service-Based Architecture:**
- OpenWebNinjaService: API communication and authentication
- EventsService: Business logic for importing and mapping data
- Models: Event, EventVenue, EventTicketLink, EventInfoLink
- Controller: EventsController with eager loading for performance

## Radio Streaming

FPSociety includes a comprehensive radio system with multiple pages and features for streaming audio to your community.

### Radio Navigation Structure

The radio system is organized into a dropdown menu with three main sections:

1. **Radio Home** (`/radio/home`) - Central hub with now playing, history, and quick links
2. **Radio Player** - Opens the enhanced popout player in a new window
3. **Song Requests** (`/radio/requests`) - Browse and request songs from the music library

### Icecast Radio Integration

**Quick Setup:**

1. Add your Icecast stream URL to `.env`:
   ```env
   ICECAST_STREAM_URL=http://your-icecast-server.com:8000/stream
   ```

2. Access the radio pages:
   - Radio Home: `http://localhost:8000/radio/home`
   - Radio Player: `http://localhost:8000/radio`
   - Song Requests: `http://localhost:8000/radio/requests`
   - Popout Player: `http://localhost:8000/radio/popout`

**Features:**
- 🏠 **Radio Home Page**:
  - Now playing with album artwork
  - Playing next preview
  - Recently played history (last 5 tracks)
  - Station status (live/offline indicator)
  - Quick links to player and requests
  - Launch popout player button
- 🎵 **Full-featured audio player** with play/pause/stop controls
- 🔊 **Volume control** with visual feedback and range slider
- 🪟 **Enhanced Popout window** - Sleek, modern player with gradient background
- 📱 **Responsive design** - Works on desktop and mobile
- 🎨 **Modern UI** - Album artwork display, animated effects, and glassmorphism cards
- 🔗 **Easy access** - Available in main navigation dropdown menu
- ⌨️ **Keyboard shortcuts** - Space bar to play/pause, Arrow keys for volume control
- 🎨 **Track Information** - Displays title, artist, and album with scrolling text
- 🔄 **Live Updates** - Real-time now playing information from AzuraCast
- 🎯 **Floating Controls** - Minimize player while browsing other pages
- 🎤 **Song Requests**:
  - Browse all requestable songs from music library
  - Search functionality by title, artist, or album
  - Album artwork display
  - Login required to submit requests
  - Request success/error feedback
  - **Redis caching** for improved performance (5-minute cache)
  - Automatic cache invalidation on song request submission

**Accessing the Radio:**
- Radio Home: `http://localhost:8000/radio/home`
- Main player: `http://localhost:8000/radio`
- Song Requests: `http://localhost:8000/radio/requests`
- Popout player: `http://localhost:8000/radio/popout`
- Navigation: Click "Radio" dropdown in the top menu

**Popout Window:**
The popout window allows users to:
- Keep the radio playing while browsing other pages
- Control playback independently from the main site
- Minimize to system tray while listening

### Azuracast Radio Integration

For advanced radio features with AzuraCast:

**Environment Variables:**
Add the following to `.env`:
```env
AZURACAST_BASE_URL=https://radio.example.com
AZURACAST_API_KEY=your_azuracast_api_key
AZURACAST_STATION_ID=1
```

**How it Works:**
- **Now playing + history**: `GET /api/nowplaying/{station_id}` returns `now_playing`, `playing_next`, `song_history`, and `is_online`.
- **Requestable songs**: `GET /api/station/{station_id}/requests` lists songs users can request.
- **Submit a request**: `POST /api/station/{station_id}/request/{request_id}` returns `200` on success with a message payload (errors surface in the response body).

**Laravel Service Usage:**
```php
$radio = app(\App\Services\AzuracastService::class);

$nowPlaying = $radio->nowPlaying();          // now_playing, playing_next, song_history, is_online
$requestable = $radio->requestableSongs();   // list of songs that can be requested
$log = $radio->requestSong($requestId, auth()->id()); // logs success/failure for the user
```

**Request Logging**
All attempts to request a song are stored in `azuracast_requests` with:
- `user_id` (nullable), `request_id`, `requested_at`
- `status` (`success`, `failed`, or `pending` during processing)
- `api_response_message` (success or error text returned by Azuracast)

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
- Universal search functionality (searches all models)
- Secondary navigation bar
- Footer with site information

All portal and forum pages extend this layout using standard Blade `@extends('layouts.app')` syntax.

### Portal
The portal homepage (`resources/views/portal/home.blade.php`) displays real-time dynamic content:
- Live Azuracast radio player with now playing info
- Latest gaming news articles from the database
- Top game deals with savings and discounts
- Latest downloads with thumbnails and stats
- Recent forum threads with activity timestamps
- Forum statistics and user information

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

### News Tables
- `news` - Gaming news articles with slugs and tags
- `tags` - Content tagging system (Spatie Tags)
- `taggables` - Polymorphic relationship for tags

### Moderation Tables
- `edit_logs` - Track all content edits with old/new content
- `ip_logs` - Log user IP addresses for security

## Spatie Packages Integration

FPSociety leverages the full power of Spatie's Laravel packages for enhanced functionality:

### 1. **laravel-permission** - Role-Based Access Control
**Status:** ✅ Fully Implemented

Role and permission management system with 8 gaming community roles and 52 granular permissions.

```php
// Usage
$user->assignRole('Moderator');
$user->hasPermissionTo('edit any post');
```

**Models Using:** `User`  
**Config:** `config/permission.php`

### 2. **laravel-activitylog** - Activity Logging & Audit Trails
**Status:** ✅ Fully Implemented

Tracks all admin actions including user management, forum operations, and news management.

```php
// Usage
activity()
    ->causedBy(auth()->user())
    ->performedOn($model)
    ->withProperties(['key' => 'value'])
    ->log('action_name');
```

**Implementation:**
- User updates and role changes
- Forum category and forum creation
- News article CRUD operations
- XP and achievement awarding
- Reputation system changes

**Config:** `config/activitylog.php`

### 3. **laravel-medialibrary** - Advanced File Management
**Status:** ✅ Fully Implemented

Handles media uploads with automatic image optimization and conversions for galleries, news, and user avatars.

```php
// Usage
$gallery->addMedia($file)->toMediaCollection('gallery-images');
$user->addMedia($avatar)->toMediaCollection('avatar');
```

**Models Using:** `User`, `Gallery`, `News`  
**Features:**
- Automatic thumbnail generation
- Image optimization on upload
- Multiple conversions (thumb, preview, large)
- Collection-based organization

**Config:** `config/media-library.php`

### 4. **laravel-sluggable** - SEO-Friendly URLs
**Status:** ✅ Fully Implemented

Automatically generates SEO-friendly slugs for forums, threads, galleries, and news.

```php
// Usage - Automatic slug generation
$forum = Forum::create(['name' => 'Counter Strike 2']);
// Generates slug: counter-strike-2
```

**Models Using:** `Forum`, `ForumThread`, `Gallery`, `News`  
**Examples:**
- Forums: `/forum/counter-strike-2`
- Threads: `/forum/cs2/best-maps-for-competitive`
- News: `/news/new-cs2-update-released`

### 5. **laravel-tags** - Content Tagging System
**Status:** ✅ Fully Implemented

Flexible tagging system for organizing threads, galleries, and news articles.

```php
// Usage
$thread->attachTags(['cs2', 'maps', 'competitive']);
$news->syncTags(['update', 'announcement']);
```

**Models Using:** `ForumThread`, `Gallery`, `News`  
**Features:**
- Multi-tagging support
- Tag-based filtering and search
- Auto-tagging from RSS imports
- Tag clouds and popular tags

**Config:** `config/tags.php`

### 6. **laravel-sitemap** - XML Sitemap Generation
**Status:** ✅ Fully Implemented

Automatic sitemap generation for search engine indexing.

**Route:** `/sitemap.xml`

**Includes:**
- Homepage and static pages
- All forums and categories
- Recent threads (1000 most recent)
- Published news articles (500 most recent)
- Public galleries (500 most recent)
- Change frequency and priority optimization

**Config:** `config/sitemap.php`

### 7. **laravel-image-optimizer** - Image Optimization
**Status:** ✅ Fully Implemented

Automatically optimizes images on upload using various optimization tools.

**Integration:**
- Works seamlessly with Media Library
- Optimizes gallery images
- Optimizes news featured images
- Optimizes user avatars
- Reduces file sizes without quality loss

**Config:** `config/image-optimizer.php`

### 8. **laravel-cookie-consent** - GDPR Cookie Compliance
**Status:** ✅ Fully Implemented

EU GDPR-compliant cookie consent banner.

**Features:**
- Dark theme matching site design
- Non-intrusive bottom banner
- 20-year cookie lifetime
- Easy accept button
- Customizable consent message

**Config:** `config/cookie-consent.php`  
**Views:** `resources/views/vendor/cookie-consent/`

### 9. **laravel-settings** - Application Settings
**Status:** ✅ Implemented

Persistent application settings storage.

**Config:** `config/settings.php`

### 10. **laravel-backup** - Automated Backups
**Status:** ✅ Implemented

Database and file backup system.

**Config:** `config/backup.php`

### 11. **laravel-menu** - Dynamic Menu Generation
**Status:** ✅ Implemented

Dynamic menu builder for navigation.

**Config:** Available via package defaults

### 12. **laravel-searchable** - Universal Search
**Status:** ✅ Fully Implemented

Powerful search across all models with relevancy ranking and grouped results.

```php
// Usage - Automatic via SearchController
Route: /search?q=query
```

**Models Using:** `ForumThread`, `ForumPost`, `News`, `Gallery`, `User`  
**Features:**
- Search across forums, posts, news articles, downloads, and users
- Grouped results by model type
- Relevancy-based ranking
- Clean, attractive search results page
- Integrated in navigation bar
- SEO-friendly search URLs

**Implementation:**
- All searchable models implement `Spatie\Searchable\Searchable` interface
- Each model defines searchable fields (title, content, name, etc.)
- Custom `getSearchResult()` method returns formatted results
- Results grouped and displayed with model-specific metadata

**Route:** `/search`  
**Controller:** `App\Http\Controllers\SearchController`  
**View:** `resources/views/search/index.blade.php`

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

## New Features in Latest Update

### Navigation Redesign & UX Improvements
- **Completely reorganized navigation** for better usability and logical grouping
- **Content Dropdown**: News, Events, Downloads, Clips, AITAH Stories - all content in one place
- **Games Dropdown**: Game Deals, Game Stores, Patch Notes - gaming-related features together
- **Community Dropdown**: What's New, Leaderboard, Achievements, Clans, Tournaments, Streamers, Casual Games, Integrations
- **Radio Dropdown**: Radio Home, Popout Player, Song Requests - clearer labels
- **Forum Link**: Direct access to forums from main navigation
- **Cleaner Design**: Reduced spacing, smaller icons, better hover states
- **Visual Grouping**: Separator lines in dropdowns for logical sections
- **Removed Redundancy**: Eliminated duplicate Streamers dropdown

### Performance & Caching Improvements
- **Redis Caching for Radio Requests**: 5-minute cache for song library dramatically improves load times
- **Automatic Cache Invalidation**: Cache clears automatically when songs are requested
- **CheapShark API Improvements**: Enhanced error handling with retry logic and better logging
- **Connection Resilience**: 3-retry mechanism for failed API requests with exponential backoff
- **Detailed Error Logging**: HTTP status codes, response bodies, and connection errors tracked

### Universal Search (Spatie Searchable)
- Powerful search across ALL models using Spatie's laravel-searchable package
- Replaces the previous MySQL full-text search with more flexible Spatie Searchable implementation
- Search forums, posts, news, downloads, and users simultaneously
- Attractive grouped results by model type
- Model-specific metadata displayed for each result type
- Integrated search bar in navigation
- Dedicated search page at `/search`
- SEO-friendly implementation with proper meta tags
- Advanced filtering and relevancy-based ranking

### Downloads Rename (formerly Gallery/Media)
- All URLs changed from `/media` to `/downloads` for clarity
- Navigation updated to say "Downloads" instead of "Gallery"
- Cleaner, more descriptive naming throughout the application
- All route names updated: `downloads.index`, `downloads.show`, etc.
- Sitemap updated to reflect new URLs
- Admin panel updated with new terminology

### Gaming Events System
- Dedicated events page showing gaming releases, tournaments, expos, and updates
- Automated scraper fetching from GameSpot and IGN RSS feeds (no API keys needed)
- Hourly scheduled imports with deduplication to prevent duplicates
- Event filtering by type (releases, tournaments, expos, updates, general)
- Event status filtering (upcoming, ongoing, past)
- Featured events highlighting on events page
- Admin management panel with publish/feature controls
- Manual import trigger via admin panel or CLI command
- Rich event detail pages with related events
- Source attribution for all imported events

### Admin Panel Improvements
- **Dark Theme Throughout** - All admin panel pages now use dark theme matching the main site
- **Unified Design** - Cards, tables, and forms consistently styled with dark backgrounds
- **Login Routing Fix** - Both admins and regular users now redirect to `/` after login (no more automatic `/admin` redirect for admins)

### Dynamic Homepage
- Homepage now displays real data instead of placeholders
- Latest news articles from the database (5 most recent)
- Top game deals with savings and discounts (6 hottest deals)
- Latest downloads with thumbnails and stats (4 most recent)
- Recent forum threads with activity (5 most active)
- Live Azuracast radio integration with now playing info
- Dynamic content updates automatically as new content is added

### Real-time Notifications
- Interactive notification dropdown in the navigation bar
- Database-driven notifications for thread replies and mentions
- Mark as read/unread functionality
- Unread count badge

### RSS Feed Management
- Admin interface to add and manage RSS feeds
- Automatic news import with configurable refresh intervals
- GUID-based deduplication to avoid duplicate articles
- Auto-tagging support for imported content
- Manual import via `php artisan rss:import` command

### Enhanced Moderation
- Thread merge functionality to combine discussions
- Thread move to relocate content between forums
- Content approval queue for reviewing pending submissions
- Approve/deny actions with moderation notes
- Enhanced report handling workflow

### Online Members Tracking
- Real-time display of active users
- 15-minute activity window
- Automatic tracking via middleware
- Displays count in navigation bar

### Admin News Management
- Full CRUD interface for news articles
- Image upload with validation
- Publish/unpublish scheduling
- Featured article support
- Tag management for better organization

## Troubleshooting

### Common Issues

**CheapShark Sync Failures:**
- The system now includes automatic retry logic (3 attempts with 1-second delays)
- Check logs at `storage/logs/laravel.log` for detailed error messages
- Verify internet connectivity and firewall settings
- CheapShark API may experience temporary outages - sync will retry automatically
- Manual sync: `php artisan cheapshark:sync`

**Redis Connection Issues:**
- Ensure Redis is running: `redis-cli ping` should return `PONG`
- Check `.env` configuration: `CACHE_STORE=redis` and `REDIS_HOST`
- For Docker: ensure Redis container is started (`docker compose up -d redis`)
- Clear cache if corrupted: `php artisan cache:clear`

**Radio Requests Page Slow Loading:**
- Redis caching is now enabled by default (5-minute cache)
- If still slow, check AzuraCast API response time
- Verify `AZURACAST_BASE_URL` and `AZURACAST_API_KEY` in `.env`
- Test API directly: `curl -H "X-API-Key: YOUR_KEY" https://your-radio.com/api/station/1/requests`
- Cache can be manually cleared: `php artisan cache:forget radio.requestable_songs`

**Patch Notes Not Scraping:**
- Verify Laravel scheduler is running: `php artisan schedule:list`
- Check if cron is configured: `* * * * * cd /path && php artisan schedule:run`
- Manual scrape: `php artisan patch-notes:scrape`
- Check logs for specific game failures
- Some game websites may block scrapers temporarily - built-in retry logic handles this

**Navigation Issues After Update:**
- Clear browser cache and hard refresh (Ctrl+Shift+R or Cmd+Shift+R)
- Clear Laravel view cache: `php artisan view:clear`
- Rebuild frontend assets: `npm run build`
- Check JavaScript console for errors

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

## Reddit Content Scraping

### Overview
The Reddit content integration automatically scrapes posts from configured subreddits and displays them on dedicated pages. Currently supports:
- **r/LivestreamFail** - Gaming clips and highlights (videos)
- **r/AITAH** - "Am I The A**hole" text-based stories

### Setup Reddit API Credentials

1. **Create a Reddit App**:
   - Go to https://www.reddit.com/prefs/apps
   - Click "Create App" or "Create Another App"
   - Select "script" as the app type
   - Fill in the name and description
   - Set redirect URI to `http://localhost` (not used but required)
   - Note your `client_id` (under app name) and `client_secret`

2. **Add credentials to `.env`**:
   ```env
   REDDIT_CLIENT_ID=your_client_id_here
   REDDIT_CLIENT_SECRET=your_client_secret_here
   REDDIT_USERNAME=your_reddit_username
   REDDIT_PASSWORD=your_reddit_password
   ```

3. **Run initial scrape**:
   ```bash
   # Seed the subreddit configuration
   php artisan db:seed --class=RedditSubredditSeeder
   
   # Run initial scrape
   php artisan reddit:scrape
   
   # Or scrape specific subreddit
   php artisan reddit:scrape LivestreamFail
   php artisan reddit:scrape AITAH
   ```

### Features

**Content Pages:**
- `/clips` - Grid view of video clips from r/LivestreamFail
- `/aitah` - List view of text stories from r/AITAH
- `/reddit/{slug}` - Individual post pages with full content

**Admin Management** (`/admin/reddit`):
- View statistics (total posts, published posts, per-subreddit counts)
- Manual scrape trigger
- Enable/disable subreddits
- Configure scrape limits
- Publish/unpublish posts
- Feature posts
- Delete posts

**Automatic Scraping:**
- Runs every 2 hours via Laravel scheduler
- Configurable per-subreddit limits (default: 25 posts)
- Automatic deduplication using Reddit post IDs
- Updates existing posts with new scores and comment counts

**Content Features:**
- Full metadata: title, body, author, flair, scores, comments
- Video embed support (YouTube, Twitch, Kick, Reddit)
- Image thumbnails
- Direct Reddit links
- View count tracking
- SEO-optimized pages

### Configuration

Each subreddit can be configured independently:
- **Enabled/Disabled** - Toggle scraping on/off
- **Content Type** - video, text, or mixed
- **Scrape Limit** - Number of posts to fetch per scrape (1-100)
- **Last Scraped** - Timestamp of last successful scrape

### Database Schema

**`reddit_posts`** - Stores all scraped posts:
- Basic info: reddit_id, title, slug, subreddit, author
- Content: body, url, permalink
- Metadata: score, num_comments, flair, posted_at
- Media: thumbnail, media (JSON), post_hint, is_video, is_self
- Management: is_published, is_featured, views_count

**`reddit_subreddits`** - Configuration for subreddits:
- name, display_name, is_enabled
- content_type, scrape_limit
- last_scraped_at

## Gamer Integrations

### Overview
FPSociety provides comprehensive gaming platform integrations allowing users to sync their gaming accounts, display their game libraries, track stats, and create/join gaming clans.

### Features

**Platform Integrations:**
- 🎮 **Steam Integration** - Sync Steam account and library
- 🎮 **Xbox Integration** - Connect Xbox Live account
- 🎮 **PSN Integration** - Link PlayStation Network account
- 🔄 **Auto-Sync** - Automatically update game libraries and playtime
- 🔐 **OAuth Authentication** - Secure token-based authentication
- 📊 **Multi-Platform Support** - Link multiple gaming platforms to one account

**Game Library:**
- 📚 **Unified Library** - View all games across all platforms in one place
- 🕐 **Playtime Tracking** - Track total playtime per game
- 🖼️ **Game Artwork** - Display game covers and artwork
- 🔍 **Search & Filter** - Find games by name, platform, or playtime
- 📈 **Statistics** - View library statistics (total games, total playtime, etc.)

**Recently Played:**
- 🎮 **Recent Activity** - See what you've been playing recently
- ⏱️ **Session Tracking** - Track individual gaming sessions
- 📊 **Activity Timeline** - Visual timeline of gaming activity
- 🎯 **Quick Access** - Jump back into recently played games

**Player Stats:**
- 📊 **Game Statistics** - Track kills, wins, levels, achievements
- 🏆 **Achievements** - Display unlocked achievements
- 📈 **Progress Tracking** - Monitor stat progression over time
- 🎮 **Multi-Game Stats** - Compare stats across different games
- 🔄 **Auto-Update** - Stats sync automatically from platforms

**Clans & Guilds:**
- 👥 **Create Clans** - Start your own gaming clan or guild
- 🏷️ **Clan Tags** - Unique clan tags (e.g., [CLAN])
- 👑 **Leadership Roles** - Leader, Officer, Member hierarchy
- 📝 **Clan Description** - Rich text clan profiles
- 🖼️ **Clan Branding** - Custom logos and banners
- 🎮 **Game-Specific Clans** - Clans for specific games
- 🔒 **Public/Private** - Control clan visibility
- 📢 **Recruitment** - Open/close clan recruiting
- 👥 **Member Limit** - Set maximum member count
- ✅ **Join Requirements** - Define requirements for joining

**Clan Forums:**
- 💬 **Clan Discussions** - Internal forum for clan members
- 📌 **Pinned Threads** - Important announcements
- 🔒 **Lock Threads** - Prevent further replies
- 👁️ **View Tracking** - Track thread popularity
- ✍️ **Rich Content** - Full text formatting support

**Clan Events:**
- 📅 **Event Calendar** - Schedule clan events and activities
- 🎯 **Event Types** - Raids, PvP, tournaments, meetings, etc.
- 👥 **Participant Tracking** - Track who's attending
- 🔢 **Max Participants** - Set event capacity
- ⏰ **Start/End Times** - Schedule with precise timing
- 📝 **Event Details** - Full descriptions and requirements

### Database Structure

**Game Integrations Table:**
- Platform connection data (Steam/Xbox/PSN)
- OAuth tokens and refresh tokens
- Platform-specific user IDs
- Last sync timestamps
- Active status

**Game Libraries Table:**
- User's game collection across platforms
- Platform-specific game IDs
- Game names and artwork
- Playtime tracking
- Addition dates

**Recently Played Table:**
- Recent gaming activity
- Last played timestamps
- Session duration tracking
- Quick access to recent games

**Player Stats Table:**
- Game-specific statistics
- Stat names and values (kills, wins, levels, etc.)
- Stat types (integer, float, string, json)
- Recording timestamps
- Historical tracking

**Clans Table:**
- Clan information and branding
- Owner and leadership
- Public/private settings
- Recruitment status
- Member limits
- Join requirements

**Clan Members Table:**
- Clan membership records
- Member roles (member, officer, leader)
- Join dates
- Member-specific clan stats

**Clan Forums Table:**
- Internal clan discussions
- Thread management (pin, lock)
- View tracking
- Author attribution

**Clan Events Table:**
- Scheduled clan activities
- Event types and descriptions
- Start/end times
- Participant lists
- Max capacity
- Creator tracking

### Usage Examples

**Link Gaming Account:**
```php
// Create a Steam integration
$integration = GameIntegration::create([
    'user_id' => auth()->id(),
    'platform' => 'steam',
    'platform_id' => $steamId,
    'username' => $steamUsername,
    'access_token' => $accessToken,
    'is_active' => true,
]);
```

**Add Games to Library:**
```php
// Add a game from Steam
$game = GameLibrary::create([
    'user_id' => auth()->id(),
    'integration_id' => $integration->id,
    'game_id' => $steamGameId,
    'game_name' => 'Counter Strike 2',
    'platform' => 'steam',
    'playtime_minutes' => 1200,
]);
```

**Track Recent Play:**
```php
// Record a gaming session
$recentPlay = RecentlyPlayed::create([
    'user_id' => auth()->id(),
    'game_library_id' => $game->id,
    'last_played_at' => now(),
    'session_minutes' => 120,
]);
```

**Create a Clan:**
```php
// Create a new clan
$clan = Clan::create([
    'name' => 'Elite Gamers',
    'tag' => '[ELITE]',
    'description' => 'Competitive CS2 clan',
    'game' => 'Counter Strike 2',
    'owner_id' => auth()->id(),
    'is_public' => true,
    'is_recruiting' => true,
    'member_limit' => 50,
]);
```

**Schedule Clan Event:**
```php
// Create a clan raid event
$event = ClanEvent::create([
    'clan_id' => $clan->id,
    'title' => 'Weekend Raid',
    'description' => 'Let\'s take down the boss!',
    'event_type' => 'raid',
    'start_time' => now()->addDays(2),
    'end_time' => now()->addDays(2)->addHours(3),
    'max_participants' => 10,
    'created_by' => auth()->id(),
]);
```

### Future Enhancements

- Real OAuth implementations for Steam/Xbox/PSN
- Automatic library syncing via platform APIs
- Stat import from platform APIs
- Clan vs Clan tournaments
- Clan leaderboards
- Clan achievements
- Event RSVP system
- Calendar integration
- Discord bot integration for clans
- In-game overlay integration

## StreamerBans Integration

### Overview
The StreamerBans integration automatically scrapes ban data from streamerbans.com, tracking streamer ban statistics, history, and details. This provides comprehensive insights into streamer moderation patterns across platforms.

### Quick Setup

1. **Run initial scrape**:
   ```bash
   # Scrape all streamers from the main page
   php artisan streamerbans:scrape
   
   # Scrape a specific streamer
   php artisan streamerbans:scrape ninja
   
   # Update existing streamers (refresh their data)
   php artisan streamerbans:scrape --update --limit=50
   ```

2. **Database migration** (included in standard migrations):
   ```bash
   php artisan migrate
   ```

### Features

**Content Pages:**
- `/streamerbans` - Browse all streamers with ban data
- `/streamerbans/{username}` - Detailed streamer page with full ban history

**Admin Management** (`/admin/streamerbans`):
- View statistics (total streamers, published count, total bans tracked)
- Manual scrape triggers:
  - Scrape all streamers from streamerbans.com
  - Update existing streamer data (oldest first)
  - Scrape specific streamer by username
- Publish/unpublish streamers
- Feature streamers
- Delete streamers
- View top 10 most banned streamers
- Track recently scraped streamers

**Automatic Scraping:**
- Runs daily via Laravel scheduler
- Updates 100 oldest streamer records per day
- Configurable via scheduled task in `routes/console.php`
- Automatic deduplication using streamer usernames
- Updates existing records with new ban data

**Data Tracked:**
- **Total Bans** - Complete count of bans for each streamer
- **Last Ban** - Date or time of most recent ban
- **Longest Ban** - Duration of the longest ban received
- **Ban History** - Full timeline of all bans (dates, durations, reasons)
- **Avatar** - Streamer profile image
- **Views Count** - Track page view statistics

**Frontend Features:**
- Search functionality (search by username)
- Multiple sorting options:
  - Most Bans (default)
  - Recently Updated
  - Alphabetical
- Responsive grid layout with cards
- Featured streamer badges
- Related streamers suggestions
- Direct links to streamerbans.com profiles
- SEO-optimized pages with metadata

### Database Schema

**`streamerbans` table** - Stores all streamer ban data:
- Basic info: username, slug, profile_url, avatar_url
- Ban statistics: total_bans, last_ban, longest_ban
- Ban history: ban_history (JSON array with detailed records)
- Metadata: last_scraped_at, is_published, is_featured, views_count
- Indexes: username, total_bans, is_published, last_scraped_at

### Configuration

The scraper is designed to:
- **Be respectful**: 1-second delay between requests to avoid overwhelming servers
- **Be robust**: Multiple HTML parsing strategies to handle different page structures
- **Be smart**: Updates existing records instead of creating duplicates
- **Be efficient**: Prioritizes oldest records for updates

### Scraping Behavior

**HTML Parsing Strategy:**
The scraper uses multiple fallback methods to extract data:
1. Searches for links matching `/user/` pattern
2. Looks for specific HTML elements (tables, lists, stat cards)
3. Uses XPath for text pattern matching (e.g., "Total Bans: 5")
4. Extracts ban history from tables or list items
5. Handles missing data gracefully

**Rate Limiting:**
- 1 second delay between each streamer page request
- Respects server resources
- Configurable batch processing for updates

### Usage Examples

**Manual Operations:**
```bash
# Initial import of all streamers
php artisan streamerbans:scrape

# Update specific streamer
php artisan streamerbans:scrape amouranth

# Refresh 100 oldest records
php artisan streamerbans:scrape --update --limit=100
```

**Scheduled Updates:**
The system automatically runs daily via Laravel scheduler:
```php
Schedule::command('streamerbans:scrape --update --limit=100')
    ->withoutOverlapping()
    ->daily();
```

**Accessing the Data:**
- Public page: `http://localhost:8000/streamerbans`
- Individual streamer: `http://localhost:8000/streamerbans/{username}`
- Admin panel: `http://localhost:8000/admin/streamerbans`

### Notes

- **Legal Compliance**: This scraper is designed for educational and informational purposes. Always respect website terms of service.
- **Data Accuracy**: Ban data is scraped from publicly available information on streamerbans.com. For official records, refer to the original source.
- **Performance**: The scraper processes requests sequentially with delays to be respectful to the source server.
- **Error Handling**: Failed scrapes are logged for debugging. Check Laravel logs for any issues.

## Game Server Management

### Overview
FPSociety includes a comprehensive game server management system allowing administrators to manage, add, edit, and delete game servers displayed on the portal. All changes reflect immediately on the user-facing sidebar and throughout the portal.

### Features

**Admin Backend** (`/admin/game-servers`):
- ✅ **Full CRUD Operations** - Create, read, update, and delete game servers
- ✅ **Server Statistics Dashboard** - Total servers, active, online, and featured counts
- ✅ **Quick Status Management** - Toggle active/inactive states with one click
- ✅ **Display Order Control** - Organize servers in custom order on the portal
- ✅ **Featured Server Support** - Highlight important servers

**Server Configuration:**
- **Basic Info**: Server name, game type, game mode, description
- **Connection Details**: IP address, port, direct connect URL
- **Status Management**: Online, offline, maintenance, coming soon
- **Player Tracking**: Max players, current player count
- **Visual Branding**: Customizable icon colors (gradient start/end), short codes
- **Advanced Options**: Featured flag, active/inactive toggle, display order

**Portal Display:**
- ✅ **Dynamic Sidebar** - Servers pulled from database, not hardcoded
- ✅ **Status Indicators** - Color-coded status badges (online, offline, maintenance, coming soon)
- ✅ **Player Counts** - Real-time display of current/max players
- ✅ **Connect Information** - Display IP:Port or direct connect URLs
- ✅ **Custom Branding** - Per-server gradient colors and short codes
- ✅ **Responsive Design** - Beautiful cards with hover effects

### Quick Setup

1. **Access Admin Panel**:
   ```
   Navigate to: /admin/game-servers
   ```

2. **Add a Server**:
   - Click "Add Server"
   - Fill in server details (name, game, short code)
   - Configure connection details (IP, port, or connect URL)
   - Set status (online/offline/maintenance/coming soon)
   - Choose custom gradient colors for server icon
   - Set display order (lower numbers appear first)
   - Toggle featured and active flags
   - Click "Add Server"

3. **Manage Existing Servers**:
   - View all servers with stats in admin panel
   - Quick toggle active/inactive status
   - Edit server details anytime
   - Delete servers no longer needed
   - Changes reflect immediately on portal

### Database Schema

**`game_servers` table:**
- **Basic**: id, name, game, game_short_code, description
- **Connection**: ip_address, port, connect_url
- **Status**: status (enum: online, offline, maintenance, coming_soon)
- **Players**: max_players, current_players, map, game_mode
- **Branding**: icon_color_from, icon_color_to (hex colors)
- **Management**: display_order, is_featured, is_active, last_ping_at
- **Metadata**: metadata (JSON), timestamps

### Usage Examples

**Creating a Server:**
```php
$server = GameServer::create([
    'name' => 'FiveM RP Server',
    'game' => 'GTA V',
    'game_short_code' => '5M',
    'description' => 'High-quality roleplay experience',
    'ip_address' => '127.0.0.1',
    'port' => 30120,
    'status' => 'online',
    'max_players' => 64,
    'current_players' => 32,
    'game_mode' => 'Roleplay',
    'icon_color_from' => '#8B5CF6',
    'icon_color_to' => '#EC4899',
    'display_order' => 1,
    'is_featured' => true,
    'is_active' => true,
]);
```

**Accessing via Routes:**
- Admin index: `/admin/game-servers`
- Create server: `/admin/game-servers/create`
- Edit server: `/admin/game-servers/{id}/edit`
- Portal display: `/` (home page left sidebar)

### Server Status Options

- **Online**: Server is up and running, players can connect
- **Offline**: Server is temporarily down
- **Maintenance**: Server undergoing maintenance
- **Coming Soon**: Server planned but not yet available

Each status has its own color-coded badge for easy identification.

## Gamer Integrations & Activity

### Overview
FPSociety provides comprehensive gaming platform integrations with database models and backend support for Steam, Xbox, and PSN account syncing, game library tracking, player statistics, and clan/guild management.

### Features

**Platform Integrations:**
- ✅ **Database Models**: GameIntegration, GameLibrary, RecentlyPlayed, PlayerStat
- ✅ **Multi-Platform Support**: Steam, Xbox, PSN account linking
- ✅ **OAuth Ready**: Token storage for platform authentication
- ✅ **Sync Tracking**: Last sync timestamps for each integration

**Game Library:**
- ✅ **Unified Library**: View games across all connected platforms
- ✅ **Playtime Tracking**: Track total playtime per game
- ✅ **Recently Played**: Session tracking and activity timeline
- ✅ **Player Stats**: Game-specific statistics storage

**Clans & Guilds:**
- ✅ **Database Models**: Clan, ClanMember, ClanForum, ClanEvent
- ✅ **Clan Management**: Create and join gaming clans/guilds
- ✅ **Hierarchy System**: Leader, officer, and member roles
- ✅ **Clan Forums**: Internal discussion boards for members
- ✅ **Event Calendar**: Schedule clan raids, PvP, tournaments
- ✅ **Public/Private Clans**: Control clan visibility
- ✅ **Recruitment System**: Open/close recruiting status

**Activity Feeds:**
- ✅ **What's New** (`/activity/whats-new`) - Global feed of latest activity
- ✅ **Trending** (`/activity/trending`) - Hot topics and popular content
- ✅ **Recent Posts** (`/activity/recent-posts`) - Latest forum replies
- ✅ **Recommended** (`/activity/recommended`) - Personalized content (auth required)

### Frontend Routes

**Gamer Integrations:**
- Dashboard: `/integrations` - Overview of connected platforms and stats
- Game Library: `/integrations/library` - All games across platforms
- Recently Played: `/integrations/recently-played` - Gaming activity

**Clans:**
- Clan List: `/clans` - Browse all public clans
- Clan Detail: `/clans/{slug}` - View clan info, members, forums, events

### Database Schema

**Game Integrations Table:**
- Platform connections (Steam/Xbox/PSN)
- OAuth tokens and refresh tokens
- Platform-specific user IDs
- Last sync timestamps

**Game Libraries Table:**
- User's game collection
- Platform-specific game IDs
- Playtime tracking
- Game artwork URLs

**Clans Table:**
- Clan information and branding
- Owner and leadership
- Public/private settings
- Recruitment status
- Member limits

**Clan Members Table:**
- Membership records
- Member roles
- Join dates
- Member-specific stats

### Configuration & Setup

The system is ready for OAuth implementation with these environment variables:

```env
# Steam Integration
STEAM_API_KEY=your_steam_api_key

# Xbox Integration
XBOX_CLIENT_ID=your_xbox_client_id
XBOX_CLIENT_SECRET=your_xbox_client_secret

# PSN Integration
PSN_CLIENT_ID=your_psn_client_id
PSN_CLIENT_SECRET=your_psn_client_secret
```

### Future Enhancements

- Real OAuth implementations for Steam/Xbox/PSN
- Automatic library syncing via platform APIs
- Stat import from platform APIs
- Clan vs Clan tournaments
- Clan leaderboards and achievements
- Event RSVP system with calendar integration

## Discord Bot Integration

### Overview
FPSociety includes a comprehensive Discord bot built with Laravel 12 and Discord-PHP v10.41.15. The bot provides seamless integration between your Discord server and the gaming community website with real-time announcements, automatic channel management, and cross-platform synchronization via Laravel Reverb.

**⚠️ Important:** This bot requires Discord-PHP v10+ which uses modern async/await patterns with ReactPHP. Ensure your server environment supports long-running PHP processes.

### Features

**Automatic Channel Provisioning:**
- ✅ **Auto-Create Channels** - Bot automatically creates required channels on startup
- ✅ **Category Organization** - Channels grouped into Community, Systems, and Moderation categories
- ✅ **Permission Management** - Automatic role-based permission configuration
- ✅ **Channel Configuration** - Centralized config file for easy channel management

**Announcement System:**
- ✅ **Bidirectional Sync** - Announcements sync between Discord and website
- ✅ **!announce Command** - Admin/Moderator command to create announcements in Discord
- ✅ **Rich Embeds** - Beautiful Discord embeds with timestamps and author info
- ✅ **Website Admin Panel** - Create announcements from the admin panel
- ✅ **Real-time Broadcasting** - Reverb integration for live website updates
- ✅ **Database Logging** - All announcements stored in database with full history

**Cross-Platform Integration:**
- ✅ **Laravel Reverb** - WebSocket broadcasting for real-time updates
- ✅ **Event System** - Laravel events for extensible architecture
- ✅ **Activity Logging** - Track all announcement actions
- ✅ **Multi-Channel Broadcasting** - Broadcasts to site.announcements, site.dashboard, discord.announcements

**Bot Commands:**
- ✅ **!announce <message>** - Create an announcement (Admin/Moderator only)
- ✅ **!ping** - Check bot responsiveness
- ✅ **!help** - Display available commands
- ✅ **!chucknorris** - Get a random Chuck Norris joke
- ✅ **!roll <dice>** - Roll dice (e.g., !roll 2d6 or !roll 1d20)
- ✅ **!flip** - Flip a coin (heads or tails)
- ✅ **!8ball <question>** - Ask the magic 8-ball a question
- ✅ **!trivia** - Get a random gaming trivia question
- ✅ **!servers** - Show game server status from the website
- ✅ **!feedback** - Submit feedback with interactive button

**Interactive UI Elements:**
- ✅ **Buttons** - Interactive buttons for user actions
- ✅ **Message Components** - Rich interactive messages with action rows
- ✅ **Ephemeral Messages** - Private responses visible only to command user
- ✅ **Modal Support** - Foundation for modal forms (buttons with callbacks)

**Website Integration:**
- ✅ **Live Bot Status** - Real-time bot status indicator on website footer
- ✅ **Bot Status API** - RESTful API endpoints for bot status and commands
- ✅ **Heartbeat System** - Automatic heartbeat to track bot uptime
- ✅ **Status Monitoring** - Visual online/offline indicator with auto-refresh

### Required Channels

The bot automatically provisions these channels:

**Community Category:**
- `#announcements` - Official announcements (read-only for members)
- `#live-streams` - Stream announcements and notifications
- `#bot-commands` - Bot interaction channel

**Systems Category:**
- `#game-status` - Real-time game server status updates
- `#leaderboards` - Player rankings and leaderboard updates

**Moderation Category:**
- `#moderation-logs` - Mod action logs (moderator-only)

### Setup & Configuration

**1. Install Dependencies:**
```bash
composer install
```

> **⚠️ IMPORTANT:** If you see a "ComponentsTrait::addComponent must be compatible" fatal error, the patch wasn't applied automatically. Follow the troubleshooting guide:
> 
> **Quick Fix:**
> - **Windows:** Run `apply-discord-patch.bat` or `composer apply-patches`
> - **Linux/Mac:** Run `./apply-discord-patch.sh` or `composer apply-patches`
> 
> **Full troubleshooting:** See [DISCORD_PATCH_TROUBLESHOOTING.md](DISCORD_PATCH_TROUBLESHOOTING.md)
> 
> **📝 Technical Note:** The project includes a composer patch that fixes a critical compatibility issue in Discord-PHP v10.41.15 (`ComponentsTrait` type mismatch). The patch is automatically applied during `composer install`, but if you're upgrading from an older version or the patch utility isn't available on your system, you may need to apply it manually.

**2. Configure Environment Variables:**
Add to your `.env` file:
```env
# Discord Bot Configuration
DISCORD_BOT_TOKEN=your_discord_bot_token_here
DISCORD_GUILD_ID=your_discord_server_id_here

# Discord OAuth (optional, for website login)
DISCORD_CLIENT_ID=your_oauth_client_id
DISCORD_CLIENT_SECRET=your_oauth_client_secret
```

**3. Run Database Migration:**
```bash
php artisan migrate
```

**4. Configure Channels (Optional):**
Edit `config/discord_channels.php` to customize:
- Channel names and topics
- Category organization
- Role permissions
- Channel order

**5. Start the Bot:**
```bash
php artisan discordbot:start
```

The bot will:
1. Connect to Discord using WebSocket gateway
2. Verify guild access
3. Create missing channels and categories (using ChannelBuilder API)
4. Apply configured permissions
5. Register message handlers
6. Start listening for commands

**Note:** The bot runs as a long-lived process. For production, use Supervisor or systemd (see Running in Production section below).

### Creating Discord Bot

**1. Create Bot on Discord Developer Portal:**
- Visit https://discord.com/developers/applications
- Click "New Application"
- Go to "Bot" section
- Click "Add Bot"
- Enable "Message Content Intent" under Privileged Gateway Intents
  > **Note:** "Message Content Intent" is a [privileged intent](https://discord.com/developers/docs/topics/gateway#privileged-intents). If your bot is in 100 or more servers, you must [verify your bot with Discord](https://support.discord.com/hc/en-us/articles/360040720412-Bot-Verification-and-Data-Allowlisting) to use this intent in production. Without verification, your bot will not receive message content in servers after reaching the 100 server limit.
- Copy the bot token (this is your `DISCORD_BOT_TOKEN`)

**2. Invite Bot to Your Server:**
- Go to OAuth2 → URL Generator
- Select scopes: `bot`
- Select permissions: `Manage Channels`, `Send Messages`, `Embed Links`, `Read Messages`, `Read Message History`
- Copy the generated URL and open it in browser
- Select your server and authorize

**3. Get Guild ID:**
- Enable Developer Mode in Discord (User Settings → Advanced → Developer Mode)
- Right-click your server icon → Copy ID (this is your `DISCORD_GUILD_ID`)

### Admin Panel Usage

**Access Announcements:**
```
Navigate to: /admin/announcements
```

**Create Website → Discord Announcement:**
1. Click "Create Announcement"
2. Enter title and message
3. Check "Publish immediately and broadcast to Discord"
4. Click "Create & Broadcast Announcement"
5. Announcement appears in Discord `#announcements` and broadcasts to website via Reverb

**Create Discord → Website Announcement:**
1. In Discord, use command: `!announce Your Title\nYour detailed message`
2. Bot creates announcement in database
3. Posts to `#announcements` channel with rich embed
4. Broadcasts to website in real-time via Reverb

### Discord Bot Commands Guide

**Community Commands (Everyone):**

**!chucknorris**
- Get a random Chuck Norris joke/fact
- Uses Chuck Norris API for endless entertainment
- Perfect for breaking the ice in chat
- Example: `!chucknorris`

**!roll <dice>**
- Roll dice for gaming decisions
- Supports standard RPG dice notation (e.g., 2d6, 1d20, 3d10)
- Limits: 1-100 dice, 2-1000 sides per die
- Shows individual rolls when rolling 10 or fewer dice
- Examples: 
  - `!roll` (defaults to 1d6)
  - `!roll 2d6` (roll two six-sided dice)
  - `!roll 1d20` (roll one twenty-sided die)

**!flip**
- Flip a coin to make quick decisions
- Returns either Heads 👑 or Tails ⚡
- Example: `!flip`

**!8ball <question>**
- Ask the magic 8-ball for wisdom
- 20 classic responses (positive, negative, and non-committal)
- Must include a question
- Example: `!8ball Will I win my next match?`

**!trivia**
- Get a random video game trivia question
- Multiple choice format with 4 options
- Questions pulled from Open Trivia Database
- Answer revealed after 30 seconds
- Difficulty levels: Easy, Medium, Hard
- Example: `!trivia`

**!servers**
- Display current game server status
- Shows live data from FPSociety website
- Includes:
  - Server name and game
  - Online/Offline/Maintenance status
  - Current player count vs max players
  - Connection information (IP:Port or direct connect URL)
- Example: `!servers`

**!ping**
- Check if bot is responsive
- Simple connectivity test
- Returns: "🏓 Pong!"
- Example: `!ping`

**!help**
- Display all available commands
- Shows command descriptions and usage
- Example: `!help`

**!feedback**
- Submit feedback to the website team
- Uses Discord interactive buttons
- Click button to get feedback submission link
- Demonstrates modal/interaction capabilities
- Response is ephemeral (private to you)
- Example: `!feedback`

**Administrative Commands:**

**!announce <title>\n<message>**
- Create an announcement (Admin/Moderator only)
- Posts to #announcements channel
- Syncs to website in real-time
- Stores in database for history
- Example: `!announce Tournament Tonight\nCS2 tournament starts at 8 PM EST!`

### Website Integration Features

**Discord Bot Status Widget:**
- Located in website footer
- Real-time online/offline indicator
- Green pulsing dot when bot is online
- Auto-refreshes every 30 seconds
- Shows helpful command tip when online

**Bot Status API Endpoints:**
- `GET /api/discord-bot/status` - Bot status, heartbeat, command list
- `GET /api/discord-bot/commands` - Detailed command documentation
- Returns JSON with bot state and available commands
- Used by frontend for live status updates

**Heartbeat System:**
- Bot sends heartbeat every 30 seconds
- Stored in cache with 90-second TTL
- Website checks heartbeat to determine online status
- Status determined solely by cache (no process checking for security)

**Integration Benefits:**
- Seamless cross-platform experience
- Commands trigger website updates
- Website data displayed in Discord
- Real-time status monitoring
- Unified gaming community platform

### Database Schema

**`announcements` table:**
- **Basic**: id, user_id, title, message
- **Source Tracking**: source (website/discord), discord_message_id, discord_channel_id
- **Publishing**: published_at timestamp
- **Metadata**: JSON field for additional data
- **Indexes**: source + created_at, published_at

### Architecture

**Event Flow:**
```
Website Announcement Created
    ↓
AnnouncementCreated Event Dispatched
    ↓
    ├─→ SendAnnouncementToDiscord Listener → Discord API
    ├─→ Reverb Broadcast → Website Users
    └─→ Database Log

Discord !announce Command
    ↓
MessageHandler Processes Command
    ↓
    ├─→ Create Database Record
    ├─→ Post to #announcements
    └─→ AnnouncementCreated Event → Reverb Broadcast
```

**Service Classes:**
- `DiscordBotService` - Main bot client and initialization
- `ChannelManager` - Channel provisioning and management
- `MessageHandler` - Command processing and message handling

**Laravel Integration:**
- `Announcement` Model - Eloquent model with relationships
- `AnnouncementCreated` Event - Broadcasts to Reverb channels
- `SendAnnouncementToDiscord` Listener - Syncs to Discord
- `AnnouncementController` - Admin panel CRUD operations

### Running in Production

**⚠️ Important:** The Discord bot is a long-running process that must be managed by a process supervisor.

**Deployment Configurations:**

Production-ready deployment configurations are available in the `/deployment` directory:
- `supervisor-discordbot.conf` - Supervisor configuration
- `systemd-discordbot.service` - Systemd service unit
- `README.md` - Detailed deployment instructions

**Quick Setup:**

**Using Supervisor (Recommended):**
```bash
# Copy configuration
sudo cp deployment/supervisor-discordbot.conf /etc/supervisor/conf.d/fpsociety-discordbot.conf

# Update paths to match your installation
sudo nano /etc/supervisor/conf.d/fpsociety-discordbot.conf

# Start the bot
sudo supervisorctl reread && sudo supervisorctl update
sudo supervisorctl start fpsociety-discordbot

# View logs
sudo supervisorctl tail -f fpsociety-discordbot
```

**Using Systemd:**
```bash
# Copy service file
sudo cp deployment/systemd-discordbot.service /etc/systemd/system/fpsociety-discordbot.service

# Update paths to match your installation
sudo nano /etc/systemd/system/fpsociety-discordbot.service

# Start the bot
sudo systemctl daemon-reload
sudo systemctl enable fpsociety-discordbot
sudo systemctl start fpsociety-discordbot

# View logs
sudo journalctl -u fpsociety-discordbot -f
```

**Using Docker:**

The bot is already configured in `scripts/supervisord.conf` and starts automatically with:
```bash
docker compose up -d
```

For complete deployment documentation, monitoring, and troubleshooting, see `/deployment/README.md`.

### Permission Configuration

Customize command permissions in `config/discord_channels.php`:

```php
'permissions' => [
    'announce' => ['admin', 'moderator'],
    'manage_channels' => ['admin'],
],
```

Role names are case-insensitive and matched against Discord role names in your server.

### Monitoring & Logs

**Check Bot Status:**
```bash
# View bot logs
tail -f storage/logs/laravel.log | grep Discord

# Check process
ps aux | grep discordbot

# Supervisor status
sudo supervisorctl status discordbot
```

**Log Events:**
- Bot startup and ready status
- Channel creation/discovery
- Command executions
- Announcement broadcasts
- Error handling

### Troubleshooting

**Bot doesn't connect:**
- Verify `DISCORD_BOT_TOKEN` is correct in `.env`
- Check bot is invited to server with correct permissions
- Ensure "Message Content Intent" is enabled in Discord Developer Portal (required for v10+)
- Check Laravel logs: `tail -f storage/logs/laravel.log | grep Discord`
- Verify PHP can run long-lived processes (no `max_execution_time` restrictions)

**Commands don't work:**
- Verify user has correct Discord roles (Admin/Moderator) matching config
- Check bot has "Read Messages" and "Read Message History" permissions
- Ensure "Message Content Intent" is enabled (this is a REQUIRED privileged intent)
- Try the `!ping` command first to test basic functionality
- Check logs for command execution errors

**Channels not created:**
- Verify `DISCORD_GUILD_ID` matches your server ID
- Check bot has "Manage Channels" permission
- Review logs: `storage/logs/laravel.log` for ChannelBuilder errors
- Ensure categories are created before channels (bot does this automatically)
- Check Discord API rate limits if creating many channels

**Announcements not syncing (Website → Discord):**
- Ensure Laravel queue worker is running: `php artisan queue:work`
- Check Reverb server is running: `php artisan reverb:start`
- Verify event listeners are registered in `app/Providers/AppServiceProvider.php`
- Check `SendDiscordAnnouncement` job logs
- Verify `#announcements` channel exists in Discord
- Test with: `php artisan queue:work --once` to process one job

**Announcements not syncing (Discord → Website):**
- Ensure bot is running (`php artisan discordbot:start`)
- Verify bot has MESSAGE_CONTENT intent enabled
- Check database connection in long-running bot process
- Review logs for "Announcement created from Discord" messages

**Bot crashes or disconnects:**
- Check for memory leaks in long-running process
- Verify ReactPHP event loop is not blocked
- Use Supervisor with `autorestart=true` for automatic recovery
- Check Discord API status: https://discordstatus.com/
- Review PHP error logs for fatal errors

### API Rate Limits

Discord enforces rate limits:
- The bot respects Discord's rate limits automatically
- Channel creation is throttled during initial provisioning
- Consider the 50 channel limit per category
- Message sending has per-channel rate limits

### Quick Start Examples

**Using Commands in Discord:**
```
User: !chucknorris
Bot: 💪 Chuck Norris Fact:
     Chuck Norris doesn't use web frameworks. He writes websites in binary.

User: !roll 2d6
Bot: 🎲 PlayerName rolled 2d6: 9 (5, 4)

User: !flip
Bot: ⚡ PlayerName flipped a coin: Tails!

User: !8ball Will I win?
Bot: 🎱 Question: Will I win?
     Answer: Signs point to yes.

User: !trivia
Bot: 🎮 Gaming Trivia (Medium)
     
     What year was Counter-Strike: Global Offensive released?
     A. 2011
     B. 2012
     C. 2013
     D. 2014
     
     *Answer will be revealed in 30 seconds...*
     
[30 seconds later]
Bot: ✅ Correct Answer: 2012

User: !servers
Bot: [Rich embed showing game server status with player counts and IPs]

User: !feedback
Bot: 📝 Submit Feedback
     Click the button below to open the feedback form!
     [Button: Open Feedback Form]
```

**Checking Bot Status on Website:**
- Look at the footer of any page on the website
- You'll see a "Discord Bot" widget showing:
  - 🟢 Online (with pulsing green dot) or 🔴 Offline
  - Helpful command tip when online
  - Auto-refreshes every 30 seconds

**API Usage:**
```bash
# Get bot status
curl https://your-domain.com/api/discord-bot/status

# Get all commands
curl https://your-domain.com/api/discord-bot/commands
```

### Security Best Practices

1. **Never commit** bot tokens to version control
2. Use `.env` for all sensitive credentials
3. Restrict announce command to trusted roles only
4. Regularly rotate bot token if compromised
5. Monitor activity logs for suspicious usage
6. Keep Discord-PHP library updated
7. Bot status endpoint is public - no sensitive data exposed

### Bot Architecture

**Service-Based Design:**
- `DiscordBotService` - Main bot client and initialization with event loop management
- `ChannelManager` - Handles channel provisioning and permissions using ChannelBuilder API
- `MessageHandler` - Processes commands and routes them to appropriate command classes
- Commands follow `CommandInterface` with permission checking via `BaseCommand`

**Key Design Patterns:**
- Command Pattern: Each bot command is a separate class implementing `CommandInterface`
- Promise-based async: Uses ReactPHP promises for all async Discord operations
- Event-driven: Laravel events (AnnouncementCreated) bridge website and Discord
- Job-based sync: Website → Discord uses queued jobs for reliability

**Discord-PHP v10 Features Used:**
- ChannelBuilder API for channel creation (replaces deprecated direct create methods)
- ReactPHP event loop for async operations
- WebSocket gateway for real-time communication
- Promise-based API for all async operations

### Extending the Bot

**Add New Commands:**

1. Create a new command class in `app/DiscordBot/Commands/`:
```php
<?php

namespace App\DiscordBot\Commands;

use Discord\Parts\Channel\Message;

class YourCommand extends BaseCommand
{
    public function getName(): string
    {
        return 'yourcmd';
    }

    public function getDescription(): string
    {
        return 'Description of your command';
    }

    protected function getRequiredRoles(): array
    {
        return ['admin']; // or [] for public access
    }

    public function execute(Message $message, string $args): void
    {
        // Your command logic here
        $message->reply('Your response');
    }
}
```

2. Register it in `app/DiscordBot/Services/MessageHandler.php`:
```php
protected function registerCommands(): void
{
    $yourCommand = new YourCommand();
    
    $this->commands = [
        $announceCommand->getName() => $announceCommand,
        $pingCommand->getName() => $pingCommand,
        $helpCommand->getName() => $helpCommand,
        $yourCommand->getName() => $yourCommand, // Add here
    ];

    $helpCommand->setCommands($this->commands);
}
```

3. Restart the bot to load the new command.

**Add New Channels:**

Edit `config/discord_channels.php`:
```php
'channels' => [
    // ... existing channels ...
    
    'your-channel' => [
        'name' => 'your-channel',
        'type' => 0, // 0 = Text channel (Channel::TYPE_TEXT)
        'category' => 'Community',
        'topic' => 'Your channel description',
        'permissions' => [
            'everyone' => [
                'view_channel' => true,
                'send_messages' => true,
            ],
            'moderator' => [
                'view_channel' => true,
                'send_messages' => true,
                'read_message_history' => true,
            ],
        ],
    ],
],
```

Restart the bot and it will auto-create the new channel with configured permissions.

### Future Enhancements

Planned features for Discord bot:
- Slash commands support
- Game server status updates to Discord
- Tournament bracket updates
- Clan/guild Discord role sync
- Leaderboard updates to Discord
- Voice channel management
- Welcome messages for new members
- Moderation commands (kick, ban, mute)
- Custom embed builder in admin panel


