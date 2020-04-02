<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function Studentgroups()
    {
        return $this->hasMany('App\Studentgroup');
    }
    public function group()
    {
        return $this->belongsTo('App\group');
    }
    public function groups()
    {
        return $this->hasMany('App\group');
    }
    public function studentexams()
    {
        return $this->hasMany('App\studentexam');
    }
}
