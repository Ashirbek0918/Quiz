@extends('dashboard.home')
@section('content')
    <div class="d-flex justify-content-center mt-5">
        <div class="col-lg-12  col-md-12 ">

            <div class="card mb-4 shadow-1">
                <div class="card-body ">
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="name"
                                   class="form-control-label">{{ __('validation.attributes.name') }}</label>
                            <input disabled type="text" value="{{ $exam->name }}" class="form-control"
                                   name="name" id="name">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="attempts_count"
                                   class="form-control-label">{{ __('quiz.exams.attempts_count') }}</label>
                            <input disabled type="number" value="{{ $exam->attempts_count }}" class="form-control"
                                   name="attempts_count" id="attempts_count">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="duration"
                                   class="form-control-label">{{ __('quiz.exams.duration') }}</label>
                            <input disabled type="text" value="{{ $exam->duration }}" class="form-control"
                                   onclick="customTime(this)" placeholder="00:30:00"
                                   name="duration" id="duration">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="from_date"
                                   class="form-control-label">{{ __('quiz.exams.from_date') }}</label>
                            <input disabled type="text" value="{{ $exam->from_date }}" class="form-control"
                                   name="from_date" id="from_date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="to_date"
                                   class="form-control-label">{{ __('quiz.exams.to_date') }}</label>
                            <input disabled type="text" value="{{ $exam->to_date }}" class="form-control"
                                   name="to_date" id="to_date">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label"
                                   for="status">{{ __('quiz.exams.status') }}</label>
                            <select disabled class="custom-select col-md-12" name="status" id="status">
                                <option
                                    value="1" @selected($exam->status == 1)> {{ __("quiz.status_active") }} </option>
                                <option
                                    value="0" @selected($exam->status == 0)> {{ __("quiz.status_inactive") }} </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label"
                                   for="is_protected">{{ __('quiz.exams.is_protected') }}</label>
                            <select disabled class="custom-select col-md-12" name="is_protected" id="is_protected">
                                <option value="0" @selected($exam->is_protected == 0)> {{ __("quiz.no") }} </option>
                                <option value="1"@selected($exam->is_protected == 1)> {{ __("quiz.yes") }} </option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label"
                                   for="lang">{{ __('quiz.exams.lang') }}</label>
                            <select disabled class="custom-select col-md-12" name="lang" id="lang">
                                <option value="ru" @selected($exam->lang == "ru")> ru</option>
                                <option value="uz" @selected($exam->lang == "uz")> uz</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label"
                                   for="show_correct_answers">{{ __('quiz.exams.show_correct_answers') }}</label>
                            <select disabled class="custom-select col-md-12" name="show_correct_answers"
                                    id="show_correct_answers">
                                <option
                                    value="0" @selected($exam->show_correct_answers == 0)> {{ __("quiz.no") }} </option>
                                <option
                                    value="1" @selected($exam->show_correct_answers == 1)> {{ __("quiz.yes") }} </option>
                            </select>
                        </div>
                    </div>
                    @include('admin.quiz.exams.topic_show')
                </div>
            </div>
        </div>
    </div>
    <div class="mb-5">
        <div class="col-lg-12  col-md-12 ">

            <div class="card mb-5 shadow-1">
                <div class="card-header">
                    <a href="{{ route('exams.exportAttempt', [$exam->id]) }}"><i class="fa fa-file-excel-o fa-2x ml-5"></i></a>
                </div>
                <div class="card-body p-5">
                    @include('admin.quiz.exams.employee')
                </div>
            </div>
        </div>
    </div>

@endsection


