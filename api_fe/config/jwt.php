<?php

define('JWT_SECRET', 'bri-secret-key-2026');
define('JWT_EXPIRY', 3600); // 1 hour in seconds
define('BE_BASE_URL', 'http://localhost:8001');

define('VALID_USERS', [
    'test' => 'test'
]);

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data) {
    return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4));
}

function jwtEncode($payload) {
    $header    = base64url_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
    $payload   = base64url_encode(json_encode($payload));
    $signature = base64url_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    return "$header.$payload.$signature";
}

function jwtDecode($token) {
    $parts = explode('.', $token);
    if (count($parts) !== 3) return null;

    [$header, $payload, $signature] = $parts;

    $expectedSig = base64url_encode(hash_hmac('sha256', "$header.$payload", JWT_SECRET, true));
    if (!hash_equals($expectedSig, $signature)) return null;

    $data = json_decode(base64url_decode($payload), true);
    if (!$data) return null;
    if ($data['exp'] < time()) return null;

    return $data;
}
