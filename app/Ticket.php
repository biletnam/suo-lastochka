<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function room()
    {
        return $this->belongsTo('suo\Room');
    }
}
