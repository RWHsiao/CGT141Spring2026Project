<?php
session_start();
include "database.php";

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["loggedIn" => false]);
    exit;
}

$id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT username, pfp FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($username, $pfp);
$stmt->fetch();

echo json_encode([
    "loggedIn" => true,
    "username" => $username,
    "pfp" => $pfp
]);
?>