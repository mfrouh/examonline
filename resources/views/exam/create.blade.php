@extends('layouts.app')
@section('title')
@lang('home.createexam')
@endsection
@section('content')
  <div class="container">
      <div class="card text-@lang('home.left')">
          <div class="card-header bg-primary">
              @lang('home.createexam')
          </div>
          <div class="card-body">
             <form action="/exam" method="post">
                @csrf
                <div class="form-group">
                  <label for="">@lang('home.nameexam')</label>
                  <input type="text" name="name" id="" class="form-control  @error('name') is-invalid @enderror" placeholder="@lang('home.nameexam')" aria-describedby="helpId">
                   @error('name')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.time')</label>
                    <input type="number" name="time" id="" class="form-control  @error('time') is-invalid @enderror" placeholder="@lang('home.time')" aria-describedby="helpId">
                     @error('time')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.gradepass')</label>
                    <input type="number" name="gradepass" id="" min="1" max="100" class="form-control  @error('gradepass') is-invalid @enderror" placeholder="@lang('home.gradepass')" aria-describedby="helpId">
                     @error('gradepass')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.start')</label>
                    <input type="datetime-local" name='start' id=""   class="form-control  @error('start') is-invalid @enderror" placeholder="@lang('home.start')" aria-describedby="helpId">
                     @error('start')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.end')</label>
                    <input type="datetime-local" name='end' id="" class="form-control  @error('end') is-invalid @enderror" placeholder="@lang('home.end')" aria-describedby="helpId">
                     @error('end')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.group')</label>
                    <select name="group_id" class="form-control  @error('group_id') is-invalid @enderror" id="">
                        @foreach (auth()->user()->groups as $group)
                          <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                     @error('end')
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
