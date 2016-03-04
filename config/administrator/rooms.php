<?php

return [
    'title' => 'Rooms',
    'single' => 'room',
    'model' => 'suo\Room',
    'columns' => [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at',
    ],
    'edit_fields' => [
        'name' => [
            'title' => 'name',
            'type' => 'text',
        ],
        'description' => [
            'title' => 'description',
            'type' => 'text',
        ]
    ]
];

