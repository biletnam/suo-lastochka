<?php

return [
    'title' => 'Tickets',
    'single' => 'ticket',
    'model' => 'Ticket',
    'columns' => [
        
    ],
    'title' => 'Tickets',
    'single' => 'ticket',
    'model' => 'suo\Ticket',
    'columns' => [
        'id',
        'room_id',
        'status',
        'deleted_at',
        'created_at',
        'updated_at',
    ],
    'edit_fields' => [
        'room' => [
            'type' => 'relationship',
            'title' => 'Room',
            'name_field' => 'description',
        ],
        'status' => [
            'type' => 'text',
            'title' => 'Status',
        ],
    ]
];

