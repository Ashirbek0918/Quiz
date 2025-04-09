@extends('participants.dashboard.home')

@section('content')
    <div class="row">

            <div class="col-12">
                <div class="brand-card m-4 shadow-1">
                    <div class="card-header {{ $item->statusName }}">
                        <span class="text-white">{{ $item->name }}</span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>{{ __('quiz.exams.attempts_count') }}</td>
                                <td>{{ $item->attempts_count }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('quiz.exams.duration') }}</td>
                                <td>{{ $item->duration }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('quiz.exams.from_date') }} | {{ __('quiz.exams.to_date') }}</td>
                                <td>{{ $item->fromDate. ' | ' . $item->toDate }}</td>

                            </tr>
                        </table>
                    </div>
                    <div class="p-4 mt-5">
                        <table class="table">
                            <tr>
                                <th>{{ __('quiz.employee.start_time') }}</th>
                                <th>{{ __('quiz.employee.end_time') }}</th>
                                <th>{{ __('quiz.questions.questions_count') }}</th>
                                <th>{{ __('quiz.employee.correct_answers_count') }}</th>
                                <th>{{ __('form.actions') }}</th>
                            </tr>
                            @foreach($attempts as $attempt)
                                <tr>
                                    <td>{{ $attempt->start_time }}</td>
                                    <td>{{ $attempt->end_time }}</td>
                                    <td>{{ $attempt->question_count }}</td>
                                    <td>{{ $attempt->correct_answers_count }}</td>
                                    <td>
                                        @if($attempt->status && !$attempt->attempt_completed)
                                            <a href="{{ route('participants.exams.getAttempt', [ $attempt->id]) }}">{{ __('quiz.employee.continue') }}</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        @if($item->statusOriginal)
                            <div class="text-center mt-5 mb-5"><a
                                    href="{{ route('participants.exams.startTest', [$item->id]) }}"
                                    class="btn btn-outline-success">{{ __('quiz.employee.start_test') }}</a></div>
                        @endif
                    </div>
                </div>
            </div>
    </div>
@endsection

