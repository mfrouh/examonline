@extends('layouts.app')
@section('title')
@lang('home.results')
@endsection
@section('content')
  <div class="container">
    <div class="row">
     <div class="col-8">
      <div class="card text-center">
          <div class="card-header bg-primary">
              @lang('home.results')
          </div>
          <div class="card-body">
              <table class="table table-striped table-inverse">
                  <thead class="thead-inverse">
                      <tr>
                          <th></th>
                          <th>@lang('home.studentname')</th>
                          <th>@lang('home.correctanswer')</th>
                          <th>@lang('home.wronganswer')</th>
                          <th>@lang('home.state')</th>
                          <th>@lang('home.score')</th>
                          <th></th>
                          <th></th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($users as $k=> $user)
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$user->name}}</td>
                              <td>{{$exam->Total($user->id)['correct']}}</td>
                              <td>{{$exam->Total($user->id)['wrong']}}</td>
                              <td>{{$exam->Total($user->id)['state']}}</td>
                              <td>{{$exam->Total($user->id)['score']}}%</td>
                              <td>
                                  <a class="btn btn-outline-primary brdrd btn-sm" href="/studentresult/{{$user->id}}/{{$exam->id}}">@lang('home.result')</a>
                              </td>
                              <td>
                                <a class="btn btn-outline-success brdrd btn-sm" href="/detailsresult/{{$user->id}}/{{$exam->id}}">@lang('home.details')</a>
                              </td>
                          </tr>
                        @endforeach
                      </tbody>
              </table>
          </div>
      </div>
     </div>
     <div class="col-4">
        <div class="card text-center mb-3">
            <div class="card-header bg-primary">
                @lang('home.results')
            </div>
            <div class="card-body">
                <canvas id="myChart"></canvas>
            </div>
        </div>
     </div>
    </div>
  </div>
  <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var pass = JSON.parse(`<?php echo $pass; ?>`);
    var fail = JSON.parse(`<?php echo $fail; ?>`);

    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'pie',

        // The data for our dataset
        data: {
            labels: ['@lang('home.pass')', '@lang('home.fail')'],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: ['green','red'],
                borderColor: ['green','red'],
                data: [pass,fail]
            }]
        },

        // Configuration options go here
        options: {}
    });
    </script>
@endsection
