# FPSociety - Production Setup Guide

## Overview

This guide will walk you through setting up FPSociety for production deployment. Follow these steps carefully to ensure a smooth launch.

---

## System Requirements

### Server Requirements
- **PHP:** 8.2 or higher
- **Database:** MySQL 8.0+ or PostgreSQL 13+
- **Web Server:** Nginx (recommended) or Apache
- **Node.js:** 18.x or higher
- **Composer:** 2.x
- **Redis:** 7.x (recommended for cache and sessions)

### Recommended Server Specifications
- **CPU:** 4+ cores
- **RAM:** 8GB minimum, 16GB recommended
- **Storage:** 50GB SSD minimum
- **Bandwidth:** Unmetered or high allocation

---

## Initial Server Setup

### 1. Update System Packages
```bash
sudo apt update && sudo apt upgrade -y
```

### 2. Install Required Packages
```bash
# PHP and extensions
sudo apt install -y php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring \
    php8.2-curl php8.2-zip php8.2-gd php8.2-redis php8.2-intl php8.2-bcmath

# MySQL
sudo apt install -y mysql-server

# Redis
sudo apt install -y redis-server

# Nginx
sudo apt install -y nginx

# Node.js (via NodeSource)
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install -y nodejs

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

## Application Setup

### 1. Clone Repository
```bash
cd /var/www
sudo git clone https://github.com/Git-Cosmo/LVbAdvanced.git fpsociety
cd fpsociety
```

### 2. Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/fpsociety
sudo chmod -R 755 /var/www/fpsociety
sudo chmod -R 775 /var/www/fpsociety/storage
sudo chmod -R 775 /var/www/fpsociety/bootstrap/cache
```

### 3. Install Dependencies
```bash
# PHP dependencies
composer install --no-dev --optimize-autoloader

# Node dependencies
npm ci
npm run build
```

### 4. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Edit .env file
nano .env
```

### 5. Configure .env File

```env
APP_NAME="FPSociety"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fpsociety_prod
DB_USERNAME=fpsociety_user
DB_PASSWORD=STRONG_PASSWORD_HERE

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@fpsociety.com"
MAIL_FROM_NAME="${APP_NAME}"

# OAuth Providers (configure these from your provider dashboards)
# Discord
DISCORD_CLIENT_ID=
DISCORD_CLIENT_SECRET=
DISCORD_REDIRECT_URI="${APP_URL}/auth/discord/callback"

# Steam
STEAM_CLIENT_KEY=
STEAM_REDIRECT_URI="${APP_URL}/auth/steam/callback"

# Battle.net
BATTLENET_CLIENT_ID=
BATTLENET_CLIENT_SECRET=
BATTLENET_REDIRECT_URI="${APP_URL}/auth/battlenet/callback"

# Backup Configuration
BACKUP_DISK=s3
BACKUP_NOTIFICATION_EMAIL=admin@fpsociety.com
```

### 6. Database Setup
```bash
# Create database
mysql -u root -p

CREATE DATABASE fpsociety_prod CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'fpsociety_user'@'localhost' IDENTIFIED BY 'STRONG_PASSWORD';
GRANT ALL PRIVILEGES ON fpsociety_prod.* TO 'fpsociety_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations
php artisan migrate --force

