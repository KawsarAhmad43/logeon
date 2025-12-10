# Logeon Package Structure

Complete overview of the Logeon package directory structure and file organization.

## Directory Tree

```
logeon-package/
├── src/                                    # Source code
│   ├── Providers/
│   │   └── LogeonServiceProvider.php      # Service provider (registers routes, views, assets)
│   └── Http/
│       └── Controllers/
│           └── LogeonController.php       # Main controller (handles log display & API)
│
├── config/                                 # Configuration
│   └── logeon.php                         # Package configuration file
│
├── resources/                              # Package resources
│   ├── views/
│   │   └── index.blade.php               # Dashboard view (Bootstrap 5 + Chart.js)
│   └── assets/
│       ├── css/
│       │   └── logeon.css                # Dashboard styling
│       └── js/
│           └── logeon.js                 # Frontend logic (filtering, charts, pagination)
│
├── routes/                                 # Package routes
│   └── web.php                           # Route definitions
│
├── tests/                                  # Unit tests
│   └── (test files)
│
├── composer.json                           # Package metadata & dependencies
├── README.md                               # Quick start guide
├── INSTALLATION.md                         # Detailed installation instructions
├── ARCHITECTURE.md                         # Technical architecture documentation
├── PUBLISHING_GUIDE.md                     # GitHub & Packagist publishing guide
├── CHANGELOG.md                            # Version history
├── LICENSE.md                              # MIT License
├── .gitignore                              # Git ignore rules
└── PACKAGE_STRUCTURE.md                    # This file
```

## File Descriptions

### Source Code

#### `src/Providers/LogeonServiceProvider.php`
- **Purpose**: Service provider for Laravel package auto-discovery
- **Responsibilities**:
  - Register configuration
  - Load routes
  - Load views
  - Publish assets to user's project
- **Key Methods**:
  - `register()` - Merge configuration
  - `boot()` - Load routes, views, and register publishables

#### `src/Http/Controllers/LogeonController.php`
- **Purpose**: Main application controller
- **Responsibilities**:
  - Display dashboard view
  - Parse log files
  - Return log data as JSON
  - Map log levels to types
- **Key Methods**:
  - `index()` - Display dashboard
  - `getLogs()` - API endpoint for log data
  - `mapLogLevel()` - Map Laravel levels to 4 types
  - `formatStackTrace()` - Format exception traces
  - `formatContext()` - Format JSON context

### Configuration

#### `config/logeon.php`
- **Purpose**: Package configuration
- **Options**:
  - `route_prefix` - URL prefix (default: 'logger')
  - `middleware` - Protection middleware
  - `log_file` - Path to log file
  - `per_page` - Pagination size
  - `enable_test_route` - Test log generation

### Resources

#### `resources/views/index.blade.php`
- **Purpose**: Main dashboard view
- **Features**:
  - Bootstrap 5 responsive layout
  - Filter panel (date range + type)
  - Pie chart (Chart.js)
  - Log table with pagination
  - Modal for log details
- **Assets Referenced**:
  - `vendor/logeon/css/logeon.css`
  - `vendor/logeon/js/logeon.js`

#### `resources/assets/css/logeon.css`
- **Purpose**: Dashboard styling
- **Includes**:
  - Filter card styles
  - Chart card styles
  - Log table styles
  - Badge styles
  - Modal styles
  - Responsive design

#### `resources/assets/js/logeon.js`
- **Purpose**: Frontend logic
- **Features**:
  - Fetch logs from API
  - Type filtering (dropdown + badges)
  - Date range filtering
  - Combined filtering
  - Pie chart updates
  - Pagination
  - Modal display
  - Filter synchronization

### Routes

#### `routes/web.php`
- **Purpose**: Package route definitions
- **Routes**:
  - `GET /logger` → `LogeonController@index` (dashboard)
  - `GET /logger/logs` → `LogeonController@getLogs` (API)
  - `GET /test-logs` → Generate test logs (conditional)
- **Configuration**:
  - Route prefix from config
  - Middleware from config

### Documentation

#### `README.md`
- Quick start guide
- Feature overview
- Installation steps
- Basic usage
- Configuration options

