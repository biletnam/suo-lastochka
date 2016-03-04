<?php

return [
    'title' => 'Users',
    'single' => 'user',
    'model' => 'suo\User',
    'columns' => [
        'id',
        'name',
        'email',
        'created_at',
        'updated_at',
    ],
    'edit_fields' => [
        'name' => [
            'title' => 'name',
            'type' => 'text',
        ],
        'description' => [
            'title' => 'email',
            'type' => 'text',
        ],
    ]
];
