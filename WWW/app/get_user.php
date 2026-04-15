<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");
session_start();
include __DIR__ . "/../database.php";

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
