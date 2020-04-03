@extends('layouts.app')
@section('title')
@lang('home.exam')
@endsection
@section('content')
<div class="container text-@lang('home.left')">
    <div class="row">
        <div class="col-lg-8">
         <div class="card mb-3 ">
           <div class="card-header bg-primary">@lang('home.questions')</div>
           <div class="card-body">
             <span class="btn btn-outline-danger brdrd  mb-2" id="timer"></span>
           <form action="/startexam" method="post" id="subforma">
               @csrf
               @include('pages.question')
               <div class="row text-center">
                <div class="col-12">
                  <input type="submit" class="btn btn-primary brdrd btn-sm endexam" value="@lang('home.end')">
                </div>
               </div>
           </form>
           </div>
         </div>
        </div>
        <div class="col-lg-4">
            <div class="card ">
              <div class="card-header bg-primary"></div>
              <div class="card-body">
                 @foreach ($questions as $k=> $question)
                     <a class="btn btn-info  LQ LQ{{$question->id}}-{{auth()->user()->id}} LQre{{$question->id}}-{{auth()->user()->id}} LQun{{$question->id}}-{{auth()->user()->id}}" id="{{$question->id}}-{{auth()->user()->id}}">{{$k+1}}</a>
                 @endforeach
                 <input type="hidden" id="au" value="{{auth()->user()->id}}">
              </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    $.each(localStorage, function(i, item) {
      if(i==$('.LQ'+i).attr('id'))
      {
        $('.LQ'+i).css('background','green');
      }
      if(i=='re'+$('.LQ'+i).attr('id'))
      {
        $('.LQ'+i).css('border','5px solid red');
      }
      if(i=='un'+$('.LQ'+i).attr('id'))
      {
        $('.LQ'+i).css('border','');
      }
    });
    $(window).load(function(){
        if (localStorage.length==0) {
            localStorage.setItem('last','');
        }
        if(localStorage.getItem('last')==''){
             $('.Q1').removeAttr('hidden');
        }
        else{
            $('.Q'+localStorage.getItem('last')).removeAttr('hidden');
        }
    });
    $('.LQ').click(function(){
        id=$(this).attr('id');
        $('.Q').attr('hidden','on')
        $('.Q'+id).removeAttr('hidden');
        localStorage.setItem('last',id);
        location.reload();
    });
    $('.CQ').click(function(){
        id=$(this).attr('role');
        $('.Q').attr('hidden','on')
        $('.Q'+id).removeAttr('hidden');
        localStorage.setItem('last',id);
    });
    $('.endexam').click(function(){
        localStorage.clear();
    });
    $('.review').click(function(){
      var id=$(this).attr('role');
      $('.LQ'+id).css('border','5px solid red');
      localStorage.setItem( 're'+id, $(this).attr('role'));
    });
    $('.clear').click(function(){
      var id=$(this).attr('role');
      $('.LQ'+id).css('background','');
      localStorage.removeItem(id);
      location.reload();
    });
    $('.unreview').click(function(){
      var id=$(this).attr('role');
      $('.LQ'+id).css('border','');
      localStorage.removeItem('re'+id);
    });
    $('input:radio').on('change', function() {
        $('input:radio').each(function() {
            if ($(this).is(':checked') == true) {
                localStorage.setItem($(this).attr('id'), $(this).val());
                $('.LQ'+$(this).attr('id')).css('background','green');
            }
        });
    });

    $('input:checkbox').on('change', function() {
         var cars = [];
        $('input:checkbox').each(function() {
            if ($(this).is(':checked') == true) {
                cars.push($(this).val());
            }
        });
            localStorage.setItem($(this).attr('id'),JSON.stringify(cars));
            $('.LQ'+$(this).attr('id')).css('background','green');
            if (cars=='') {
                localStorage.removeItem($(this).attr('id'));
                $('.LQ'+$(this).attr('id')).css('background','');
            }
    });
    $('input:text').on('change', function() {
        $('input:text').each(function() {
            if ($(this).val() !='') {
                localStorage.setItem($(this).attr('id'),$(this).val());
                $('.LQ'+$(this).attr('id')).css('background','green');
            }
            else
            {
                localStorage.removeItem($(this).attr('id'));
                $('.LQ'+$(this).attr('id')).css('background','');
            }
        });
    });
    $.each(localStorage, function(i, item) {

        if(item[0]=="[")
        {
        var favorites=JSON.parse(localStorage.getItem(i));

        for (var j=0; j<favorites.length; j++) {
           $("input[type=checkbox][value=\""+favorites[j]+"\"]."+i).click();
         }
        }
        else
        {
           $(".t"+i).attr('value',item);
           $("input[type=radio][value=\""+item+"\"]."+i).click();
        }

    });
    $(window).load(function(e){
      var timeer=$('#start').attr('title');
      var exam=$('#exam_id').val();
      var au=$('#au').val();
      $.ajax({
          type:'post',
          url:'/sessionexam',
          data:{timeer:timeer,exam:exam,au:au},
          dataType:'json',
          success:function(data){
           if(data.success=="foundnotend"){
             localStorage.setItem(au+"__"+exam+"endtime",data.data);
           }
            if(data.success=="foundend"){
             clearInterval(time);
             $('#timer').hide();
             $('input').removeAttr('required');
             $('#subforma').submit();
            }
          }
        });
      var sec = 60*timeer;
      var now =new Date();
      var y =new Date();
      var endsec =new Date();
      var end= new Date( now.getTime() + sec);
      endsec.setMinutes(now.getMinutes() + sec/60);
      var hh= localStorage.getItem(au+"__"+exam+"endtime");
      var time = setInterval(myTimer, 1000);
      function myTimer() {
       now++;
      if(localStorage.getItem(au+"__"+exam+"cont")){
        var old= localStorage.getItem(au+"__"+exam+"cont");
        var hu = localStorage.getItem(au+"__"+exam+"end") - old;
       if(hh && hh>0){
        var g = hh;
        }else
        {
         var g = localStorage.getItem(au+"__"+exam+"end") - old;
        }
         hh--;
        old++;
        localStorage.setItem(au+"__"+exam+"cont", old);
        var ar=Array(0,1,2,3,4,5,6,7,8,9);
        var mint;
        var seconds;
        var ho;
       if(jQuery.inArray(Math.floor(g/60),ar) !== -1)
       {
          mint="0"+Math.floor(g/60);

       }else
       {
        if(Math.floor(g/60)>= 60 )
         {
          ho=Math.floor(g/60)/60;
          if(jQuery.inArray(Math.floor(g/60)%60,ar) !== -1){
          mint="0"+Math.floor(ho)+":"+"0"+Math.floor(g/60)%60;
          }
          else
          {
            mint="0"+Math.floor(ho)+":"+Math.floor(g/60)%60;
          }
         }else
         {
          mint="00:"+Math.floor(g/60);
         }

       }
       if(jQuery.inArray(g%60,ar) !== -1)
       {
        seconds="0"+g%60;
       }else
       {
        seconds=g%60;
       }
        document.getElementById('timer').innerHTML =  mint+":"+seconds ;
        if(g == 0)
        {
          clearInterval(time);
          $('#timer').hide();
          $('input').removeAttr('required');
          $('#subforma').submit();

        }

      }else
      {
        localStorage.setItem(au+"__"+exam+"cont", now);
        localStorage.setItem(au+"__"+exam+"end", end.getTime());
        localStorage.setItem(au+"__"+exam+"thr", endsec);
      }

 }

});

});
</script>
@endsection
