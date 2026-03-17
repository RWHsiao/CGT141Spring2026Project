const container = document.getElementById('game-container');
const canvas = document.createElement('canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;

const speed = GAME_SETTINGS.speed;

console.log('Size: ', speed);