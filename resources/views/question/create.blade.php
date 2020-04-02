@extends('layouts.app')
@section('title')
@lang('home.createquestion')
@endsection
@section('content')
  <div class="container">
    <div class="row">
     <div class="col-4">
      <div class="card text-@lang('home.left')">
          <div class="card-header bg-primary">
              @lang('home.createquestion')
          </div>
          <div class="card-body">
             <form action="/question" method="post">
                @csrf
                <div class="form-group">
                  <label for="">@lang('home.question')</label>
                  <textarea name="question" id="" class="form-control  @error('question') is-invalid @enderror">{{old('question')}}</textarea>
                   @error('question')
                     <span class="invalid-feedback" role="alert">
                         <strong>{{ $message }}</strong>
                     </span>
                   @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.type')</label>
                    <select name="type" id="changetype" class="form-control  @error('type') is-invalid @enderror" value="{{old('type')}}">
                        <option value="">@lang('home.selecttype')</option>
                        <option value="choiceone">@lang('home.choiceone')</option>
                        <option value="trueorfalse">@lang('home.trueorfalse')</option>
                        <option value="complete"{{old('type')=='complete'?'selected':''}}>@lang('home.complete')</option>
                        <option value="multiplechoice">@lang('home.multiplechoice')</option>
                    </select>
                     @error('type')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group" id="option1" @error("option1") {{''}} @else {{'hidden'}} @enderror>
                    <label for="">@lang("home.option1")</label>
                    <input type="text" name="option1"  class="form-control  @error("option1") is-invalid @enderror"  value="{{old('option1')}}">
                     @error("option1")
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div><div class="form-group" id="option2" @error("option2") {{''}} @else {{'hidden'}} @enderror>
                    <label for="">@lang("home.option2")</label>
                    <input type="text" name="option2"  class="form-control  @error("option2") is-invalid @enderror"  value="{{old('option2')}}">
                     @error("option2")
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div><div class="form-group" id="option3" @error("option3") {{''}} @else {{'hidden'}} @enderror>
                    <label for="">@lang("home.option3")</label>
                    <input type="text" name="option3"  class="form-control  @error("option3") is-invalid @enderror"  value="{{old('option3')}}">
                     @error("option3")
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group" id="option4" @error("option4") {{''}} @else {{'hidden'}} @enderror>
                    <label for="">@lang("home.option4")</label>
                    <input type="text" name="option4"  class="form-control  @error("option4") is-invalid @enderror" value="{{old('option4')}}">
                     @error("option4")
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group" id="correctanswer" @error("correctanswer") {{''}} @else {{'hidden'}} @enderror>
                    <label for="">@lang("home.correctanswer")</label>
                    <select name="correctanswer[]" id="mul" class="form-control">
                      <option id="opt1" value="option1">@lang('home.option1')</option>
                      <option id="opt2" value="option2">@lang('home.option2')</option>
                      <option id="opt3" value="option3">@lang('home.option3')</option>
                      <option id="opt4" value="option4">@lang('home.option4')</option>
                    </select>
                     @error("correctanswer")
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                <div class="form-group">
                    <label for="">@lang('home.mark')</label>
                    <input type="number" name="mark"  class="form-control  @error('mark') is-invalid @enderror" value="{{old('mark')}}">
                     @error('mark')
                       <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                       </span>
                     @enderror
                </div>
                 <input type="hidden" name="exam_id" value="{{$exam->id}}">
                <div class="form-group text-center">
                    <input type="submit" class="btn btn-outline-primary btn-sm" value="@lang('home.save')">
                </div>
             </form>

          </div>
      </div>
     </div>
     <div class="col-8">
         @include('exam.question')
     </div>
    </div>
  </div>
  <script type="text/javascript">
    $(function() {
        $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        function mu() {
            var type=$('#changetype').val();
            if (type=='complete') {
                $('#mul').removeAttr('multiple');
                $('#option1').attr('hidden','on');
                $('#option2').attr('hidden','on');
                $('#option3').attr('hidden','on');
                $('#option4').attr('hidden','on');
                $('#opt2').attr('hidden','on');
                $('#opt3').attr('hidden','on');
                $('#opt4').attr('hidden','on');
                $('#option1').removeAttr('hidden');
                $('#correctanswer').removeAttr('hidden');
            }
            if (type=='trueorfalse') {
                $('#mul').removeAttr('multiple');
                $('#option1').attr('hidden','on');
                $('#option2').attr('hidden','on');
                $('#option3').attr('hidden','on');
                $('#option4').attr('hidden','on');
                $('#opt3').attr('hidden','on');
                $('#opt4').attr('hidden','on');
                $('#option1').removeAttr('hidden');
                $('#option2').removeAttr('hidden');
                $('#correctanswer').removeAttr('hidden');
            }
            if (type=='multiplechoice') {
                $('#option1').removeAttr('hidden');
                $('#option2').removeAttr('hidden');
                $('#option3').removeAttr('hidden');
                $('#option4').removeAttr('hidden');
                $('#opt1').removeAttr('hidden');
                $('#opt2').removeAttr('hidden');
                $('#opt3').removeAttr('hidden');
                $('#opt4').removeAttr('hidden');
                $('#correctanswer').removeAttr('hidden');
                $('#mul').attr('multiple','on');
            }

            if ( type=='choiceone') {
                $('#mul').removeAttr('multiple');
                $('#option1').removeAttr('hidden');
                $('#option2').removeAttr('hidden');
                $('#option3').removeAttr('hidden');
                $('#option4').removeAttr('hidden');
                $('#opt1').removeAttr('hidden');
                $('#opt2').removeAttr('hidden');
                $('#opt3').removeAttr('hidden');
                $('#opt4').removeAttr('hidden');
                $('#correctanswer').removeAttr('hidden');
            }
        }
        $(window).load(function(){
            mu();

        });
        $('#changetype').change(function(){
            mu();
        });
        });
   </script>
@endsection
