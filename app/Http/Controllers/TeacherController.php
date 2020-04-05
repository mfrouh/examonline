<?php

namespace App\Http\Controllers;

use App\exam;
use App\finalresult;
use App\group;
use App\question;
use App\studentexam;
use App\studentgroup;
use App\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function __construct()
    {
       $this->middleware(['auth','checkrole:teacher']);
    }
    public function waitingstudent()
    {
        $groups=auth()->user()->groups->pluck('id')->toArray();
        $studentgroups=studentgroup::whereIn('group_id',$groups)->where('state','waiting')->get();
        return view('teacher.studentgroup',compact('studentgroups'));
    }
    public function refusedstudent()
    {
        $groups=auth()->user()->groups->pluck('id')->toArray();
        $studentgroups=studentgroup::whereIn('group_id',$groups)->where('state','refused')->get();
        return view('teacher.studentgroup',compact('studentgroups'));
    }
    public function acceptstudent()
    {
        $groups=auth()->user()->groups->pluck('id')->toArray();
        $studentgroups=studentgroup::whereIn('group_id',$groups)->where('state','accept')->get();
        return view('teacher.studentgroup',compact('studentgroups'));
    }
    public function students($id)
    {
        if(in_array($id,auth()->user()->groups->pluck('id')->toArray()))
        {
        $studentgroups=studentgroup::where('group_id',$id)->where('state','accept')->get();
        return view('teacher.studentgroup',compact('studentgroups'));
        }
        return abort('404');
    }
    public function activestudent(Request $request)
    {
        $studentgroup=studentgroup::find($request->studentgroup_id);
        $studentgroup->state=$request->state;
        $studentgroup->save();
        return response()->json('200');
    }
    public function results($id)
    {
        $groups=auth()->user()->groups->pluck('id')->toArray();
        $exam=exam::where('id',$id)->whereIn('group_id',$groups)->first();
        if ($exam) {
        $finalresults=finalresult::where('exam_id',$exam->id)->get();
        $pass=finalresult::where('exam_id',$exam->id)->where('state','pass')->count();
        $fail=finalresult::where('exam_id',$exam->id)->where('state','fail')->count();
        return view('teacher.results',compact(['finalresults','exam','fail','pass']));
        }
        return abort('404');
    }
    public function examdetails($id)
    {
        $groups=auth()->user()->groups->pluck('id')->toArray();
        $exam=exam::where('id',$id)->whereIn('group_id',$groups)->first();
        if ($exam) {
        $studentexams=studentexam::where('exam_id',$exam->id)->get();
        $questions=$exam->questions;
        $correct=array();
        $wrong=array();
        $notanswer=array();
        foreach ($studentexams as $key => $studentexam) {

           foreach ($studentexam->correct() as $key => $value) {
            $correct[]=$key;
           }
           foreach ($studentexam->wrong() as $key => $value) {
            $wrong[]=$key;
           }
           foreach ($studentexam->notanswer() as $key => $value) {
            $notanswer[]=$value;
          }
        }
        $countwrong=count($wrong);
        $countcorrect=count($correct);
        $countnotanswer=count($notanswer);
        $correct=array_count_values($correct);
        $notanswer=array_count_values($notanswer);
        $wrong=array_count_values($wrong);
        return view('teacher.examdetails',compact(['questions','correct','notanswer','wrong','countwrong','countcorrect','countnotanswer']));
        }
        return abort('404');
    }
    public function result($userid,$id)
    {
        $exam=exam::findorfail($id);
        $studentexams=studentexam::where('exam_id',$id)->where('user_id',$userid)->get();
        if (in_array($exam->group_id,auth()->user()->groups->pluck('id')->toArray())) {
        return view('student.result',compact(['studentexams','exam','userid']));
        }
        return abort('404');
    }
    public function detailsresult($userid,$id)
    {
        $exam=exam::findorfail($id);
        $studentexams=studentexam::where('exam_id',$id)->where('user_id',$userid)->get();
        if (in_array($exam->group_id,auth()->user()->groups->pluck('id')->toArray())) {
            return view('teacher.detailsresult',compact(['studentexams','userid','exam']));
        }
        return abort('404');
    }
}
