<?php

namespace KawsarAhmad43\Logeon\Http\Controllers;

use Illuminate\Routing\Controller;

class LogeonController extends Controller
{
    public function index()
    {
        return view('logeon::index');
    }

    public function getLogs()
    {
        $logFile = config('logeon.log_file', storage_path('logs/laravel.log'));

        if (!file_exists($logFile)) {
            return response()->json([]);
        }

        $content = file_get_contents($logFile);
        $logs = [];

        // Split log entries by timestamp pattern
        $pattern = '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] local\.(\w+): /';
        $parts = preg_split($pattern, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

        // Process each log entry
        for ($i = 1; $i < count($parts); $i += 3) {
            if (!isset($parts[$i]) || !isset($parts[$i + 1]) || !isset($parts[$i + 2])) {
                continue;
            }

            $timestamp = $parts[$i];
            $level = strtolower($parts[$i + 1]);
            $messageAndContext = trim($parts[$i + 2]);

            // Map Laravel log levels to our 4 types: info, error, warn, custom
            $type = $this->mapLogLevel($level);

            // Extract message and details
            $message = '';
            $details = '';

            // Check if this log has exception context
            if (preg_match('/^(.+?)\s*\{"exception":"(.+)"\}\s*$/s', $messageAndContext, $matches)) {
                // Log with exception (usually ERROR)
                $message = trim($matches[1]);
                $details = $this->formatStackTrace($matches[2]);
            } elseif (preg_match('/^(.+?)\s*(\{.+\})\s*$/s', $messageAndContext, $matches)) {
                // Log with JSON context (INFO, WARNING, CUSTOM)
                $message = trim($matches[1]);
                $details = $this->formatContext($matches[2]);
            } else {
                // Simple log without context
                $message = $messageAndContext;
                $details = 'No additional context';
            }

            $logs[] = [
                'ts' => $timestamp,
                'type' => $type,
                'msg' => $message,
                'details' => $details
            ];
        }

        // Sort newest first
        usort($logs, function ($a, $b) {
            return strtotime($b['ts']) - strtotime($a['ts']);
        });

        return response()->json($logs);
    }

    /**
     * Map Laravel log levels to our 4 types
     */
    private function mapLogLevel($level)
    {
        $level = strtolower($level);

        switch ($level) {
            case 'error':
            case 'critical':
            case 'alert':
            case 'emergency':
                return 'error';

            case 'warning':
            case 'notice':
                return 'warn';

            case 'info':
            case 'debug':
                return 'info';

            default:
                return 'custom';
        }
    }

    /**
     * Format exception stack trace for better readability
     */
    private function formatStackTrace($exceptionString)
    {
        // Decode escaped characters
        $decoded = str_replace(['\\"', '\\\\'], ['"', '\\'], $exceptionString);

        // Format for better readability
        $formatted = preg_replace('/\[stacktrace\]/', "\n[STACKTRACE]", $decoded);
        $formatted = preg_replace('/#(\d+)/', "\n#$1", $formatted);

        return trim($formatted);
    }

    /**
     * Format JSON context for better readability
     */
    private function formatContext($jsonString)
    {
        try {
            $decoded = json_decode($jsonString, true);
            if ($decoded !== null) {
                return json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
            }
        } catch (\Exception) {
            // If JSON decode fails, return as is
        }

        return $jsonString;
    }
}

