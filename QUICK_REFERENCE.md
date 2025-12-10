# Logeon Quick Reference Guide

Fast lookup for common tasks and commands.

## Installation

```bash
# Install package
composer require kawsarahmad43/logeon

# Publish assets
php artisan vendor:publish --tag=logeon-assets

# Access dashboard
http://yourapp.com/logger
```

## Publishing to GitHub & Packagist

```bash
# 1. Initialize git
cd ~/logeon-package
git init
git add .
git commit -m "Initial commit: Logeon v1.0.0"

# 2. Create GitHub repo at https://github.com/new
# Name: logeon
# Make it PUBLIC

# 3. Push to GitHub
git remote add origin https://github.com/KawsarAhmad43/logeon.git
git branch -M main
git push -u origin main

# 4. Create release on GitHub
# Go to: https://github.com/KawsarAhmad43/logeon/releases
# Tag: v1.0.0

# 5. Register on Packagist
# Go to: https://packagist.org/submit
# Enter: https://github.com/KawsarAhmad43/logeon

# 6. Set up GitHub webhook
# Copy webhook URL from Packagist
# Add to GitHub: Settings → Webhooks
```

## Configuration

```php
// config/logeon.php
return [
    'route_prefix' => 'logger',           // URL prefix
    'middleware' => ['web'],              // Protection
    'log_file' => storage_path('logs/laravel.log'),
    'per_page' => 10,                     // Pagination
    'enable_test_route' => true,          // Test logs
];
```

## Environment Variables

```env
LOGEON_ROUTE_PREFIX=logger
LOGEON_ENABLE_TEST_ROUTE=true
```

## Publishing Commands

```bash
# Publish all
php artisan vendor:publish --tag=logeon

# Publish config only
php artisan vendor:publish --tag=logeon-config

# Publish views only
php artisan vendor:publish --tag=logeon-views

# Publish assets only
php artisan vendor:publish --tag=logeon-assets

# Force republish
php artisan vendor:publish --tag=logeon --force
```

## Routes

```
GET  /logger              Dashboard
GET  /logger/logs         API endpoint
GET  /test-logs           Generate test logs
```

## Log Types

- **INFO** - Informational messages
- **ERROR** - Error messages
- **WARN** - Warning messages
- **CUSTOM** - Custom log levels

## Filtering

**By Type**: Click badges or use dropdown
**By Date**: Select from/to dates
**Combined**: Use both filters together

## Security

```php
// Protect with authentication
'middleware' => ['web', 'auth'],

// Protect with authorization
'middleware' => ['web', 'auth', 'admin'],
```

## Troubleshooting

```bash
# Clear cache
php artisan cache:clear

# Clear routes
php artisan route:clear

# Clear views
php artisan view:clear

# Republish assets
php artisan vendor:publish --tag=logeon-assets --force

# Check installation
composer show kawsarahmad43/logeon

# Validate composer.json
composer validate
```

## File Locations

**Package**: `vendor/kawsarahmad43/logeon/`
**Config**: `config/logeon.php`
**Views**: `resources/views/vendor/logeon/`
**Assets**: `public/vendor/logeon/`

## Package Structure

```
src/
├── Providers/LogeonServiceProvider.php
└── Http/Controllers/LogeonController.php

config/
└── logeon.php

resources/
├── views/index.blade.php
└── assets/
    ├── css/logeon.css
    └── js/logeon.js

routes/
└── web.php
```

## Updating Package

```bash
# Update version in composer.json
# Update CHANGELOG.md

# Commit and push
git add .
git commit -m "Update: v1.1.0"
git push origin main

# Create release on GitHub
# Packagist auto-updates
```

## Version Numbering

- `v1.0.0` - Initial release
- `v1.1.0` - New feature
- `v1.0.1` - Bug fix
- `v2.0.0` - Major rewrite

## Useful Links

- **GitHub**: https://github.com/KawsarAhmad43/logeon
- **Packagist**: https://packagist.org/packages/kawsarahmad43/logeon
- **Issues**: https://github.com/KawsarAhmad43/logeon/issues
- **Laravel Docs**: https://laravel.com/docs
- **Packagist Docs**: https://packagist.org/about

## Common Issues

| Issue | Solution |
|-------|----------|
| Assets not loading | `php artisan vendor:publish --tag=logeon-assets --force` |
| Routes not working | `php artisan route:clear` |
| No logs showing | Check `storage/logs/laravel.log` exists |
| Permission denied | `chmod -R 775 storage/logs` |
| Package not found | `composer require kawsarahmad43/logeon` |

## Support

- **Email**: ahmad43.bu@gmail.com
- **GitHub Issues**: https://github.com/KawsarAhmad43/logeon/issues
- **Documentation**: See README.md, INSTALLATION.md, ARCHITECTURE.md
