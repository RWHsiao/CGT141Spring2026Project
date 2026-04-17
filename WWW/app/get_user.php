<?php
include __DIR__ . "/../header.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}
require_once __DIR__ . "/../session.php";
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
$stmt->close();


echo json_encode([
    "id" => $id,
    "loggedIn" => true,
    "username" => $username,
    "pfp" => $pfp
]);
