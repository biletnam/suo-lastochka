<?php

return [
    'title' => 'Checks',
    'single' => 'check',
    'model' => 'suo\Check',
    'columns' => [
        'id',
        'number',
        'addminsion_date',
        'created_at',
        'updated_at',
    ],
    'edit_fields' => [
        'number' => [
            'title' => 'number',
            'type' => 'text',
        ],
        'addminsion_date' => [
            'title' => 'addminsion_date',
            'type' => 'text',
        ],
    ]
];

