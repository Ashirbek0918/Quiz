<div class="modal fade" id="m_modal_attempt_{{ $participant->id }}" tabindex="-1" role="dialog"
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
                    @foreach($participant->participantExamAttempts as $participantAttempt)
                        <tr @if(is_null($participantAttempt->checked_by)) class="bg-light" @endif>
                            <td>
                                <a href="{{ route('exams.result', [$participantAttempt->id]) }}">{{ $participantAttempt->question_count }}</a>
                            </td>
                            <td>{{ $participantAttempt->correct_answers_count }}</td>
                            <td>
                                @if($participantAttempt->exists_practical)
                                    <a href="{{ route('exams.showAttempt', [ $participantAttempt->id]) }}">{{ __('quiz.exams.check') }}</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
