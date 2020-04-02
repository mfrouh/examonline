@extends('layouts.app')
@section('title')
@lang('home.editexam')
@endsection
@section('content')
  <div class="container">
      <div class="card text-@lang('home.left')">
          <div class="card-header bg-primary">
              @lang('home.editexam')
          </div>
          <div class="card-body">
             <form action="/exam/{{$exam->id}}" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="">@lang('home.nameexam')</label>
                  <input type="text" name="name" value="{{$exam->name}}" id="" class="form-control  @error('name') is-invalid @enderror" placeholder="@lang('home.nameexam')" aria-describedby="helpId">
                   @error('name')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.time')</label>
                    <input type="number" name="time" id="" value="{{$exam->time}}" class="form-control  @error('time') is-invalid @enderror" placeholder="@lang('home.time')" aria-describedby="helpId">
                     @error('time')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.gradepass')</label>
                    <input type="number" name="gradepass" min="1" max="100" id="" value="{{$exam->gradepass}}" class="form-control  @error('gradepass') is-invalid @enderror" placeholder="@lang('home.gradepass')" aria-describedby="helpId">
                     @error('gradepass')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.start')</label>
                    <input type="datetime-local" name='start' min="{{$exam->now()}}" id="" value="{{$exam->start()}}" class="form-control  @error('start') is-invalid @enderror" placeholder="@lang('home.start')" aria-describedby="helpId">
                     @error('start')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.end')</label>
                    <input type="datetime-local" name='end'  min="{{$exam->now()}}" id=""value="{{$exam->end()}}" class="form-control  @error('end') is-invalid @enderror" placeholder="@lang('home.end')" aria-describedby="helpId">
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
                          <option value="{{$group->id}}"{{$exam->group_id==$group->id?'selected':''}}>{{$group->name}}</option>
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
