# Installation Guide

## Requirements
- PHP 8.4 or higher
- Composer
- Node.js 18+ and NPM
- Database (SQLite, MySQL, or PostgreSQL)

## Quick Start

### 1. Clone and Install Dependencies

```bash
# Clone the repository
git clone https://github.com/Git-Cosmo/LVbAdvanced.git
cd LVbAdvanced

# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 2. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup

Edit `.env` file and configure your database:

**For SQLite (default, easiest)**:
```env
DB_CONNECTION=sqlite
# DB_DATABASE will default to database/database.sqlite
```

**For MySQL**:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lvbadvanced
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Run Migrations and Seed Data

```bash
# Create database tables
php artisan migrate

# Seed with example data (creates admin user and sample blocks)
php artisan db:seed
```

**Default Admin Credentials**:
- Email: `admin@example.com`
- Password: `password`

### 5. Build Frontend Assets

```bash
# For development
npm run dev

# For production
npm run build
```

### 6. Start the Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Accessing the Application

- **Public Portal**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/login
- **Admin Login**: admin@example.com / password

## Post-Installation

### 1. Change Admin Password
After first login, go to the admin panel and change the default password.

### 2. Configure Spatie Packages

Review configuration files in `config/` directory:
- `config/permission.php` - Role & permission settings
- `config/media-library.php` - Media upload settings
- `config/backup.php` - Backup configuration
- `config/activitylog.php` - Activity logging

### 3. Set Up Backups

Configure your backup destination in `.env`:
```env
BACKUP_ARCHIVE_PASSWORD=your_secure_password
```

Then run:
```bash
php artisan backup:run
```

### 4. Configure Cron Jobs

For scheduled tasks (backups, sitemap generation), add to crontab:
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

## Development Mode

```bash
# Run development server with hot reload
npm run dev & php artisan serve
```

## Production Deployment

### 1. Optimize Application

```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Build production assets
npm run build
```

### 2. Set Permissions

```bash
chmod -R 755 storage bootstrap/cache
```

### 3. Environment

Set `.env` for production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### 4. Queue Workers

For better performance, set up queue workers:
```env
QUEUE_CONNECTION=database
```

Then run:
```bash
php artisan queue:work --daemon
```

## Troubleshooting

### Permission Errors
```bash
php artisan cache:clear
php artisan config:clear
chmod -R 755 storage bootstrap/cache
```

### Database Issues
```bash
php artisan migrate:fresh --seed
```

### Asset Issues
```bash
npm install
npm run build
php artisan view:clear
```

### Can't Login
Ensure the admin user has the 'admin' role:
```bash
php artisan tinker
>>> $user = User::where('email', 'admin@example.com')->first();
>>> $user->assignRole('admin');
```

## Additional Configuration

### Email
Configure mail settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### File Storage
To use public storage for media:
```bash
php artisan storage:link
```

## Support

For issues or questions, please check:
- README.md for general information
- Laravel documentation: https://laravel.com/docs
- Spatie packages: https://spatie.be/open-source

## Security

If you discover any security vulnerabilities, please report them responsibly.
