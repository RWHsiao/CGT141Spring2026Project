document.getElementById("delete-button").addEventListener("click", function() {
    $("#delete-modal").modal("show");
});

document.getElementById("confirm-delete").addEventListener("click", function() {
    deleteAccount();
});

function deleteAccount() {
    $("#delete-modal").modal("hide");
    fetch("delete_account.php")
    .then(response => response.text())
    .then(msg => {
        $("#delete-success-modal").modal('show');

        document.getElementById("delete-success-button").addEventListener("click", function() {
            $("#delete-success-modal").modal('hide');
            window.location.href = "index.php";
        });

        $('#delete-success-modal').on('hidden.bs.modal', function () {
            window.location.href = "index.php";
        });
    })
    .catch(err => {
        console.error(err);
        alert("Something went wrong. Try again.");
    });
    
}