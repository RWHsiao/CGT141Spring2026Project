restartBtn.addEventListener('click', () => {
    resetGame();
    hideGameOver();
});

exitBtn.addEventListener('click', () => {
    window.location.href = "/WWW/games.php";
});

function showGameOver() {
    scoreText.textContent = "Score: " + score;
    gameOverPopup.classList.remove('hidden');
}

function hideGameOver() {
    gameOverPopup.classList.add('hidden');
}

function triggerGameOver() {
    console.log("Game Over. Score: " + score);
    gameOver = true;
    showGameOver();
    fetch("/WWW/add_score.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ score: score })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) console.log("Score saved!");
        else console.error("Error saving score:", data.message);
    })
    .catch(err => console.error("Network error:", err));
}