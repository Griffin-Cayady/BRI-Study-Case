<?php

define('BE_LOG_FILE', __DIR__ . '/../logs/api_be.log');

function writeBeLog($method, $endpoint, $ip, $status, $responseTimeMs, $context = []) {
    $logDir = dirname(BE_LOG_FILE);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }

    $entry = [
        'timestamp'        => date('c'),
        'method'           => $method,
        'endpoint'         => $endpoint,
        'ip'               => $ip,
        'status'           => $status,
        'response_time_ms' => $responseTimeMs,
    ];

    if (!empty($context)) {
        $entry['context'] = $context;
    }

    file_put_contents(BE_LOG_FILE, json_encode($entry) . PHP_EOL, FILE_APPEND | LOCK_EX);
}
