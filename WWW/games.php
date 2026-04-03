<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <Title>Games</Title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="/CSS/master.css" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        <div id="page-container" class="container-fluid">
            <?php
            $currentPage = 'games';
            include "navbar.php";
            ?>

            <div id="games-content">
                <h1>
                    Games
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
                                        onclick=\"location.href='play.php?game=" . urlencode($gameName) . "&variant=" . urlencode($variant) . "'\">
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
                </div>
            </div>
        
        </div>

        <script src="/JS/search.js"></script>
    </body>
</html>