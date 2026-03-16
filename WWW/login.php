<?php
include "database.php"; // your db connection file

$message = ""; // feedback message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $message = "Login successful!";
            // Start session or redirect as needed
            // session_start();
            // $_SESSION['user_id'] = $user['id'];
            // header("Location: dashboard.php");
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "User not found";
    }
}
?>

<!DOCTYPE XHTML PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <Title>Home</Title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="css/master.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class="form-body">
        <div class="form-container" id="login-container">
            <div id="close-button">
                <a href="index2.html">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
            <div class="logo-container">
                <img src="Images/Logo.png" alt="Logo" id="form-logo"/>
            </div>
            <h2>Login</h2>
            <a href="sign_up.html">Sign up instead</a>
            <form id="form-fields" method="POST" action="login.php">
                <label for="username">Username</label><br/>
                <input type="text" class="text-input" id="username" name="username"><br/>
                <br/>
                <label for="password">Password</label><br/>
                <input type="password" class="text-input" id="password" name="password"><br/>
                <br/>
                <br/>
                <p style="color:red;"><?php echo $message; ?></p>
                <input type="submit" id="submit-button" value="Login" disabled>
            </form>
        </div>
    </body>
</html>