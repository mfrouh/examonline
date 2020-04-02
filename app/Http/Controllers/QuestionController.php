<?php

namespace App\Http\Controllers;

use App\exam;
use App\Http\Requests\question as AppQuestion;
use App\question;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
        $questions=question::whereIn('exam_id',$exams->pluck('id'))->get();
        return view('question.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $exam=exam::findorfail($id);
        if($exam->group->user_id==auth()->user()->id){
        return view('question.create',compact('exam'));
        }
        return abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppQuestion $request)
    {
        $question=new question();
        $question->question=$request->question;
        $question->type=$request->type;
        $question->option1=$request->option1;
        $question->option2=$request->option2;
        $question->option3=$request->option3;
        $question->option4=$request->option4;
        $question->correctanswer=json_encode($request->correctanswer);
        $question->mark=$request->mark;
        $question->exam_id=$request->exam_id;
        $question->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(question $question)
    {
        return view('question.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit($id,question $question)
    {
        $exam=exam::findorfail($id);
        if($exam->group->user_id==auth()->user()->id){
        return view('question.edit',compact(['question','exam']));
        }
        return abort('404');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AppQuestion $request, question $question)
    {
        $question->question=$request->question;
        $question->type=$request->type;
        $question->option1=$request->option1;
        $question->option2=$request->option2;
        $question->option3=$request->option3;
        $question->option4=$request->option4;
        $question->correctanswer=json_encode($request->correctanswer);
        $question->mark=$request->mark;
        $question->exam_id=$request->exam_id;
        $question->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(question $question)
    {
        $question->delete();
        return back();
    }
}
