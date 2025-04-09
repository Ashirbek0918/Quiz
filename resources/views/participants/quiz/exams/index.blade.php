@extends('participants.dashboard.home')

@section('content')
    <div class="row">
        @foreach($pagination->items() as $exam)
            <div class="col-lg-6 col-sm-12">
                <div class="brand-card m-4 shadow-1">
                    {{--                    bg-gray-500--}}
                    <div class="card-header {{ $exam->statusName }}">
                        <span class="text-white">{{ $exam->name }}</span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>{{ __('quiz.exams.attempts_count') }}</td>
                                <td>{{ $exam->attempts_count }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('quiz.exams.duration') }}</td>
                                <td>{{ $exam->duration }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('form.departments.department') }}</td>
                                <td>{{ $exam->departmentName }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('quiz.exams.from_date') }} | {{ __('quiz.exams.to_date') }}</td>
                                <td>{{ $exam->fromDate. ' | ' . $exam->toDate }}</td>

                            </tr>
                            <tr>
                                <td>{{ __('quiz.questions.questions_count') }}</td>
                                <td>{{ $exam->questions_count }}</td>

                            </tr>
                            <tr>
                                <td>{{ __('quiz.employee.correct_answers_count') }}</td>
                                <td>
                                    @foreach($exam->participantAttempt as $participantAttempt)
                                        {{ $participantAttempt->correct_answers_count }}
                                        @break
                                    @endforeach
                                </td>

                            </tr>
                        </table>
                        <div class="text-center">
                            <a href="{{ route("participants.exams.showExam", [$exam->id]) }}" class="btn btn-outline-success pl-5 pr-5">{{ __('form.show') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <nav class="d-flex justify-content-between">
                <span>{{ __('form.showed') }}: <b>{{ $pagination->count() }}</b></span>
                {{ $pagination->links('pagination::bootstrap-4') }}
                <span>{{ __('form.total') }}: <b>{{ $pagination->total() }}</b></span>
            </nav>
        </div>
    </div>
@endsection

