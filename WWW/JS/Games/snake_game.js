const container = document.getElementById('game-container');
const canvas = document.createElement('canvas');
canvas.width = container.offsetWidth;
canvas.height = container.offsetHeight;

const size = GAME_SETTINGS.size;

console.log('Size: ', size);