
$(document).ready(function() {
    let validUsername = false;
    function checkUsername() {
        let username = $(this).val().trim();

        if (username.length == 0) {
            $("#username-status").text("Username cannot be empty").css("color", "red");
            validUsername = false;
            updateSubmitButton();
            return;
        }
        if (username.length > 25) {
            $("#username-status").text("Username cannot be more than 25 characters long").css("color", "red");
            validUsername = false;
            updateSubmitButton();
            return;
        }

        $.get(
            "/check_username.php",
            { username: username },
            function(result) {
                if (result.available) {
                    $("#username-status").text("Username available").css("color", "green");
                    validUsername = true;
                } else {
                    $("#username-status").text("Username already taken").css("color", "red");
                    validUsername = false;
                }
                updateSubmitButton();
            },
            "json"
        );
        
    }

    let validPasswords = false;
    function checkPasswords() {
        let password = $("#password").val();
        let password2 = $("#password2").val();

        if (password.length == 0) {
            $("#password-status").text("Password cannot be empty").css("color", "red");
            $("#password2-status").text("");
            validPasswords = false;
        }
        else if (password === password2) {
            $("#password-status").text("");
            $("#password2-status").text("Passwords match").css("color", "green");
            validPasswords = true;
        } else {
            $("#password-status").text("");
            $("#password2-status").text("Passwords do not match").css("color", "red");
            validPasswords = false;
        }
        updateSubmitButton();
        
    }

    function updateSubmitButton() {
        let submitEnabled = validUsername && validPasswords && $("#robot-checkbox").is(":checked");
        $("#submit-button").prop("disabled", !submitEnabled);
    }

    $("#username").on("input", checkUsername);
    $("#password, #password2").on("input", checkPasswords);
    $("#robot-checkbox").on("change", updateSubmitButton);
});