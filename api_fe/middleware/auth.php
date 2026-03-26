<?php

require_once __DIR__ . '/../config/jwt.php';

function authenticate() {
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
        http_response_code(401);
        echo json_encode([
            'status'  => 'error',
            'code'    => 401,
            'message' => 'Unauthorized: missing or invalid Authorization header'
        ]);
        exit;
    }

    $token   = substr($authHeader, 7);
    $payload = jwtDecode($token);

    if (!$payload) {
        http_response_code(401);
        echo json_encode([
            'status'  => 'error',
            'code'    => 401,
            'message' => 'Unauthorized: token is invalid or expired'
        ]);
        exit;
    }

    return $payload;
}
