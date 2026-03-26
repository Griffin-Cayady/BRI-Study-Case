<?php

require_once __DIR__ . '/../config/database.php';

function listEmployee() {
    $conn = getConnection();

    $result = $conn->query("CALL sp_list_employee()");

    if (!$result) {
        http_response_code(500);
        echo json_encode([
            'status'  => 'error',
            'code'    => 500,
            'message' => 'Query failed: ' . $conn->error
        ]);
        $conn->close();
        return;
    }

    $employees = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();

    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'code'   => 200,
        'data'   => $employees
    ]);
}

listEmployee();
