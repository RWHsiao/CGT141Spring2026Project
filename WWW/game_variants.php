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
            'lives' => 5
        ],
        'Medium' => [
            'script' => 'pong.js',
            'ballSpeed' => 1.25,
            'enemySpeed' => 1.5,
            'lives' => 5
        ],
        'Hard' => [
            'script' => 'pong.js',
            'ballSpeed' => 1.5,
            'enemySpeed' => 2.5,
            'lives' => 5
        ],
        'Extreme' => [
            'script' => 'pong.js',
            'ballSpeed' => 1.5,
            'enemySpeed' => 2.5,
            'lives' => 1
        ]
    ],
    'Snake Game' => [
        'Classic' => [
            'script' => 'snake_game.js',
            'rows' => 15,
            'cols' => 17,
            'foods' => 1,
            'obstacles' => 0
        ],
        'Extended' => [
            'script' => 'snake_game.js',
            'rows' => 25,
            'cols' => 29,
            'foods' => 10,
            'obstacles' => 0
        ],
        'Obstacles' => [
            'script' => 'snake_game.js',
            'rows' => 15,
            'cols' => 17,
            'foods' => 1,
            'obstacles' => 15
        ],
        'Extended + Obstacles' => [
            'script' => 'snake_game.js',
            'rows' => 25,
            'cols' => 29,
            'foods' => 10,
            'obstacles' => 40
        ]
    ]
];
?>