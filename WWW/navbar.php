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
?>

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
                <li class="<?php echo ($currentPage === 'home') ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
                <li class="<?php echo ($currentPage === 'games') ? 'active' : ''; ?>"><a href="games.php">Games</a></li>
                <li class="<?php echo ($currentPage === 'leaderboards') ? 'active' : ''; ?>"><a href="leaderboards.php">Leaderboards</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <?php if ($loggedIn): ?>
                    <li>
                        <a id="user-container" class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <span class="navbar-text"><?php echo htmlspecialchars($username); ?></span>
                            <span class="navbar-btn">
                                <img src="Images/PFP<?php echo $pfpNum; ?>.png" alt="PFP" id="profile-img">
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login/Sign Up<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="login.php">Login</a></li>
                            <li><a href="sign_up.php">Sign Up</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>

        </div>

    </div>
</nav>