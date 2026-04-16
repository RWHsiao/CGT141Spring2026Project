<?php
session_start();
include __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];

$old = $data['old'];
$new = $data['new'];

$stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hash);
$stmt->fetch();

if (!password_verify($old, $hash)) {
    echo json_encode(["success" => false]);
    exit;
}

$newHash = password_hash($new, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
$stmt->bind_param("si", $newHash, $user_id);
$stmt->execute();

echo json_encode(["success" => true]);
?>