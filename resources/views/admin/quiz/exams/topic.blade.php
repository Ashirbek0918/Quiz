<table class="table table-responsive-sm mt-5">
    <thead>
    <tr>
        <th>#</th>
        <th>{{ __('validation.attributes.name') }}</th>
        <th>{{ __('quiz.questions.questions_count') }}</th>
        <th>MAX {{ __('quiz.questions.questions_count') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($topics as $topic)
        <tr>
            <td>
                <input type="checkbox" name="topics[{{ $loop->iteration }}][topic_id]" value="{{ $topic->id }}"
                       class="topic-id" data-value="{{ $topic->id }}"
                @foreach($item->topics as $examTopic)
                    @checked($examTopic['topic_id'] == $topic->id)
                    @endforeach
                >
            </td>
            <td>{{ $topic->hname }}</td>
            <td>{{ $topic->questions_count}}</td>
            <td>
                @php $disableStatus = true @endphp
                <input class="form-control" max="{{ $topic->questions_count }}" type="number"
                       id="question-count-{{ $topic->id }}"
                       @foreach($item->topics as $examTopic)

                           @if($examTopic['topic_id'] == $topic->id)
                               @php $disableStatus = false @endphp
                               value="{{ $examTopic['questions_count'] }}"
                       @endif
                       @endforeach
                        @if($disableStatus)
                            disabled
                            value="{{ $topic->questions_count }}"
                        @endif
                       name="topics[{{ $loop->iteration }}][questions_count]">
            </td>
    @endforeach
    </tbody>
</table>
<div class="form-group">
    <div class="text-center mt-3">
        <a href="{{ route('exams.index') }}"
           class="btn btn-slack col-md-2">{{{ __('form.cancel') }}}</a>
        <button class="btn btn-info col-md-1">{{ __('form.save') }}</button>
    </div>
</div>
