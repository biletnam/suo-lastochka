<?php

return [
    'title' => 'Tickets',
    'single' => 'ticket',
    'model' => 'suo\Ticket',
    'columns' => [
        'id',
        'room_id',
        'window',
        'status',
        'check_id',
        'created_by_type',
        'created_by_id',
        'check_id',
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
        'window' => [
            'type' => 'text',
            'title' => 'Window',
        ],
        'status' => [
            'type' => 'text',
            'title' => 'Status',
        ],
        'check' => [
            'type' => 'relationship',
            'title' => 'Check',
            'name_field' => 'number',
        ],
        'admission_date' => [
            'type' => 'datetime',
            'title' => 'admission_date',
            'date_format' => 'dd.mm.yy', //optional, will default to this value
            'time_format' => 'HH:mm',    //optional, will default to this value
        ],
    ]
];

