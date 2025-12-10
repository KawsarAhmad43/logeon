<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Logeon Route Prefix
    |--------------------------------------------------------------------------
    |
    | This value determines the route prefix for accessing the log viewer.
    | Default: 'logger'
    | Access at: http://yourapp.com/logger
    |
    */
    'route_prefix' => env('LOGEON_ROUTE_PREFIX', 'logger'),

    /*
    |--------------------------------------------------------------------------
    | Logeon Middleware
    |--------------------------------------------------------------------------
    |
    | Define middleware to protect the log viewer route.
    | Example: ['web', 'auth', 'admin']
    |
    */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Log File Path
    |--------------------------------------------------------------------------
    |
    | The path to the Laravel log file to be displayed.
    | Default: storage_path('logs/laravel.log')
    |
    */
    'log_file' => storage_path('logs/laravel.log'),

    /*
    |--------------------------------------------------------------------------
    | Logs Per Page
    |--------------------------------------------------------------------------
    |
    | Number of log entries to display per page in the viewer.
    |
    */
    'per_page' => 10,

    /*
    |--------------------------------------------------------------------------
    | Enable Test Route
    |--------------------------------------------------------------------------
    |
    | Enable or disable the /test-logs route for generating sample logs.
    | Set to false in production!
    |
    */
    'enable_test_route' => env('LOGEON_ENABLE_TEST_ROUTE', env('APP_ENV') !== 'production'),

];

