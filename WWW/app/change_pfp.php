<?php
session_start();
include __DIR__ . "/../database.php";

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];
$pfp = $data['pfp'];

$stmt = $conn->prepare("UPDATE users SET pfp=? WHERE id=?");
$stmt->bind_param("ii", $pfp, $user_id);
$stmt->execute();

echo json_encode(["success" => true]);
?>