#### `INSTALLATION.md`
- Detailed installation instructions
- Configuration guide
- Usage examples
- Troubleshooting
- Security setup

#### `ARCHITECTURE.md`
- Technical architecture
- Installation flow
- Resource locations
- Service provider details
- Controller flow
- Frontend architecture
- Configuration options
- Security considerations

#### `PUBLISHING_GUIDE.md`
- GitHub repository setup
- Packagist registration
- Auto-update configuration
- Version numbering
- Maintenance guidelines

#### `CHANGELOG.md`
- Version history
- Feature list
- Release notes

#### `composer.json`
- Package metadata
- Dependencies
- Autoloading configuration
- Laravel auto-discovery
- Author information

#### `LICENSE.md`
- MIT License text

#### `.gitignore`
- Git ignore rules
- Vendor directory
- IDE files
- OS files

## Installation Flow

When a user installs the package:

```
1. composer require kawsarahmad43/logeon
   ↓
2. Package downloaded to vendor/kawsarahmad43/logeon/
   ↓
3. Auto-discovery registers LogeonServiceProvider
   ↓
4. Service provider loads routes and views
   ↓
5. php artisan vendor:publish --tag=logeon-assets
   ↓
6. Resources copied to user's project:
   - config/logeon.php
   - resources/views/vendor/logeon/
   - public/vendor/logeon/
   ↓
7. User accesses http://yourapp.com/logger
```

## Resource Publishing

### Published Locations

**Configuration**:
```
vendor/kawsarahmad43/logeon/config/logeon.php
    ↓ (published to)
config/logeon.php
```

**Views**:
```
vendor/kawsarahmad43/logeon/resources/views/index.blade.php
    ↓ (published to)
resources/views/vendor/logeon/index.blade.php
```

**Assets**:
```
vendor/kawsarahmad43/logeon/resources/assets/css/logeon.css
vendor/kawsarahmad43/logeon/resources/assets/js/logeon.js
    ↓ (published to)
public/vendor/logeon/css/logeon.css
public/vendor/logeon/js/logeon.js
```

## File Sizes

- `LogeonServiceProvider.php` - ~1.4 KB
- `LogeonController.php` - ~3.9 KB
- `logeon.php` (config) - ~0.5 KB
- `index.blade.php` - ~5.2 KB
- `logeon.css` - ~2.1 KB
- `logeon.js` - ~6.8 KB
- `web.php` (routes) - ~0.8 KB

**Total Package Size**: ~20 KB (excluding documentation)

## Dependencies

### Required
- PHP 8.2+
- Laravel 11.x or 12.x
- illuminate/support
- illuminate/routing

### Optional (for development)
- phpunit/phpunit
- laravel/framework

## Namespace Structure

```
KawsarAhmad43\Logeon\
├── LogeonServiceProvider
└── Http\
    └── Controllers\
        └── LogeonController
```

## Configuration Hierarchy

1. **Package Default** - `vendor/kawsarahmad43/logeon/config/logeon.php`
2. **Published Config** - `config/logeon.php` (if published)
3. **Environment Variables** - `.env` file
4. **Runtime Override** - `config('logeon.*')`

## Asset Publishing Tags

- `logeon-config` - Configuration only
- `logeon-views` - Views only
- `logeon-assets` - CSS/JS only
- `logeon` - All resources

## Extending the Package

### Custom Configuration
```bash
php artisan vendor:publish --tag=logeon-config
```
Edit `config/logeon.php`

### Custom Views
```bash
php artisan vendor:publish --tag=logeon-views
```
Edit `resources/views/vendor/logeon/index.blade.php`

### Custom Styles
```bash
php artisan vendor:publish --tag=logeon-assets
```
Edit `public/vendor/logeon/css/logeon.css`

## Version Information

- **Current Version**: 1.0.0
- **PHP Requirement**: ^8.2
- **Laravel Requirement**: ^11.0|^12.0
- **License**: MIT

## Support & Contribution

- **GitHub**: https://github.com/KawsarAhmad43/logeon
- **Packagist**: https://packagist.org/packages/kawsarahmad43/logeon
- **Issues**: https://github.com/KawsarAhmad43/logeon/issues
- **Email**: ahmad43.bu@gmail.com
