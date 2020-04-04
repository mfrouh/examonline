<?php

use App\exam;
use App\examsetting;
use App\question;
use App\studentexam;

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
        $examsetting=examsetting::where('user_id',$studentexam->user_id)->where('exam_id',$studentexam->exam_id)->delete();
    }
}
