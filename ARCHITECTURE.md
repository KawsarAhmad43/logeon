# Logeon Package Architecture

## Overview

Logeon is a Laravel package that provides a beautiful log viewer with filtering, charts, and real-time monitoring. This document explains the package architecture and how resources are installed into user projects.

## Package Structure

```
logeon/
├── src/
│   ├── LogeonServiceProvider.php          # Main service provider
│   └── Http/
│       └── Controllers/
│           └── LogeonController.php       # Log viewer controller
├── config/
│   └── logeon.php                         # Package configuration
├── resources/
│   ├── views/
│   │   └── index.blade.php               # Main dashboard view
│   └── assets/
│       ├── css/
│       │   └── logeon.css                # Styles
│       └── js/
│           └── logeon.js                 # Frontend logic
├── routes/
│   └── web.php                           # Package routes
├── composer.json                          # Package metadata
├── README.md                              # Documentation
├── CHANGELOG.md                           # Version history
├── LICENSE.md                             # MIT License
└── INSTALLATION.md                        # Installation guide
```

## Architecture Flow

### 1. Installation Process

```
┌─────────────────────────────────────────────────────────────┐
│  User runs: composer require mediusware/logeon              │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│  Composer downloads package from Packagist                  │
│  Package installed to: vendor/mediusware/logeon/            │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│  Laravel Auto-Discovery                                     │
│  Registers: LogeonServiceProvider                           │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│  Service Provider Boot Process                              │
│  - Loads routes from routes/web.php                         │
│  - Loads views from resources/views                         │
│  - Merges config from config/logeon.php                     │
│  - Registers publishable assets                             │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│  User runs: php artisan vendor:publish --tag=logeon-assets │
└────────────────────┬────────────────────────────────────────┘
                     │
                     ▼
┌─────────────────────────────────────────────────────────────┐
│  Assets Published to User's Project:                        │
│  - public/vendor/logeon/css/logeon.css                      │
│  - public/vendor/logeon/js/logeon.js                        │
└─────────────────────────────────────────────────────────────┘
```

### 2. Runtime Architecture

```
┌──────────────────────────────────────────────────────────────┐
│                    User's Laravel Project                     │
│                                                               │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  Routes (Auto-registered by Package)                   │  │
│  │  - GET /logger          → LogeonController@index       │  │
│  │  - GET /logger/logs     → LogeonController@getLogs     │  │
│  │  - GET /test-logs       → Generate test logs (optional)│  │
│  └────────────────────────────────────────────────────────┘  │
│                           │                                   │
│                           ▼                                   │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  LogeonController                                       │  │
│  │  - index(): Renders dashboard view                     │  │
│  │  - getLogs(): Parses laravel.log and returns JSON      │  │
│  └────────────────────────────────────────────────────────┘  │
│                           │                                   │
│                           ▼                                   │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  View: logeon::index                                    │  │
│  │  - Loads CSS from public/vendor/logeon/css/logeon.css  │  │
│  │  - Loads JS from public/vendor/logeon/js/logeon.js     │  │
│  └────────────────────────────────────────────────────────┘  │
│                           │                                   │
│                           ▼                                   │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  Frontend (logeon.js)                                   │  │
│  │  - Fetches logs from /logger/logs API                  │  │
│  │  - Renders chart with Chart.js                         │  │
│  │  - Handles filtering (date range, type)                │  │
│  │  - Manages pagination                                   │  │
│  └────────────────────────────────────────────────────────┘  │
│                           │                                   │
│                           ▼                                   │
│  ┌────────────────────────────────────────────────────────┐  │
│  │  Log File: storage/logs/laravel.log                     │  │
│  │  - Parsed by LogeonController                          │  │
│  │  - Supports: INFO, ERROR, WARNING, CUSTOM              │  │
│  │  - Includes stack traces for exceptions                │  │
│  └────────────────────────────────────────────────────────┘  │
└──────────────────────────────────────────────────────────────┘
```

## Component Details

### 1. Service Provider (`LogeonServiceProvider.php`)

**Responsibilities:**
- Register package routes
- Register package views with namespace `logeon::`
- Merge package configuration
- Publish assets, config, and views

**Key Methods:**
```php
register()  // Merges config
boot()      // Loads routes, views, publishes assets
```

### 2. Controller (`LogeonController.php`)

