<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    public function rooms()
    {
        return $this->belongsToMany('suo\Room');
    }
}
