const container = document.getElementById('game-container');
const canvas = document.getElementById('game-canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;
const ctx = canvas.getContext('2d');
container.appendChild(canvas);

const rows = GAME_SETTINGS.rows;
const cols = GAME_SETTINGS.cols;
const foods = GAME_SETTINGS.foods;
const numObstacles = GAME_SETTINGS.obstacles;

const relWidth = 160;
const relHeight = 90;
const relBoardHeight = 80;
const relSquareSize = relBoardHeight / rows;
const relFoodRadius = (relSquareSize * 0.9) / 2;
const relSnakeWidth = (relSquareSize * 0.6);

const moveFrames = 30;


let gameStart = false;
let gameOver = false;
let pause = false;
let frame = 0;
let score = 0;

let grid = [];
const EMPTY = 0;
const SNAKE = 1;
const FOOD = 2;
const OBSTACLE = 3;

let snake = [];
let head = {};
let tail = {};

function createGrid() {
    snake = [
        { r: (rows + 1) / 2, c: 3, dirR: 0, dirC: 1 },
        { r: (rows + 1) / 2, c: 2, dirR: 0, dirC: 1 },
        { r: (rows + 1) / 2, c: 1, dirR: 0, dirC: 1 }
    ];
    head = snake[0];
    tail = snake[2];
    for (let r = 0; r < rows; r++) {
        grid[r] = [];
        for (let c = 0; c < cols; c++) {
            grid[r][c] = EMPTY;
        }
    }
    for (let i = 0; i < snake.length; i++) {
        grid[snake[i].r][snake[i].c] = SNAKE;
    }
}

let obstacles = [];
function createObstacles() {
    obstacles = [];
    for (let i = 0; i < numObstacles; i++) {
        let r = 0;
        let c = 0;
        let closeCount = 0;
        let tooCloseToSnake = false;
        do {
            r = Math.floor(Math.random() * rows);
            c = Math.floor(Math.random() * cols);
            closeCount = 0;
            for (let j = 0; j < i; j++) {
                if (Math.abs(obstacles[j].r - r) <= 1 && Math.abs(obstacles[j].c - c) <= 1) {
                    closeCount++;
                }
            }
            tooCloseToSnake = false;
            for (let j = 0; j < snake.length; j++) {
                if (Math.abs(snake[j].r - r) <= 2 && Math.abs(snake[j].c - c) <= 2) {
                    tooCloseToSnake = true;
                    break;
                }
            }
        } while (grid[r][c] !== EMPTY || closeCount > 1 || tooCloseToSnake);
        grid[r][c] = OBSTACLE;
        obstacles.push({
            r: r,
            c: c
        });
    }
}

function spawnFood() {
    let r = 0;
    let c = 0;
    do {
        r = Math.floor(Math.random() * rows);
        c = Math.floor(Math.random() * cols);
    } while (grid[r][c] !== EMPTY);
    grid[r][c] = FOOD;
}

function update() {
    if (!gameStart || gameOver || pause) {
        return;
    }
    frame++;
    if (frame % moveFrames == 0) {
        if (inputQueue.length > 0) {
            const next = inputQueue.shift();
            if (!(head.dirR == -next.dirR && head.dirC == -next.dirC)) {
                head.dirR = next.dirR;
                head.dirC = next.dirC;
            }
        }
        let newHead = {
            r: head.r + head.dirR,
            c: head.c + head.dirC,
            dirR: head.dirR,
            dirC: head.dirC
        };
        if (newHead.r < 0 || newHead.r >= rows || newHead.c < 0 || newHead.c >= cols || grid[newHead.r][newHead.c] == OBSTACLE) {
            triggerGameOver();
            //return;
        }
        let ate = grid[newHead.r][newHead.c] == FOOD;
        if (ate) {
            score++;
            snake.unshift(newHead);
            head = snake[0];
            grid[newHead.r][newHead.c] = SNAKE;
            spawnFood();
        }
        else {
            grid[snake[snake.length - 1].r][snake[snake.length - 1].c] = EMPTY;
            for (let i = snake.length - 1; i > 0; i--) {
                snake[i].r = snake[i - 1].r;
                snake[i].c = snake[i - 1].c;
                snake[i].dirR = snake[i - 1].dirR;
                snake[i].dirC = snake[i - 1].dirC;
            }
            snake[0] = newHead;
            head = snake[0];
            grid[head.r][head.c] = SNAKE;
        }
        
    }
    
}

function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    // Background
    ctx.fillStyle = 'green';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Grid
    const squareSize = (relSquareSize / relHeight) * canvas.height;
    const vertOffset = (canvas.height - (squareSize * rows)) / 2;
    const horzOffset = (canvas.width - (squareSize * cols)) / 2;

    let color = 0;
    for (let i = 0; i < rows; i++) {
        for (let j = 0; j < cols; j++) {
            if (grid[i][j] == OBSTACLE) {
                ctx.fillStyle = '#474747';
            }
            else if (color % 2 == 0) {
                ctx.fillStyle = '#c5ff74a6';
            }
            else {
                ctx.fillStyle = '#6fce74af';
            }
            ctx.fillRect(horzOffset + j * squareSize, vertOffset + i * squareSize, squareSize, squareSize);
            color++;

            if (grid[i][j] == FOOD) {
                drawCircle(ctx, horzOffset + j * squareSize + squareSize / 2, vertOffset + i * squareSize + squareSize / 2,
                    (relFoodRadius / relHeight) * canvas.height, 'red');
            }
        }
    }

    // Snake
    const snakeWidth = (relSnakeWidth / relHeight) * canvas.height;
    for (let i = 0; i < snake.length; i++) {
        ctx.fillStyle = 'blue';
        drawCircle(ctx, horzOffset + snake[i].c * squareSize + squareSize / 2,
            vertOffset + snake[i].r * squareSize + squareSize / 2, snakeWidth / 2, 'blue');
        if (i > 0) {
            if (snake[i].dirR == 1) {
                ctx.fillRect(horzOffset + snake[i].c * squareSize + squareSize / 2 - (snakeWidth / 2),
                    vertOffset + snake[i].r * squareSize + squareSize / 2, snakeWidth, squareSize);
            }
            else if (snake[i].dirR == -1) {
                ctx.fillRect(horzOffset + snake[i].c * squareSize + squareSize / 2 - (snakeWidth / 2),
                    vertOffset + (snake[i].r - 1) * squareSize + squareSize / 2, snakeWidth, squareSize);
            }
            else if (snake[i].dirC == 1) {
                ctx.fillRect(horzOffset + snake[i].c * squareSize + squareSize / 2,
                    vertOffset + snake[i].r * squareSize + squareSize / 2 - (snakeWidth / 2), squareSize, snakeWidth);
            }
            else {
                ctx.fillRect(horzOffset + (snake[i].c - 1) * squareSize + squareSize / 2,
                    vertOffset + snake[i].r * squareSize + squareSize / 2 - (snakeWidth / 2), squareSize, snakeWidth);
            }
            
        }
    }

    // Draw eyes
    const eyeRadius = snakeWidth / 4;
    if (head.dirR == 1) {
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4, eyeRadius, 'white');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4, eyeRadius, 'white');

        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4 + eyeRadius / 4, eyeRadius * 0.75, 'black');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4 + eyeRadius / 4, eyeRadius * 0.75, 'black');
    }
    else if (head.dirR == -1) {
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4, eyeRadius, 'white');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4, eyeRadius, 'white');
        
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4 - eyeRadius / 4, eyeRadius * 0.75, 'black');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4 - eyeRadius / 4, eyeRadius * 0.75, 'black');
    }
    else if (head.dirC == 1) {
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4, eyeRadius, 'white');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4, eyeRadius, 'white');
        
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4 + eyeRadius / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4, eyeRadius * 0.75, 'black');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 - squareSize / 4 + eyeRadius / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4, eyeRadius * 0.75, 'black');
    }
    else {
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4, eyeRadius, 'white');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4, eyeRadius, 'white');
        
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4 - eyeRadius / 4,
            vertOffset + head.r * squareSize + squareSize / 2 + squareSize / 4, eyeRadius * 0.75, 'black');
        drawCircle(ctx, horzOffset + head.c * squareSize + squareSize / 2 + squareSize / 4 - eyeRadius / 4,
            vertOffset + head.r * squareSize + squareSize / 2 - squareSize / 4, eyeRadius * 0.75, 'black');
    }

    // Score
    const vertScoreOffset = vertOffset * 0.4;
    const horzScoreOffset = horzOffset * 0.08;
    ctx.fillStyle = "white";
    const fontSize = canvas.width * 0.03;
    ctx.font = `${fontSize}px Arial`;
    ctx.textAlign = "left";
    ctx.textBaseline = "top";

    ctx.fillText("Score: " + score, horzScoreOffset, vertScoreOffset);
}

