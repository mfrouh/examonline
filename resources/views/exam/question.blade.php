<div class="card text-center">
    <div class="card-header bg-primary">
        @lang('home.questions')
    </div>
    <div class="card-body">
        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th></th>
                    <th>@lang('home.question')</th>
                    <th>@lang('home.type')</th>
                    <th>@lang('home.option1')</th>
                    <th>@lang('home.option2')</th>
                    <th>@lang('home.option3')</th>
                    <th>@lang('home.option4')</th>
                    <th>@lang('home.correctanswer')</th>
                    <th>@lang('home.mark')</th>
                    <th>@lang('home.exams')</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($exam->questions as $k=> $question)
                    <tr>
                        <td>{{$k+1}}</td>
                        <td>{{$question->question}}</td>
                        <td>{{$question->type}}</td>
                        <td>{{$question->option1}}</td>
                        <td>{{$question->option2}}</td>
                        <td>{{$question->option3}}</td>
                        <td>{{$question->option4}}</td>
                        <td>{{$question->correctanswer}}</td>
                        <td>{{$question->mark}}</td>
                        <td>{{$question->exam->name}}</td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="/question/{{$question->exam_id}}/{{$question->id}}/edit"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-outline-danger btn-sm" href="" onclick="event.preventDefault();document.getElementById('delete-question-{{$question->id}}').submit();">
                            <i class="fa fa-trash"></i></a>
                            <form id="delete-question-{{$question->id}}" action="/question/{{$question->id}}" method="POST" style="display: none;">
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
