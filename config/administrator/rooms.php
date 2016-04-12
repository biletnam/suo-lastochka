<?php

return [
    'title' => 'Rooms',
    'single' => 'room',
    'model' => 'suo\Room',
    'columns' => [
        'id',
        'name',
        'description',
        'ip',
        'max_day_record',
        'num_terminals' => [
            'title' => '# Terminals',
            'relationship' => 'terminals', //this is the name of the Eloquent relationship method!
            'select' => "COUNT((:table).id)",
        ],
        'num_users' => [
            'title' => '# Users',
            'relationship' => 'users', //this is the name of the Eloquent relationship method!
            'select' => "COUNT((:table).id)",
        ],
        'num_panels' => [
            'title' => '# Panels',
            'relationship' => 'panels', //this is the name of the Eloquent relationship method!
            'select' => "COUNT((:table).id)",
        ],
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
        ],
        'ip' => [
            'title' => 'ip',
            'type' => 'text',
        ],
        'max_day_record' => [
            'title' => 'max_day_record',
            'type' => 'text',
        ],
        'terminals' => [
            'title' => 'Terminals',
            'type' => 'relationship',
            'name_field' => 'description',
        ],
        'users' => [
            'title' => 'Users',
            'type' => 'relationship',
            'name_field' => 'name',
        ],
        'panels' => [
            'title' => 'Panels',
            'type' => 'relationship',
            'name_field' => 'description',
        ],
    ]
];

