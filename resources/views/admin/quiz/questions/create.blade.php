@extends('dashboard.home')
@section('head')
    <link href="{{ asset('assets/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection
@section('content')
    <div class="d-flex justify-content-center mt-5 mb-5">
        <div class="col-lg-12 col-xlg-9 col-md-7 ">
            <div class="card mb-4 shadow-1">
                <div class="card-body">
                    <form action="{{ route('questions.store', [$topic])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="topic_id" value="{{ $topic }}">
                        <div class="col-md-12 mb-3">
                            <label class="form-control-label"
                                   for="content">{{ __('quiz.questions.question') }}</label>
                            <textarea name="content" class="form-control" id="content" cols="30"
                                      rows="5">{{ old('content') }}</textarea>
                            {{--                            <input type="text" class="form-control" name="content" id="content">--}}
                            @if($errors->has('content'))
                                <div class="text-danger">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label"
                                       for="type">{{ __('quiz.questions.types.types') }}</label>
                                <select class="custom-select col-md-12" name="type" id="type">
                                    @foreach($types as $type => $typeName)
                                        <option value="{{ $type }}"> {{ $typeName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('type'))
                                    <div class="text-danger">{{ $errors->first('type') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-control-label"
                                       for="lang">{{ __('quiz.questions.lang') }}</label>
                                <select class="custom-select col-md-12" name="lang" id="lang">
                                    <option value="ru"> ru</option>
                                    <option value="uz"> uz</option>
                                </select>
                                @if($errors->has('lang'))
                                    <div class="text-danger">{{ $errors->first('lang') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 mb-5" id="special_titles">
                            <label for="validationTooltip03">{{ __('quiz.answers.answers') }}</label><span
                                class="btn btn-outline-success ml-3 mb-2"
                                id="special_titles_button"><i
                                    class="fa fa-plus-circle"></i></span>
                            <div class="d-flex mb-4">
                                <div style="width: 4%">
                                    <span><input type="checkbox" style="width: 20px" class="form-control checkbox-list"
                                                 checked="checked" name="answer[0][is_correct]" value="1"
                                                 id="checkbox0"></span>
                                </div>
                                <div style="width: 92%">
                                    <textarea name="answer[0][content]" id="answer" class="textarea-list"></textarea>
                                </div>
                                <div style="width: 4%">
                                    <span class="btn btn-outline-danger special_titles_button_remove">-</span>
                                </div>
                            </div>
                        </div>
                        @if($errors->has('answer.*'))
                            <ul>
                                @foreach($errors->get('answer.*') as $errors)
                                    @foreach($errors as $error)
                                        <div class="text-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                @endforeach
                            </ul>
                        @endif
                        <div class="form-group text-center">
                            <a href="{{ route('questions.index', [$topic]) }}"
                               class="btn btn-slack ">{{{ __('form.cancel') }}}</a>
                            <button class="btn btn-info">{{ __('form.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection
        @section('script')
            <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
            <script>
                $('#content').summernote({
                    // placeholder: 'Question',
                    tabsize: 2,
                    height: 150
                });
                $('#answer').summernote({
                    // placeholder: 'answer',
                    tabsize: 2,
                    height: 60
                });
            </script>
            <script>
                let counter = 0;
                $('#special_titles_button').on('click', function (e) {
                    e.preventDefault()
                    counter++
                    $('#special_titles').append(`
                    <div class="d-flex mb-3">
                                <div style="width: 4%">
                                    <span ><input type="checkbox" style="width: 20px" class="form-control checkbox-list" name="answer[${counter}][is_correct]" id="checkbox${counter}" value="1"></span>
                                </div>
                                <div style="width: 92%">
                                    <textarea name="answer[${counter}][content]" id="answer${counter}" class="textarea-list"></textarea>
                                </div>
                                <div style="width: 4%">
                                    <span class="btn btn-outline-danger special_titles_button_remove">-</span>
                                </div>
                    </div>`)
                    $(`#answer${counter}`).summernote({
                        // placeholder: 'answer',
                        tabsize: 2,
                        height: 60
                    });
                })
                document.addEventListener('click', function (e) {
                    if (e.target.classList.contains('special_titles_button_remove')) {
                        e.target.parentElement.parentElement.remove();
                    }
                    if (e.target.classList.contains('checkbox-list')) {
                        let type = $('#type').val()
                        if (type == 1) {
                            $(".checkbox-list").prop('checked', false);
                            $('#' + e.target.getAttribute('id')).prop('checked', true);
                        }
                        // e.target.parentElement.parentElement.remove();
                    }
                })
                $('#type').change(function (ty) {
                    let value = ty.target.value
                    if (value == 3) {
                        $("#special_titles").addClass('d-none');
                    } else {
                        $("#special_titles").removeClass('d-none');
                    }
                    if (value == 1) {
                        $(".checkbox-list").prop('checked', false).first().prop('checked', true);
                    }
                })
            </script>
@endsection
