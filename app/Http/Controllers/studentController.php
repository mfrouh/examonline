<?php

namespace App\Http\Controllers;

use App\exam;
use App\examsetting;
use App\finalresult;
use App\studentgroup;
use App\question;
use App\studentexam;
use Carbon\Carbon;
use CorrectExam;
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
           $Myquestion=new CorrectExam($request->except('_token'));
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
        $finalresults=finalresult::where('user_id',auth()->user()->id)->get();
        return view('student.results',compact('finalresults'));
    }
    public function sessionexam(Request $request)
    {
        $CorrectExam=new CorrectExam($request->except('_token'));
        return response()->json($CorrectExam->sessionexam($request));
    }
}
