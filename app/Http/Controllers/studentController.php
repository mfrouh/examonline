<?php

namespace App\Http\Controllers;

use App\exam;
use App\examsetting;
use App\studentgroup;
use App\question;
use App\studentexam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Myquestion;

class studentController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth','checkrole:student']);
    }
    public function show(exam $exam)
    {
        if(!$exam->IsTaked() && $exam->IsActive() && $exam->IsJoinGroup())
        {
           $questions=question::where('exam_id',$exam->id)->get();
           return view('pages.show',compact('questions'));
        }
        return abort('404');
    }
    public function startexam(Request $request)
    {
        $exam=exam::find($request->exam_id);
        $studentexams=studentexam::where('exam_id',$exam->id)->where('user_id',auth()->user()->id)->count();
        if($exam->take > $studentexams){
        $Myquestion=new Myquestion($request->except('_token'));
        $Myquestion->saveexam();
        return redirect('/results');
        }
        return redirect('/results');
    }
    public function exams()
    {
        $exams=exam::whereIn('group_id',auth()->user()->studentgroups->pluck('group_id')->toArray())->orderby('id','desc')->get();
        return view('student.exams',compact('exams'));
    }
    public function result($userid,$id)
    {
        $exam=exam::findorfail($id);
        $studentexams=studentexam::where('exam_id',$id)->where('user_id',$userid)->get();
        if ($userid==auth()->user()->id) {
        return view('student.result',compact(['studentexams','exam','userid']));
        }
        return abort('404');
    }
    public function results()
    {
        $exam_id=auth()->user()->studentexams->pluck('exam_id')->toArray();
        $exams=exam::whereIn('id',$exam_id)->get();
        return view('student.results',compact('exams'));
    }
    public function sessionexam(Request $request)
    {
        $arr=[0,1,2,3,4,5,6,7,8,9];
        $day='';$hour='';$minute='';$second='';
        $date=Carbon::now()->addMinutes($request->timeer);
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
        $totalend=$day.$hour.$minute.$second;
        $examf=examsetting::where('user_id',auth()->user()->id)->where('exam_id',$request->exam)->count();
        $ex=examsetting::where('user_id',auth()->user()->id)->where('exam_id',$request->exam)->first();
     if($examf==0){
        $examsetting=new examsetting();
        $examsetting->name=auth()->user()->id."__".$request->exam;
        $examsetting->user_id=auth()->user()->id;
        $examsetting->exam_id=$request->exam;
        $examsetting->end=$totalend=$day.$hour.$minute.$second;
        $examsetting->save();
        return response()->json(['success'=>'ok','data'=>$examsetting]);
        }
    else{
        $arr=[0,1,2,3,4,5,6,7,8,9];
        $day;$hour;$minute;$second;
        $date=Carbon::now();
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
        $totalnow=$day.$hour.$minute.$second;
        // $tnowsec=$day*60*60*24+$hour*60*60+$minute*60+$second;
       if( $totalnow >= $ex->end){
        return response()->json(['success'=>'foundend','data'=>$totalnow]);
       }
       else
       {
        $ag = str_split($ex->end, strlen($ex->end)/4);

         $tnowsec=$day*60*60*24+$hour*60*60+$minute*60+$second;
         $tnowsecend=$ag[0]*60*60*24+$ag[1]*60*60+($ag[2])*60+$ag[3];
        return response()->json(['success'=>'foundnotend','data'=>($tnowsecend-$tnowsec)]);
       }
    }
    }
}
