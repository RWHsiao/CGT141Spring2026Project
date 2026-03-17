
$(document).ready(function() {
    let nonEmptyUsername = $("#username").val().trim().length > 0;
    let nonEmptyPassword = $("#password").val().trim().length > 0;

    function checkUsername() {
        let username = $(this).val().trim();

        nonEmptyUsername = username.length > 0;
        updateSubmitButton();
    }
    function checkPassword() {
        let password = $("#password").val();
        
        nonEmptyPassword = password.length > 0;
        updateSubmitButton();
        
    }

    function updateSubmitButton() {
        let submitEnabled = nonEmptyUsername && nonEmptyPassword;
        $("#submit-button").prop("disabled", !submitEnabled);
    }

    $("#username").on("input", checkUsername);
    $("#password").on("input", checkPassword);
});