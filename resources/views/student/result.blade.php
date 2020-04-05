@extends('layouts.app')
@section('title')
@lang('home.result')
@endsection
@section('content')
<div class="container">
  <div class="row mb-3">
   <div class="col-12 text-center">
    @foreach ($studentexams as $k=> $studentexam)
       <a class="btn btn-outline-success LR LR{{$k}}" id="{{$k}}">{{$k+1}}</a>
    @endforeach
    <a class="btn btn-outline-primary brdrd" id="printtable"><i class="fa fa-print" aria-hidden="true"></i>@lang('home.print')</a>
   </div>
  </div>
  <div class="row">
   <div class="col-4">
        <div class="card text-center  mb-3">
            <div class="card-header  bg-primary">
                @lang('home.result')
            </div>
            @foreach ($studentexams as $k=> $studentexam)
            <div class="card-body R R{{$k}}" hidden>
                 <canvas id="myChart{{$k}}"></canvas>
            </div>
            @endforeach
        </div>
        <div class="card text-center">
            <div class="card-header bg-primary">
                @lang('home.total')
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                       @lang('home.correctanswer')
                    </div>
                    <div class="col-6">
                      {{$exam->Total($userid)['correct']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                       @lang('home.wronganswer')
                    </div>
                    <div class="col-6">
                      {{$exam->Total($userid)['wrong']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                       @lang('home.notanswer')
                    </div>
                    <div class="col-6">
                      {{$exam->Total($userid)['notanswer']}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                       @lang('home.score')
                    </div>
                    <div class="col-6">
                      {{$exam->Total($userid)['score']}}%
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                       @lang('home.state')
                    </div>
                    <div class="col-6">
                      {{$exam->Total($userid)['state']}}
                    </div>
                </div>
           </div>
        </div>
   </div>
   <div class="col-8">
    <div class="card text-center all">
        <div class="card-header bg-primary">
            @lang('home.result')
        </div>
        @foreach ($studentexams as $k=> $studentexam)
        <div class="card-body R R{{$k}}" hidden>
             <div class="row ">
                <div class="col-6  p-2 bg-danger">@lang('home.teachername')</div>
                <div class="col-6  p-2 bg-info">{{$studentexam->exam->group->user->name}}</div>
             </div>
             <div class="row">
                <div class="col-6  p-2 bg-info">@lang('home.studentname')</div>
                <div class="col-6  p-2 bg-danger">{{$studentexam->user->name}}</div>
             </div>
             <div class="row ">
                   <div class="col-6  p-2 bg-danger">@lang('home.exam')</div>
                   <div class="col-6  p-2 bg-info">{{$studentexam->exam->name}}</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-info">@lang('home.group')</div>
                   <div class="col-6  p-2 bg-danger">{{$studentexam->exam->group->name}}</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-danger">@lang('home.correctanswer')</div>
                   <div class="col-6  p-2 bg-info">{{$studentexam->countcorrect()}}</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-info">@lang('home.wronganswer')</div>
                   <div class="col-6  p-2 bg-danger">{{$studentexam->countwrong()}}</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-danger">@lang('home.notanswer')</div>
                   <div class="col-6  p-2 bg-info">{{$studentexam->countnotanswer()}}</div>
             </div>
             <div class="row">
                <div class="col-6  p-2 bg-info">@lang('home.total')</div>
                <div class="col-6  p-2 bg-danger">{{$studentexam->total}} @lang('home.grade')</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-danger">@lang('home.result')</div>
                   <div class="col-6  p-2 bg-info">{{$studentexam->result}} @lang('home.grade')</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-info">@lang('home.score')</div>
                   <div class="col-6  p-2 bg-danger">{{$studentexam->score}}%</div>
             </div>
             <div class="row">
                   <div class="col-6  p-2 bg-danger">@lang('home.state')</div>
                   <div class="col-6  p-2 bg-info">
                       @if ($studentexam->state=='pass')
                           <a class="btn btn-success brdrd">{{$studentexam->state}}</a>
                       @endif
                       @if ($studentexam->state=='fail')
                           <a class="btn btn-danger brdrd">{{$studentexam->state}}</a>
                       @endif
                    </div>
             </div>
        </div>
        <script>
            var k = JSON.parse(`<?php echo $k; ?>`);
            var ctx = document.getElementById('myChart'+k).getContext('2d');
            var correct = JSON.parse(`<?php echo $studentexam->countcorrect(); ?>`);
            var wrong = JSON.parse(`<?php echo $studentexam->countwrong(); ?>`);
            var notanswer = JSON.parse(`<?php echo $studentexam->countnotanswer(); ?>`);

            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'pie',

                // The data for our dataset
                data: {
                    labels: ['@lang('home.correctanswer')', '@lang('home.wronganswer')', '@lang('home.notanswer')'],
                    datasets: [{
                        label: 'My First dataset',
                        backgroundColor: ['green','red','yellow'],
                        borderColor: ['green','red','yellow'],
                        data: [correct,wrong,notanswer]
                    }]
                },

                // Configuration options go here
                options: {}
            });
        </script>
        @endforeach
    </div>
   </div>
  </div>
</div>
<script>
    $(window).load(function(){
        if (localStorage.length==0) {
            localStorage.setItem('lastresult','');
        }
        if(localStorage.getItem('lastresult')==''){
             $('.R0').removeAttr('hidden');
             $('.LR0').css('background','');
             $('.LR0').css('background','green');
        }
        else{
            $('.R'+localStorage.getItem('lastresult')).removeAttr('hidden');
            $('.LR').css('background','');
            $('.LR'+localStorage.getItem('lastresult')).css('background','green');
        }
    });
   $('.LR').click(function(){
        id=$(this).attr('id');
        $('.R').attr('hidden','on')
        $('.R'+id).removeAttr('hidden');
        $('.LR').css('background','');
        $('.LR'+id).css('background','green');
        localStorage.setItem('lastresult',id);
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
