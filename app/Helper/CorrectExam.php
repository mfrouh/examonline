<?php

use App\exam;
use App\examsetting;
use App\finalresult;
use App\question;
use App\studentexam;
use Carbon\Carbon;

class CorrectExam
{
    protected $questions;
    public function __construct($questions)
    {
        $this->questions=$questions;
    }
    private function CorrectAnswer()
    {
       $correct=array();
       foreach ($this->questions as $id => $answer)
       {

         $question=question::find($id);

          ///True Or false correct Answer ////

         if ($question && $question->IsTrueOrFalse())
          {
             if (in_array($answer,json_decode($question->correctanswer)))
             {
                $correct[$question->id]=$answer;
             }
          }

            ///ChoiceOne correct Answer ////

         if ($question && $question->IsChoiceOne())
         {
             if (in_array($answer,json_decode($question->correctanswer)))
             {
                $correct[$question->id]=$answer;
             }
         }

         ///Complete correct Answer ////

         if ($question && $question->IsComplete())
         {
           if ($answer==$question->option1)
           {
              $correct[$question->id]=$answer;
           }
         }
          ///MultipleChoice correct Answer ////

         if ($question && $question->IsMultipleChoice())
          {
             if (array_intersect(json_decode($question->correctanswer),$answer))
             {
                $correct[$question->id]=json_encode(array_intersect(json_decode($question->correctanswer),$answer));
             }
          }
       }
        return $correct;
    }
    private function WrongAnswer()
    {
        $wrong=array();
         foreach ($this->questions as $id => $answer)
         {
           $question=question::find($id);

            //// True or False Wrong Answer////

             if ($question && $question->IsTrueOrFalse())
             {
                if(!in_array($answer,json_decode($question->correctanswer)))
               {
                  $wrong[$question->id]=$answer;
               }
             }

            //// Complete Wrong Answer////

            if ($question && $question->IsComplete())
            {
                if ($answer!=$question->option1)
                {
                    $wrong[$question->id]=$answer;
                }
            }

            //// MultipleChoice Wrong Answer////

            if ($question && $question->IsMultipleChoice())
            {
                if (array_diff($answer,json_decode($question->correctanswer)))
                {
                    $wrong[$question->id]=json_encode(array_diff($answer,json_decode($question->correctanswer)));
                }
            }

             //// ChoiceOne Wrong Answer////

            if ($question && $question->IsChoiceOne())
            {
               if (!in_array($answer,json_decode($question->correctanswer)))
               {
                   $wrong[$question->id]=$answer;
               }
            }

         }

         return $wrong;
    }
    private function NotAnswer()
    {
        $combin=array();
        foreach ($this->CorrectAnswer() as $key => $value) {
           $combin[]=$key;
        }
        foreach ($this->WrongAnswer() as $key => $value) {
           $combin[]=$key;
        }
        if(array_diff(json_decode($this->questions['allquest']),$combin))
        {
            return array_diff(json_decode($this->questions['allquest']),$combin);
        }
    }
    private function CorrectAnswerExceptMultipleChoice()
    {
      $correct=array();
       foreach ($this->questions as $id => $answer)
       {
         $question=question::find($id);

          ///True Or false correct Answer ////

         if ($question && $question->IsTrueOrFalse())
          {
             if (in_array($answer,json_decode($question->correctanswer)))
             {
                $correct[$question->id]=$answer;
             }
          }

            ///ChoiceOne correct Answer ////

         if ($question && $question->IsChoiceOne())
         {
             if (in_array($answer,json_decode($question->correctanswer)))
             {
                $correct[$question->id]=$answer;
             }
         }

         ///Complete correct Answer ////

         if ($question && $question->IsComplete())
         {
           if ($answer==$question->option1)
           {
              $correct[$question->id]=$answer;
           }
         }
       }
        return $correct;
    }
    private function MarkMultipleChoice()
    {
        $mark=0;
       foreach ($this->questions as $id => $answer)
       {
           $correct=0;
           $wrong=0;
           $question=question::find($id);

           if ($question && $question->IsMultipleChoice())
            {
                ///Mark coreect Answer MultipleChoice///

             if (array_intersect(json_decode($question->correctanswer),$answer))
             {
                $this->Correct[$question->id]=array_intersect(json_decode($question->correctanswer),$answer);
                $y=count(array_intersect(json_decode($question->correctanswer),$answer))/count(json_decode($question->correctanswer));
                $correct=($y*$question->mark);
             }
              ///Mark Wrong Answer MultipleChoice///

             if (array_diff($answer,json_decode($question->correctanswer)))
             {
                $this->Wrong[$question->id]=array_diff($answer,json_decode($question->correctanswer));
                $y=count(array_diff($answer,json_decode($question->correctanswer)))/count(json_decode($question->correctanswer));
                $wrong=($y*$question->mark);

             }
             if($wrong >= $correct)
             {
               $mark+=0;
             }
             elseif($wrong < $correct)
             {
                $mark+=($correct-$wrong);
             }
            }
       }
        return $mark;
    }
    private function Mark()
    {
        $mark=0;
        foreach ($this->CorrectAnswerExceptMultipleChoice() as $key => $value) {
           $question=question::find($key);
           $mark+=$question->mark;
        }
        $mark+=$this->MarkMultipleChoice();
        return $mark;
    }
    private function Total()
    {
       $total=0;
       foreach (json_decode($this->questions['allquest']) as $key => $value) {
           $question=question::find($value);
           $total+=$question->mark;
       }
       return $total;
    }
    private function Score()
    {
      return ($this->Mark()/$this->Total())*100;
    }
    private function State()
    {
        $exam=exam::find($this->questions['exam_id']);
        if($this->Score()>=$exam->gradepass){
          return 'pass';
        }
        else
        {
          return 'fail';
        }
    }
    public function getdate()
    {
       return ['Correct'=>$this->CorrectAnswer(),'Wrong'=>$this->WrongAnswer(),'NotAnswer'=>$this->NotAnswer(),'Score'=>$this->Score(),'State'=>$this->State(),'Total'=>$this->Total(),'Mark'=>$this->Mark(),'Questions'=>$this->questions['allquest']];
    }
    public function saveexam()
    {
        $studentexam=new studentexam();
        $studentexam->result=$this->Mark();
        $studentexam->total=$this->Total();
        $studentexam->score=$this->Score();
        $studentexam->state=$this->State();
        $studentexam->questions=$this->questions['allquest'];
        $studentexam->exam_id=$this->questions['exam_id'];
        $studentexam->user_id=auth()->user()->id;
        $studentexam->correct=json_encode($this->CorrectAnswer());
        $studentexam->wrong=json_encode($this->WrongAnswer());
        $studentexam->notanswer=json_encode($this->NotAnswer());
        $studentexam->save();
        $this->finalresult();
        $examsetting=examsetting::where('user_id',$studentexam->user_id)->where('exam_id',$studentexam->exam_id)->delete();
    }
    private function gettime($date)
    {
        $arr=[0,1,2,3,4,5,6,7,8,9];
        $day='';$hour='';$minute='';$second='';
        $date=$date;

        if(in_array($date->get('day'),$arr))
        {
            $day="0".$date->get('day');
        }
        else
        {
            $day=$date->get('day');
        }

        if(in_array($date->get('hour'),$arr))
        {
            $hour="0".$date->get('hour');
        }
        else
        {
            $hour=$date->get('hour');
        }

        if(in_array($date->get('minute'),$arr))
        {
          $minute="0".$date->get('minute');
        }
        else
        {
            $minute=$date->get('minute');
        }

        if(in_array($date->get('second'),$arr))
        {
          $second="0".$date->get('second');
        }
        else
        {
            $second=$date->get('second');
        }
        $total=$day.$hour.$minute.$second;

        return $total;
    }
    private function getnow($date)
    {
        $arr=[0,1,2,3,4,5,6,7,8,9];
        $day='';$hour='';$minute='';$second='';
        $date=$date;

        if(in_array($date->get('day'),$arr))
        {
            $day="0".$date->get('day');
        }
        else
        {
            $day=$date->get('day');
        }

        if(in_array($date->get('hour'),$arr))
        {
            $hour="0".$date->get('hour');
        }
        else
        {
            $hour=$date->get('hour');
        }

        if(in_array($date->get('minute'),$arr))
        {
          $minute="0".$date->get('minute');
        }
        else
        {
            $minute=$date->get('minute');
        }

        if(in_array($date->get('second'),$arr))
        {
          $second="0".$date->get('second');
        }
        else
        {
            $second=$date->get('second');
        }
        return $day*60*60*24+$hour*60*60+$minute*60+$second;
    }
    public function sessionexam($request)
    {
        $date1=Carbon::now()->addMinutes($request->timeer);
        $countexam=examsetting::where('user_id',auth()->user()->id)->where('exam_id',$request->exam)->count();
        $ex=examsetting::where('user_id',auth()->user()->id)->where('exam_id',$request->exam)->first();
        if($countexam==0)
        {
            $examsetting=new examsetting();
            $examsetting->name=auth()->user()->id."__".$request->exam;
            $examsetting->user_id=auth()->user()->id;
            $examsetting->exam_id=$request->exam;
            $examsetting->end=$this->gettime($date1);
            $examsetting->save();
            return ['success'=>'ok','data'=>$examsetting];
        }
        else
        {
          $date2=Carbon::now();

          if($this->gettime($date2) >= $ex->end)
          {
             return ['success'=>'foundend','data'=>$this->gettime($date2)];
          }
          else
          {
             $ag = str_split($ex->end, strlen($ex->end)/4);
             $tnowsec=$this->getnow($date2);
             $tnowsecend=$ag[0]*60*60*24+$ag[1]*60*60+($ag[2])*60+$ag[3];
             return ['success'=>'foundnotend','data'=>($tnowsecend-$tnowsec)];
          }
        }
    }
    private function finalresult()
    {
       $finalresult=finalresult::where('user_id',auth()->user()->id)->where('exam_id',$this->questions['exam_id'])->first();
       $exam=exam::find($this->questions['exam_id']);
       if(!$finalresult)
       {
          $finalresult=new finalresult();
          $finalresult->exam_id=$exam->id;
          $finalresult->user_id=auth()->user()->id;
          $finalresult->correct=$exam->Total(auth()->user()->id)['correct'];
          $finalresult->wrong=$exam->Total(auth()->user()->id)['wrong'];
          $finalresult->notanswer=$exam->Total(auth()->user()->id)['notanswer'];
          $finalresult->score=$exam->Total(auth()->user()->id)['score'];
          $finalresult->state=$exam->Total(auth()->user()->id)['state'];
          $finalresult->taked=$exam->Total(auth()->user()->id)['taked'];
          $finalresult->save();
       }
       else
       {
          $finalresult->exam_id=$exam->id;
          $finalresult->user_id=auth()->user()->id;
          $finalresult->correct=$exam->Total(auth()->user()->id)['correct'];
          $finalresult->wrong=$exam->Total(auth()->user()->id)['wrong'];
          $finalresult->notanswer=$exam->Total(auth()->user()->id)['notanswer'];
          $finalresult->score=$exam->Total(auth()->user()->id)['score'];
          $finalresult->state=$exam->Total(auth()->user()->id)['state'];
          $finalresult->taked=$exam->Total(auth()->user()->id)['taked'];
          $finalresult->save();
       }
    }
}
