@extends('layouts.app')
@section('title')
@lang('home.groups')
@endsection
@section('content')
  <div class="container">
      <div class="card text-center">
          <div class="card-header bg-primary">
              @lang('home.groups')
          </div>
          <div class="card-body">
              <table class="table table-striped table-inverse">
                  <thead class="thead-inverse">
                      <tr>
                          <th><a class="btn btn-outline-primary btn-sm" href="/studentgroup/create">@lang('home.creategroup')</a></th>
                          <th>@lang('home.namegroup')</th>
                          <th>@lang('home.state')</th>
                          <th>#</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($studentgroups as $k=> $studentgroup)
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$studentgroup->group->name}}</td>
                              <td>{!!$studentgroup->state()!!}</td>
                              <td>
                                  <a class="btn btn-outline-danger btn-sm" href="" onclick="event.preventDefault();document.getElementById('delete-studentgroup-{{$studentgroup->id}}').submit();">
                                  <i class="fa fa-trash"></i></a>
                                  <form id="delete-studentgroup-{{$studentgroup->id}}" action="/studentgroup/{{$studentgroup->id}}" method="POST" style="display: none;">
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
