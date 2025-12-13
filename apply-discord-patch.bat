@echo off
REM Windows batch script to manually apply Discord-PHP ComponentsTrait patch
REM Run this if you're experiencing the ComponentsTrait type mismatch error

echo Applying Discord-PHP ComponentsTrait patch...

if not exist "patches\discord-php-components-trait-type-fix.patch" (
    echo ERROR: Patch file not found at patches\discord-php-components-trait-type-fix.patch
    echo Please ensure you are running this from the project root directory.
    pause
    exit /b 1
)

if not exist "vendor\team-reflex\discord-php\src\Discord\Builders\ComponentsTrait.php" (
    echo ERROR: Discord-PHP library not found in vendor directory.
    echo Please run "composer install" first.
    pause
    exit /b 1
)

REM Check if patch is available
where patch >nul 2>nul
if %errorlevel% neq 0 (
    echo.
    echo WARNING: 'patch' command not found on your system.
    echo.
    echo You have two options:
    echo.
    echo Option 1: Install Git for Windows (includes patch utility)
    echo   Download from: https://git-scm.com/download/win
    echo.
    echo Option 2: Manually edit the file
    echo   File: vendor\team-reflex\discord-php\src\Discord\Builders\ComponentsTrait.php
    echo   Line 78: Change "abstract public function addComponent($component): self;"
    echo   To: "abstract public function addComponent(ComponentObject $component): self;"
    echo.
    pause
    exit /b 1
)

REM Apply the patch
cd vendor\team-reflex\discord-php
patch -p1 --forward --no-backup-if-mismatch < ..\..\..\patches\discord-php-components-trait-type-fix.patch 2>nul
if %errorlevel% equ 0 (
    echo SUCCESS: Patch applied successfully!
) else (
    REM Check if patch was already applied
    findstr /C:"addComponent(ComponentObject $component)" src\Discord\Builders\ComponentsTrait.php >nul 2>nul
    if %errorlevel% equ 0 (
        echo SUCCESS: Patch was already applied.
    ) else (
        echo WARNING: Patch may have failed. Please apply manually.
        echo See instructions above.
    )
)

cd ..\..\..
echo.
echo Done! You can now start the Discord bot.
pause
