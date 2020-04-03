<?php

use App\exam;
use App\examsetting;
use App\question;
use App\studentexam;

class Myquestion
{
    protected $questions;
    private $Correct=array();
    private $Wrong=array();
    private $Mark=0;
    public function __construct($questions)
    {
        $this->questions=$questions;
    }
    private function CorTrueOrFalse()
    {
       foreach ($this->questions as $id => $answer)
       {
         $question=question::find($id);
         if ($question && $question->IsTrueOrFalse())
          {
             if (in_array($answer,json_decode($question->correctanswer)))
             {
                $this->Correct[$question->id]=$answer;
                $this->Mark+=$question->mark;
             }
          }
       }
        return $this->Correct;

    }
    private function FalTrueOrFalse()
    {
       foreach ($this->questions as $id => $answer)
       {
            $question=question::find($id);
         if ($question && $question->IsTrueOrFalse())
          {
            if(!in_array($answer,json_decode($question->correctanswer)))
             {
                 $this->Wrong[$question->id]=$answer;
             }
          }
       }
        return $this->Wrong;
    }
    private function CorMultipleChoice()
    {
       foreach ($this->questions as $id => $answer)
       {
            $question=question::find($id);
         if ($question && $question->IsMultipleChoice())
          {
             if (array_intersect(json_decode($question->correctanswer),$answer))
             {
                $this->Correct[$question->id]=json_encode(array_intersect(json_decode($question->correctanswer),$answer));
             }
          }
       }
        return $this->Correct;
    }
    private function FalMultipleChoice()
    {
       foreach ($this->questions as $id => $answer)
       {
            $question=question::find($id);
         if ($question && $question->IsMultipleChoice())
          {
             if (array_diff($answer,json_decode($question->correctanswer)))
             {
                $this->Wrong[$question->id]=json_encode(array_diff($answer,json_decode($question->correctanswer)));
             }
          }
       }
        return $this->Wrong;
    }
    private function CorChoiceOne()
    {
       foreach ($this->questions as $id => $answer)
       {
            $question=question::find($id);
         if ($question && $question->IsChoiceOne())
          {
            if (in_array($answer,json_decode($question->correctanswer)))
            {
                $this->Correct[$question->id]=$answer;
                $this->Mark+=$question->mark;
            }
          }
       }
       return $this->Correct;
    }
    private function FalChoiceOne()
    {
       foreach ($this->questions as $id => $answer)
       {
            $question=question::find($id);
         if ($question && $question->IsChoiceOne())
          {
            if (!in_array($answer,json_decode($question->correctanswer)))
            {
                $this->Wrong[$question->id]=$answer;
            }
          }
       }
      return $this->Wrong;
    }
    private function CorComplete()
    {
       foreach ($this->questions as $id => $answer)
       {
        $question=question::find($id);
         if ($question && $question->IsComplete())
          {
            if ($answer==$question->option1)
            {
              $this->Correct[$question->id]=$answer;
              $this->Mark+=$question->mark;
            }
          }
       }
       return  $this->Correct;
    }
    private function FalComplete()
    {
       foreach ($this->questions as $id => $answer)
       {
         $question=question::find($id);
         if ($question && $question->IsComplete())
          {
            if ($answer!=$question->option1)
            {
              $this->Wrong[$question->id]=$answer;
            }
          }
       }
       return  $this->Wrong;
    }
    private function Correct()
    {
        return $this->mergeanswer($this->CorTrueOrFalse(),$this->CorMultipleChoice(),$this->CorChoiceOne(),$this->CorComplete());
    }
    private function cor()
    {
        return $this->mer($this->CorTrueOrFalse(),$this->CorChoiceOne(),$this->CorComplete());
    }
    private function Wrong()
    {
        return $this->mergeanswer($this->FalTrueOrFalse(),$this->FalMultipleChoice(),$this->FalChoiceOne(),$this->FalComplete());
    }
    private function NotAnswer()
    {
        $combin=array();
        foreach ($this->Correct() as $key => $value) {
           $combin[]=$key;
        }
        foreach ($this->Wrong() as $key => $value) {
           $combin[]=$key;
        }
        if(array_diff(json_decode($this->questions['allquest']),$combin))
        {
            return array_diff(json_decode($this->questions['allquest']),$combin);
        }
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
    private function merge($arr1,$arr2)
    {
       $combin=array();
       foreach ($arr1 as $key => $value) {
          $combin[$key]=$value;
       }
       foreach ($arr2 as $key => $value) {
          $combin[$key]=$value;
       }
       return $combin;
    }
    private function mergeanswer($arr1,$arr2,$arr3,$arr4)
    {
       $combin=array();
       foreach ($arr1 as $key => $value) {
          $combin[$key]=$value;
       }
       foreach ($arr2 as $key => $value) {
          $combin[$key]=$value;
       }
       foreach ($arr3 as $key => $value) {
          $combin[$key]=$value;
      }
      foreach ($arr4 as $key => $value) {
          $combin[$key]=$value;
      }
       return $combin;
    }
    private function mer($arr1,$arr2,$arr3)
    {
       $combin=array();
       foreach ($arr1 as $key => $value) {
          $combin[$key]=$value;
       }
       foreach ($arr2 as $key => $value) {
          $combin[$key]=$value;
       }
       foreach ($arr3 as $key => $value) {
          $combin[$key]=$value;
      }
       return $combin;
    }
    public function getdate()
    {
       return ['Correct'=>$this->Correct(),'Wrong'=>$this->Wrong(),'NotAnswer'=>$this->NotAnswer(),'Score'=>$this->Score(),'State'=>$this->State(),'Total'=>$this->Total(),'Mark'=>$this->Mark(),'Questions'=>$this->questions['allquest']];
    }
    private function Mark()
    {
        $mark=0;
        foreach ($this->cor() as $key => $value) {
           $question=question::find($key);
           $mark+=$question->mark;
        }
        $mark+=$this->MarkPl();

        return $mark;
    }
    private function MarkPl()
    {
        $mark=0;

       foreach ($this->questions as $id => $answer)
       {
        $correct=0;
        $wrong=0;
           $question=question::find($id);
           if ($question && $question->IsMultipleChoice())
            {
             if (array_intersect(json_decode($question->correctanswer),$answer))
             {
                $this->Correct[$question->id]=array_intersect(json_decode($question->correctanswer),$answer);
                $y=count(array_intersect(json_decode($question->correctanswer),$answer))/count(json_decode($question->correctanswer));
                $correct=($y*$question->mark);
             }
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
    public function saveexam()
    {
        $studentexam=new studentexam();
        $studentexam->result=$this->Mark();
        $studentexam->total=$this->Total();
        $studentexam->score= ($studentexam->result/$studentexam->total)*100;
        $exam=exam::find($this->questions['exam_id']);
        if($studentexam->score >=$exam->gradepass){
            $studentexam->state='pass';
        }
        else
        {
            $studentexam->state='fail';
        }
        $studentexam->questions=$this->questions['allquest'];
        $studentexam->exam_id=$this->questions['exam_id'];
        $studentexam->user_id=auth()->user()->id;
        $studentexam->correct=json_encode($this->Correct());
        $studentexam->wrong=json_encode($this->Wrong());
        $studentexam->notanswer=json_encode($this->NotAnswer());
        $studentexam->save();
        $examsetting=examsetting::where('user_id',$studentexam->user_id)->where('exam_id',$studentexam->exam_id)->delete();
    }
}
