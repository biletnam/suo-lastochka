<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    public function rooms()
    {
        return $this->belongsToMany('suo\Room');
    }
}
