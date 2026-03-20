const container = document.getElementById('game-container');
const canvas = document.createElement('canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;
const ctx = canvas.getContext('2d');
container.appendChild(canvas);
canvas.id = "game-canvas";

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
const relPipeMovement = 0.8 * speed;
const pipeSpawnFrames = 90 / speed;
const relPipeVerticalMovement = 60;

const relLift = 1.45;
const relGravity = 0.08;

let bird = {
    x: relBirdX,
    y: relHeight / 2,
    velocity: 0,
    gravity: relGravity,
    lift: -relLift,
    size: relBirdSize
};

let pipes = [];
let frame = 0;
let score = 0;
let gameStart = false;
let gameOver = false;
let prevTop = relHeight / 2;

function createPipe() {
    const gap = Math.random() * (relMaxPipeGap - relMinPipeGap) + relMinPipeGap;
    let top = Math.random() * (relHeight - gap);

    // make sure the diff isn't too much that it is impossible to make it
    while (Math.abs(top - prevTop) > relHeight * 0.7 / Math.sqrt(speed)) {
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

function resizeCanvas() {
    canvas.width = canvas.clientWidth;
    canvas.height = canvas.clientHeight;
}

function update() {
    if (!gameStart || gameOver) {
        return;
    }
    frame++;

    // Bird physics
    bird.velocity += bird.gravity;
    bird.y += bird.velocity;

    // Top boundary
    if (bird.y < 0) {
        bird.y = 0;
        bird.velocity = 0;
    }

    // Bottom boundary
    if (bird.y + bird.size > relHeight) {
        bird.y = relHeight - bird.size;
        console.log("Game Over");
        gameOver = true;
    }

    // Create pipes
    if (frame % pipeSpawnFrames === 0) {
        createPipe();
    }

    // Move pipes
    pipes.forEach(pipe => {
        pipe.x -= relPipeMovement;
        if (pipe.verticalMove != 0 && pipe.verticalMoveCount < relPipeVerticalMovement) {
            pipe.top += pipe.verticalMove;
            pipe.bottom += pipe.verticalMove;
            pipe.verticalMoveCount++;
        }
        
    });

    // Remove offscreen pipes
    pipes = pipes.filter(pipe => pipe.x + pipe.width > 0);

    pipes.forEach(pipe => {
        if (bird.x < pipe.x + pipe.width && bird.x + bird.size > pipe.x &&
            (bird.y < pipe.top || bird.y + bird.size > pipe.bottom)) {
            console.log("Game Over");
            gameOver = true;
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

document.addEventListener('keydown', (e) => {
    if (e.code === "Space" || e.code === "ArrowUp") {
        e.preventDefault();
        bird.velocity = bird.lift;
        gameStart = true;
    }
});

// document.addEventListener('click', () => {
//     bird.velocity = bird.lift;
//     gameStart = true;
// });

// document.addEventListener('touchstart', () => {
//     bird.velocity = bird.lift;
//     gameStart = true;
// });

document.addEventListener('pointerdown', (e) => {
    bird.velocity = bird.lift;
    gameStart = true;
});

function gameLoop() {
    update();
    draw();
    requestAnimationFrame(gameLoop);
}

window.addEventListener('resize', resizeCanvas);
resizeCanvas(); 
gameLoop();