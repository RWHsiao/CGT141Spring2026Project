<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Credentials: true");
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

$allowed = [
    "http://localhost:8000",
    "https://playvideogames.me"
];

if (in_array($origin, $allowed)) {
    header("Access-Control-Allow-Origin: $origin");
    header("Access-Control-Allow-Credentials: true");
}
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
include __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];

$old = $data['old'];
$new = $data['new'];

$stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "user_id" => $_SESSION['user_id'] ?? null,
        "error" => $conn->error
    ]);
    exit;
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hash);
$stmt->fetch();
$stmt->close(); 

if (!password_verify($old, $hash)) {
    echo json_encode([
        "success" => false,
        "user_id" => $_SESSION['user_id'] ?? null
    ]);
    exit;
}

$newHash = password_hash($new, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
if (!$stmt) {
    echo json_encode([
        "success" => false,
        "user_id" => $_SESSION['user_id'] ?? null,
        "error" => $conn->error
    ]);
    exit;
}
$stmt->bind_param("si", $newHash, $user_id);
$stmt->execute();
$stmt->close(); 

echo json_encode(["success" => true]);
