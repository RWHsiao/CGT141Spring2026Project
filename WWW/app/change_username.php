<?php
include __DIR__ . "/../header.php";
require_once __DIR__ . "/../session.php";
include __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];
$username = $data['username'];

$stmt = $conn->prepare("UPDATE users SET username=? WHERE id=?");
$stmt->bind_param("si", $username, $user_id);
$stmt->execute();
$stmt->close(); 

echo json_encode(["success" => true]);
