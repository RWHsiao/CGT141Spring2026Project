<?php
session_start();
include __DIR__ . "/../database.php";

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();

session_destroy();

echo json_encode(["success" => true]);
?>