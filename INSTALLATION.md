# Logeon Installation Guide

Complete guide for installing and configuring the Logeon package in your Laravel application.

## Quick Start

### 1. Install Package

```bash
composer require mediusware/logeon
```

### 2. Publish Assets

```bash
php artisan vendor:publish --tag=logeon-assets
```

### 3. Access Dashboard

Visit: `http://yourapp.com/logger`

## Detailed Installation

### Step 1: Install via Composer

```bash
composer require mediusware/logeon
```

This will:
- Download the package to `vendor/mediusware/logeon/`
- Auto-register the `LogeonServiceProvider`
- Load package routes and views

### Step 2: Publish Assets

Publish CSS, JS, and configuration files:

```bash
php artisan vendor:publish --tag=logeon-assets
```

This copies:
- `config/logeon.php` - Configuration file
- `resources/views/vendor/logeon/` - Views
- `public/vendor/logeon/` - CSS and JS assets

### Step 3: (Optional) Customize Configuration

Publish configuration file:

```bash
php artisan vendor:publish --tag=logeon-config
```

Edit `config/logeon.php`:

```php
return [
    // Route prefix (default: 'logger')
    'route_prefix' => env('LOGEON_ROUTE_PREFIX', 'logger'),
    
    // Middleware protection
    'middleware' => ['web'],
    
    // Log file path
    'log_file' => storage_path('logs/laravel.log'),
    
    // Logs per page
    'per_page' => 10,
    
    // Enable test route
    'enable_test_route' => env('LOGEON_ENABLE_TEST_ROUTE', env('APP_ENV') !== 'production'),
];
```

### Step 4: (Optional) Customize Views

Publish views:

```bash
php artisan vendor:publish --tag=logeon-views
```

Edit `resources/views/vendor/logeon/index.blade.php`

### Step 5: (Optional) Customize Styles

Publish assets:

```bash
php artisan vendor:publish --tag=logeon-assets
```

Edit `public/vendor/logeon/css/logeon.css`

## Configuration Options

### Route Prefix

Change the URL prefix for accessing the log viewer:

```php
// config/logeon.php
'route_prefix' => 'admin/logs',
```

Access at: `http://yourapp.com/admin/logs`

### Middleware Protection

Protect the log viewer with middleware:

```php
// config/logeon.php
'middleware' => ['web', 'auth', 'admin'],
```

### Custom Log File

Point to a different log file:

```php
// config/logeon.php
'log_file' => storage_path('logs/custom.log'),
```

### Pagination

Change logs per page:

```php
// config/logeon.php
'per_page' => 20,
```

### Test Route

Enable/disable test log generation:

```php
// config/logeon.php
'enable_test_route' => true,
```

Or via environment variable:

```env
LOGEON_ENABLE_TEST_ROUTE=true
```

## Environment Variables

Add to your `.env` file:

```env
# Route prefix
LOGEON_ROUTE_PREFIX=logger

# Enable test route
LOGEON_ENABLE_TEST_ROUTE=true
```

## Usage

### Access Dashboard

After installation, visit:

```
http://yourapp.com/logger
```

### Generate Test Logs

If test route is enabled:

```
http://yourapp.com/test-logs
```

Or generate logs programmatically:

```php
// In your code
\Log::info('User logged in', ['user_id' => 123]);
\Log::warning('Cache is full');
\Log::error('Payment failed', ['order_id' => 456]);
\Log::notice('Custom event', ['event' => 'user_action']);
```

### Filter Logs

In the dashboard:

1. **By Type**: Click badges or use dropdown
2. **By Date**: Select from/to dates
3. **Combined**: Use both filters together

## Security

### Protect with Authentication

```php
// config/logeon.php
'middleware' => ['web', 'auth'],
```

### Protect with Authorization

Create a custom middleware:

```php
// app/Http/Middleware/CanViewLogs.php
public function handle($request, $next)
{
    if (!auth()->user()->can('view-logs')) {
        abort(403);
    }
    return $next($request);
}

// config/logeon.php
'middleware' => ['web', 'auth', 'can-view-logs'],
```

### Production Safety

Test route is automatically disabled in production:

```php
// config/logeon.php
'enable_test_route' => env('LOGEON_ENABLE_TEST_ROUTE', env('APP_ENV') !== 'production'),
```

## Troubleshooting

### Assets Not Loading

Clear cache and republish:

```bash
php artisan cache:clear
php artisan vendor:publish --tag=logeon-assets --force
```

### Routes Not Working

Clear route cache:

```bash
php artisan route:clear
php artisan config:clear
```

### No Logs Showing

1. Check log file exists: `storage/logs/laravel.log`
2. Verify log file path in config
3. Generate test logs: `http://yourapp.com/test-logs`
4. Check file permissions: `chmod 755 storage/logs`

### Permission Denied

Ensure storage directory is writable:

```bash
chmod -R 775 storage/logs
chown -R www-data:www-data storage/logs
```

### Package Not Found

Verify installation:

```bash
composer show mediusware/logeon
```

If not found, reinstall:

```bash
composer require mediusware/logeon
```

## Uninstallation

Remove the package:

```bash
# Remove package
composer remove mediusware/logeon

# Remove published files (optional)
rm -rf public/vendor/logeon
rm -rf resources/views/vendor/logeon
rm config/logeon.php
```

## Next Steps

1. Configure middleware for security
2. Customize views and styles
3. Set up log rotation
4. Monitor logs regularly
5. Report issues on GitHub

## Support

For help:
- GitHub Issues: https://github.com/KawsarAhmad43/logeon/issues
- Email: kawsar@mediusware.com
- Documentation: https://github.com/KawsarAhmad43/logeon
