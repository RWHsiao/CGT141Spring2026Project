<?php
include "header.php";
require_once "session.php";
include "database.php";


$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("DELETE FROM users WHERE id = ?");

$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

session_unset();
session_destroy();

echo json_encode([
    "success" => true
]);
exit;