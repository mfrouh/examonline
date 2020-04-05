@extends('layouts.app')
@section('title')
@lang('home.results')
@endsection
@section('content')
  <div class="container">
      <div class="card text-center">
          <div class="card-header bg-primary">
              @lang('home.results')
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
                          <th>@lang('home.calculate')</th>
                          <th>@lang('home.take')</th>
                          <th>@lang('home.taked')</th>
                          <th>@lang('home.start')</th>
                          <th>@lang('home.end')</th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($finalresults as $k=> $finalresult)
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$finalresult->exam->name}}</td>
                              <td>{{$finalresult->exam->time}} @lang('home.min')</td>
                              <td>{{$finalresult->exam->gradepass}} %</td>
                              <td>{{$finalresult->exam->group->name}}</td>
                              <td>@lang('home.'.$finalresult->exam->calculate)</td>
                              <td>{{$finalresult->exam->take}}</td>
                              <td>{{$finalresult->taked}}</td>
                              <td>{{$finalresult->exam->start->translatedformat('d-m-Y h:i A')}}</td>
                              <td>{{$finalresult->exam->end->translatedformat('d-m-Y h:i A')}}</td>
                              <td>
                                  <a class="btn btn-outline-primary brdrd btn-sm" href="/result/{{auth()->user()->id}}/{{$finalresult->exam->id}}">@lang('home.result')</a>
                              </td>
                          </tr>
                        @endforeach
                      </tbody>
              </table>
          </div>
      </div>
  </div>
@endsection
