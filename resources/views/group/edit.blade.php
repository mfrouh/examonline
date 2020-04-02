@extends('layouts.app')
@section('title')
@lang('home.editgroup')
@endsection
@section('content')
  <div class="container">
      <div class="card text-@lang('home.left')">
          <div class="card-header bg-primary">
            @lang('home.editgroup')
          </div>
          <div class="card-body">
             <form action="/group/{{$group->id}}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="">@lang('home.namegroup')</label>
                  <input type="text" name="name" id="" class="form-control  @error('name') is-invalid @enderror" placeholder="@lang('home.namegroup')" value="{{$group->name}}" aria-describedby="helpId">
                   @error('name')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                   @enderror
                </div>
                <div class="form-group text-center">
                  <input type="submit" class="btn btn-outline-primary btn-sm" value="@lang('home.save')">
                </div>
             </form>
          </div>
      </div>
  </div>
@endsection
