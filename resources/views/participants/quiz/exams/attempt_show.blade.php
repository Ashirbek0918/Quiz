<div class="modal fade" id="m_modalExam_{{ $exam->id }}" tabindex="-1" role="dialog"
     style="display: none; padding-right: 15px;">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{ $exam->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="ion-ios-close-empty"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>{{ __('quiz.questions.questions_count') }}</th>
                        <th>{{ __('quiz.employee.correct_answers_count') }}</th>
                        <th>{{ __('form.actions') }}</th>
                    </tr>
                    @foreach($exam->employeeAttempt as $employeeAttempt)
                        <tr>
                            <td>{{ $employeeAttempt->question_count }}</td>
                            <td>{{ $employeeAttempt->correct_answers_count }}</td>
                            <td><a href="{{ route('participants.exams.getAttempt', [ $employeeAttempt->id]) }}">{{ __('quiz.employee.continue') }}</a></td>
                        </tr>
                    @endforeach
                </table>
                <div class="text-center mt-5"><a
                        href="{{ route('participants.exams.startTest', [$exam->id]) }}"
                        class="btn btn-outline-success">{{ __('quiz.employee.start_test') }}</a></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('form.close') }}</button>
                {{--                <a href="" class="btn btn-danger"--}}
                {{--                   data-message="{{ __('form.confirm_delete') }}"--}}
                {{--                   onclick="return confirm(this.getAttribute('data-message'));"--}}
                {{--                >{{ __('form.delete') }}</a>--}}
                {{--                <button type="button" class="btn btn-danger">delete</button>--}}
            </div>
        </div>
    </div>
</div>