**Responsibilities:**
- Render the dashboard view
- Parse Laravel log files
- Map log levels to 4 categories (info, error, warn, custom)
- Format stack traces and context data
- Return logs as JSON API

**Key Methods:**
```php
index()              // Returns dashboard view
getLogs()            // Parses logs and returns JSON
mapLogLevel()        // Maps Laravel levels to 4 types
formatStackTrace()   // Formats exception traces
formatContext()      // Pretty prints JSON context
```

### 3. Frontend (`logeon.js`)

**Responsibilities:**
- Fetch logs from API endpoint
- Render pie chart with Chart.js
- Handle filtering (type, date range)
- Manage pagination
- Display log details in modal

**Key Features:**
- Real-time log updates
- Combined filters (type + date)
- Badge and dropdown synchronization
- Dynamic chart updates

### 4. Configuration (`config/logeon.php`)

**Configurable Options:**
```php
'route_prefix'       // Default: 'logger'
'middleware'         // Default: ['web']
'log_file'          // Default: storage_path('logs/laravel.log')
'per_page'          // Default: 10
'enable_test_route' // Default: false in production
```

## Resource Publishing

### Assets (Required)

```bash
php artisan vendor:publish --tag=logeon-assets
```

**Published to:**
- `public/vendor/logeon/css/logeon.css`
- `public/vendor/logeon/js/logeon.js`

### Config (Optional)

```bash
php artisan vendor:publish --tag=logeon-config
```

**Published to:**
- `config/logeon.php`

### Views (Optional)

```bash
php artisan vendor:publish --tag=logeon-views
```

**Published to:**
- `resources/views/vendor/logeon/index.blade.php`

### All Resources

```bash
php artisan vendor:publish --tag=logeon
```

## Log Parsing Logic

### Supported Log Levels

| Laravel Level | Logeon Type | Color  |
|--------------|-------------|--------|
| emergency    | error       | Red    |
| alert        | error       | Red    |
| critical     | error       | Red    |
| error        | error       | Red    |
| warning      | warn        | Yellow |
| notice       | warn        | Yellow |
| info         | info        | Blue   |
| debug        | info        | Blue   |
| custom       | custom      | Purple |

### Log Format Support

1. **Simple Logs**
   ```
   [2025-12-10 12:00:00] local.INFO: User logged in
   ```

2. **Logs with Context**
   ```
   [2025-12-10 12:00:00] local.INFO: User logged in {"user_id":123}
   ```

3. **Logs with Exceptions**
   ```
   [2025-12-10 12:00:00] local.ERROR: Payment failed
   Stack trace:
   #0 /path/to/file.php(123): method()
   #1 {main}
   ```

## Security Considerations

### Default Security
- Routes use `web` middleware by default
- Test route disabled in production

### Recommended Protection

Add authentication middleware in config:
```php
'middleware' => ['web', 'auth', 'admin'],
```

Or use custom middleware:
```php
'middleware' => ['web', 'can:view-logs'],
```

## Customization

### Custom Route Prefix

```php
// config/logeon.php
'route_prefix' => 'admin/logs',
```

Access at: `http://yourapp.com/admin/logs`

### Custom Log File

```php
// config/logeon.php
'log_file' => storage_path('logs/custom.log'),
```

### Custom Views

After publishing views, customize:
```
resources/views/vendor/logeon/index.blade.php
```

## Dependencies

### PHP Dependencies
- PHP ^8.2
- Laravel ^11.0 or ^12.0

### Frontend Dependencies (CDN)
- Bootstrap 5.3.3
- Chart.js (latest)

## Performance Considerations

1. **Large Log Files**: The package reads the entire log file. For very large files (>100MB), consider log rotation.

2. **Caching**: No caching is implemented by default. Logs are parsed on each request.

3. **Pagination**: Frontend pagination only. All logs are loaded initially.

## Future Enhancements

- [ ] Server-side pagination for large log files
- [ ] Real-time log streaming with WebSockets
- [ ] Log file rotation management
- [ ] Export logs to CSV/JSON
- [ ] Search functionality
- [ ] Multiple log file support
- [ ] Log level statistics over time

## Support

- **GitHub**: https://github.com/KawsarAhmad43/logeon
- **Issues**: https://github.com/KawsarAhmad43/logeon/issues
- **Email**: kawsarahmad43@gmail.com

## License

MIT License - See LICENSE.md for details
