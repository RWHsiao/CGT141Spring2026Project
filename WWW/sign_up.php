<?php
include "database.php";
session_start();

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $pfp_raw = $_POST['pfp'] ?? 'pfp1';
    $pfp = (int)substr($pfp_raw, 3);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert = $conn->prepare("INSERT INTO users (username, password, pfp) VALUES (?, ?, ?)");
    $insert->bind_param("ssi", $username, $hashed_password, $pfp);

    if ($insert->execute()) {
        $success = true; // trigger modal
    } else {
        $message = "Error: " . $conn->error;
    }

    $insert->close();
}
?>

<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <Title>Sign Up</Title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="/WWW/CSS/master.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class="form-body">
        <div class="form-container" id="sign-up-container">
            <div id="close-button">
                <a href="index.php">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
            <div class="logo-container">
                <img src="Images/Logo.png" alt="Logo" id="form-logo"/>
            </div>
            <h2>Sign Up</h2>
            <a href="login.php">Login instead</a>
            <form class="form-fields" method="POST">
                <label for="username">Username</label><br/>
                <input type="text" class="text-input" id="username" name="username" required><br/>
                <span id="username-status"></span><br/>
                <br/>
                <label for="password">Password</label><br/>
                <input type="password" class="text-input" id="password" name="password" required><br/>
                <span id="password-status"></span><br/>
                <br/>
                <label for="password2">Re-enter Password</label><br/>
                <input type="password" class="text-input" id="password2" name="password2" required><br/>
                <span id="password2-status"></span><br/>
                <br/>
                <label for="username">Select Profile Picture</label><br/>
                <div class="pfp-selection">
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp1" required checked>
                        <img src="Images/PFP1.png" class="pfp-option">
                    </label>
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp2">
                        <img src="Images/PFP2.png" class="pfp-option">
                    </label>
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp3">
                        <img src="Images/PFP3.png" class="pfp-option">
                    </label>
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp4">
                        <img src="Images/PFP4.png" class="pfp-option">
                    </label>
                </div>
                <br/>
                <label>
                    <input id="robot-checkbox" type="checkbox" required>
                    I am not a robot
                </label>
                <br/>
                <br/>
                <input type="submit" id="submit-button" class="submit-button" value="Sign up" disabled>
                
            </form>

            <div id="successModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sign Up Successful!</h4>
                    </div>
                    <div class="modal-body">
                        <p>Your account has been created successfully. You may now log in.</p>
                    </div>
                    <div class="modal-footer">
                        <a href="login.php" class="btn btn-success">Go to Login</a>
                    </div>
                    </div>
                </div>
            </div>

            <?php if ($success): ?>
            <script>
                $(document).ready(function(){
                    $("#successModal").modal('show');
                });
            </script>
            <?php endif; ?>
        </div>

        <script src="/WWW/JS/check_sign_up.js"></script>
    </body>
</html>