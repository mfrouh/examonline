@php
    $arr=array();
@endphp
@foreach ($questions as $k=> $question)
@php
    $arr[]=$question->id;
@endphp
<div class=" mb-3 Q Q{{$k+1}} Q{{$question->id}}-{{auth()->user()->id}}" hidden>
  <div class="row text-center bg-primary">
      <div class="col-2 p-2 bg-danger">
         {{$k+1}}
      </div>
      <div class="col-8 p-2">
         {{$question->question}}
      </div>
      <div class="col-2 p-2 bg-warning">
         {{$question->mark}} @lang('home.grade')
      </div>
  </div>
@if ($question->type=='complete')
   <div class="row">
       <input type="text" name="{{$question->id}}" id="{{$question->id}}-{{auth()->user()->id}}" class="form-control t{{$question->id}}-{{auth()->user()->id}}">
   </div>
@elseif($question->type=='trueorfalse')
   <div class="row">
     <div class="col-12 bg-white border-black  p-2">
        <input type="radio"  class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option1" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}">
        <label for="option1" >{{$question->option1}}</label>
     </div>
     <div class="col-12 bg-white border-black p-2">
        <input type="radio"  class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option2" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}">
        <label for="option2">{{$question->option2}}</label>
     </div>
   </div>
@elseif($question->type=='choiceone')
   <div class="row">
     <div class="col-12 bg-white border-black p-2">
        <input type="radio" class="form-control-check {{$question->id}}-{{auth()->user()->id}} " value="option1" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}">
        <label for="option1">{{$question->option1}}</label>
     </div>
     <div class="col-12 bg-white border-black p-2">
        <input type="radio" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option2"  id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}">
        <label for="option2">{{$question->option2}}</label>
     </div>
   </div>
   <div class="row">
     <div class="col-12 bg-white border-black p-2">
        <input type="radio" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option3" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}">
        <label for="option3">{{$question->option3}}</label>
     </div>
     <div class="col-12 bg-white border-black p-2">
        <input type="radio" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option4" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}">
        <label for="option4">{{$question->option4}}</label>
     </div>
   </div>
   @elseif($question->type=='multiplechoice')
   <div class="row">
     <div class="col-12 bg-white border-black p-2">
        <input type="checkbox" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option1" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}[]">
        <label for="option1">{{$question->option1}}</label>
     </div>
     <div class="col-12 bg-white border-black p-2">
        <input type="checkbox" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option2" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}[]">
        <label for="option2">{{$question->option2}}</label>
     </div>
   </div>
   <div class="row">
     <div class="col-12 bg-white border-black p-2">
        <input type="checkbox" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option3" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}[]">
        <label for="option3">{{$question->option3}}</label>
     </div>
     <div class="col-12 bg-white border-black p-2">
        <input type="checkbox" class="form-control-check {{$question->id}}-{{auth()->user()->id}}" value="option4" id="{{$question->id}}-{{auth()->user()->id}}" name="{{$question->id}}[]">
        <label for="option4">{{$question->option4}}</label>
     </div>
   </div>
@endif
</div>
<div class="row mb-3 Q Q{{$k+1}} Q{{$question->id}}-{{auth()->user()->id}}" hidden>
    <div class="col-2">
        <a class=" btn btn-danger btn-sm brdrd review"    role="{{$question->id}}-{{auth()->user()->id}}">@lang('home.review')</a>
    </div>
    <div class="col-2">
        <a class=" btn btn-warning btn-sm brdrd unreview" role="{{$question->id}}-{{auth()->user()->id}}">@lang('home.unreview')</a>
    </div>
    <div class="col-2">
        <a class=" btn btn-secondary btn-sm brdrd clear" role="{{$question->id}}-{{auth()->user()->id}}">@lang('home.clear')</a>
    </div>
    @if ($k < count($questions)-1)
    <div class="col-3">
        <a class=" btn btn-info btn-sm brdrd CQ" role="{{$k+1+1}}">@lang('home.next')</a>
    </div>
    @endif
    @if ($k!=0)
    <div class="col-3">
        <a class=" btn btn-success btn-sm brdrd CQ" role="{{$k+1-1}}">@lang('home.previous')</a>
    </div>
    @endif
</div>
@endforeach
<input type="hidden" name="allquest" value="{{json_encode($arr)}}">
<input type="hidden" name="exam_id" id="exam_id" value="{{$question->exam_id}}">
<input type="hidden" name="start"  id="start" title="{{$question->exam->time}}">

