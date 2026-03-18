const container = document.getElementById('game-container');
const canvas = document.createElement('canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;

const lives = GAME_SETTINGS.lives;

console.log('Size: ', lives);