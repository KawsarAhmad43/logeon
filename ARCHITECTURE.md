# Logeon Package Architecture

## Overview

Logeon is a Laravel package that provides a beautiful log viewer with advanced filtering and visualization capabilities. This document describes the package structure and how it integrates with Laravel applications.

## Package Structure

```
logeon-package/
├── src/
│   ├── Providers/
│   │   └── LogeonServiceProvider.php      # Service provider for package registration
│   └── Http/
│       └── Controllers/
│           └── LogeonController.php       # Main controller for log handling
├── config/
│   └── logeon.php                         # Configuration file
├── resources/
│   ├── views/
│   │   └── index.blade.php               # Main dashboard view
│   └── assets/
│       ├── css/
│       │   └── logeon.css                # Styling
│       └── js/
│           └── logeon.js                 # Frontend logic
├── routes/
│   └── web.php                           # Package routes
├── tests/                                 # Unit tests
├── composer.json                          # Package metadata
├── README.md                              # Documentation
├── LICENSE.md                             # MIT License
├── CHANGELOG.md                           # Version history
└── ARCHITECTURE.md                        # This file
```

## Installation Flow

### Step 1: Composer Installation
```bash
composer require mediusware/logeon
```

The package is installed to `vendor/mediusware/logeon/`

### Step 2: Auto-Discovery
Laravel's auto-discovery automatically registers the `LogeonServiceProvider` via the `extra.laravel.providers` configuration in `composer.json`.

### Step 3: Service Provider Registration
The `LogeonServiceProvider` is automatically loaded and:
- Merges configuration from `config/logeon.php`
- Loads routes from `routes/web.php`
- Loads views from `resources/views` with namespace `logeon::`
- Registers publishable assets

### Step 4: Asset Publishing
```bash
php artisan vendor:publish --tag=logeon-assets
```

This copies:
- **Config**: `config/logeon.php` → `config/logeon.php`
- **Views**: `resources/views/` → `resources/views/vendor/logeon/`
- **Assets**: `resources/assets/` → `public/vendor/logeon/`

## Resource Installation Locations

When a user installs the package, resources are published to:

### Configuration
```
vendor/mediusware/logeon/config/logeon.php
    ↓ (published to)
config/logeon.php
```

### Views
```
vendor/mediusware/logeon/resources/views/index.blade.php
    ↓ (published to)
resources/views/vendor/logeon/index.blade.php
```

### Assets (CSS/JS)
```
vendor/mediusware/logeon/resources/assets/css/logeon.css
vendor/mediusware/logeon/resources/assets/js/logeon.js
    ↓ (published to)
public/vendor/logeon/css/logeon.css
public/vendor/logeon/js/logeon.js
```

## Service Provider Details

### Register Method
- Merges package configuration with application configuration
- Allows users to override settings via `config/logeon.php`

### Boot Method
- Loads routes from `routes/web.php`
- Loads views with namespace `logeon::`
- Registers publishable assets with tags:
  - `logeon-config` - Configuration file only
  - `logeon-views` - Views only
  - `logeon-assets` - CSS/JS assets only
  - `logeon` - All resources

## Routes

The package registers the following routes (configurable via `config/logeon.php`):

```php
GET  /logger              → LogeonController@index    (name: logeon.index)
GET  /logger/logs         → LogeonController@getLogs  (name: logeon.logs)
GET  /test-logs           → Generate test logs        (conditional)
```

Route prefix and middleware are configurable:
```php
'route_prefix' => env('LOGEON_ROUTE_PREFIX', 'logger'),
'middleware' => ['web'],
```

## Controller Flow

### LogeonController

**index()** - Display the dashboard
1. Reads configuration
2. Renders `logeon::index` view
3. Passes configuration to view

**getLogs()** - API endpoint for log data
1. Reads log file from configured path
2. Parses logs using regex patterns
3. Maps log levels to 4 types (info, error, warn, custom)
4. Returns JSON response with:
   - Timestamp
   - Log type
   - Message
   - Context (if available)
   - Stack trace (if exception)

## Frontend Architecture

### Views (Blade)
- Uses Bootstrap 5 for styling
- Includes Chart.js for visualization
- Dynamic API endpoint via `window.LOGEON_API_URL`

### JavaScript (logeon.js)
- Fetches logs from API endpoint
- Implements filtering logic:
  - Type filtering (dropdown + badges)
  - Date range filtering
  - Combined filtering
- Updates pie chart dynamically
- Handles pagination
- Displays log details in modal

### Styling (logeon.css)
- Custom styles for dashboard
- Responsive design
- Badge styling
- Modal styling

## Configuration Options

```php
return [
    // Route prefix for accessing the log viewer
    'route_prefix' => env('LOGEON_ROUTE_PREFIX', 'logger'),
    
    // Middleware to protect the log viewer
    'middleware' => ['web'],
    
    // Path to the log file
    'log_file' => storage_path('logs/laravel.log'),
    
    // Number of logs per page
    'per_page' => 10,
    
    // Enable test route (disabled in production by default)
    'enable_test_route' => env('LOGEON_ENABLE_TEST_ROUTE', env('APP_ENV') !== 'production'),
];
```

## Log Parsing

The controller parses Laravel's monolog format:

```
[2025-12-10 11:30:01] local.INFO: User logged in {"user_id":123}
[2025-12-10 11:30:02] local.ERROR: Payment failed {"order_id":456}
```

Parsing steps:
1. Split logs by timestamp pattern
2. Extract timestamp, level, message
3. Parse JSON context if present
4. Extract stack trace if exception
5. Map level to type (info/error/warn/custom)

## Security Considerations

1. **Middleware Protection**: Configure middleware in `config/logeon.php`
   ```php
   'middleware' => ['web', 'auth', 'admin'],
   ```

2. **Production Safety**: Test route disabled by default in production

3. **Log File Access**: Only reads configured log file path

4. **No Database Access**: Reads from file system only

## Publishing Workflow

### For Package Developers

1. Create package in separate repository
2. Push to GitHub
3. Register on Packagist
4. Users install via `composer require mediusware/logeon`

### For Package Users

1. Install: `composer require mediusware/logeon`
2. Publish assets: `php artisan vendor:publish --tag=logeon-assets`
3. Configure: Edit `config/logeon.php` (optional)
4. Access: Visit `/logger` in browser

## Extending the Package

### Custom Configuration
Publish and edit `config/logeon.php`:
```bash
php artisan vendor:publish --tag=logeon-config
```

### Custom Views
Publish and edit views:
```bash
php artisan vendor:publish --tag=logeon-views
```

Edit `resources/views/vendor/logeon/index.blade.php`

### Custom Styling
Publish and edit CSS:
```bash
php artisan vendor:publish --tag=logeon-assets
```

Edit `public/vendor/logeon/css/logeon.css`

## Testing

Run tests:
```bash
composer test
```

Tests are located in `tests/` directory.

## Support

For issues or questions:
- GitHub: https://github.com/KawsarAhmad43/logeon
- Email: kawsar@mediusware.com
