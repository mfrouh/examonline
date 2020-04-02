<?php

namespace App\Http\Controllers;

use App\group;
use App\Http\Requests\group as AppGroup;
use Illuminate\Http\Request;

class GroupController extends Controller
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
        $groups=auth()->user()->groups;
        return view('group.index',compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('group.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppGroup $request)
    {
        $group=new group();
        $group->name=$request->name;
        $group->user_id=auth()->user()->id;
        $group->save();
        return redirect('/group');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(group $group)
    {
        return view('group.show',compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(group $group)
    {
        return view('group.edit',compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(AppGroup $request, group $group)
    {
        $group->name=$request->name;
        $group->user_id=auth()->user()->id;
        $group->save();
        return redirect('/group');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(group $group)
    {
        $group->delete();
        return back();
    }
}
