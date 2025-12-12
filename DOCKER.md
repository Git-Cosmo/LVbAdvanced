# Docker Deployment Guide

This guide explains how to deploy FPSociety using Docker and Docker Compose.

## Table of Contents
- [Prerequisites](#prerequisites)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [Building the Image](#building-the-image)
- [Running with Docker Compose](#running-with-docker-compose)
- [Environment Variables](#environment-variables)
- [Volumes and Persistence](#volumes-and-persistence)
- [Health Checks](#health-checks)
- [Troubleshooting](#troubleshooting)
- [Production Deployment](#production-deployment)

## Prerequisites

- Docker Engine 20.10 or higher
- Docker Compose 2.0 or higher
- At least 2GB of RAM
- At least 5GB of disk space

## Quick Start

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Git-Cosmo/LVbAdvanced.git
   cd LVbAdvanced
   ```

2. **Create environment configuration:**
   ```bash
   cp .env.docker.example .env.docker
   # Edit .env.docker with your configuration
   ```

3. **Generate application key:**
   ```bash
   # You can generate a key locally or in the container
   # Format: base64:RANDOM_32_BYTE_STRING
   # Example: base64:AbCdEfGhIjKlMnOpQrStUvWxYz0123456789ABCD=
   ```

4. **Start the services:**
   ```bash
   docker compose up -d
   ```

5. **Access the application:**
   - Application: http://localhost:8067
   - Health check: http://localhost:8067/up

## Configuration

### Environment Files

The Docker setup supports multiple environment file options:

1. **`.env.docker`** (Recommended): Create this file from `.env.docker.example` for Docker-specific configuration.
2. **`.env`**: If `.env.docker` doesn't exist, the container will use the standard `.env` file.
3. **`.env.example`**: As a fallback, the container will copy this to `.env` if neither of the above exists.

### Key Configuration Variables

```env
# Application
APP_NAME=FPSociety
APP_ENV=production
APP_KEY=base64:YOUR_32_BYTE_KEY_HERE
APP_DEBUG=false
APP_URL=http://localhost:8067

# Database (Docker services)
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=lvbadvanced
DB_USERNAME=root
DB_PASSWORD=secret

# Redis (Docker service)
REDIS_HOST=redis
REDIS_PORT=6379
QUEUE_CONNECTION=redis
CACHE_STORE=redis

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=redis
```

## Building the Image

### Build from Source

```bash
# Build the Docker image
docker build -t lvbadvanced:latest .

# Build with specific tag
docker build -t lvbadvanced:v1.0.0 .

# Build with no cache (clean build)
docker build --no-cache -t lvbadvanced:latest .
```

### Multi-Stage Build

The Dockerfile uses a multi-stage build process:

1. **Build Stage**: Installs dependencies, builds frontend assets
2. **Runtime Stage**: Copies built artifacts, sets up runtime environment

This approach results in a smaller final image (~200-300MB vs 1GB+).

## Running with Docker Compose

### Start Services

```bash
# Start all services in detached mode
docker compose up -d

# Start and view logs
docker compose up

# Start specific services
docker compose up -d fpsociety redis
```

### Stop Services

```bash
# Stop all services
docker compose down

# Stop and remove volumes (WARNING: deletes data!)
docker compose down -v
```

### View Logs

```bash
# View logs from all services
docker compose logs

# Follow logs in real-time
docker compose logs -f

# View logs from specific service
docker compose logs -f fpsociety
docker compose logs -f db
docker compose logs -f redis
```

### Service Management

```bash
# Restart a service
docker compose restart fpsociety

# Rebuild and restart
docker compose up -d --build fpsociety

# Scale services (if supported)
docker compose up -d --scale fpsociety=2
```

## Environment Variables

The docker-compose.yml accepts environment variables for configuration:

```bash
# Set via environment
export DB_PASSWORD=my_secure_password
docker compose up -d

# Or create a .env file in the project root
# docker-compose will automatically load it
```

### Available Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `DB_CONNECTION` | mysql | Database driver |
| `DB_HOST` | db | Database hostname |
| `DB_PORT` | 3306 | Database port |
| `DB_DATABASE` | lvbadvanced | Database name |
| `DB_USERNAME` | root | Database user |
| `DB_PASSWORD` | secret | Database password |
| `REDIS_HOST` | redis | Redis hostname |
| `REDIS_PORT` | 6379 | Redis port |

## Volumes and Persistence

### Data Volumes

The docker-compose.yml defines the following volumes:

- `db_data`: MySQL database files (persistent)
- `redis_data`: Redis data files (persistent)

### Bind Mounts

Optional bind mounts for development:

```yaml
volumes:
  - ./storage:/var/www/storage
  - ./bootstrap/cache:/var/www/bootstrap/cache
```

### Backing Up Volumes

```bash
# Backup MySQL database
docker compose exec db mysqldump -u root -p lvbadvanced > backup.sql

# Backup volumes
docker run --rm -v lvbadvanced_db_data:/data -v $(pwd):/backup \
  alpine tar czf /backup/db_backup.tar.gz /data

# Restore volumes
docker run --rm -v lvbadvanced_db_data:/data -v $(pwd):/backup \
  alpine tar xzf /backup/db_backup.tar.gz -C /
```

## Health Checks

All services include health checks:

### Application Health Check

- **Endpoint**: `http://localhost:8067/up`
- **Interval**: 30 seconds
- **Timeout**: 10 seconds
- **Retries**: 3
- **Start Period**: 60 seconds

### Database Health Check

```bash
# Check database status
docker compose exec db mysqladmin ping -h localhost -u root -p
```

### Redis Health Check

```bash
# Check Redis status
docker compose exec redis redis-cli ping
```

### View Health Status

```bash
# View health status of all services
docker compose ps

# Detailed health check info
docker inspect --format='{{.State.Health.Status}}' fpsociety
```

## Troubleshooting

### Common Issues

#### 1. Build Failures

**Problem**: Build fails with missing dependencies

```bash
# Solution: Clear Docker cache and rebuild
docker builder prune -a
docker compose build --no-cache
```

#### 2. Database Connection Errors

**Problem**: `SQLSTATE[HY000] [2002] Connection refused`

```bash
# Solution: Wait for database to be ready
docker compose logs db

# Check if database is healthy
docker compose ps db

# Restart the application container
docker compose restart fpsociety
```

#### 3. Permission Issues

**Problem**: Laravel can't write to storage directories

```bash
# Solution: Fix permissions inside container
docker compose exec fpsociety chown -R www-data:www-data storage bootstrap/cache
docker compose exec fpsociety chmod -R 775 storage bootstrap/cache
```

#### 4. Port Already in Use

**Problem**: Port 8067 is already in use

```bash
# Solution: Change port in docker-compose.yml
ports:
  - "8080:80"  # Use port 8080 instead
```

#### 5. Out of Memory

**Problem**: Container crashes or build fails

```bash
# Solution: Increase Docker memory limit
# Docker Desktop: Settings > Resources > Memory (increase to 4GB+)

# Or use --memory flag
docker compose build --memory 4g
```

### Debugging Commands

```bash
# Enter the container shell
docker compose exec fpsociety bash

# Check PHP version and extensions
docker compose exec fpsociety php -v
docker compose exec fpsociety php -m

# Run Laravel commands
docker compose exec fpsociety php artisan about
docker compose exec fpsociety php artisan migrate:status

# Check Nginx logs
docker compose exec fpsociety tail -f /var/log/nginx/access.log
docker compose exec fpsociety tail -f /var/log/nginx/error.log

# Check Supervisor logs
docker compose exec fpsociety tail -f /var/log/supervisor/supervisord.log
```

## Production Deployment

### Security Considerations

1. **Change default passwords:**
   ```env
   DB_PASSWORD=use_a_strong_random_password
   ```

2. **Set APP_DEBUG to false:**
   ```env
   APP_DEBUG=false
   ```

3. **Use HTTPS:**
   - Configure reverse proxy (Nginx, Traefik, or Caddy)
   - Obtain SSL certificate (Let's Encrypt)
   - Update APP_URL to use https

4. **Secure Redis:**
   ```yaml
   redis:
     command: redis-server --requirepass your_redis_password
   ```

5. **Limit exposed ports:**
   ```yaml
   # Only expose application port, hide database and Redis
   db:
     ports: []  # Remove port exposure
   redis:
     ports: []  # Remove port exposure
   ```

### Using a Reverse Proxy

Example Nginx configuration:

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name yourdomain.com;

    ssl_certificate /path/to/cert.pem;
    ssl_certificate_key /path/to/key.pem;

    location / {
        proxy_pass http://localhost:8067;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

### Monitoring

```bash
# Monitor resource usage
docker stats fpsociety

# Set up logging with external service
docker compose logs -f | your-logging-tool

# Configure log rotation
docker compose --log-driver json-file --log-opt max-size=10m
```

### Scaling

For high-traffic deployments:

1. Use a load balancer (Nginx, HAProxy)
2. Scale PHP-FPM workers in supervisord.conf
3. Consider separate queue workers
4. Use external MySQL and Redis services

### Automated Deployments

Example CI/CD pipeline (GitHub Actions):

```yaml
name: Deploy

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Build and push Docker image
        run: |
          docker build -t yourdomain.com/lvbadvanced:latest .
          docker push yourdomain.com/lvbadvanced:latest
      - name: Deploy to server
        run: |
          ssh user@server 'cd /app && docker compose pull && docker compose up -d'
```

## Additional Resources

- [Docker Documentation](https://docs.docker.com/)
- [Docker Compose Documentation](https://docs.docker.com/compose/)
- [Laravel Sail (Official Docker Guide)](https://laravel.com/docs/sail)
- [Project README](README.md)

## Support

For issues related to Docker deployment:

1. Check the [Troubleshooting](#troubleshooting) section
2. View container logs: `docker compose logs -f`
3. Open an issue on GitHub

## License

This Docker configuration is part of the LVbAdvanced project and follows the same license.
