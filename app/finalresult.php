<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class finalresult extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function exam()
    {
        return $this->belongsTo('App\exam');
    }
}
