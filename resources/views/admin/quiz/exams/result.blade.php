@extends('dashboard.home')
@section('head')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        <div class="col-9 mb-5">
            <div class="card mb-4 shadow-1">
                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('quiz.exams.exams') }}
                    </h4>
                </div>
                {{--                                @dd($questions,$item)--}}
                <div class="card-body">
                    @foreach($errors->all() as $error)
                        <div class="text-danger">{{ $error }}</div>
                    @endforeach
                    @php $ids = [] @endphp
                    @foreach($questions as $question)
                        <div class="form-row question-content @if($loop->iteration > 1) d-none @endif"
                             id="question_{{ $loop->iteration }}">
                            <div class="col-2 bg-black-1 p-3"><b>{{ $loop->iteration }})</b></div>
                            <div class="col-10 bg-black-1 p-3"><b>{!! $question->content !!}</b></div>
                            @if($question->type == 3)
                                <div class="col-12 p-3 mb-5 ">
                                    <textarea name="answers[{{ $question->id }}]"
                                              data-value="{{ $loop->iteration }}"
                                              id="textarea-{{ $loop->iteration }}" disabled>
{{--                                            {{ $item->practical_answers[$question->id] }}--}}
                                        </textarea>
                                    <div class="col-1">
                                        @if(in_array($question->id,$item->checked_answers))
                                            @php $ids[] = $question->id; @endphp
                                            <i
                                                class="fa  fa-check-square text-success fa-2x "></i>
                                        @else
                                            <i class="fa fa-times text-danger fa-2x "></i>
                                        @endif
                                    </div>
                                </div>
                            @else
                                @foreach($question->answers as $answer)
                                    <div class="col-1 p-3 d-flex ">
                                        <div class="col-1">
                                            @if($answer->is_correct)
                                                <i class="fa  fa-check-square text-success "></i>
                                            @elseif(in_array($answer->id, $item->employee_answers[$question->id]) && !$answer->is_correct)
                                                <i class="fa fa-times  text-danger "></i>
                                            @endif
                                        </div>
                                        <div class="col-1">
                                            <input
                                                @if($question->type == 1) type="radio"
                                                @php $question_answers = [];
                                                    foreach ($question->answers as $answer_employee){
                                                        if ($answer_employee->is_correct){
                                                            $question_answers[] = $answer_employee->id;
                                                        }
                                                    }
                                                    if(!array_diff($question_answers,$item->employee_answers[$question->id]) &&  !array_diff($item->employee_answers[$question->id],$question_answers)){
                                                        $ids[] = $question->id;
                                                    }
                                                @endphp
                                                @elseif($question->type == 2) type="checkbox"
                                                @php if(in_array($answer->id,$item->employee_answers[$question->id]) && $answer->is_correct){ $ids[] = $question->id;} @endphp
                                                @endif
                                                @checked(in_array($answer->id, $item->employee_answers[$question->id]))
                                                name="answers[{{ $question->id }}][]"
                                                value="{{ $answer->id }}"
                                                id="answer_{{ $loop->parent->iteration }}"
                                                data-value="{{ $loop->parent->iteration }}"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="col-11 p-3">
                                        <label for="answer_{{ $answer->id }}">{!! $answer->content !!}</label>
                                    </div>
                                @endforeach
                            @endif
                            <div class=" col-12 text-center mt-3">
                                @if(!$loop->first)
                                    <button type="button" class="btn btn-outline-primary action-page"
                                            data-value="-1"><<
                                        {{ __('quiz.employee.previous') }}</button>
                                @endif
                                @if(!$loop->last)
                                    <button type="button" class="btn btn-outline-primary ml-4 action-page"
                                            data-value="1">{{ __('quiz.employee.next') }} >>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3 card mt-4" style="min-height: 500px">
            <div class="text-center p-5">
                @foreach($questions as $question)
                    <button
                        class="btn pagination-button @if(in_array($question->id, $ids)) btn-success @else btn-danger @endif mg-b-10"
                        style="border-radius: 50%; width: 45px; height: 45px "
                        id="button-{{ $loop->iteration }}"
                        data-value="{{ $loop->iteration }}">{{ $loop->iteration }}</button>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
    @foreach($questions as $question)
        @if($question->type === 3)
            <script>
                $('#textarea-{{ $loop->iteration }}').summernote({
                    // placeholder: 'Question',
                    tabsize: 2,
                    height: 150,
                    callbacks: {
                        onChange: function (contents, $editable) {
                            let textareaId = {{ $loop->iteration }};
                            if (removeTags(contents).length > 0) {
                                if (!selectedQuestions.includes(`${textareaId}`)) {
                                    selectedQuestions.push(`${textareaId}`)
                                    changeBtnClass()
                                }
                            } else {

                                let index = selectedQuestions.indexOf(`${textareaId}`);
                                if (index >= 0) {
                                    selectedQuestions.splice(index, 1);
                                    changeBtnClass()
                                }
                            }
                            // @this.set("description", contents);
                        }
                    }
                });
            </script>
        @endif
    @endforeach
    <script>
        let questionsCount = {{ $item->question_count }};
        let selectedQuestions = []

        function removeTags(str) {
            if ((str === null) || (str === ''))
                return false;
            else
                str = str.toString();

            // Regular expression to identify HTML tags in
            // the input string. Replacing the identified
            // HTML tag with a null string.
            return str.replace(/(<([^>]+)>)/ig, '');
        }

        // function changeBtnClass() {
        //     for (let i = 1; i <= questionsCount; i++) {
        //         if (selectedQuestions.includes(`${i}`)) {
        //             $(`#button-${i}`).removeClass("btn-outline-primary btn-primary").addClass("btn-compose")
        //         } else {
        //             let sBtn = $(`#button-${i}`).removeClass("btn-compose")
        //             if (questionStep == i) {
        //                 sBtn.addClass("btn-primary")
        //             }
        //         }
        //     }
        // }

        $('.input-list').change(function (e) {
            let id = e.target.getAttribute('data-value')
            let inputName = e.target.getAttribute('name')
            let inputGroup = $(`input[name='${inputName}']:checked`)
            if (inputGroup.length > 0) {
                if (!selectedQuestions.includes(id)) {
                    selectedQuestions.push(id)
                }
            } else {
                let index = selectedQuestions.indexOf(`${id}`);

                if (index >= 0) {
                    selectedQuestions.splice(index, 1);
                }
            }
            changeBtnClass()
        })
    </script>
    <script>
        let questionStep = 1
        $('.pagination-button').click(function (e) {
            $('.btn-primary').removeClass("btn-primary").addClass("btn-outline-primary")
            e.target.classList.remove("btn-outline-primary")
            e.target.classList.add("btn-primary")
            let id = e.target.getAttribute("data-value")
            questionStep = id
            $(`.question-content`).addClass("d-none")
            $(`#question_${id}`).removeClass("d-none")
            changeBtnClass()
        })
        $('.action-page').click(function (e) {
            $('.btn-primary').removeClass("btn-primary").addClass("btn-outline-primary")
            let statusButton = e.target.getAttribute("data-value")
            if (statusButton > 0) {
                questionStep++
            } else {
                questionStep--
            }
            $(`#button-${questionStep}`).removeClass("btn-outline-primary").addClass("btn-primary")
            $(`.question-content`).addClass("d-none")
            $(`#question_${questionStep}`).removeClass("d-none")
            changeBtnClass()
        })
    </script>
@endsection
