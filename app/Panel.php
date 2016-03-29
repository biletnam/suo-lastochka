<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    public function rooms()
    {
        return $this->belongsToMany('suo\Room');
    }
}
