
$(document).ready(function() {

    const pfpInputs = document.querySelectorAll('input[name="pfp"]');

    pfpInputs.forEach(input => {
        if (parseInt(input.value.substring(3), 10) === window.currentPfpNum) {
            input.checked = true;
        }
    });

    function checkUsername() {
        let newUsername = $("#username").val().trim();

        console.log(window.currentUsername);
        if (newUsername === window.currentUsername) {
            $("#username-status").text("");
            $("#username-submit-button").prop("disabled", true);
            return;
        }
        if (newUsername.length == 0) {
            $("#username-status").text("Username cannot be empty").css("color", "red");
            $("#username-submit-button").prop("disabled", true);
            return;
        }
        if (newUsername.length > 25) {
            $("#username-status").text("Username cannot be more than 25 characters long").css("color", "red");
            $("#username-submit-button").prop("disabled", true);
            return;
        }

        $.get("/check_username.php", { username: newUsername }, function(data) {
            let result = JSON.parse(data);
            if (result.available) {
                $("#username-status").text("Username available").css("color", "green");
                $("#username-submit-button").prop("disabled", false);
            } else {
                $("#username-status").text("Username already taken").css("color", "red");
                $("#username-submit-button").prop("disabled", true);
            }
        });
        
    }

    function checkPasswords() {
        let oldPassword = $("#old-password").val();
        let newPassword = $("#new-password").val();
        let newPassword2 = $("#new-password2").val();

        if (newPassword.length == 0) {
            $("#password-status").text("Password cannot be empty").css("color", "red");
            $("#password2-status").text("");
            $("#password-submit-button").prop("disabled", true);
        }
        else if (newPassword === newPassword2) {
            $("#password-status").text("");
            $("#password2-status").text("Passwords match").css("color", "green");
            $("#password-submit-button").prop("disabled", false);
        } else {
            $("#password-status").text("");
            $("#password2-status").text("Passwords do not match").css("color", "red");
            $("#password-submit-button").prop("disabled", true);
        }

        if (oldPassword.length == 0) {
            $("#password-submit-button").prop("disabled", true);
        }
    }

    function updatePfp() {
        const selected = document.querySelector('input[name="pfp"]:checked');

        if (!selected) {
            $("#pfp-submit-button").prop("disabled", true);
            return;
        }
    
        const selectedPfpNum = parseInt(selected.value.substring(3), 10);
        $("#pfp-submit-button").prop("disabled", selectedPfpNum === window.currentPfpNum);
    }

    $("#username").on("input", checkUsername);
    $("#new-password, #new-password2").on("input", checkPasswords);
    pfpInputs.forEach(input => {
        input.addEventListener('change', updatePfp);
    });
});