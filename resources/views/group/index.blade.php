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
                          <th><a class="btn btn-outline-primary btn-sm" href="/group/create">@lang('home.creategroup')</a></th>
                          <th>@lang('home.namegroup')</th>
                          <th>#</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($groups as $k=> $group)
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$group->name}}</td>
                              <td>
                                  <a class="btn btn-outline-success btn-sm" href="/students/{{$group->id}}">@lang('home.students')</a>
                                  <a class="btn btn-outline-primary btn-sm" href="/group/{{$group->id}}/edit"><i class="fa fa-edit"></i></a>
                                  <a class="btn btn-outline-danger btn-sm" href="" onclick="event.preventDefault();document.getElementById('delete-group-{{$group->id}}').submit();">
                                  <i class="fa fa-trash"></i></a>
                                  <form id="delete-group-{{$group->id}}" action="/group/{{$group->id}}" method="POST" style="display: none;">
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
