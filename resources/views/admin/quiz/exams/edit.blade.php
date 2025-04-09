@extends('dashboard.home')
@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-lg-12  col-md-12 ">

            <div class="card mb-4 shadow-1">
                <div class="card-body ">
                    <form action="{{ route('exams.update', [$item->id]) }} " method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="name"
                                       class="form-control-label">{{ __('validation.attributes.name') }}</label>
                                <input type="text" value="{{ $item->name }}" class="form-control"
                                       name="name" id="name">
                                @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="attempts_count"
                                       class="form-control-label">{{ __('quiz.exams.attempts_count') }}</label>
                                <input type="number" value="{{ $item->attempts_count }}" class="form-control"
                                       name="attempts_count" id="attempts_count">
                                @if($errors->has('attempts_count'))
                                    <div class="text-danger">{{ $errors->first('attempts_count') }}</div>
                                @endif
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="duration"
                                       class="form-control-label">{{ __('quiz.exams.duration') }}</label>
                                <input type="text" value="{{ $item->duration }}" class="form-control"
                                       onclick="customTime(this)" placeholder="00:30:00"
                                       name="duration" id="duration">
                                @if($errors->has('duration'))
                                    <div class="text-danger">{{ $errors->first('duration') }}</div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="from_date"
                                       class="form-control-label">{{ __('quiz.exams.from_date') }}</label>
                                <input type="datetime-local" value="{{ $item->from_date }}" class="form-control"
                                       name="from_date" id="from_date">
                                @if($errors->has('from_date'))
                                    <div class="text-danger">{{ $errors->first('from_date') }}</div>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="to_date"
                                       class="form-control-label">{{ __('quiz.exams.to_date') }}</label>
                                <input type="datetime-local" value="{{ $item->to_date }}" class="form-control"
                                       name="to_date" id="to_date">
                                @if($errors->has('to_date'))
                                    <div class="text-danger">{{ $errors->first('to_date') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-control-label"
                                       for="status">{{ __('quiz.exams.status') }}</label>
                                <select class="custom-select col-md-12" name="status" id="status">
                                    <option value="1" @selected($item->status == 1)> {{ __("quiz.status_active") }} </option>
                                    <option value="0" @selected($item->status == 0)> {{ __("quiz.status_inactive") }} </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label"
                                       for="is_protected">{{ __('quiz.exams.is_protected') }}</label>
                                <select class="custom-select col-md-12" name="is_protected" id="is_protected">
                                    <option value="0" @selected($item->is_protected == 0)> {{ __("quiz.no") }} </option>
                                    <option value="1"@selected($item->is_protected == 1)> {{ __("quiz.yes") }} </option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label"
                                       for="lang">{{ __('quiz.exams.lang') }}</label>
                                <select class="custom-select col-md-12" name="lang" id="lang">
                                    <option value="ru" @selected($item->lang == "ru")> ru</option>
                                    <option value="uz" @selected($item->lang == "uz")> uz</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-control-label"
                                       for="show_correct_answers">{{ __('quiz.exams.show_correct_answers') }}</label>
                                <select class="custom-select col-md-12" name="show_correct_answers"
                                        id="show_correct_answers">
                                    <option value="0" @selected($item->show_correct_answers == 0)> {{ __("quiz.no") }} </option>
                                    <option value="1" @selected($item->show_correct_answers == 1)> {{ __("quiz.yes") }} </option>
                                </select>
                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <div class="text-center mt-3">--}}
{{--                                --}}{{--                                <a href="{{ route('employees.index') }}"--}}
{{--                                --}}{{--                                   class="btn btn-slack col-md-2">{{{ __('form.cancel') }}}</a>--}}
{{--                                <button type="button"--}}
{{--                                        class="btn btn-info col-md-3 get-topics">{{ __('quiz.topics.topics') }}</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                       @include('admin.quiz.exams.topic')
                        {{--                        <div class="form-group">--}}
                        {{--                            <div class="text-center mt-3">--}}
                        {{--                                <a href="{{ route('employees.index') }}"--}}
                        {{--                                   class="btn btn-slack col-md-2">{{{ __('form.cancel') }}}</a>--}}
                        {{--                                <button class="btn btn-info col-md-1">{{ __('form.add') }}</button>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('assets/plugins/formatter/jquery.formatter.min.js') }}"></script>
    <script src="{{ asset('assets/js/formatter.js') }}"></script>
    <script src="{{ asset('assets/js/imask.min.js') }}"></script>
    <script>
        $(".topic-id").change(function (e) {
            let topicId = e.target.getAttribute('data-value')
            $(`#question-count-${topicId}`).prop('disabled', (i, v) => !v);
            // console.log(e.target.getAttribute('data-value'))
        });
    </script>

@endsection

