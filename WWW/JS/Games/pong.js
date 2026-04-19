const container = document.getElementById('game-container');
const canvas = document.getElementById('game-canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;
const ctx = canvas.getContext('2d');
container.appendChild(canvas);

const maxLives = GAME_SETTINGS.lives;
let lives = maxLives;
const ballSpeed = GAME_SETTINGS.ballSpeed;
const enemySpeed = GAME_SETTINGS.enemySpeed;

const relWidth = 160;
const relHeight = 90;
const relPaddleWidth = 3;
const relPaddleOffset = 5;
const relPaddleHeight = 14;
const relBallRadius = 1.5;
const relPlayerMove = 0.75;
const relEnemyMove = 0.4 * enemySpeed;

const collisionMultiplier = 1 + (ballSpeed / 10);

gameName = "Pong";
gameControls = "Use the up and down arrow keys or touch to move your paddle. Try to get the highest score before you lose all your lives!";

let gameStart = false;
let gameOver = false;
let pause = false;
let prevTime = 0;
let score = 0;

let relBallMove = 0.5;
let ballVelX = 0;
let ballVelY = 0;

let ballX = relWidth / 2;
let ballY = relHeight / 2;

let playerX = relWidth - relPaddleOffset;
let playerY = relHeight / 2 - (relPaddleHeight / 2);
let upPressed = false;
let downPressed = false;

let enemyX = relPaddleOffset;
let enemyY = relHeight / 2 - (relPaddleHeight / 2);

function startRound() {
    let relBallVelocity = relBallMove * ballSpeed;
    let ballAngle = Math.random() * (Math.PI / 3) - (Math.PI / 6);
    ballVelX = Math.cos(ballAngle) * relBallVelocity;
    ballVelY = Math.sin(ballAngle) * relBallVelocity;
    ballX = relWidth / 2;
    ballY = relHeight / 2;
    playerY = relHeight / 2 - (relPaddleHeight / 2);
    enemyY = relHeight / 2 - (relPaddleHeight / 2);
    startingNewRound = false;
}

let startingNewRound = false;

function update(dt) {
    if (!gameStart || gameOver || pause || startingNewRound) {
        return;
    }

    // Move ball
    ballX += ballVelX;
    ballY += ballVelY;
    if (ballY <= relBallRadius || ballY >= relHeight - relBallRadius) {
        ballVelY *= -1;
        ballY = Math.max(relBallRadius, ballY);
        ballY = Math.min(relHeight - relBallRadius, ballY);
    }
    if (ballX <= -relBallRadius) {
        score++;
        startingNewRound = true;
        setTimeout(function() {
            startRound();
        }, 1000);
    }
    else if (ballX >= relWidth + relBallRadius) {
        lives--;
        if (lives <= 0) {
            triggerGameOver();
            return;
        }
        startingNewRound = true;
        setTimeout(function() {
            startRound();
        }, 1000);
    }
    else if (ballVelX < 0 && ballX >= relPaddleOffset &&
             ballX <= relPaddleOffset + relPaddleWidth + relBallRadius) {
        if (ballY >= enemyY - relBallRadius && ballY <= enemyY + relPaddleHeight + relBallRadius) {
            ballX = relPaddleOffset + relPaddleWidth + relBallRadius;
            let paddleCenter = enemyY + relPaddleHeight / 2;
            let hitPos = (ballY - paddleCenter) / (relPaddleHeight / 2);

            let speed = Math.sqrt(ballVelX * ballVelX + ballVelY * ballVelY) * collisionMultiplier;

            ballVelX = speed * Math.cos(hitPos * Math.PI / 3);
            ballVelY = speed * Math.sin(hitPos * Math.PI / 3);
        }
    }
    else if (ballVelX > 0 && ballX >= relWidth - relPaddleOffset - relPaddleWidth - relBallRadius &&
             ballX <= relWidth - relPaddleOffset) {
        if (ballY >= playerY - relBallRadius && ballY <= playerY + relPaddleHeight + relBallRadius) {
            ballX = relWidth - relPaddleOffset - relPaddleWidth - relBallRadius;

            let paddleCenter = playerY + relPaddleHeight / 2;
            let hitPos = (ballY - paddleCenter) / (relPaddleHeight / 2);
            let speed = Math.sqrt(ballVelX * ballVelX + ballVelY * ballVelY) * collisionMultiplier;

            ballVelX = -speed * Math.cos(hitPos * Math.PI / 3);
            ballVelY = speed * Math.sin(hitPos * Math.PI / 3);
        }
    }

    // Move enemy
    let enemyCenter = enemyY + (relPaddleHeight / 2);
    if (Math.abs(ballY - enemyCenter) > relEnemyMove) {
        if (ballY < enemyCenter) {
            enemyY -= Math.min(relEnemyMove, Math.abs(ballY - enemyCenter) * 0.3);
            enemyY = Math.max(enemyY, 0);
        }
        else if (ballY > enemyCenter) {
            enemyY += Math.min(relEnemyMove, Math.abs(ballY - enemyCenter) * 0.3);
            enemyY = Math.min(enemyY, relHeight - relPaddleHeight);
        }
    }

    // Move player
    if (upPressed && !downPressed) {
        playerY -= relPlayerMove
    }
    else if (downPressed && !upPressed) {
        playerY += relPlayerMove;
    }
    else if (yTarget != -1) {
        let playerCenter = playerY + relPaddleHeight / 2;
        if (Math.abs(playerCenter - yTarget) < relPlayerMove) {
            playerY = yTarget - relPaddleHeight / 2;
        }
        else if (playerCenter > yTarget) {
            playerY -= relPlayerMove;
        }
        else {
            playerY += relPlayerMove;
        }
    }
    playerY = Math.max(playerY, 0);
    playerY = Math.min(playerY, relHeight - relPaddleHeight);
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    ctx.fillStyle = 'white';
    ctx.fillRect((enemyX / relWidth) * canvas.width, (enemyY / relHeight) * canvas.height,
                 (relPaddleWidth / relWidth) * canvas.width, (relPaddleHeight / relHeight) * canvas.height);
    ctx.fillRect(((playerX - relPaddleWidth) / relWidth) * canvas.width, (playerY / relHeight) * canvas.height,
                 (relPaddleWidth / relWidth) * canvas.width, (relPaddleHeight / relHeight) * canvas.height);
    ctx.beginPath();
    ctx.arc((ballX / relWidth) * canvas.width, (ballY / relHeight) * canvas.height,
            (relBallRadius / relWidth) * canvas.width, 0, Math.PI * 2);
    ctx.fill();

    // Score
    ctx.fillStyle = "white";
    const fontSize = canvas.width * 0.03;
    ctx.font = `${fontSize}px Arial`;
    ctx.textAlign = "center";
    ctx.textBaseline = "top";

    ctx.fillText("Lives: " + lives + "    Score: " + score, canvas.width / 2, 10);

    if (!gameStart) {
        ctx.fillText("Press space or click to start", canvas.width / 2, canvas.height / 3);
    }
}

document.addEventListener("keydown", (e) => {
    if (pause || gameOver) return;
    if (e.code === "Space" && !gameStart) {
        gameStart = true;
        startRound();
    }
    if (e.key === "ArrowUp" && gameStart) {
        upPressed = true;
    }
    if (e.key === "ArrowDown" && gameStart) {
        downPressed = true;
    }
});


document.addEventListener('pointerdown', (e) => {
    if (pause || gameOver) return;
    if (e.target.closest('#close-btn') || e.target.closest('#controls-btn')) {
        return;
    }
    if (!gameStart) {
        gameStart = true;
        startRound();
    }
});

let yTarget = -1;
document.addEventListener('touchstart', (e) => {
    if (pause || gameOver) return;
    e.preventDefault();
    const touch = e.changedTouches[0];
    const rect = canvas.getBoundingClientRect();
    yTarget = (touch.clientY - rect.top) * (relHeight / rect.height);
}, { passive: false });
document.addEventListener('touchmove', (e) => {
    if (pause || gameOver) return;
    e.preventDefault();
    const touch = e.changedTouches[0];
    const rect = canvas.getBoundingClientRect();
    yTarget = (touch.clientY - rect.top) * (relHeight / rect.height);
}, { passive: false });
document.addEventListener("touchend", () => {
    if (pause || gameOver) return;
    yTarget = -1;
});

function resetGame() {
    gameStart = false;
    gameOver = false;
    score = 0;
    lives = maxLives;
    upPressed = false;
    downPressed = false;

    ballX = relWidth / 2;
    ballY = relHeight / 2;
    playerY = relHeight / 2 - (relPaddleHeight / 2);
    enemyY = relHeight / 2 - (relPaddleHeight / 2);
}

document.addEventListener("keyup", (e) => {
    if (e.key === "ArrowUp") {
        upPressed = false;
    }
    if (e.key === "ArrowDown") {
        downPressed = false;
    }
});

function gameLoop(currTime) {
    const dt = (currTime - prevTime) / 1000;
    prevTime = currTime;

    update(dt);
    draw();
    requestAnimationFrame(gameLoop);
}

resetGame();
requestAnimationFrame(gameLoop);