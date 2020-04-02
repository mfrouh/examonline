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
                          <th></th>
                          <th>@lang('home.namegroup')</th>
                          <th>@lang('home.studentname')</th>
                          <th>@lang('home.state')</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($studentgroups as $k=> $studentgroup)

                          <tr>
                              <td>{{$k+1}}</td>
                              <td>{{$studentgroup->user->name}}</td>
                              <td>{{$studentgroup->group->name}}</td>
                              <td>
                                  <form action="/activestudent" method="post">
                                    @csrf
                                    <select name="state" id="changestate" class="form-control">
                                          <option value="waiting" {{$studentgroup->state=='waiting'?'selected':''}}>@lang('home.waiting')</option>
                                          <option value="accept"  {{$studentgroup->state=='accept'?'selected':''}}>@lang('home.accept')</option>
                                          <option value="refused" {{$studentgroup->state=='refused'?'selected':''}}>@lang('home.refused')</option>
                                    </select>
                                    <input type="hidden" id="studentgroup_id" name="studentgroup_id" value="{{$studentgroup->id}}">
                                  </form>
                              </td>

                          </tr>
                        @endforeach
                      </tbody>
              </table>
          </div>
      </div>
  </div>
  <script type="text/javascript">
    $(function() {
        $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $('#changestate').change(function(){
            state=$(this).val();
            studentgroup_id=$('#studentgroup_id').val();
            $.ajax({
                 type:'post',
                 url:'/activestudent',
                 data:{state:state,studentgroup_id:studentgroup_id},
                 dataType:'json',
                success:function(data){
                    location.reload();
            },
            });
        });
    });
 </script>

@endsection
