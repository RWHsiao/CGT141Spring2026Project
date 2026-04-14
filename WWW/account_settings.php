<?php
session_start();
include "database.php";

$loggedIn = false;
$user_id = -1;
$username = "";
$pfpNum = 1;
$success = -1;
$titleMessage = "";
$message = "";

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $action = $_POST['action'] ?? '';

    if ($action == "change-username") {
        $new_username = trim($_POST['username']);
        $stmt = $conn->prepare("UPDATE users SET username = ? WHERE id = ?");
        $stmt->bind_param("si", $new_username, $user_id);
        $stmt->execute();
        $stmt->close();

        $username = $new_username;
        $success = 1;
        $titleMessage = "Changed Username Successfully!";
        $message = "Your username has been updated to " . htmlspecialchars($new_username) . ".";
    }

    else if ($action == "change-password") {
        $old_password = $_POST['old-password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if (password_verify($old_password, $user['password'])) {
            $new_password = $_POST['new-password'];
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();
            $stmt->close();

            $success = 1;
            $titleMessage = "Changed Password Successfully!";
            $message = "Your password has been updated.";
        }
        else {
            $success = 0;
            $titleMessage = "Password Change Failed";
            $message = "Incorrect password.";
        }
    }

    else if ($action == "change-pfp") {
        $pfp_raw = $_POST['pfp'] ?? 'pfp1';
        $new_pfp = (int)substr($pfp_raw, 3);
        $stmt = $conn->prepare("UPDATE users SET pfp = ? WHERE id = ?");
        $stmt->bind_param("ii", $new_pfp, $user_id);
        $stmt->execute();
        $stmt->close();

        $pfpNum = $new_pfp;
        $success = 1;
        $titleMessage = "Changed Profile Picture Successfully!";
        $message = "Your profile picture has been updated.";
    }
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1 Strict//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Account Settings</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <link href="/css/master.css" rel="stylesheet" type="text/css"/>
        <link rel="icon" href="/images/Logo.jpg" type="image/jpg">
    </head>

    <body id="account-body">
        <div id="account-container">
            <div id="close-button">
                <a href="index.php">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </div>
            <div class="logo-container">
                <img src="/images/Logo.jpg" alt="Logo" id="form-logo"/>
            </div>
            <h2>Account Settings</h2>
            <br/>
            <h4>Change Username</h4>
            <form class="form-fields" id="change-username" method="POST">
                <input type="hidden" name="action" value="change-username">
                <label for="username">New Username</label><br/>
                <input type="text" class="text-input" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br/>
                <span id="username-status"></span><br/>
                <br/>
                <input type="submit" id="username-submit-button" class="submit-button" value="Change Username" disabled>
            </form>
            <br/>
            <br/>
            <h4>Change Password</h4>
            <form class="form-fields" id="change-password" method="POST">
                <input type="hidden" name="action" value="change-password">
                <label for="old-password">Old Password</label><br/>
                <input type="password" class="text-input" id="old-password" name="old-password" required><br/>
                <br/>
                <br/>
                <label for="new-password">New Password</label><br/>
                <input type="password" class="text-input" id="new-password" name="new-password" required><br/>
                <span id="password-status"></span><br/>
                <br/>
                <label for="new-password2">Re-Enter New Password</label><br/>
                <input type="password" class="text-input" id="new-password2" name="new-password2" required><br/>
                <span id="password2-status"></span><br/>
                <br/>
                <input type="submit" id="password-submit-button" class="submit-button" value="Change Password" disabled>
            </form>
            <br/>
            <br/>
            <h4>Change Profile Picture</h4>
            <form class="form-fields" id="change-pfp" method="POST">
                <input type="hidden" name="action" value="change-pfp">
                <div class="pfp-selection">
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp1" required>
                        <img src="/images/PFP1.png" class="pfp-option">
                    </label>
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp2">
                        <img src="/images/PFP2.png" class="pfp-option">
                    </label>
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp3">
                        <img src="/images/PFP3.png" class="pfp-option">
                    </label>
                    <label class="pfp-label">
                        <input type="radio" name="pfp" value="pfp4">
                        <img src="/images/PFP4.png" class="pfp-option">
                    </label>
                </div>
                <br/>
                <input type="submit" id="pfp-submit-button" class="submit-button" value="Change Profile Picture" disabled>
            </form>
            <br/>
            <br/>
            <br/>
            <button id="delete-button" class="btn btn-danger">Delete Account</button>

            <div id="success-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 id="success-modal-title" class="modal-title">Title Text</h4>
                        </div>
                        <div id="success-modal-body" class="modal-body">
                            <p>Body Text</p>
                        </div>
                        <div class="modal-footer">
                            <a id="modal-btn" class="btn btn-success">Ok</a>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                const success = <?php echo $success; ?>;
                const titleMessage = "<?php echo addslashes($titleMessage); ?>";
                const message = "<?php echo addslashes($message); ?>";
                if (success != -1) {
                    $(document).ready(function(){
                        if (success == 1) {
                            $("#modal-btn").removeClass()
                                .addClass("btn btn-success");
                        }
                        else {
                            $("#modal-btn").removeClass()
                                .addClass("btn btn-danger");
                        }
                        $("#success-modal-title").text(titleMessage);
                        $("#success-modal-body p").text(message);

                         $("#modal-btn").click(function(e) {
                            e.preventDefault();
                            $("#success-modal").modal('hide');
                        });

                        $("#success-modal").modal('show');
                    });
                }
            </script>


            <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Confirm Account Deletion</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete your account? All scores for this account will be deleted. This cannot be undone.</p>
                        </div>
                        <div class="modal-footer">
                            <button id="cancel-delete" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button id="confirm-delete" class="btn btn-danger">Delete</button>
                        </div>
                    </div>
                </div>
            </div>

            <div id="delete-success-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Account Deleted</h4>
                        </div>
                        <div class="modal-body">
                            <p>Your account has been deleted successfully.</p>
                        </div>
                        <div class="modal-footer">
                            <button id="delete-success-button" class="btn btn-primary">Ok</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            window.currentUsername = <?php echo json_encode($username); ?>;
            window.currentPfpNum = <?php echo json_encode((int)$pfpNum); ?>;
        </script>
        <script src="/js/check_account_change.js"></script>
        <script src="/js/delete_account.js"></script>
    </body>
</html>