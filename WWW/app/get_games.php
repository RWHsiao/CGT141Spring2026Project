<?php
include __DIR__ . "/../header.php";
require_once __DIR__ . "/../session.php";
include __DIR__ . "/../database.php";
include __DIR__ . "/../game_variants.php";

$result = [];

foreach ($games as $gameName => $variants) {
    foreach ($variants as $variant => $settings) {

        $stmt = $conn->prepare("
            SELECT COUNT(*) as plays, MAX(score) as high_score 
            FROM scores 
            WHERE game_name = ? AND variant = ?
        ");
        $stmt->bind_param("ss", $gameName, $variant);
        $stmt->execute();
        $stmt->bind_result($plays, $highScore);
        $stmt->fetch();
        $stmt->close();

        if ($plays === 0) $highScore = '--';

        $result[] = [
            "game" => $gameName,
            "variant" => $variant,
            "plays" => $plays,
            "high_score" => $highScore
        ];
    }
}

echo json_encode($result);
