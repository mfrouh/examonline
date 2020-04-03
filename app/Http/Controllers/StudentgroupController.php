<?php

namespace App\Http\Controllers;

use App\Http\Requests\studentgroup as AppStudentgroup;
use App\studentgroup;
use Illuminate\Http\Request;

class StudentgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
       $this->middleware(['auth','checkrole:student']);
    }
    public function index()
    {
       $studentgroups=auth()->user()->studentgroups;
       return view('studentgroup.index',compact('studentgroups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('studentgroup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppStudentgroup $request)
    {
        $student=studentgroup::where('user_id',auth()->user()->id)->where('group_id',$request->group_id)->first();
        if(!$student){
        $studentgroup=new studentgroup();
        $studentgroup->group_id=$request->group_id;
        $studentgroup->user_id=auth()->user()->id;
        $studentgroup->save();
        return redirect('/studentgroup');
        }
        return back()->with('error','this found');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\studentgroup  $studentgroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(studentgroup $studentgroup)
    {
       $studentgroup->delete();
       return back();
    }
}
