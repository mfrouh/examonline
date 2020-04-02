<?php

namespace App\Http\Controllers;

use App\exam;
use App\Http\Requests\exam as AppExam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth','checkrole:teacher']);
    }
    public function index()
    {
        $exams=exam::whereIn('group_id',auth()->user()->groups->pluck('id'))->get();
        return view('exam.index',compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('exam.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppExam $request)
    {
        $exam=new exam();
        $exam->name=$request->name;
        $exam->group_id=$request->group_id;
        $exam->time=$request->time;
        $exam->start=$request->start;
        $exam->end=$request->end;
        $exam->take=$request->take;
        $exam->calculate=$request->calculate;
        $exam->gradepass=$request->gradepass;
        $exam->save();
        return redirect('/exam');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(exam $exam)
    {
        if($exam->group->user_id==auth()->user()->id)
        {
          return view('exam.show',compact('exam'));
        }
          return abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(exam $exam)
    {
        if($exam->group->user_id==auth()->user()->id)
        {
        return view('exam.edit',compact('exam'));
        }
        return abort('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(AppExam $request, exam $exam)
    {
        $exam->name=$request->name;
        $exam->group_id=$request->group_id;
        $exam->time=$request->time;
        $exam->start=$request->start;
        $exam->end=$request->end;
        $exam->take=$request->take;
        $exam->calculate=$request->calculate;
        $exam->gradepass=$request->gradepass;
        $exam->save();
        return redirect('/exam');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy(exam $exam)
    {
      $exam->delete();
      return back();
    }
}
