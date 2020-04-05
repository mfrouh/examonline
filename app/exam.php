<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam extends Model
{
    protected $fillable = [
        'name', 'time', 'start','end','gradepass','group_id'
    ];
    protected $dates=[
        'start','end'
    ];
    public function finalresults()
    {
        return $this->hasMany('App\finalresult');
    }
    public function start()
     {
       return $this->start->translatedformat('Y-m-d').'T'. $this->start->translatedformat('h:i:s');
     }
    public function now()
     {
       return now()->translatedformat('Y-m-d').'T'. now()->translatedformat('h:i:s');
     }
    public function end()
     {
       return $this->end->translatedformat('Y-m-d').'T'. $this->end->translatedformat('h:i:s');
     }
    public function group()
    {
        return $this->belongsTo('App\group');
    }
    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function questions()
    {
        return $this->hasMany('App\question');
    }
    public function studentexams()
    {
        return $this->hasMany('App\studentexam');
    }
    public function IsActive()
    {
        if($this->start<=now() && now()<=$this->end && !count($this->questions)==0)
        {
            return true;
        }
        return false;
    }
    public  function IsJoinGroup()
    {
        foreach (auth()->user()->studentgroups as $key => $studentgroup) {
           if ($studentgroup->group_id==$this->group_id && $studentgroup->state=="accept" ) {
               return true;
           }
        }
        return false;
    }
    public function IsTaked()
    {
        if(in_array($this->id,$this->MR()) && $this->take <= count($this->MR()))
        {
            return true;
        }
        return false;
    }
    public function MR()
    {
       $exams=array();
       foreach (auth()->user()->studentexams as $key => $studentexam) {
           if($studentexam->exam_id==$this->id)
           {
               $exams[]=$studentexam->exam_id;
           }
       }
       return $exams;
    }
    public function Total($id)
    {
       $correct=0;
       $wrong=0;
       $notanswer=0;
       $score=array();
       $totalscore=0;
       $state='';
       $studentexams=studentexam::where('user_id',$id)->where('exam_id',$this->id)->get();
       $taked=studentexam::where('user_id',$id)->where('exam_id',$this->id)->count();
       foreach ($studentexams as $key => $studentexam) {
               $correct+=$studentexam->countcorrect();
               $wrong+=$studentexam->countwrong();
               $notanswer+=$studentexam->countnotanswer();
               $score[]=$studentexam->score;
       }
       if($this->calculate=='best')
       {
        $totalscore=max($score);
       }
       elseif($this->calculate=='average')
       {
        $totalscore=array_sum($score)/count($score);
       }
       if($this->gradepass <= $totalscore)
       {
        $state='pass';
       }
       else
       {
        $state='fail';
       }
       return ['correct'=>$correct,'wrong'=>$wrong,'notanswer'=>$notanswer,'score'=>$totalscore,'state'=>$state,'taked'=>$taked];
    }

}
