<?php

define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'db_employee');
define('DB_USER', 'root');
define('DB_PASS', 'root');

function getConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($conn->connect_error) {
        http_response_code(500);
        echo json_encode([
            'status'  => 'error',
            'code'    => 500,
            'message' => 'Database connection failed: ' . $conn->connect_error
        ]);
        exit;
    }

    $conn->set_charset('utf8mb4');
    return $conn;
}
