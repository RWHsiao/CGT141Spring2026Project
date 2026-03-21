<?php
$games = [
    'Flappy Bird' => [
        'Easy' => [
            'script' => 'flappy_bird.js',
            'speed' => 1,
            'maxGap' => 8,
            'movingObstacles' => false
        ],
        'Medium' => [
            'script' => 'flappy_bird.js',
            'speed' => 1.5,
            'maxGap' => 7,
            'movingObstacles' => false
        ],
        'Hard' => [
            'script' => 'flappy_bird.js',
            'speed' => 2,
            'maxGap' => 6,
            'movingObstacles' => false
        ],
        'Extreme' => [
            'script' => 'flappy_bird.js',
            'speed' => 2,
            'maxGap' => 6,
            'movingObstacles' => true
        ]
    ],
    'Pong' => [
        'Easy' => [
            'script' => 'pong.js',
            'ballSpeed' => 1,
            'enemySpeed' => 1,
            'lives' => 3
        ],
        'Medium' => [
            'script' => 'pong.js',
            'ballSpeed' => 2,
            'enemySpeed' => 2,
            'lives' => 3
        ],
        'Hard' => [
            'script' => 'pong.js',
            'ballSpeed' => 3,
            'enemySpeed' => 3,
            'lives' => 3
        ],
        'Extreme' => [
            'script' => 'pong.js',
            'ballSpeed' => 3,
            'enemySpeed' => 3,
            'lives' => 1
        ]
    ],
    'Snake Game' => [
        'Classic' => [
            'script' => 'snake_game.js',
            'size' => 15,
            'apples' => 1,
            'obstacles' => false
        ],
        'Extended' => [
            'script' => 'snake_game.js',
            'size' => 25,
            'apples' => 2,
            'obstacles' => false
        ],
        'Hard' => [
            'script' => 'snake_game.js',
            'size' => 15,
            'apples' => 1,
            'obstacles' => true
        ]
    ]
];
?>