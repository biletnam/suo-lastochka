<?php

return [
    'title' => 'Roles',
    'single' => 'role',
    'model' => 'suo\Role',
    'columns' => [
        'id',
        'name',
        'description',
        'num_users' => [
            'title' => '# Users',
            'relationship' => 'users', //this is the name of the Eloquent relationship method!
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
        'users' => [
            'title' => 'Users',
            'type' => 'relationship',
            'name_field' => 'name',
        ],
    ]
];

