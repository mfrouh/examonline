<?php

namespace App\Http\Controllers;

use App\exam;
use App\question;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Myquestion;

class SettingController extends Controller
{

    public function show()
    {
        $exams=exam::whereIn('group_id',auth()->user()->groups->pluck('id'))->get();
        $questions=question::whereIn('exam_id',$exams->pluck('id'))->get();
        return view('pages.show',compact('questions'));
    }
    public function startexam(Request $request)
    {
        $Myquestion=new Myquestion($request->except('_token'));
        return $Myquestion->getdate();
    }
    public function myinformation()
    {
        return view('pages.myinformation');
    }
    public function information(Request $request)
    {
      $user =User::find(auth()->user()->id);
      $user->name=$request->name;
      $user->email=$request->email;
      if($request->image){
        $user->image=sorteimage('storage/user',$request->image);
      }
      else{
        $user->image=$user->image;
      }
      $user->save();
      return back();
    }
    public function changepassword(Request $request)
    {
        $this->validate($request,[
             'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
      $user =User::find(auth()->user()->id);
      if (Hash::check($request->oldpassword,$user->password )) {
        $user->password=Hash::make($request->password);
        $user->save();
       }


     return back();

    }
}
