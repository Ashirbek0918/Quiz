@extends('participants.dashboard.home')
@section('head')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection
@section('content')
    {{--    @include('employee.quiz.exams.time_viewer')--}}

    <div class="row">
        <div class="col-9 mb-5">

            <div class="card mb-4 shadow-1">

                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('quiz.exams.exams') }}
                    </h4>
                    <h3 id="remaining-time" class="ml-3">{{ $item->remaining_time }}</h3>

                </div>

                <form action="{{ route('participants.exams.finishAttempt', [$item->id]) }}" method="post">
                    @csrf
                    <div class="card-body">
                        {{--                    @if($errors->has("answers"))@dd($errors)--}}
                        @foreach($errors->all() as $error)
                            <div class="text-danger">{{ $error }}</div>
                        @endforeach
                        {{--                    @endif--}}
                        {{--                        <div class="col-12">--}}
                        {{--                            {{ __('quiz.questions.questions') }}--}}
                        {{--                        </div>--}}
                        @foreach($questions as $question)
                            <div class="form-row question-content @if($loop->iteration > 1) d-none @endif"
                                 id="question_{{ $loop->iteration }}">
                                <div class="col-2 bg-black-1 p-3"><b>{{ $loop->iteration }})</b></div>
                                <div class="col-10 bg-black-1 p-3"><b>{!! $question->content !!}</b></div>
                                @if($question->type == 3)
                                    <div class="col-12 p-3">
                                        <textarea name="answers[{{ $question->id }}]"
                                                  data-value="{{ $loop->iteration }}"
                                                  class="textarea-list"
                                                  id="textarea-{{ $loop->iteration }}"></textarea>
                                    </div>
                                @else
                                    @foreach($question->answers as $answer)
                                        <div class="col-1 p-3"><input class="input-list"
                                                                      @if($question->type == 1) type="radio"
                                                                      @elseif($question->type == 2) type="checkbox"
                                                                      @endif name="answers[{{ $question->id }}][]"
                                                                      id="answer_{{ $loop->parent->iteration }}"
                                                                      data-value="{{ $loop->parent->iteration }}"
                                                                      value="{{ $answer->id }}"></div>
                                        <div class="col-11 p-3"><label
                                                for="answer_{{ $answer->id }}">{!! $answer->content !!}</label></div>
                                    @endforeach
                                @endif
                                @if($loop->last)
                                    <div class="col-12 text-center mt-5 mb-5">
                                        <button
                                            class="btn btn-success">{{ __('quiz.employee.save_and_finish_test') }}</button>
                                    </div>
                                @endif
                                <div class=" col-12 text-center">
                                    @if(!$loop->first)
                                        <button type="button" class="btn btn-outline-success action-page"
                                                data-value="-1"><<
                                            {{ __('quiz.employee.previous') }}</button>
                                    @endif
                                    @if(!$loop->last)
                                        <button type="button" class="btn btn-outline-success ml-4 action-page"
                                                data-value="1">{{ __('quiz.employee.next') }} >>
                                        </button>
                                    @endif
                                </div>
                            </div>

                        @endforeach


                    </div>
                </form>
            </div>
        </div>
        <div class="col-3 card mt-4" style="min-height: 500px">
            <div class="text-center p-5">
                @foreach($questions as $question)
                    <button
                        class="btn pagination-button @if($loop->iteration > 1) btn-outline-success @else btn-success @endif mg-b-10"
                        style="border-radius: 50%; width: 45px; height: 45px "
                        id="button-{{ $loop->iteration }}"
                        data-value="{{ $loop->iteration }}">{{ $loop->iteration }}</button>
                @endforeach
                {{--                        <button class="btn btn-success">{{ __('quiz.employee.save_and_finish_test') }}</button>--}}
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
                    callbacks : {
                        onChange : function(contents, $editable){
                            let textareaId = {{ $loop->iteration }};
                            if (removeTags(contents).length > 0){
                                if (!selectedQuestions.includes(`${textareaId}`)) {
                                    selectedQuestions.push(`${textareaId}`)
                                    changeBtnClass()
                                }
                            }else {

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
        function changeBtnClass() {
            for (let i = 1; i <= questionsCount; i++) {
                if (selectedQuestions.includes(`${i}`)) {
                    $(`#button-${i}`).removeClass("btn-outline-success btn-success").addClass("btn-compose")
                } else {
                    let sBtn = $(`#button-${i}`).removeClass("btn-compose")
                    if (questionStep == i) {
                        sBtn.addClass("btn-success")
                    }
                }
            }
        }
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
            $('.btn-success').removeClass("btn-success").addClass("btn-outline-success")
            e.target.classList.remove("btn-outline-success")
            e.target.classList.add("btn-success")
            let id = e.target.getAttribute("data-value")
            questionStep = id
            $(`.question-content`).addClass("d-none")
            $(`#question_${id}`).removeClass("d-none")
            changeBtnClass()
        })

        $('.action-page').click(function (e) {
            $('.btn-success').removeClass("btn-success").addClass("btn-outline-success")

            let statusButton = e.target.getAttribute("data-value")
            if (statusButton > 0) {
                questionStep++
            } else {
                questionStep--
            }

            $(`#button-${questionStep}`).removeClass("btn-outline-success").addClass("btn-success")

            $(`.question-content`).addClass("d-none")
            $(`#question_${questionStep}`).removeClass("d-none")
            changeBtnClass()

        })

    </script>
    <script>
        // Set the date we're counting down to
        let countDownDate = new Date("{{ $item->end_time }}").getTime();
        // Update the count-down every 1 second
        let x = setInterval(function () {

            // Get today's date and time
            let now = new Date().getTime();

            // Find the distance between now and the count down date
            let distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            // let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (hours.toString().length == 1) {
                hours = "0" + hours
            }
            if (minutes.toString().length == 1) {
                minutes = "0" + minutes
            }

            if (seconds.toString().length == 1) {
                seconds = "0" + seconds
            }
            document.getElementById("remaining-time").innerHTML = hours + ":"
                + minutes + ":" + seconds;

            // If the count-down is finished, write some text
            if (distance < 1000) {
                document.getElementById("remaining-time").innerHTML = "<span class='text-danger'>{{ __('quiz.employee.time_is_over') }}</span>";
                clearInterval(x);
                setTimeout(function () {
                    location.href = "{{ route("participants.exams.index", ["session" => __('quiz.employee.test_time_is_over')]) }}"
                }, 2000)
            }
        }, 1000);
    </script>
@endsection
