@php
 $questions=App\question::whereIn('id',json_decode($studentexam->questions))->get();
@endphp
@foreach ($questions as $k=> $question)

<div class=" mb-3">
  <div class="row text-center bg-primary">
      <div class="col-2 p-2 bg-danger">
         {{$k+1}}
      </div>
      <div class="col-8 p-2">
         {{$question->question}}
      </div>
      <div class="col-1 p-2 bg-warning">
         {{$question->mark}} @lang('home.grade')
      </div>
      <div class="col-1 p-2 bg-info">
        {{$studentexam->Corrected($question->id)}} @lang('home.grade')
     </div>
  </div>
@if ($question->type=='complete')
   <div class="row">
       <input type="text" disabled value="{{$studentexam->IsCom($question->id)}}" name="{{$studentexam->id}}{{$question->id}}" class="form-control {{$studentexam->IsComBg($question->id)}}">
   </div>
@elseif($question->type=='trueorfalse')
   <div class="row">
     <div class="col-6  border-black p-2 {{$studentexam->Isbg($question->id,"option1")}}">
        <input type="radio" disabled class="form-control-check" value="option1" {{$studentexam->IsCheck($question->id,"option1")}} name="{{$studentexam->id}}{{$question->id}}">
        <label for="option1">{{$question->option1}}</label>
     </div>
     <div class="col-6  border-black p-2 {{$studentexam->Isbg($question->id,"option2")}}">
        <input type="radio" disabled class="form-control-check" value="option2" {{$studentexam->IsCheck($question->id,"option2")}} name="{{$studentexam->id}}{{$question->id}}">
        <label for="option2" >{{$question->option2}}</label>
     </div>
   </div>
@elseif($question->type=='choiceone')
   <div class="row">
     <div class="col-6  border-black p-2  {{$studentexam->IsBg($question->id,"option1")}}">
        <input type="radio" disabled class="form-control-check " {{$studentexam->IsCheck($question->id,"option1")}} value="option1" name="{{$studentexam->id}}{{$question->id}}">
        <label for="option1">{{$question->option1}}</label>
     </div>
     <div class="col-6  border-black p-2 {{$studentexam->IsBg($question->id,"option2")}}">
        <input type="radio" disabled class="form-control-check" {{$studentexam->IsCheck($question->id,"option2")}} value="option2" name="{{$studentexam->id}}{{$question->id}}">
        <label for="option2">{{$question->option2}}</label>
     </div>
   </div>
   <div class="row">
     <div class="col-6  border-black p-2 {{$studentexam->IsBg($question->id,"option3")}}">
        <input type="radio" disabled class="form-control-check"{{$studentexam->IsCheck($question->id,"option3")}} value="option3" name="{{$studentexam->id}}{{$question->id}}">
        <label for="option3">{{$question->option3}}</label>
     </div>
     <div class="col-6  border-black p-2 {{$studentexam->IsBg($question->id,"option4")}}">
        <input type="radio" disabled class="form-control-check" {{$studentexam->IsCheck($question->id,"option4")}} value="option4" name="{{$studentexam->id}}{{$question->id}}">
        <label for="option4">{{$question->option4}}</label>
     </div>
   </div>
   @elseif($question->type=='multiplechoice')
   <div class="row">

     <div class="col-6  border-black p-2 {{$studentexam->IsMulBg($question->id,"option1")}}">
        <input type="checkbox" disabled class="form-control-check" value="option1" {{$studentexam->IsMulCheck($question->id,"option1")}} name="{{$question->id}}[]">
        <label for="option1">{{$question->option1}}</label>
     </div>
     <div class="col-6  border-black p-2 {{$studentexam->IsMulBg($question->id,"option2")}}">
        <input type="checkbox" disabled class="form-control-check" value="option2"  {{$studentexam->IsMulCheck($question->id,"option2")}} name="{{$question->id}}[]">
        <label for="option2">{{$question->option2}}</label>
     </div>
   </div>
   <div class="row">
     <div class="col-6  border-black p-2 {{$studentexam->IsMulBg($question->id,"option3")}}">
        <input type="checkbox" disabled class="form-control-check" value="option3"  {{$studentexam->IsMulCheck($question->id,"option3")}} name="{{$question->id}}[]">
        <label for="option3">{{$question->option3}}</label>
     </div>
     <div class="col-6  border-black p-2 {{$studentexam->IsMulBg($question->id,"option4")}}">
        <input type="checkbox" disabled class="form-control-check" value="option4"  {{$studentexam->IsMulCheck($question->id,"option4")}} name="{{$question->id}}[]">
        <label for="option4">{{$question->option4}}</label>
     </div>
   </div>
@endif
</div>
@endforeach
