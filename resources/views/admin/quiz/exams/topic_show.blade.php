<table class="table mt-5">
    <thead>
    <tr>
        <th>{{ __('validation.attributes.name') }}</th>
        <th>{{ __('quiz.questions.questions_count') }}</th>
{{--        <th>MAX {{ __('quiz.questions.questions_count') }}</th>--}}
    </tr>
    </thead>
    <tbody>
    @foreach($topics as $topic)
        @if(array_key_exists($topic->id, $exam->topics))
            <tr>

                <td>{{ $topic->hname }}</td>
                {{--            <td>{{ $topic->questions_count}}</td>--}}
                <td>
                    {{ $exam->topics[$topic->id]['questions_count'] }}
                </td>
            </tr>
        @endif

    @endforeach
    <tr>

        <th>{{ __('form.total') }}:</th>
        <th>
            <span class="text-body">{{ array_sum(array_column($exam->topics, 'questions_count')) }}</span>
        </th>
    </tr>
    </tbody>
</table>

