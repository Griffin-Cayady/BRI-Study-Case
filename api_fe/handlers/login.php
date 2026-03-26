<?php

require_once __DIR__ . '/../config/jwt.php';

function login() {
    $body     = json_decode(file_get_contents('php://input'), true);
    $username = $body['username'] ?? '';
    $password = $body['password'] ?? '';

    if (!$username || !$password) {
        http_response_code(400);
        echo json_encode([
            'status'  => 'error',
            'code'    => 400,
            'message' => 'username and password are required'
        ]);
        return;
    }

    if (!isset(VALID_USERS[$username]) || VALID_USERS[$username] !== $password) {
        addLogContext(['username' => $username, 'login_success' => false]);
        http_response_code(401);
        echo json_encode([
            'status'  => 'error',
            'code'    => 401,
            'message' => 'Invalid username or password'
        ]);
        return;
    }

    $now   = time();
    $token = jwtEncode([
        'username' => $username,
        'iat'      => $now,
        'exp'      => $now + JWT_EXPIRY
    ]);

    addLogContext(['username' => $username, 'login_success' => true]);
    http_response_code(200);
    echo json_encode([
        'status'     => 'success',
        'code'       => 200,
        'token'      => $token,
        'expires_in' => JWT_EXPIRY
    ]);
}

login();
