<?php

return [
    'brand' => 'Al Diwan Engineering Consultancy',
    'home' => 'Back to home',
    'back' => 'Go back',
    'support' => 'If the issue continues, please try again later.',

    'pages' => [
        '401' => [
            'title' => 'Authentication required',
            'description' => 'Please sign in before accessing this page.',
        ],
        '403' => [
            'title' => 'Access denied',
            'description' => 'You do not have permission to access this page.',
        ],
        '404' => [
            'title' => 'Page not found',
            'description' => 'The page may have moved, been removed, or the address may be incorrect.',
        ],
        '419' => [
            'title' => 'Session expired',
            'description' => 'Your session expired for your protection. Go back and try again.',
        ],
        '429' => [
            'title' => 'Too many requests',
            'description' => 'Too many requests were sent in a short time. Please wait and try again.',
        ],
        '500' => [
            'title' => 'Something went wrong',
            'description' => 'We encountered a technical problem while processing your request.',
        ],
        '503' => [
            'title' => 'Temporarily unavailable',
            'description' => 'We are carrying out maintenance and improvements. Please check back soon.',
        ],
    ],
];
