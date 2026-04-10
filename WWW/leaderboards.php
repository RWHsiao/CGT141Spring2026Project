<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Leaderboards</title>
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
            <?php
            $currentPage = 'leaderboards';
            include "navbar.php";
            ?>
            <div id="games-content">
                <h1>
                    Leaderboards
                </h1>
                <div id="search-container">
                    <div id="search-header">
                        <input type="text" class="form-control" id="game-search" placeholder="Search games...">
 
                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
                                Sort
                                <span class="caret"></span>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-right">
                                <li><a class="sort-option" data-sort="high">Plays (Highest)</a></li>
                                <li><a class="sort-option" data-sort="low">Plays (Lowest)</a></li>
                                <li><a class="sort-option" data-sort="az">Name (A-Z)</a></li>
                                <li><a class="sort-option" data-sort="za">Name (Z-A)</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="game-list">

                        <?php
                        include "database.php";
                        include "game_variants.php";
                        

                        foreach($games as $gameName => $variants) {
                            foreach($variants as $variant => $settings) {

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

                                echo "
                                <button class='game-item btn'
                                        data-name='" . htmlspecialchars($gameName . ' - ' . $variant) . "'
                                        data-plays='0'
                                        onclick='openModal(\"$gameName\", \"$variant\")'>
                                    <span class='game-name'>{$gameName} - {$variant}</span>
                                    <span class='game-info'>
                                        <span class='game-plays'>Plays: $plays</span>
                                        <span class='game-high-score'>High Score: $highScore</span>
                                    </span>
                                </button>
                                ";
                            }
                        }
                        ?>

                    </div>

                    <div id="list-modal" class="modal-overlay">
                        <div class="modal-box">
                            <span class="modal-close">&times;</span>

                            <h3 id="modal-game-name">
                                Game Name
                            </h3>
                            <h3>
                                Leaderboard
                            </h3>
                            <ul class="modal-list">
                                <li id="first" class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">1</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li id="second" class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">2</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li id="third" class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">3</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">4</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">5</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">6</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">7</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">8</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">9</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span class="leader-info">
                                        <span class="rank">10</span>
                                        <span class="user-info">
                                            <img class="leader-pfp" src="Images/PFP1.png" alt="PFP">
                                            <span class="leader-username">Username</span>
                                        </span>
                                    </span>
                                    <span>1000</span>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        <script>
            window.currentUsername = <?php echo json_encode($username); ?>;
        </script>

        <script src="/JS/search.js"></script>
        <script src="/JS/open_leaderboard_modal.js"></script>
    </body>
</html>