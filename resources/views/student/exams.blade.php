@extends('layouts.app')
@section('title')
@lang('home.exams')
@endsection
@section('content')
  <div class="container">
      <div class="card text-center">
          <div class="card-header bg-primary">
              @lang('home.exams')
          </div>
          <div class="card-body">
              <table class="table table-striped table-inverse">
                  <thead class="thead-inverse">
                      <tr>
                          <th></th>
                          <th>@lang('home.nameexam')</th>
                          <th>@lang('home.time')</th>
                          <th>@lang('home.gradepass')</th>
                          <th>@lang('home.group')</th>
                          <th>@lang('home.start')</th>
                          <th>@lang('home.end')</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($exams as $k=> $exam)
                         @if(!$exam->IsTaked() && $exam->IsJoinGroup() && $exam->IsActive())
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$exam->name}}</td>
                              <td>{{$exam->time}} @lang('home.min')</td>
                              <td>{{$exam->gradepass}} %</td>
                              <td>{{$exam->group->name}}</td>
                              <td>{{$exam->start->translatedformat('d-m-Y h:i A')}}</td>
                              <td>{{$exam->end->translatedformat('d-m-Y h:i A')}}</td>
                              <td>
                                  <a class="btn btn-outline-success brdrd btn-sm" href="/show/{{$exam->id}}">@lang('home.start')</a>
                              </td>
                          </tr>
                          @endif
                        @endforeach
                      </tbody>
              </table>
          </div>
      </div>
  </div>
@endsection
