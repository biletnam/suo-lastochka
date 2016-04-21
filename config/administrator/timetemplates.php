<?php

return [
    'title' => 'Timetemplates',
    'single' => 'timetemplate',
    'model' => 'suo\Timetemplate',
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
        ],
    ]
];

