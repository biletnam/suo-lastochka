<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Timetemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    public function room()
    {
        return $this->belongsTo('suo\Room');
    }
}
