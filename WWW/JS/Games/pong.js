const container = document.getElementById('game-container');
const canvas = document.getElementById('game-canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;
const ctx = canvas.getContext('2d');
container.appendChild(canvas);

let lives = GAME_SETTINGS.lives;
const ballSpeed = GAME_SETTINGS.ballSpeed;
const enemySpeed = GAME_SETTINGS.enemySpeed;

const relWidth = 160;
const relHeight = 90;
const relPaddleWidth = 3;
const relPaddleOffset = 5;
const relPaddleHeight = 14;
const relBallRadius = 1.5;
const relPlayerMove = 0.25;
const relEnemyMove = 0.5 * enemySpeed;

let gameStart = false;
let gameOver = false;
let pause = false;
let prevTime = 0;
let score = 0;

let relBallVelocity = 0;
let relBallMove = 0.2;
let ballAngle = 0;

let ballX = relWidth / 2;
let ballY = relHeight / 2;
let ballDir = 1;

let playerX = relWidth - relPaddleOffset;
let playerY = relHeight / 2 - (relPaddleHeight / 2);
let playerYVel = 0;

let enemyX = relPaddleOffset;
let enemyY = relHeight / 2 - (relPaddleHeight / 2);

function startRound() {
    relBallVelocity = relBallMove * ballSpeed;
    ballAngle = Math.random() * (Math.PI / 3) - (Math.PI / 6);
    ballX = relWidth / 2;
    ballY = relHeight / 2;
    playerY = relHeight / 2 - (relPaddleHeight / 2);
    playerYVel = 0;
    enemyY = relHeight / 2 - (relPaddleHeight / 2);
}

function update(dt) {
    if (!gameStart || gameOver || pause) {
        return;
    }
    // Move ball

    ballX += relBallVelocity * Math.cos(ballAngle) * ballDir;
    ballY += relBallVelocity * Math.sin(ballAngle);
    console.log(ballAngle + " " + ballX + " " + ballY);
    if (ballY <= relBallRadius || ballY >= relHeight - relBallRadius) {
        ballAngle = -ballAngle;
        ballY = Math.max(relBallRadius, ballY);
        ballY = Math.min(relHeight - relBallRadius, ballY);
    }
    if (ballX <= -relBallRadius) {
        score++;
        startRound();
    }
    else if (ballX >= relWidth + relBallRadius) {
        lives--;
        if (lives <= 0) {
            triggerGameOver();
            return;
        }
        startRound();
    }
    else if (ballDir == -1 && ballX >= relPaddleOffset &&
             ballX <= relPaddleOffset + relPaddleWidth + relBallRadius) {
        if (ballY >= enemyY - relBallRadius && ballY <= enemyY + relPaddleHeight + relBallRadius) {
            ballX = relPaddleOffset + relPaddleWidth + relBallRadius;
            ballDir = 1;
            relBallVelocity *= 1.1;
        }
    }
    else if (ballDir == 1 && ballX >= relWidth - relPaddleOffset - relPaddleWidth - relBallRadius &&
             ballX <= relWidth - relPaddleOffset) {
        if (ballY >= playerY - relBallRadius && ballY <= playerY + relPaddleHeight + relBallRadius) {
            ballX = relWidth - relPaddleOffset - relPaddleWidth - relBallRadius;
            ballDir = -1;
            relBallVelocity *= 1.1;
        }
    }

    // Move enemy
    let enemyCenter = enemyY + (relPaddleHeight / 2);
    if (Math.abs(ballY - enemyCenter) > relEnemyMove) {
        if (ballY < enemyCenter) {
            enemyY -= relEnemyMove;
            enemyY = Math.max(enemyY, 0);
        }
        else if (ballY > enemyCenter) {
            enemyY += relEnemyMove;
            enemyY = Math.min(enemyY, relHeight - relPaddleHeight);
        }
    }
    

    // Move player
    playerY += playerYVel;
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
        console.log('start game');
        gameStart = true;
        startRound();
    }
    if (e.key === "ArrowUp" && gameStart) {
        //playerY -= relPlayerMove;
        //playerY = Math.max(playerY, 0);
        playerYVel = -relPlayerMove;
    }
    if (e.key === "ArrowDown" && gameStart) {
        //playerY += relPlayerMove;
        //playerY = Math.min(playerY, relHeight - relPaddleHeight);
        playerYVel = relPlayerMove;
    }
});

document.addEventListener("keyup", (e) => {
    if (e.key === "ArrowUp" && gameStart) {
        playerYVel = 0;
    }
    if (e.key === "ArrowDown" && gameStart) {
        playerYVel = 0;
    }
});

function gameLoop(currTime) {
    const dt = (currTime - prevTime) / 1000;
    prevTime = currTime;

    update(dt);
    draw();
    requestAnimationFrame(gameLoop);
}

requestAnimationFrame(gameLoop);