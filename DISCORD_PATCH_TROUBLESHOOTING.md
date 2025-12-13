# Discord-PHP ComponentsTrait Patch - Troubleshooting Guide

## Error: "Declaration of MessageBuilder::addComponent must be compatible with ComponentsTrait::addComponent"

If you're still seeing this error after pulling the latest changes, the patch hasn't been applied to your vendor directory. Follow these steps:

---

## Quick Fix (Recommended)

### For Windows Users

1. Open Command Prompt or PowerShell in your project root directory
2. Run one of these commands:

```cmd
REM Option 1: Run the batch script
apply-discord-patch.bat

REM Option 2: Run composer command
composer apply-patches
```

### For Linux/Mac Users

1. Open terminal in your project root directory
2. Run one of these commands:

```bash
# Option 1: Run the shell script
./apply-discord-patch.sh

# Option 2: Run composer command
composer apply-patches
```

---

## Why This Happens

The patch is applied automatically during `composer install` or `composer update`. If you're still seeing the error, it means:

1. **You haven't run `composer install` yet** - The vendor directory doesn't exist or is incomplete
2. **The patch command failed silently** - Your system might not have the `patch` utility installed
3. **You're using an old vendor directory** - You may have copied vendor files from another location

---

## Step-by-Step Solution

### Step 1: Verify You Have the Latest Code

```bash
git pull origin main
```

### Step 2: Remove Old Vendor Directory (if exists)

**Windows:**
```cmd
rmdir /s /q vendor
```

**Linux/Mac:**
```bash
rm -rf vendor
```

### Step 3: Install Dependencies

```bash
composer install
```

The patch should be applied automatically during installation.

### Step 4: Verify Patch Was Applied

Check the file `vendor/team-reflex/discord-php/src/Discord/Builders/ComponentsTrait.php` at line 78.

**It should look like this (CORRECT):**
```php
abstract public function addComponent(ComponentObject $component): self;
```

**NOT like this (INCORRECT):**
```php
abstract public function addComponent($component): self;
```

### Step 5: If Automatic Patch Failed

If the patch still wasn't applied, you have three options:

#### Option A: Manual Application (Requires patch utility)

**Windows (Git Bash or Git for Windows):**
```bash
cd vendor/team-reflex/discord-php
patch -p1 < ../../../patches/discord-php-components-trait-type-fix.patch
cd ../../..
```

**Linux/Mac:**
```bash
cd vendor/team-reflex/discord-php
patch -p1 < ../../../patches/discord-php-components-trait-type-fix.patch
cd ../../..
```

#### Option B: Manual File Edit

1. Open: `vendor/team-reflex/discord-php/src/Discord/Builders/ComponentsTrait.php`
2. Go to line 78
3. Change:
   ```php
   abstract public function addComponent($component): self;
   ```
   To:
   ```php
   abstract public function addComponent(ComponentObject $component): self;
   ```
4. Save the file

#### Option C: Install patch utility (if missing)

**Windows:**
- Install [Git for Windows](https://git-scm.com/download/win) which includes the patch utility
- Or install via [Chocolatey](https://chocolatey.org/): `choco install patch`

**Ubuntu/Debian:**
```bash
sudo apt-get install patch
```

**macOS:**
```bash
brew install gpatch
# Or use the built-in patch command
```

**Fedora/RHEL:**
```bash
sudo yum install patch
```

---

## Verification

After applying the patch, verify it works:

```bash
php artisan test --filter=DiscordBot
```

You should see:
```
Tests:  6 passed (9 assertions)
```

Then try starting the bot:
```bash
php artisan discordbot:start
```

The bot should start without the fatal error.

---

## Common Issues

### "patch: command not found"

**Solution:** Install the patch utility (see Option C above) or use manual file editing (Option B).

### "Reversed (or previously applied) patch detected"

**This is normal!** It means the patch was already applied. Your bot should work now.

### Patch fails with "Hunk failed"

**Solution:** The vendor file might have been modified. Delete the vendor directory and run `composer install` again.

### Error persists after applying patch

1. Verify the patch was actually applied (check line 78 in ComponentsTrait.php)
2. Clear PHP's opcache: `php artisan config:clear && php artisan cache:clear`
3. Restart your PHP process/web server
4. On Windows, close and reopen your command prompt/PowerShell

---

## Alternative: Downgrade Discord-PHP

If you can't apply the patch, you can temporarily downgrade to an older version that doesn't have this bug:

```bash
composer require team-reflex/discord-php:^10.41.14
```

**Note:** This is not recommended as you'll miss bug fixes and features from newer versions.

---

## Need Help?

1. Check that you're running the commands from the project root directory
2. Verify you have write permissions to the vendor directory
3. Make sure you have the latest code from the repository
4. Check the patch file exists at: `patches/discord-php-components-trait-type-fix.patch`
5. If all else fails, use Option B (Manual File Edit) above

---

## Technical Details

**What the patch does:**
- Adds `ComponentObject` type hint to the abstract method in `ComponentsTrait`
- Makes it compatible with the implementations in `MessageBuilder`, `ModalBuilder`, and `ActionRow`
- This is a bug in Discord-PHP v10.41.15 that affects PHP 8.2+

**Why it's needed:**
- Discord-PHP v10.41.15 introduced `ComponentsTrait` on Dec 12, 2024
- The trait's abstract method lacks a type hint while all implementations have one
- PHP 8.2+ enforces strict method signature compatibility
- Without the patch, the bot crashes immediately on startup

**When you can remove it:**
- Once Discord-PHP releases a fix (likely in v10.41.16 or later)
- Check the official repository: https://github.com/discord-php/DiscordPHP