# Seed database
php artisan db:seed --force
```

### 7. Link Storage
```bash
php artisan storage:link
```

### 8. Optimize Application
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## Web Server Configuration

### Nginx Configuration

Create file: `/etc/nginx/sites-available/fpsociety`

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name yourdomain.com www.yourdomain.com;
    
    # Redirect to HTTPS
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name yourdomain.com www.yourdomain.com;

    root /var/www/fpsociety/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/letsencrypt/live/yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/yourdomain.com/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers HIGH:!aNULL:!MD5;
    ssl_prefer_server_ciphers on;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Gzip Compression
    gzip on;
    gzip_vary on;
    gzip_proxied any;
    gzip_comp_level 6;
    gzip_types text/plain text/css text/xml text/javascript application/json application/javascript application/xml+rss application/rss+xml font/truetype font/opentype application/vnd.ms-fontobject image/svg+xml;

    # Logging
    access_log /var/log/nginx/fpsociety_access.log;
    error_log /var/log/nginx/fpsociety_error.log;

    # Laravel routing
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf|eot)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Block access to sensitive files
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/fpsociety /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## SSL Certificate Setup

### Using Let's Encrypt (Recommended)

```bash
# Install Certbot
sudo apt install -y certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal test
sudo certbot renew --dry-run
```

---

## Queue Worker Setup

### Supervisor Configuration

Create file: `/etc/supervisor/conf.d/fpsociety-worker.conf`

```ini
[program:fpsociety-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/fpsociety/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/fpsociety/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start fpsociety-worker:*
```

---

## Scheduled Tasks

### Cron Configuration

```bash
sudo crontab -e -u www-data
```

Add this line:
```
* * * * * cd /var/www/fpsociety && php artisan schedule:run >> /dev/null 2>&1
```

---

## Monitoring Setup

### 1. Application Monitoring

Install Laravel Telescope for debugging (disable in production after setup):
```bash
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate
```

### 2. Server Monitoring

```bash
# Install monitoring tools
sudo apt install -y htop iotop nethogs
```

### 3. Log Monitoring

```bash
# View Laravel logs
tail -f /var/www/fpsociety/storage/logs/laravel.log

# View Nginx logs
tail -f /var/log/nginx/fpsociety_error.log
```

---

## Backup Configuration

### Database Backup Script

Create file: `/usr/local/bin/backup-fpsociety-db.sh`

```bash
#!/bin/bash
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/var/backups/fpsociety"
mkdir -p $BACKUP_DIR

mysqldump -u fpsociety_user -p'YOUR_PASSWORD' fpsociety_prod | gzip > $BACKUP_DIR/db_backup_$TIMESTAMP.sql.gz

# Keep only last 7 days
find $BACKUP_DIR -name "db_backup_*.sql.gz" -mtime +7 -delete
```

Make executable:
```bash
sudo chmod +x /usr/local/bin/backup-fpsociety-db.sh
```

Add to crontab (daily at 2 AM):
```bash
0 2 * * * /usr/local/bin/backup-fpsociety-db.sh
```

---

## Security Hardening

### 1. Firewall Setup
```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

### 2. Fail2Ban Configuration
```bash
sudo apt install -y fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

### 3. Secure MySQL
```bash
sudo mysql_secure_installation
```

### 4. PHP Security

Edit `/etc/php/8.2/fpm/php.ini`:
```ini
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log
max_execution_time = 30
max_input_time = 60
memory_limit = 256M
post_max_size = 20M
upload_max_filesize = 20M
```

Restart PHP-FPM:
```bash
sudo systemctl restart php8.2-fpm
```

---

## Performance Tuning

### PHP-FPM Optimization

Edit `/etc/php/8.2/fpm/pool.d/www.conf`:
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 500
```

### Redis Optimization

Edit `/etc/redis/redis.conf`:
```
maxmemory 256mb
maxmemory-policy allkeys-lru
```

### MySQL Optimization

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:
```ini
[mysqld]
innodb_buffer_pool_size = 2G
innodb_log_file_size = 256M
max_connections = 200
query_cache_size = 64M
query_cache_limit = 2M
```

---

## Post-Deployment Testing

### 1. Functionality Tests
- [ ] Homepage loads
- [ ] User registration works
- [ ] Login/logout works
- [ ] Forum posting works
- [ ] File upload works
- [ ] RSVP system works
- [ ] Messaging works
- [ ] Search functionality works

### 2. Performance Tests
```bash
# Test page load speed
curl -w "@curl-format.txt" -o /dev/null -s https://yourdomain.com

# Create curl-format.txt:
echo "time_namelookup: %{time_namelookup}\ntime_connect: %{time_connect}\ntime_starttransfer: %{time_starttransfer}\ntime_total: %{time_total}\n" > curl-format.txt
```

### 3. Security Tests
- [ ] HTTPS enforced
- [ ] Security headers present
- [ ] No exposed sensitive files
- [ ] Rate limiting working
- [ ] CSRF protection active

---

## Troubleshooting

### Common Issues

**Issue: 500 Internal Server Error**
- Check logs: `tail -f storage/logs/laravel.log`
- Verify permissions: `sudo chown -R www-data:www-data storage bootstrap/cache`
- Clear cache: `php artisan cache:clear`

**Issue: Queue not processing**
- Check supervisor: `sudo supervisorctl status`
- Restart workers: `sudo supervisorctl restart fpsociety-worker:*`
- Check failed jobs: `php artisan queue:failed`

**Issue: Slow performance**
- Enable OPcache
- Optimize autoloader: `composer dump-autoload --optimize`
- Check database slow queries
- Verify Redis is running

---

## Maintenance Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear failed jobs
php artisan queue:flush

# Optimize application
php artisan optimize

# Generate sitemap
php artisan sitemap:generate
```

---

## Support & Resources

- **Documentation:** `/FEATURES_ADDED.md`, `/DEPLOYMENT_CHECKLIST.md`
- **Laravel Docs:** https://laravel.com/docs
- **Community:** Discord, Forums
- **Issues:** GitHub Issues

---

**Last Updated:** December 2025  
**Version:** 1.0  
**Maintainer:** FPSociety Team
