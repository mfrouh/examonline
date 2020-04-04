@extends('layouts.app')
@section('title')
@lang('home.exam')
@endsection
@section('content')
<div class="container text-@lang('home.left')">
    <div class="row">
        <div class="col-lg-8">
         <div class="card mb-3 ">
           <div class="card-header bg-primary">@lang('home.questions')</div>
           <div class="card-body">
             <span class="btn btn-outline-danger brdrd  mb-2" id="timer"></span>
           <form action="/startexam" method="post" id="subforma">
               @csrf
               @include('pages.question')
               <div class="row text-center">
                <div class="col-12">
                  <input type="submit" class="btn btn-primary brdrd btn-sm endexam" value="@lang('home.end')">
                </div>
               </div>
           </form>
           </div>
         </div>
        </div>
        <div class="col-lg-4">
            <div class="card ">
              <div class="card-header bg-primary"></div>
              <div class="card-body">
                 @foreach ($questions as $k=> $question)
                     <a class="btn btn-info  LQ LQ{{$question->id}}-{{auth()->user()->id}} LQre{{$question->id}}-{{auth()->user()->id}} LQun{{$question->id}}-{{auth()->user()->id}}" id="{{$question->id}}-{{auth()->user()->id}}">{{$k+1}}</a>
                 @endforeach
                 <input type="hidden" id="au" value="{{auth()->user()->id}}">
              </div>
            </div>
        </div>
    </div>
</div>
<script src="{{url('/js/exam.js')}}"></script>
@endsection
