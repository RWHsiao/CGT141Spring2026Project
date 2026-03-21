
$(document).ready(function() {
    document.getElementById("delete-button").addEventListener("click", function() {
        $("#delete-modal").modal("show");
    });

    document.getElementById("confirm-delete").addEventListener("click", function() {
        deleteAccount();
    });

    $("#delete-success-button").click(function(e) {
        e.preventDefault();
        $("#delete-success-modal").modal('hide');
    });

    $('#delete-success-modal').on('hidden.bs.modal', function () {
        window.location.href = "index.php";
    });
});
// Show modal after fetch
function deleteAccount() {
    $("#delete-modal").modal("hide");
    fetch("delete_account.php")
        .then(response => response.text())
        .then(msg => {
            setTimeout(function() {
                $("#delete-success-modal").modal('show');
            }, 500);
        })
        .catch(err => {
            console.error(err);
            alert("Something went wrong. Try again.");
        });
}
