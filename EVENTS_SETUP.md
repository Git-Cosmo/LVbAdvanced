# Events System Setup Guide

This guide will help you set up the OpenWebNinja Events API integration.

## Prerequisites

You need an API key from OpenWebNinja to import real-time events data.

## Step-by-Step Setup

### 1. Get Your API Key

1. Visit [OpenWebNinja Real-Time Events API](https://www.openwebninja.com/api/real-time-events-search/)
2. Sign up or log in to your account
3. Navigate to your API keys section
4. Copy your API key

### 2. Configure Your Application

1. **Copy the example environment file** (if you haven't already):
   ```bash
   cp .env.example .env
   ```

2. **Edit your `.env` file** and add your API key:
   ```bash
   # Find this line in your .env file:
   OPEN_WEB_NINJA_API_KEY=
   
   # Replace it with your actual API key:
   OPEN_WEB_NINJA_API_KEY=your_actual_api_key_here
   ```

3. **Clear the configuration cache**:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### 3. Verify Your Configuration

Run this command to verify your API key is configured correctly:
```bash
php artisan tinker --execute="echo config('services.openwebninja.api_key') ? 'API key is configured' : 'API key is NOT configured';"
```

You should see: `API key is configured`

If you see `API key is NOT configured`, double-check that:
- Your `.env` file exists in the root directory
- The `OPEN_WEB_NINJA_API_KEY` line has your actual API key (no quotes needed)
- You've cleared the config cache with `php artisan config:clear`

### 4. Test the Import

Now you can import events:

**Via Command Line:**
```bash
php artisan events:import -v
```

**Via Admin Panel:**
1. Navigate to Admin → Events Management
2. Click "Import Events Now"

### Troubleshooting

#### Error: "Missing Authentication Token" (403)

This error means your API key is not being sent to the API. Common causes:

1. **API key not in `.env` file**
   - Solution: Add `OPEN_WEB_NINJA_API_KEY=your_key` to `.env`

2. **Configuration cache not cleared**
   - Solution: Run `php artisan config:clear`

3. **Empty or invalid API key**
   - Solution: Verify your key at OpenWebNinja dashboard
   - Make sure there are no spaces or quotes around the key in `.env`

4. **`.env` file doesn't exist**
   - Solution: Copy `.env.example` to `.env` first

#### Error: "API key not configured"

This is shown in the admin panel when the system can't find your API key.

**Check:**
```bash
# Verify .env file exists
ls -la .env

# Check if the key is in the file
grep OPEN_WEB_NINJA_API_KEY .env

# Test configuration loading
php artisan tinker --execute="var_dump(config('services.openwebninja.api_key'));"
```

#### Events Not Importing

If the import completes but no events are added:

1. Check if events already exist (the system prevents duplicates)
2. Try different search queries (gaming-related events only)
3. Check the logs: `tail -f storage/logs/laravel.log`

### Database Migration

If you're upgrading from an old events system, run:
```bash
php artisan migrate --force
```

This will create the new tables:
- `events` - Main events data
- `event_venues` - Normalized venue information
- `event_ticket_links` - Ticket purchase links
- `event_info_links` - Additional information sources
- `event_venue` - Pivot table for events-venues relationship
- `event_imported_items` - Deduplication tracking

### Scheduled Imports

Events are automatically imported hourly. To enable scheduled tasks:

1. Add to your crontab:
   ```bash
   * * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
   ```

2. Or run the scheduler in the background:
   ```bash
   php artisan schedule:work
   ```

### Support

If you continue to experience issues:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Verify your API key is valid at OpenWebNinja
3. Ensure your server can reach `api.openwebninja.com` (no firewall blocking)
4. Test with verbose output: `php artisan events:import -v`

## Quick Reference

### Important Files
- `.env` - Your API key configuration
- `config/services.php` - Service configuration
- `app/Services/OpenWebNinjaService.php` - API integration
- `app/Services/EventsService.php` - Event import logic

### Important Commands
```bash
# Import events manually
php artisan events:import

# Import with verbose output
php artisan events:import -v

# Clear configuration cache
php artisan config:clear

# Check configuration
php artisan tinker --execute="var_dump(config('services.openwebninja'));"
```

### Admin Panel Features
- View all imported events
- Import events manually
- Feature/unfeature events
- Publish/unpublish events
- Delete events
- View statistics (total, upcoming, ongoing, featured)
