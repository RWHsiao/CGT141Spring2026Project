<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <Title>My Stats</Title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="/WWW/CSS/master.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div id="page-container" class="container-fluid">
            <?php
            $currentPage = 'stats';
            include "navbar.php";
            ?>
            <div id="games-content">
                <h1>
                    My Stats
                </h1>
                <div id="search-container" style="border: 2px solid red; margin-top: 0px;">
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
                                    WHERE game_name = ? AND variant = ? AND user_id = ?
                                ");
                                $stmt->bind_param("ssi", $gameName, $variant, $user_id);
                                $stmt->execute();
                                $stmt->bind_result($plays, $highScore);
                                $stmt->fetch();
                                $stmt->close();

                                if ($plays === 0) $highScore = '--';

                                echo "
                                <button class='game-item btn'
                                        data-name='" . htmlspecialchars($gameName . ' - ' . $variant) . "'
                                        data-plays='0'
                                        onclick='openModal(\"$gameName\", \"$variant\", $user_id)'>
                                    <span class='game-name'>{$gameName} - {$variant}</span>
                                    <span class='game-info'>
                                        <span class='game-plays'>My Plays: $plays</span>
                                        <span class='game-high-score'>My High Score: $highScore</span>
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
                                My High Scores
                            </h3>
                            <ul class="modal-list">
                                <li id="first" class="modal-item">
                                    <span>1</span>
                                    <span>1000</span>
                                </li>
                                <li id="second" class="modal-item">
                                    <span>2</span>
                                    <span>1000</span>
                                </li>
                                <li id="third" class="modal-item">
                                    <span>3</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item"> 
                                    <span>4</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span>5</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span>6</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span>7</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span>8</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span>9</span>
                                    <span>1000</span>
                                </li>
                                <li class="modal-item">
                                    <span>10</span>
                                    <span>1000</span>
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
            
        </div>
        <script src="/JS/search.js"></script>
        <script src="/JS/open_stat_modal.js"></script>
    </body>
</html>