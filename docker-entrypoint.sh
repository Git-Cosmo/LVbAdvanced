#!/bin/bash
set -e

# Use the .env.docker as .env if it exists, otherwise check for .env
if [ -f /var/www/.env.docker ]; then
    echo "Using .env.docker configuration..."
    cp /var/www/.env.docker /var/www/.env
elif [ ! -f /var/www/.env ]; then
    echo "No .env file found, copying from .env.example..."
    cp /var/www/.env.example /var/www/.env
    echo "WARNING: Please configure your .env file with proper credentials"
fi

# Install/ensure schedule cron exists
CRON_FILE="/etc/crontabs/root"
CRON_JOB="* * * * * cd /var/www && php artisan schedule:run >> /var/log/cron.log 2>&1"

echo "Ensuring Laravel scheduler cron is installed..."
if ! grep -Fxq "$CRON_JOB" $CRON_FILE 2>/dev/null; then
    echo "$CRON_JOB" >> $CRON_FILE
    echo "Cron job added."
else
    echo "Cron job already exists."
fi

# Make sure cron log file exists
touch /var/log/cron.log

# Run migrations safely (only if DB is ready)
echo "Waiting for database..."
MAX_TRIES=10
TRIES=0
until php artisan migrate --force; do
  TRIES=$((TRIES+1))
  if [ $TRIES -ge $MAX_TRIES ]; then
    echo "Database not ready after $MAX_TRIES tries, exiting."
    exit 1
  fi
  echo "Database not ready, retrying in 5 seconds..."
  sleep 5
done

# Sync schedule monitor definitions
echo "Syncing scheduled tasks for monitoring..."
php artisan schedule-monitor:sync --force || true

# Start cron daemon
echo "Starting cron..."
crond

# Fix Windows-mounted directory permissions
echo "Fixing permissions on storage and cache directories..."

# Ensure www-data owns them (recursively)
chown -R www-data:www-data /var/www/storage || true
chown -R www-data:www-data /var/www/bootstrap/cache || true

# Ensure correct execution + write permissions
chmod -R ug+rwX /var/www/storage
chmod -R ug+rwX /var/www/bootstrap/cache

# Ensure storage symlink exists
if [ ! -L /var/www/public/storage ]; then
    echo "Creating storage symlink..."
    php artisan storage:link
fi

# Start Supervisor (runs Nginx + PHP-FPM + queue workers)
echo "Starting Supervisor..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
