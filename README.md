# Logeon - Laravel Log Viewer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mediusware/logeon.svg?style=flat-square)](https://packagist.org/packages/mediusware/logeon)
[![Total Downloads](https://img.shields.io/packagist/dt/mediusware/logeon.svg?style=flat-square)](https://packagist.org/packages/mediusware/logeon)
[![License](https://img.shields.io/packagist/l/mediusware/logeon.svg?style=flat-square)](https://packagist.org/packages/mediusware/logeon)

A beautiful, modern Laravel log viewer with filtering, charts, and real-time monitoring capabilities.

![Logeon Dashboard](https://via.placeholder.com/800x400?text=Logeon+Dashboard)

## ✨ Features

- 🎨 **Beautiful UI** - Clean, modern interface with Bootstrap 5
- 📊 **Visual Charts** - Pie chart showing log distribution by type
- 🔍 **Advanced Filtering** - Filter by date range and log type
- 🎯 **4 Log Types** - INFO, ERROR, WARNING, CUSTOM
- 📝 **Stack Traces** - Full exception details with formatted stack traces
- ⚡ **Real-time** - Instant log updates
- 🎨 **Customizable** - Publishable views, assets, and configuration
- 🔒 **Secure** - Configurable middleware protection
- 📱 **Responsive** - Works on desktop, tablet, and mobile

## 📋 Requirements

- PHP 8.2 or higher
- Laravel 11.x or 12.x

## 🚀 Installation

### Step 1: Install via Composer

```bash
composer require mediusware/logeon
```

### Step 2: Publish Assets

Publish the package assets (CSS, JS) to your public directory:

```bash
php artisan vendor:publish --tag=logeon-assets
```

### Step 3: Access the Dashboard

Visit your application at:

```
http://yourapp.com/logger
```

That's it! 🎉

## 📖 Usage

### Viewing Logs

After installation, access the log viewer at `/logger` in your browser. The dashboard will display:

- **Pie Chart**: Visual representation of log distribution
- **Filters**: Date range and type filters
- **Log Table**: Paginated list of logs with details
- **Log Details**: Click any log to view full details in a modal

### Generating Test Logs

If you want to generate sample logs for testing:

```php
// In your controller or tinker
\Log::info('User logged in', ['user_id' => 123]);
\Log::error('Payment failed', ['order_id' => 456]);
\Log::warning('API rate limit approaching', ['current' => 95]);
```

Or enable the test route in configuration and visit `/test-logs`.

## ⚙️ Configuration

### Publish Configuration File

```bash
php artisan vendor:publish --tag=logeon-config
```

This creates `config/logeon.php`:

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

### Environment Variables

Add these to your `.env` file:

```env
LOGEON_ROUTE_PREFIX=logger
LOGEON_ENABLE_TEST_ROUTE=true
```

## 🔒 Security

### Protecting the Log Viewer

By default, the log viewer is accessible to anyone. To protect it, add middleware in the configuration:

```php
// config/logeon.php
'middleware' => ['web', 'auth', 'admin'],
```

Or create a custom middleware:

```php
'middleware' => ['web', 'can:view-logs'],
```

## 🎨 Customization

### Custom Route Prefix

Change the route prefix in `config/logeon.php`:

```php
'route_prefix' => 'admin/logs',
```

Access at: `http://yourapp.com/admin/logs`

### Custom Log File

Point to a different log file:

```php
'log_file' => storage_path('logs/custom.log'),
```

### Custom Views

Publish and customize the views:

```bash
php artisan vendor:publish --tag=logeon-views
```

Views will be published to `resources/views/vendor/logeon/index.blade.php`

## 📊 Log Types

Logeon categorizes Laravel logs into 4 types:

| Laravel Level | Logeon Type | Color  | Description |
|--------------|-------------|--------|-------------|
| emergency, alert, critical, error | **ERROR** | 🔴 Red | Critical errors and exceptions |
| warning, notice | **WARNING** | 🟡 Yellow | Warnings and notices |
| info, debug | **INFO** | 🔵 Blue | Informational messages |
| custom | **CUSTOM** | 🟣 Purple | Custom log levels |

## 🎯 Features in Detail

### 1. Filtering

- **Date Range Filter**: Filter logs by from/to dates
- **Type Filter**: Filter by log type using dropdown or clickable badges
- **Combined Filters**: Use multiple filters together
- **Badge Sync**: Clicking badges automatically updates the dropdown

### 2. Visual Dashboard

- **Pie Chart**: Visual representation of log distribution
- **Clickable Badges**: Quick filtering by clicking type badges
- **Pagination**: Navigate through large log files
- **Modal Details**: Click any log to view full details including stack traces

### 3. Log Parsing

- Parses all Laravel log levels
- Extracts timestamps, levels, messages, and context
- Formats exception stack traces with line breaks
- Pretty prints JSON context data
- Sorts logs by timestamp (newest first)

## 📚 Documentation

- [Installation Guide](INSTALLATION.md) - Detailed installation instructions
- [Architecture](ARCHITECTURE.md) - Package architecture and design
- [Publishing Guide](PUBLISHING_GUIDE.md) - How to publish to Packagist
- [Changelog](CHANGELOG.md) - Version history

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 👨‍💻 Credits

- **Kawsar Ahmad** - [GitHub](https://github.com/KawsarAhmad43)
- **Mediusware** - [Website](https://mediusware.com)

## 🐛 Support

For issues, questions, or contributions:

- **GitHub Issues**: [https://github.com/KawsarAhmad43/logeon/issues](https://github.com/KawsarAhmad43/logeon/issues)
- **Email**: kawsarahmad43@gmail.com
- **Packagist**: [https://packagist.org/packages/mediusware/logeon](https://packagist.org/packages/mediusware/logeon)

## ⭐ Show Your Support

If you find this package helpful, please give it a ⭐ on [GitHub](https://github.com/KawsarAhmad43/logeon)!

---

Made with ❤️ by [Kawsar Ahmad](https://github.com/KawsarAhmad43) and [Mediusware](https://mediusware.com)
