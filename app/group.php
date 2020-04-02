<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class group extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];
   public function exams()
   {
       return $this->hasMany('App\exam');
   }
   public function user()
   {
       return $this->belongsTo('App\User');
   }
   public function users()
   {
       return $this->hasMany('App\User');
   }
   public function studentgroups()
   {
       return $this->hasMany('App\Studentgroup');
   }
}
