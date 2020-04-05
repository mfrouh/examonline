@extends('layouts.app')
@section('title')
@lang('home.results')
@endsection
@section('content')
  <div class="container">
    <a class="btn btn-outline-primary brdrd" id="printtable"><i class="fa fa-print" aria-hidden="true"></i>@lang('home.print')</a>
    <div class="row">
     <div class="col-8">
      <div class="card text-center all">
          <div class="card-header bg-primary">
              @lang('home.results')
          </div>
          <div class="card-body">
              <table class="table table-striped table-inverse">
                  <thead class="thead-inverse">
                      <tr>
                          <th></th>
                          <th>@lang('home.question')</th>
                          <th>@lang('home.correctanswer')</th>
                          <th>@lang('home.wronganswer')</th>
                          <th>@lang('home.notanswer')</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($questions as $k=> $question)
                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$question->question}}</td>
                              <td>
                                  @if(isset($correct[$question->id]))
                                    {{$correct[$question->id]}}
                                  @endif
                              </td>
                              <td>
                                  @if(isset($wrong[$question->id]))
                                    {{$wrong[$question->id]}}
                                  @endif
                              </td>
                              <td>
                                  @if(isset($notanswer[$question->id]))
                                    {{$notanswer[$question->id]}}
                                  @endif
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
    var countnotanswer = JSON.parse(`<?php echo $countnotanswer; ?>`);
    var countwrong = JSON.parse(`<?php echo $countwrong; ?>`);
    var countcorrect = JSON.parse(`<?php echo $countcorrect; ?>`);
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'pie',

        // The data for our dataset
        data: {
            labels: ['@lang('home.correctanswer')', '@lang('home.wronganswer')','@lang('home.notanswer')'],
            datasets: [{
                label: 'My First dataset',
                backgroundColor: ['green','red','yellow'],
                borderColor: ['green','red','yellow'],
                data: [countcorrect,countwrong,countnotanswer]
            }]
        },

        // Configuration options go here
        options: {}
    });
    </script>
    <script type="text/javascript">
        $(function() {
           $('#printtable').click(function(e){
            $('.all').printThis({
                // beforePrintEvent:$('.btn').hide(),
            });
           })
        });
    </script>

@endsection
