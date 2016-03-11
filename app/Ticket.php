<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id'];

    public function room()
    {
        return $this->belongsTo('suo\Room');
    }
}
