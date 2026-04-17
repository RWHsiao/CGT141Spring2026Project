<?php
include __DIR__ . "/../header.php";
require_once __DIR__ . "/../session.php";
include __DIR__ . "/../database.php";
include __DIR__ . "/../game_variants.php";

$user_id = $_SESSION['user_id'];
$result = [];

foreach($games as $gameName => $variants) {
    foreach($variants as $variant => $settings) {

        $stmt = $conn->prepare("
            SELECT COUNT(*) as plays, MAX(score) as high_score 
            FROM scores 
            WHERE game_name = ? AND variant = ? AND user_id = ?
        ");
        $stmt->bind_param("ssi", $gameName, $variant, $user_id);
        $stmt->execute();
        $stmt->bind_result($plays, $highScore);
        $stmt->fetch();
        $stmt->close();

        if ($plays === 0) $highScore = '--';

        $result[] = [
            "game" => $gameName,
            "variant" => $variant,
            "plays" => $plays,
            "high_score" => $highScore,
            "user_id" => $user_id
        ];
    }
}

echo json_encode($result);
