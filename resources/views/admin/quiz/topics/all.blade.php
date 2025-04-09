<table class="table table-responsive-sm">
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
            <td><input type="checkbox" onchange="disableInput(this)" name="topics[{{ $loop->iteration }}][topic_id]" value="{{ $topic->id }}" class="topic-id" data-value="{{ $topic->id }}"></td>
            <td>{{ $topic->hname }}</td>
            <td>{{ $topic->questions_count}}</td>
            <td><input class="form-control" id="question-count-{{ $topic->id }}" max="{{ $topic->questions_count }}" type="number" name="topics[{{ $loop->iteration }}][questions_count]" value="{{ $topic->questions_count }}" disabled></td>
    @endforeach
    </tbody>
</table>
<div class="form-group">
    <div class="text-center mt-3">
        <a href="{{ route('exams.index') }}"
           class="btn btn-slack col-md-2">{{{ __('form.cancel') }}}</a>
        <button class="btn btn-info col-md-1">{{ __('form.add') }}</button>
    </div>
</div>
