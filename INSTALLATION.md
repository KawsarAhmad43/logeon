# Logeon Installation Guide

This guide covers different installation methods for the Logeon package.

## Method 1: Install from Packagist (Recommended for Production)

Once the package is published to Packagist, install it via Composer:

```bash
composer require mediusware/logeon
```

Then publish the assets:

```bash
php artisan vendor:publish --tag=logeon-assets
```

## Method 2: Install from GitHub

If the package is hosted on GitHub:

```bash
composer require mediusware/logeon
```

Or add to your `composer.json`:

```json
{
    "require": {
        "mediusware/logeon": "^1.0"
    }
}
```

Then run:

```bash
composer update
php artisan vendor:publish --tag=logeon-assets
```

## Method 3: Local Development (Path Repository)

For local development or testing before publishing:

### Step 1: Add Path Repository

Add this to your Laravel project's `composer.json`:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "./packages/mediusware/logeon"
        }
    ],
    "require": {
        "mediusware/logeon": "@dev"
    }
}
```

### Step 2: Install the Package

```bash
composer update mediusware/logeon
```

### Step 3: Publish Assets

```bash
php artisan vendor:publish --tag=logeon-assets
```

### Step 4: Clear Cache

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Method 4: Install from Private Repository

If you're using a private Git repository:

### Step 1: Add to composer.json

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/mediusware/logeon.git"
        }
    ],
    "require": {
        "mediusware/logeon": "^1.0"
    }
}
```

### Step 2: Install

```bash
composer install
php artisan vendor:publish --tag=logeon-assets
```

## Post-Installation Steps

### 1. Verify Installation

Check if the package is installed:

```bash
composer show mediusware/logeon
```

### 2. Check Routes

```bash
php artisan route:list | grep logeon
```

You should see:
```
GET|HEAD  logger .............. logeon.index › Mediusware\Logeon\Http\Controllers\LogeonController@index
GET|HEAD  logger/logs ......... logeon.logs › Mediusware\Logeon\Http\Controllers\LogeonController@getLogs
```

### 3. Access the Dashboard

Visit: `http://yourapp.com/logger`

### 4. Generate Test Logs (Optional)

If enabled in config:

```bash
# Via browser
http://yourapp.com/test-logs

# Or via tinker
php artisan tinker
>>> \Log::info('Test log', ['key' => 'value']);
>>> \Log::error('Test error', ['error' => 'Something went wrong']);
```

## Configuration

### Publish Configuration File

```bash
php artisan vendor:publish --tag=logeon-config
```

This creates `config/logeon.php` where you can customize:

- Route prefix
- Middleware
- Log file path
- Pagination settings
- Test route enablement

### Customize Views

```bash
php artisan vendor:publish --tag=logeon-views
```

Views will be published to `resources/views/vendor/logeon/`

## Troubleshooting

### Assets Not Loading

If CSS/JS assets are not loading:

```bash
php artisan vendor:publish --tag=logeon-assets --force
php artisan cache:clear
```

### Routes Not Working

Clear route cache:

```bash
php artisan route:clear
php artisan config:clear
```

### Package Not Found

If using path repository, ensure the path is correct:

```bash
# Check if package directory exists
ls -la packages/mediusware/logeon/

# Update composer
composer update mediusware/logeon
```

### Permission Issues

Ensure storage/logs directory is writable:

```bash
chmod -R 775 storage/logs
```

## Uninstallation

To remove the package:

```bash
# Remove package
composer remove mediusware/logeon

# Remove published assets
rm -rf public/vendor/logeon

# Remove published config (optional)
rm config/logeon.php

# Remove published views (optional)
rm -rf resources/views/vendor/logeon
```

## Support

For issues or questions:
- GitHub Issues: https://github.com/mediusware/logeon/issues
- Email: info@mediusware.com

