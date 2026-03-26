<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/config/logger.php';

$startTime = microtime(true);
ob_start();

$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri    = rtrim($uri, '/');
$method = $_SERVER['REQUEST_METHOD'];

$routes = [
    'POST' => [
        '/api_fe/auth/login'    => __DIR__ . '/handlers/login.php',
    ],
    'GET' => [
        '/api_fe/list_employee' => __DIR__ . '/handlers/list_employee.php',
    ],
];

if (isset($routes[$method][$uri])) {
    require $routes[$method][$uri];
} else {
    http_response_code(404);
    echo json_encode([
        'status'  => 'error',
        'code'    => 404,
        'message' => 'Endpoint not found. Available: POST /api_fe/auth/login | GET /api_fe/list_employee'
    ]);
}

$responseTimeMs = round((microtime(true) - $startTime) * 1000);
$ip             = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

global $logContext;
writeFeLog($method, $uri, $ip, http_response_code(), $responseTimeMs, $logContext ?? []);

ob_end_flush();
