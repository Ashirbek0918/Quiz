<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('validation.attributes.fullname') }}</th>
        {{--        <th>{{ __('form.departments.department') }}</th>--}}
        {{--        <th>{{ __('form.branches.branch') }}</th>--}}
        <th>{{ __('quiz.employee.correct_answers_count') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pagination->items() as $participant)
        @php $correctAnswersCount = null; $checkedBy = null; @endphp
        @foreach($participant->participantExamAttempts as $attempt)
            @php $correctAnswersCount = $attempt->correct_answers_count; $checkedBy = $attempt->checked_by; @endphp
            @break
        @endforeach

        <tr @if(is_null($checkedBy)) class="bg-light" @endif>
            <th scope="row">{{ ($pagination->currentpage()-1) * $pagination->perpage() + $loop->index + 1 }}</th>
            <td>
                <a href="" data-toggle="modal"
                   data-target="#m_modal_attempt_{{ $participant->id }}">{{ $participant->fullname }}</a>
                @include('admin.quiz.exams.attempt_show')
            </td>
            <td>
                {{ $correctAnswersCount }}
            </td>

        </tr>
    @endforeach
    </tbody>
</table>
<nav class="d-flex justify-content-between">
    <span>{{ __('form.showed') }}: <b>{{ $pagination->count() }}</b></span>
    {{ $pagination->links('pagination::bootstrap-4') }}
    <span>{{ __('form.total') }}: <b>{{ $pagination->total() }}</b></span>
</nav>

