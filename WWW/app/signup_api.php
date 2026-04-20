<?php
include __DIR__ . "/../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include __DIR__ . "/../database.php";
require_once __DIR__ . "/../session.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];
$password2 = $_POST['password2'];

$pfp_raw = $_POST['pfp'] ?? 'pfp1';
$pfp = (int)substr($pfp_raw, 3);
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$insert = $conn->prepare("INSERT INTO users (username, password, pfp) VALUES (?, ?, ?)");
$insert->bind_param("ssi", $username, $hashed_password, $pfp);

if ($insert->execute()) {
    $insert->close();
    $success = true;
    echo json_encode([
        "success" => true,
        "message" => "Signup successful"
    ]);
}
else {
    $insert->close();
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $conn->error
    ]);
}
exit;