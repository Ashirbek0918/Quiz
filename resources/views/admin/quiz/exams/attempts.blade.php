@extends('dashboard.home')

@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4 shadow-1">
            <div class="card-header">
                {{ __('quiz.evaluation') }}
            </div>

            <div class="card-body collapse show" id="collapse1">
                <form action="{{ route('exams.checkAttempt', [$item->id]) }}" method="post">
                    @csrf
                    <table class="table table-responsive-sm">
                        <thead>
                        <tr>
                            <th width="3%">#</th>
                            <th>{{ __('quiz.questions.questions') }}</th>
                            <th>{{ __('quiz.answers.answers') }}</th>
                            <th width="15%">{{ __('quiz.evaluation') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td width="3%">{{ $loop->iteration }}</td>
                                <th class="bg-light">{!! $question->content !!}</th>
                                <td>
                                    @if(array_key_exists($question->id, $item->practical_answers))
                                        {!! $item->practical_answers[$question->id] !!}
                                    @endif
                                </td>
                                <th width="15%">
                                    <input type="checkbox" name="checked_answers[]"
                                           @if($item->checked_by) onclick="this.checked=!this.checked;" @endif
                                           @checked(in_array($question->id, $item->checked_answers))
                                           value="{{ $question->id }}">
                                </th>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <div class="text-center mt-5">
                        <a href="{{ route('exams.show', [$item->exam_id]) }}"
                           class="btn btn-slack col-md-1">{{{ __('form.cancel') }}}</a>
                        @if(is_null($item->checked_by))
                            <button class="btn btn-info">{{ __('form.save') }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
