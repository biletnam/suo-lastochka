<?php

namespace suo;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function roles()
    {
        return $this->belongsToMany('suo\Role');
    }

    public function rooms()
    {
        return $this->belongsToMany('suo\Room');
    }

    public function isOperator()
    {
        $isOperator = !$this->roles->filter(function($item) {
            return strtolower($item->name) == 'operator';
        })->isEmpty();
    
        return $isOperator;
    }

}
