<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Studentgroup extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function group()
    {
        return $this->belongsTo('App\group');
    }
    public function state()
    {
       if ($this->state=='accept')
        {
             return "<a class='btn btn-primary btn-sm brdrd'>{$this->lang()}</a>";
        }
       elseif ($this->state=='waiting')
        {
             return "<a class='btn btn-warning btn-sm brdrd'>{$this->lang()}</a>";
        }
       elseif ($this->state=='refused')
        {
             return "<a class='btn btn-danger btn-sm brdrd'>{$this->lang()}</a>";
        }
    }
    public function lang()
    {
       return __('home.'.$this->state);
    }

}
