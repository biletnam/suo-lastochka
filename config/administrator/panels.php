<?php

return [
    'title' => 'Panels',
    'single' => 'panel',
    'model' => 'suo\Panel',
    'columns' => [
        'id',
        'ip_address',
        'name',
        'description',
        'created_at',
        'updated_at',
    ],
    'edit_fields' => [
        'ip_address' => [
            'title' => 'ip address',
            'type' => 'text',
        ],
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

