<?php
return [
    'padmin' => [
        'type' => 2,
    ],
    'admin' => [
        'type' => 1,
        'ruleName' => 'userGroup',
        'children' => [
            'padmin',
        ],
    ],
];
