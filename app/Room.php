<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'ip'];

    public function terminals()
    {
        return $this->belongsToMany('suo\Terminal');
    }

    public function users()
    {
        return $this->belongsToMany('suo\User');
    }
}
