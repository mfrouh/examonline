@extends('layouts.app')
@section('title')
@lang('home.addgroup')
@endsection
@section('content')
  <div class="container">
      <div class="card text-@lang('home.left')">
          <div class="card-header bg-primary">
              @lang('home.addgroup')
          </div>
          <div class="card-body">
             <form action="/studentgroup" method="post">
                @csrf
                <div class="form-group">
                  <label for="">@lang('home.namegroup')</label>
                  <select name="group_id"  class="form-control  @error('group_id') is-invalid @enderror">
                       <option value="">@lang('home.selectgroup')</option>
                       @php
                           $groups=App\group::all();
                       @endphp
                      @foreach ($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                      @endforeach
                  </select>
                   @error('group_id')
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
