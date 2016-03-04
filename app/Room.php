<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function terminals()
    {
        return $this->belongsToMany('suo\Terminal');
    }
}
