<?php

require_once __DIR__ . '/../config/jwt.php';
require_once __DIR__ . '/../middleware/auth.php';

function listEmployee() {
    authenticate();

    $ch = curl_init(BE_BASE_URL . '/api_be/list_employee');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_TIMEOUT        => 10,
    ]);

    $response  = curl_exec($ch);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);

    if ($curlError) {
        http_response_code(502);
        echo json_encode([
            'status'  => 'error',
            'code'    => 502,
            'message' => 'Failed to reach backend: ' . $curlError
        ]);
        return;
    }

    http_response_code($httpCode);
    echo $response;
}

listEmployee();
