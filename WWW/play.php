<?php
session_start();
include "database.php";

$loggedIn = false;
$username = "";
$pfpNum = 1;

if (isset($_SESSION['user_id'])) {
    $loggedIn = true;
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT username, pfp FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($usernameDB, $pfpNumDB);
    if ($stmt->fetch()) {
        $username = $usernameDB;
        $pfpNum = $pfpNumDB;
    }
    $stmt->close();
}

include 'game_variants.php';

$gameName = $_GET['game'];
$variant = $_GET['variant'];

$settings = $games[$gameName][$variant] ?? null;
if (!$settings) {
    die("Invalid game or variant");
}

$script = $settings['script'];
unset($settings['script']);
?>

<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <Title>Play</Title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="/WWW/CSS/master.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div id="page-container" class="container-fluid">
            <header id="play-header">
                <?php if ($loggedIn): ?>
                    <div id="user-container">
                        <span class="navbar-text"><?php echo htmlspecialchars($username); ?></span>
                        <span class="navbar-btn">
                            <img src="Images/PFP<?php echo $pfpNum; ?>.png" alt="PFP" id="profile-img">
                        </span>
                    </div>
                <?php else: ?>
                    <div id="user-container">
                        <span class="navbar-text">Guest</span>
                    </div>
                <?php endif; ?>
                <h1>
                    <?php echo "{$gameName} - {$variant}"; ?>
                </h1>
                <div id="close-button">
                    <a href="games.php">
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </div>
            </header>

            <div id="game-container" style="border: 2px solid red;">
                <canvas id="gameCanvas"></canvas>
            </div>

        </div>
    </body>
</html>