<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Home</title>
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
            $currentPage = 'home';
            include "navbar.php";
            ?>
            <div id="content">
                <div class="logo-container">
                    <img src="Images/Logo.jpg" alt="Logo" id="content-logo"/>
                </div>
                <br/>
                <p id="content-text">
                    This is a website for playing simple games 
                    (<a href="https://en.wikipedia.org/wiki/Flappy_Bird">Flappy Bird</a>, 
                    <a href="https://en.wikipedia.org/wiki/Snake_(video_game_genre)">Snake Game</a>, 
                    and <a href="https://en.wikipedia.org/wiki/Pong">Pong</a>) and some custom variants.
                </p>
                <p id="content-text">
                    This website was created by Ryan as a project for CGT 141.
                </p>
                <br/>
                <div id="press-start-container">
                    <img src="Images/Press_Start.gif" alt="Press Start Gif" id="press-start-gif"/>
                </div>
            </div>

        </div>
    </body>
</html>