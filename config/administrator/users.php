<?php

return [
    'title' => 'Users',
    'single' => 'user',
    'model' => 'suo\User',
    'columns' => [
        'id',
        'name',
        'email',
        'num_roles' => [
            'title' => '# Roles',
            'relationship' => 'roles', //this is the name of the Eloquent relationship method!
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
            'title' => 'email',
            'type' => 'text',
        ],
        'roles' => [
            'title' => 'Roles',
            'type' => 'relationship',
            'name_field' => 'description',
        ],
    ]
];
