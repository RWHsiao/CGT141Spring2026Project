const container = document.getElementById('game-container');
const canvas = document.getElementById('game-canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;
const ctx = canvas.getContext('2d');

const speed = GAME_SETTINGS.speed;
const movingObstacles = GAME_SETTINGS.movingObstacles;
const maxGap = GAME_SETTINGS.maxGap;

const relWidth = 160;
const relHeight = 90;
const relBirdX = 20;
const relBirdSize = 4;
const relPipeWidth = 1.8 * relBirdSize;
const relMaxPipeGap = maxGap * relBirdSize;
const relMinPipeGap = 4 * relBirdSize;
const relPipeMovement = 65 * speed;
const pipeSpawnTime = 1.45 / speed;
const relPipeVerticalMovement = 0.8;

const relLift = 91;
const relGravity = 325;

let bird = {
    x: relBirdX,
    y: relHeight / 2,
    velocity: 0,
    gravity: relGravity,
    lift: -relLift,
    size: relBirdSize
};

let pipes = [];
let prevTime = 0;
let pipeTimer = 0;
let score = 0;
let gameStart = false;
let gameOver = false;
let pause = false;
let prevTop = relHeight / 2;

gameName = "Flappy Bird";
gameControls = "Press space or up arrow or click to flap. Avoid the pipes and try to get the highest score!";

function createPipe() {
    const gap = Math.random() * (relMaxPipeGap - relMinPipeGap) + relMinPipeGap;
    let top = Math.random() * (relHeight - gap);

    // make sure the diff isn't too much that it is impossible to make it
    while (Math.abs(top - prevTop) > relHeight * 0.55 / Math.sqrt(speed)) {
        top = Math.random() * (relHeight - gap);
    }  

    prevTop = top;
    let verticalMove = 0;
    let initialTop = top;
    if (movingObstacles) {
        initialTop = Math.random() * (relHeight - gap);
        while (Math.abs(initialTop - top) < relHeight * 0.3) {
            initialTop = Math.random() * (relHeight - gap);
        } 

        verticalMove = (top - initialTop) / relPipeVerticalMovement;
    }

    pipes.push({
        x: relWidth,
        top: initialTop,
        bottom: initialTop + gap,
        verticalMove: verticalMove,
        verticalMoveCount: 0,
        width: relPipeWidth,
        passed: false
    });
}

function update(dt) {
    if (!gameStart || gameOver || pause) {
        return;
    }

    // Bird physics
    bird.velocity += bird.gravity * dt;
    bird.y += bird.velocity * dt;

    // Top boundary
    if (bird.y < 0) {
        bird.y = 0;
        bird.velocity = 0;
    }

    // Bottom boundary
    if (bird.y + bird.size > relHeight) {
        bird.y = relHeight - bird.size;
        triggerGameOver();
    }

    // Create pipes
    pipeTimer += dt;
    if (pipeTimer >= pipeSpawnTime) {
        createPipe();
        pipeTimer = 0;
    }

    // Move pipes
    pipes.forEach(pipe => {
        pipe.x -= relPipeMovement * dt;
        if (pipe.verticalMove != 0 && pipe.verticalMoveCount < relPipeVerticalMovement) {
            const moveAmount = pipe.verticalMove * dt;
            pipe.top += moveAmount;
            pipe.bottom += moveAmount;
            pipe.verticalMoveCount += dt;
        }
        
    });

    // Remove offscreen pipes
    pipes = pipes.filter(pipe => pipe.x + pipe.width > 0);

    pipes.forEach(pipe => {
        if (bird.x < pipe.x + pipe.width && bird.x + bird.size > pipe.x &&
            (bird.y < pipe.top || bird.y + bird.size > pipe.bottom)) {
            triggerGameOver();
        }
        if (bird.x > pipe.x + pipe.width && !pipe.passed) {
            score++;
            pipe.passed = true;
        }
    });
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Bird
    ctx.fillStyle = 'yellow';
    ctx.fillRect(canvas.width * (bird.x / relWidth), canvas.height * (bird.y / relHeight), canvas.width * (bird.size / relWidth), canvas.height * (bird.size/ relHeight));

    // Pipes
    ctx.fillStyle = 'green';
    pipes.forEach(pipe => {
        ctx.fillRect(canvas.width * (pipe.x / relWidth), 0, canvas.width * (pipe.width / relWidth), canvas.height * (pipe.top / relHeight));
        ctx.fillRect(canvas.width * (pipe.x / relWidth), canvas.height * (pipe.bottom / relHeight), canvas.width * (pipe.width / relWidth), canvas.height * ((relHeight - pipe.bottom) / relHeight));
    });

    // Score
    ctx.fillStyle = "white";
    const fontSize = canvas.width * 0.03;
    ctx.font = `${fontSize}px Arial`;
    ctx.textAlign = "center";
    ctx.textBaseline = "top";

    ctx.fillText("Score: " + score, canvas.width / 2, 10);

    if (!gameStart) {
        ctx.fillText("Press space or up arrow or click to start", canvas.width / 2, canvas.height / 2);
    }

}


function resetGame() {
    bird.y = relHeight / 2;
    bird.velocity = 0;

    pipes = [];
    frame = 0;
    score = 0;
    prevTop = relHeight / 2;

    gameStart = false;
    gameOver = false;
}


document.addEventListener('keydown', (e) => {
    if (pause || gameOver) return;
    if (e.code === "Space" || e.code === "ArrowUp") {
        e.preventDefault();
        bird.velocity = bird.lift;
        gameStart = true;
    }
});


document.addEventListener('pointerdown', (e) => {
    if (pause || gameOver) return;
    if (e.target.closest('#close-btn') || e.target.closest('#controls-btn')) {
        return;
    }
    bird.velocity = bird.lift;
    gameStart = true;
});

function gameLoop(currTime) {
    const dt = (currTime - prevTime) / 1000;
    prevTime = currTime;

    update(dt);
    draw();
    requestAnimationFrame(gameLoop);
}

requestAnimationFrame(gameLoop);