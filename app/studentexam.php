<?php

namespace App;

use App\question;
use Illuminate\Database\Eloquent\Model;

class studentexam extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function exam()
    {
        return $this->belongsTo('App\exam');
    }
    public function Correct()
    {
        $arr=array();
        foreach (json_decode($this->correct) as $key => $value) {
           $arr[$key]=$value;
        };
        return $arr;
    }
    public function Wrong()
    {
        $arr=array();
        foreach (json_decode($this->wrong) as $key => $value) {
            if (is_array($value)) {
                $arr[$key]=json_encode($value);
            }
            else {
                $arr[$key]=$value;
            }

        };
        return $arr;
    }
    public function NotAnswer()
    {
        $arr=array();
       if (json_decode($this->notanswer)!=null) {
        foreach (json_decode($this->notanswer) as $key => $value) {
           $arr[$key]=$value;
        };
       }
        return $arr;

    }
    public function countcorrect()
    {
      return count($this->Correct());
    }
    public function countwrong()
    {
      return count($this->Wrong());
    }
    public function countnotanswer()
    {
      return count($this->NotAnswer());
    }
    public function IsBg($id,$option)
    {
        if(isset($this->correct()[$id]) && $this->correct()[$id]=="$option"){
        return 'bg-success';
        }
        elseif(isset($this->wrong()[$id]) && $this->wrong()[$id]=="$option")
        {
        return 'bg-danger';
        }
    }
    public function Ischeck($id,$option)
    {
        if(isset($this->correct()[$id]) && $this->correct()[$id]=="$option")
        {
            return 'checked';
        }
        elseif(isset($this->wrong()[$id]) && $this->wrong()[$id]=="$option")
        {
            return 'checked';
        }
    }

    public function IsMulCheck($id,$option)
    {

        if (isset($this->wrong()[$id])) {
        $wrong=array();
        foreach (json_decode($this->wrong()[$id]) as $key => $value) {
            $wrong[]=$value;
        }
        }
        if (isset($this->correct()[$id])) {
        $correct=array();
        foreach (json_decode($this->correct()[$id]) as $key => $value) {
            $correct[]=$value;
        }
         }
        if(isset($this->correct()[$id]) && in_array($option,$correct))
        {
            return'checked';
        }
        elseif(isset($this->wrong()[$id]) && in_array($option,$wrong))
        {
            return'checked';
        }
    }
    public function IsMulBg($id,$option)
    {

        if (isset($this->Wrong()[$id])) {
            $wrong=array();
            foreach (json_decode($this->wrong()[$id]) as $key => $value) {
                $wrong[]=$value;
            }
        }
        if (isset($this->correct()[$id])) {
            $correct=array();
            foreach (json_decode($this->correct()[$id]) as $key => $value) {
                $correct[]=$value;
            }
        }
        if(isset($this->correct()[$id]) &&  in_array($option,$correct))
        {
            return'bg-success';
        }
        elseif(isset($this->wrong()[$id])  && in_array($option,$wrong))
        {
            return'bg-danger';
        }
    }
    public function IsComBg($id)
    {
        if(isset($this->correct()[$id]))
        {
            return 'bg-success';
        }
        elseif(isset($this->wrong()[$id]))
        {
            return 'bg-danger text-white';
        }
    }
    public function IsCom($id)
    {
        if(isset($this->correct()[$id]))
        {
            return $this->correct()[$id];
        }
        elseif(isset($this->wrong()[$id]))
        {
            return $this->wrong()[$id];
        }
    }
    public function Corrected($id)
    {
        $wrong=0;
        $correct=0;
        $question=question::findorfail($id);
         if(isset($this->Correct()[$id]) && isset($this->Wrong()[$id]))
         {
            if(is_array(json_decode($this->Correct()[$id])))
            {
                $correct =$question->mark*(count(json_decode($this->Correct()[$id]))/count(json_decode($question->correctanswer)));
            }
            $wrong1=array();
            foreach (json_decode($this->wrong()[$id]) as $key => $value) {
                $wrong1[]=$value;
            }
            if(is_array($wrong1))
            {
                $wrong =$question->mark*(count($wrong1)/count(json_decode($question->correctanswer)));
            }
            if($wrong >= $correct)
            {
              return 0;
            }
            elseif($wrong < $correct)
            {
               return $correct-$wrong;
            }
         }
         elseif(isset($this->Correct()[$id]))
         {
             if(is_array(json_decode($this->Correct()[$id])))
             {
                 return  $question->mark*count(json_decode($this->Correct()[$id]))/count(json_decode($question->correctanswer));
             }
           return $question->mark;
         }
         elseif(isset($this->Wrong()[$id]))
         {
            if(is_array(json_decode($this->Wrong()[$id])))
            {
                return  $question->mark*count(json_decode($this->Wrong()[$id]))/count(json_decode($question->correctanswer));
            }
           return 0;
         }
         elseif(isset($this->NotAnswer()[$id]))
         {
           return 0;
         }
         else
         {
             return 0;
         }

    }
}
