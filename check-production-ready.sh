#!/bin/bash

# FPSociety Production Readiness Check Script
# Run this script to verify your installation is ready for production

echo "🚀 FPSociety Production Readiness Check"
echo "========================================"
echo ""

ERRORS=0
WARNINGS=0

# Colors
RED='\033[0;31m'
YELLOW='\033[1;33m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color

# Helper functions
error() {
    echo -e "${RED}✗${NC} $1"
    ((ERRORS++))
}

warning() {
    echo -e "${YELLOW}⚠${NC} $1"
    ((WARNINGS++))
}

success() {
    echo -e "${GREEN}✓${NC} $1"
}

# Check if .env exists
echo "📋 Environment Configuration"
if [ -f .env ]; then
    success ".env file exists"
    
    # Check critical env variables
    if grep -q "APP_ENV=production" .env; then
        success "APP_ENV is set to production"
    else
        error "APP_ENV is not set to production"
    fi
    
    if grep -q "APP_DEBUG=false" .env; then
        success "APP_DEBUG is set to false"
    else
        error "APP_DEBUG is not set to false (SECURITY RISK!)"
    fi
    
    if grep -q "APP_KEY=base64:" .env; then
        success "APP_KEY is generated"
    else
        error "APP_KEY is not generated"
    fi
    
    if grep -q "APP_URL=https://" .env; then
        success "APP_URL uses HTTPS"
    elif grep -q "APP_URL=http://localhost" .env || grep -q "APP_URL=http://127" .env; then
        warning "APP_URL is set to localhost (update for production)"
    else
        error "APP_URL should use HTTPS"
    fi
else
    error ".env file not found"
fi
echo ""

# Check directory permissions
echo "📁 Directory Permissions"
if [ -w storage/ ]; then
    success "storage/ directory is writable"
else
    error "storage/ directory is not writable"
fi

if [ -w bootstrap/cache/ ]; then
    success "bootstrap/cache/ directory is writable"
else
    error "bootstrap/cache/ directory is not writable"
fi
echo ""

# Check if vendor exists
echo "📦 Dependencies"
if [ -d vendor/ ]; then
    success "Composer dependencies installed"
else
    error "Composer dependencies not installed (run: composer install)"
fi

if [ -d node_modules/ ]; then
    success "NPM dependencies installed"
else
    warning "NPM dependencies not installed (run: npm install)"
fi

if [ -d public/build/ ]; then
    success "Assets compiled"
else
    warning "Assets not compiled (run: npm run build)"
fi
echo ""

# Check storage link
echo "🔗 Storage Link"
if [ -L public/storage ]; then
    success "Storage is linked"
else
    warning "Storage not linked (run: php artisan storage:link)"
fi
echo ""

# Check cache files
echo "⚡ Cache Optimization"
if [ -f bootstrap/cache/config.php ]; then
    success "Configuration cached"
else
    warning "Configuration not cached (run: php artisan config:cache)"
fi

if [ -f bootstrap/cache/routes-v7.php ]; then
    success "Routes cached"
else
    warning "Routes not cached (run: php artisan route:cache)"
fi
echo ""

# Check error pages
echo "🚨 Error Pages"
if [ -f resources/views/errors/404.blade.php ]; then
    success "404 error page exists"
else
    warning "404 error page not found"
fi

if [ -f resources/views/errors/500.blade.php ]; then
    success "500 error page exists"
else
    warning "500 error page not found"
fi

if [ -f resources/views/errors/503.blade.php ]; then
    success "503 error page exists"
else
    warning "503 error page not found"
fi
echo ""

# Check documentation
echo "📚 Documentation"
if [ -f DEPLOYMENT_CHECKLIST.md ]; then
    success "Deployment checklist available"
else
    warning "Deployment checklist not found"
fi

if [ -f PRODUCTION_SETUP.md ]; then
    success "Production setup guide available"
else
    warning "Production setup guide not found"
fi

if [ -f GO_LIVE_CHECKLIST.md ]; then
    success "Go-live checklist available"
else
    warning "Go-live checklist not found"
fi
echo ""

# Check if database can be reached (if .env exists)
echo "🗄️ Database"
if [ -f .env ]; then
    if php artisan db:show > /dev/null 2>&1; then
        success "Database connection successful"
    else
        error "Cannot connect to database"
    fi
else
    warning "Skipping database check (.env not found)"
fi
echo ""

# Check composer autoload optimization
echo "🎯 Optimization"
if [ -f vendor/composer/autoload_classmap.php ]; then
    CLASSMAP_SIZE=$(wc -l < vendor/composer/autoload_classmap.php)
    if [ $CLASSMAP_SIZE -gt 100 ]; then
        success "Composer autoload is optimized"
    else
        warning "Run: composer install --optimize-autoloader"
    fi
else
    warning "Composer autoload not found"
fi
echo ""

# Summary
echo "========================================"
echo "📊 Summary"
echo "========================================"
echo ""

if [ $ERRORS -eq 0 ] && [ $WARNINGS -eq 0 ]; then
    echo -e "${GREEN}✓ All checks passed! Ready for production!${NC}"
    exit 0
elif [ $ERRORS -eq 0 ]; then
    echo -e "${YELLOW}⚠ $WARNINGS warning(s) found. Review and fix before going live.${NC}"
    exit 1
else
    echo -e "${RED}✗ $ERRORS error(s) and $WARNINGS warning(s) found.${NC}"
    echo -e "${RED}Please fix all errors before deploying to production!${NC}"
    exit 2
fi
