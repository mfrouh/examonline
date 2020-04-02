<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $fillable = [
        'question', 'type', 'option1','option2','option3','option4','complete','correctanswer','mark','exam_id'
    ];
    public function exam()
    {
        return $this->belongsTo('App\exam');
    }
    public function IsComplete()
    {
        return $this->type=='complete';
    }
    public function IsTrueOrFalse()
    {
        return $this->type=='trueorfalse';
    }
    public function IsChoiceOne()
    {
        return $this->type=='choiceone';
    }
    public function IsMultipleChoice()
    {
        return $this->type=='multiplechoice';
    }
}
