<?php

return [
    'path' => [
        'upload' => '/uploads',
        'image' => '/uploads/images',
    ],

    'user' => [
        'default_avatar' => 'default.jpg',
        'role' => [
            'user' => 1,
            'partner' => 2,
            'admin' => 3,
        ],
        'status' => [
            'activated' => 1,
            'unactivated' => 0,
        ],
        'task_bar_status' => [
            'update_profile' => 1,
            'change_password' => 2,
        ]
    ],

    'garage' => [
        'default_avatar' => 'default.jpg',
        'top_rated_number' => 5,
        'comment' => [
          'paginate' => 5,
        ],
        'status' => [
            'activated' => 1,
            'unactivated' => 0,
        ],
        'type' => [
            'car' => 1,
            'motor' => 2,
            'bike' => 3,
        ]
    ],

    'article' => [
        'default_avatar' => 'default.jpg',
        'recent_viewed_number' => 5,
        'paginate' => 6,
        'comment' => [
            'paginate' => 10,
        ],
        'status' => [
            'activated' => 1,
            'unactivated' => 0,
        ],
    ],

    'error' => [
        '404' => [
            'image' => 'uploads/images/errors/404.png',
        ]
    ],

    'home_map_icon' => 'uploads/images/location-map-flat.jpg',
    'paging_number' => 10,
];
