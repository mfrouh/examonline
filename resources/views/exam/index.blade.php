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
                          <th><a class="btn btn-outline-primary btn-sm" href="/exam/create">@lang('home.createexam')</a></th>
                          <th>@lang('home.nameexam')</th>
                          <th>@lang('home.time')</th>
                          <th>@lang('home.gradepass')</th>
                          <th>@lang('home.group')</th>
                          <th>@lang('home.start')</th>
                          <th>@lang('home.end')</th>
                          <th>#</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($exams as $k=> $exam)
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$exam->name}}</td>
                              <td>{{$exam->time}}</td>
                              <td>{{$exam->gradepass}}</td>
                              <td>{{$exam->group->name}}</td>
                              <td>{{$exam->start->translatedformat('d-m-Y h:i A')}}</td>
                              <td>{{$exam->end->translatedformat('d-m-Y h:i A')}}</td>
                              <td>
                                  <a class="btn btn-outline-warning btn-sm" href="/results/{{$exam->id}}">@lang('home.results')</a>
                                  <a class="btn btn-outline-info btn-sm" href="/examdetails/{{$exam->id}}">@lang('home.details')</a>
                                  <a class="btn btn-outline-warning btn-sm" href="/question/{{$exam->id}}/create"><i class="fa fa-plus"></i></a>
                                  <a class="btn btn-outline-primary btn-sm" href="/exam/{{$exam->id}}/edit"><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-outline-danger btn-sm" href="" onclick="event.preventDefault();document.getElementById('delete-exam-{{$exam->id}}').submit();">
                                  <i class="fa fa-trash"></i></a>
                                  <form id="delete-exam-{{$exam->id}}" action="/exam/{{$exam->id}}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                  </form>
                              </td>
                          </tr>
                        @endforeach
                      </tbody>
              </table>
          </div>
      </div>
  </div>
@endsection
