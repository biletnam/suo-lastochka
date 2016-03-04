<?php

return [
    'title' => 'Rooms',
    'single' => 'room',
    'model' => 'suo\Room',
    'columns' => [
        'id',
        'name',
        'description',
        'num_terminals' => [
            'title' => '# Terminals',
            'relationship' => 'terminals', //this is the name of the Eloquent relationship method!
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
        'terminals' => [
            'title' => 'Terminals',
            'type' => 'relationship',
            'name_field' => 'description',
        ],
    ]
];

