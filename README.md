# Logeon - Laravel Log Viewer

A beautiful, modern Laravel log viewer with advanced filtering, visual charts, and real-time monitoring capabilities.

## Features

✨ **Beautiful UI** - Clean, modern interface with Bootstrap 5  
📊 **Visual Charts** - Pie chart showing log distribution by type  
🔍 **Advanced Filtering** - Filter by date range and log type  
🎯 **4 Log Types** - INFO, ERROR, WARNING, CUSTOM  
📝 **Stack Traces** - Full exception details with formatted stack traces  
⚡ **Real-time** - Instant log updates  
🎨 **Customizable** - Publishable views, assets, and configuration  
🔒 **Secure** - Configurable middleware protection  

## Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x

## Installation

### Step 1: Install via Composer

```bash
composer require kawsarahmad43/logeon
```

### Step 2: Publish Assets

Publish the package assets (CSS, JS, views, config) to your project:

```bash
php artisan vendor:publish --tag=logeon-assets
```

### Step 3: (Optional) Publish Configuration

If you want to customize the configuration:

```bash
php artisan vendor:publish --tag=logeon-config
```

### Step 4: (Optional) Publish Views

If you want to customize the views:

```bash
php artisan vendor:publish --tag=logeon-views
```

Or publish everything at once:

```bash
php artisan vendor:publish --tag=logeon
```

## Usage

After installation, access the log viewer at:

```
http://yourapp.com/logger
```

### Generate Test Logs

If you have enabled the test route in your configuration, you can generate sample logs:

```
http://yourapp.com/test-logs
```

## Configuration

The configuration file is located at `config/logeon.php` after publishing:

```php
return [
    'route_prefix' => env('LOGEON_ROUTE_PREFIX', 'logger'),
    'middleware' => ['web'],
    'log_file' => storage_path('logs/laravel.log'),
    'per_page' => 10,
    'enable_test_route' => env('LOGEON_ENABLE_TEST_ROUTE', env('APP_ENV') !== 'production'),
];
```

## Security

By default, the log viewer is accessible to anyone. To protect it, add middleware in the configuration:

```php
'middleware' => ['web', 'auth', 'admin'],
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Support

For issues or questions, please visit:
- GitHub: https://github.com/KawsarAhmad43/logeon
- Email: ahmad43.bu@gmail.com
