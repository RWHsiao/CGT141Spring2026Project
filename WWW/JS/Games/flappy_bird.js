const container = document.getElementById('game-container');
const canvas = document.createElement('canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;
const ctx = canvas.getContext('2d');
container.appendChild(canvas);
canvas.id = "game-canvas";

const speed = GAME_SETTINGS.speed;

const relWidth = 160;
const relHeight = 90;
const relBirdX = 20;
const relBirdSize = 4;
const relPipeWidth = 1.8 * relBirdSize;
const relMaxPipeGap = 8 * relBirdSize;
const relMinPipeGap = 4 * relBirdSize;
const relPipeMovement = 0.8;

const relLift = 1.6;
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

function createPipe() {
    const gap = Math.random() * (relMaxPipeGap - relMinPipeGap) + relMinPipeGap;
    const top = Math.random() * (relHeight - gap);
    

    pipes.push({
        x: relWidth,
        top: top,
        bottom: top + gap,
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
    if (frame % 90 === 0) {
        createPipe();
    }

    // Move pipes
    pipes.forEach(pipe => {
        pipe.x -= relPipeMovement;
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

document.addEventListener('click', () => {
    bird.velocity = bird.lift;
    gameStart = true;
});

document.addEventListener('touchstart', () => {
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