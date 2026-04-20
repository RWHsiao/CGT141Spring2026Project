<?php
include "header.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
include "database.php";

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['available' => false]);
    } else {
        echo json_encode(['available' => true]);
    }

    $stmt->close();
}
