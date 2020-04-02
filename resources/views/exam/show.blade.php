@extends('layouts.app')
@section('title')
@lang('home.questions')
@endsection
@section('content')
  <div class="container">
     @include('exam.question')
  </div>
@endsection
