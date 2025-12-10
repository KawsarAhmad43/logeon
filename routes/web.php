<?php

use Illuminate\Support\Facades\Route;
use Mediusware\Logeon\Http\Controllers\LogeonController;

$prefix = config('logeon.route_prefix', 'logger');
$middleware = config('logeon.middleware', ['web']);

Route::middleware($middleware)->prefix($prefix)->group(function () {
    Route::get('/', [LogeonController::class, 'index'])->name('logeon.index');
    Route::get('/logs', [LogeonController::class, 'getLogs'])->name('logeon.logs');
});

// Test route (only if enabled in config)
if (config('logeon.enable_test_route', false)) {
    Route::middleware($middleware)->get('/test-logs', function () {
        // INFO logs
        \Log::info('User logged in successfully', ['user_id' => 123, 'ip' => '192.168.1.1']);
        \Log::info('Application started');
        \Log::info('Database connection established', ['driver' => 'mysql', 'host' => 'localhost']);
        
        // WARNING logs
        \Log::warning('API rate limit approaching', ['current' => 95, 'limit' => 100]);
        \Log::warning('Cache is getting full');
        \Log::warning('Disk space low', ['available' => '2GB', 'total' => '100GB']);
        
        // ERROR logs
        \Log::error('Payment processing failed', ['order_id' => 456, 'amount' => 99.99]);
        \Log::error('Email sending failed', ['recipient' => 'user@example.com', 'error' => 'SMTP timeout']);
        
        // CUSTOM logs (using NOTICE level which maps to 'warn' but can be distinguished)
        \Log::notice('Custom event triggered', ['event' => 'user_action', 'category' => 'custom']);
        \Log::notice('Feature flag toggled', ['feature' => 'new_ui', 'enabled' => true]);
        
        return 'Test logs generated! Check <a href="/' . config('logeon.route_prefix', 'logger') . '">/logger</a>';
    })->name('logeon.test');
}

