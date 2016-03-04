<?php

return [
    'title' => 'Terminals',
    'single' => 'terminal',
    'model' => 'suo\Terminal',
    'columns' => [
        'id',
        'ip_address',
        'name',
        'description',
        'num_rooms' => [
            'title' => '# Rooms',
            'relationship' => 'rooms', //this is the name of the Eloquent relationship method!
            'select' => "COUNT((:table).id)",
        ],
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
        ],
        'rooms' => [
            'type' => 'relationship',
            'title' => 'Rooms',
            'name_field' => 'description', //using the getFullNameAttribute accessor
        ],
    ]
];

