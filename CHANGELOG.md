# Changelog

All notable changes to `logeon` will be documented in this file.

## [1.0.0] - 2025-12-10

### Added
- Initial release
- Beautiful log viewer dashboard with Bootstrap 5
- Support for 4 log types: INFO, ERROR, WARNING, CUSTOM
- Advanced filtering by date range and log type
- Visual pie chart showing log distribution
- Clickable badges for quick type filtering
- Modal popup for detailed log view
- Full stack trace display for exceptions
- JSON context formatting for structured logs
- Pagination for large log files
- Configurable route prefix and middleware
- Publishable views, assets, and configuration
- Test route for generating sample logs
- Automatic production safety (test route disabled)
- Real-time log parsing from laravel.log
- Responsive design for mobile and desktop

### Features
- Parse all Laravel log levels
- Map log levels to 4 categories for simplified viewing
- Format exception stack traces with line breaks
- Pretty print JSON context data
- Sort logs by timestamp (newest first)
- Dynamic chart updates based on filters
- Combined filtering (date + type)
- Badge and dropdown filter synchronization
