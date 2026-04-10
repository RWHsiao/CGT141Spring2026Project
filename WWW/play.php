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
$_SESSION['current_game'] = $gameName;
$_SESSION['current_variant'] = $variant;

$settings = $games[$gameName][$variant] ?? null;
if (!$settings) {
    die("Invalid game or variant");
}

$script = $settings['script'];
unset($settings['script']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Play</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="/CSS/master.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="Images/Logo.jpg" type="image/jpg">
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
                    <a>
                        <span class="glyphicon glyphicon-remove"></span>
                    </a>
                </div>
            </header>
            
            <div id="controls-container">
                <button id="controls-btn" class="btn btn-info">Controls</button>
            </div>
            

            <div id="game-container">
                <canvas id="game-canvas"></canvas>
                <div id="game-over-popup" class="hidden">
                    <div id="popup-content">
                        <h1 id="game-over">Game Over</h1>
                        <p id="final-score">Score: 0</p>
                        <button id="restart-btn">Play Again</button>
                        <button id="exit-btn">Exit</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exit-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Confirm Exit</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to exit? Your progress will be lost, and your score will not be saved.</p>
                    </div>
                    <div class="modal-footer">
                        <button id="cancel-exit" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button id="confirm-exit" class="btn btn-danger">Exit</button>
                    </div>
                    </div>
                </div>
            </div>

            <div id="controls-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="controls-modal-title">GamesControls</h4>
                        </div>
                        <div class="modal-body" id="controls-modal-body">
                            <p>Text</p>
                        </div>
                        <div class="modal-footer">
                            <button id="controls-modal-button" class="btn btn-primary">Ok</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script>
            const GAME_SETTINGS = <?php echo json_encode($settings); ?>;
        </script>

        <script src="/JS/play_manager.js"></script>
        <script src="/JS/game_over_logic.js"></script>
        <script src="\JS\Games\<?php echo $script; ?>"></script>
        <script>
            resizeCanvas();
            scalePopup();
        </script>
    </body>
</html>