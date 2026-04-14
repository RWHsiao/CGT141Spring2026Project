const gameContainer = document.getElementById('game-container');
const gameCanvas = document.getElementById('game-canvas');
const header = document.getElementById('play-header');
const controlsContainer = document.getElementById('controls-container');
function resizeCanvas() {

    const maxWidth = gameContainer.clientWidth;

    const margin = parseFloat(window.getComputedStyle(gameContainer).marginTop);
    const headerHeight = header.offsetHeight;
    const controlsHeight = controlsContainer.offsetHeight;
    const maxHeight = window.innerHeight - headerHeight - controlsHeight - 2 * margin;

    const aspect = 16 / 9;

    let width = maxWidth;
    let height = width / aspect;

    // If too tall, constrain by height instead
    if (height > maxHeight) {
        height = maxHeight;
        width = height * aspect; 
    }

    // Apply display size (CSS size)
    gameCanvas.style.width = width + "px";
    gameCanvas.style.height = height + "px";

    gameContainer.style.height = height + "px";

    // Match internal resolution
    gameCanvas.width = width;
    gameCanvas.height = height;
}



const gameOverPopup = document.getElementById('game-over-popup');
const gameOverPopupContent = document.getElementById('popup-content');
const gameOverText = document.getElementById('game-over');
const scoreText = document.getElementById('final-score');
const restartBtn = document.getElementById('restart-btn');
const exitBtn = document.getElementById('exit-btn');

function scalePopup() {
    const rect = gameCanvas.getBoundingClientRect();

    gameOverPopup.style.position = "absolute";
    const popupWidth = rect.width * 0.5;
    const popupHeight = rect.height * 0.4;
    gameOverPopup.style.width = popupWidth + "px";
    gameOverPopup.style.height = popupHeight + "px";

    gameOverPopupContent.style.padding = popupWidth * 0.03 + "px";

    const fontSize = rect.width * 0.03; 
    gameOverText.style.fontSize = fontSize + "px";
    gameOverText.style.margin = "0 0 " + (popupHeight * 0.05) + "px 0";
    scoreText.style.fontSize = fontSize * 0.8 + "px";
    scoreText.style.margin = "0 0 " + (popupHeight * 0.05) + "px 0";

    const btnFontSize = rect.width * 0.02;
    [restartBtn, exitBtn].forEach(btn => {
        btn.style.fontSize = btnFontSize + "px";
        btn.style.padding = rect.height * 0.01 + "px " + rect.width * 0.015 + "px";
    });
}

let gameName = "[Game Name]";
let gameControls = "[Game Controls]";

$(document).ready(function() {
    $("#confirm-exit").click(function(e) {
        e.preventDefault();
        $("#exit-modal").modal('hide');
        window.location.href = "/games.php";
    });

    $("#cancel-exit").click(function(e) {
        e.preventDefault();
        $("#exit-modal").modal('hide');
    });

    $('#exit-modal').on('hidden.bs.modal', function () {
        resume();
    });

    $('#exit-modal').on('shown.bs.modal', function () {
        $('#confirm-exit').trigger('focus');
    });

    $("#controls-modal-button").click(function(e) {
        e.preventDefault();
        $("#controls-modal").modal('hide');
    });

    $("#controls-modal").on('hidden.bs.modal', function () {
        if (gameStart && !gameOver) {
            resume();
        }
        else {
            pause = false;
        }
    });

    $('#controls-modal').on('shown.bs.modal', function () {
        $('#controls-modal-button').trigger('focus');
    });

    $('#controls-modal-title').text(gameName + " Controls");
    $('#controls-modal-body p').text(gameControls);
});

let resuming = false;
function resume() {
    resuming = true;
    setTimeout(function() {
        if (resuming) {
            pause = false;
        }
        resuming = false;
    }, 1000);
}

document.getElementById('close-button').addEventListener('pointerdown', (e) => {
    e.stopPropagation();
    if (gameStart && !gameOver) {
        pause = true;
        resuming = false;
        $("#exit-modal").modal('show');
    }
    else {
        window.location.href = "/games.php";
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === "Escape") {
        if (gameStart && !gameOver && (!pause || resuming)) {
            e.stopPropagation();
            e.preventDefault();
            pause = true;
            resuming = false;
            $("#exit-modal").modal('show');
        }
        else if (!pause) {
            e.stopPropagation();
            e.preventDefault();
            window.location.href = "/games.php";
        }
    }
});

document.getElementById('controls-btn').addEventListener('pointerdown', (e) => {
    e.stopPropagation();
    pause = true;
    resuming = false;
    $("#controls-modal").modal('show');
});

window.addEventListener('resize', () => {
    resizeCanvas();
    scalePopup();
});

resizeCanvas();
scalePopup();