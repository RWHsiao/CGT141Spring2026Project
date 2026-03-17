<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <Title>Home</Title>
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
            $currentPage = 'games';
            include "navbar.php";
            ?>
<!--
            <nav class="navbar navbar-inverse">
                <div id="navigation-container" class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="navbar-brand" href="index.php">
                            <img src="Images/Logo.png" alt="Logo" id="logo-img"/>
                        </a>

                    </div>

                    <div class="collapse navbar-collapse" id="main-navbar">

                        <ul id="navbar-left-group" class="nav navbar-nav">
                            <li><a href="index.php">Home</a></li>
                            <li class="active"><a href="games.html">Games</a></li>
                            <li><a href="leaderboards.html">Leaderboards</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a id="user-container" class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="navbar-text">Username</span>
                                    <span class="navbar-btn">
                                        <img src="Images/PFP.png" alt="PFP" id="profile-img">
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Logout</a></li>
                                </ul>
                            </li>
                        </ul>

                    </div>

                </div>
            </nav>
-->
            <div id="games-content">
                <h1>
                    Games
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
                                <li><a href="#" class="sort-option" data-sort="az">Name (A-Z)</a></li>
                                <li><a href="#" class="sort-option" data-sort="za">Name (Z-A)</a></li>
                                <li><a href="#" class="sort-option" data-sort="new">Plays (Highest)</a></li>
                                <li><a href="#" class="sort-option" data-sort="old">Plays (Lowest)</a></li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="game-list">

                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        <button class="game-item btn">
                            <span class="game-name">Game Name</span>
                            <span class="game-info">
                                <span class="game-plays">Plays: 0</span>
                                <span class="game-high-score">Highest Score: --</span>
                            </span>
                        </button>
                        

                    </div>
                </div>
            </div>
            

        </div>
    </body>
</html>