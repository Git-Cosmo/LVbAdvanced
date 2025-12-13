#!/bin/bash
# Unix/Linux/Mac script to manually apply Discord-PHP ComponentsTrait patch
# Run this if you're experiencing the ComponentsTrait type mismatch error

set -e

echo "Applying Discord-PHP ComponentsTrait patch..."

if [ ! -f "patches/discord-php-components-trait-type-fix.patch" ]; then
    echo "ERROR: Patch file not found at patches/discord-php-components-trait-type-fix.patch"
    echo "Please ensure you are running this from the project root directory."
    exit 1
fi

if [ ! -f "vendor/team-reflex/discord-php/src/Discord/Builders/ComponentsTrait.php" ]; then
    echo "ERROR: Discord-PHP library not found in vendor directory."
    echo "Please run 'composer install' first."
    exit 1
fi

# Check if patch command is available
if ! command -v patch &> /dev/null; then
    echo "ERROR: 'patch' command not found on your system."
    echo "Please install it using your package manager:"
    echo "  Ubuntu/Debian: sudo apt-get install patch"
    echo "  macOS: brew install gpatch (or use the built-in patch)"
    echo "  Fedora/RHEL: sudo yum install patch"
    exit 1
fi

# Apply the patch
cd vendor/team-reflex/discord-php
if patch -p1 --forward --no-backup-if-mismatch < ../../../patches/discord-php-components-trait-type-fix.patch; then
    echo "SUCCESS: Patch applied successfully!"
elif grep -q "addComponent(ComponentObject \$component)" src/Discord/Builders/ComponentsTrait.php; then
    echo "SUCCESS: Patch was already applied."
else
    echo "WARNING: Patch may have failed. Please apply manually:"
    echo "  File: vendor/team-reflex/discord-php/src/Discord/Builders/ComponentsTrait.php"
    echo "  Line 78: Change 'abstract public function addComponent(\$component): self;'"
    echo "  To: 'abstract public function addComponent(ComponentObject \$component): self;'"
    exit 1
fi

cd ../../..
echo ""
echo "Done! You can now start the Discord bot."