function drawCircle(ctx, x, y, radius, color) {
    ctx.fillStyle = color;
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, Math.PI * 2);
    ctx.fill();
}

const inputQueue = [];
const MAX_QUEUE = 5;

function enqueue(direction) {
    if (inputQueue.length >= MAX_QUEUE) return;

    if (inputQueue.length > 0) {
        const last = inputQueue[inputQueue.length - 1];
        if (last === direction || (last.r == -direction.r && last.c == -direction.c)) return;
    }

    inputQueue.push(direction);
}

document.addEventListener("keydown", (e) => {
    if (e.key === "ArrowUp") {
        enqueue({dirR: -1, dirC: 0});
        gameStart = true;
    }
    if (e.key === "ArrowDown") {
        enqueue({dirR: 1, dirC: 0});
        gameStart = true;
    }
    if (e.key === "ArrowLeft" && gameStart) {
        enqueue({dirR: 0, dirC: -1});
    }
    if (e.key === "ArrowRight") {
        enqueue({dirR: 0, dirC: 1});
        gameStart = true;
    }
});

function resetGame() {
    createGrid();
    if (numObstacles > 0) createObstacles();
    for (let i = 0; i < foods; i++) {
        spawnFood();
    }
    gameStart = false;
    gameOver = false;
}


function gameLoop() {
    update();
    draw();
    requestAnimationFrame(gameLoop);
}

resetGame();
gameLoop();