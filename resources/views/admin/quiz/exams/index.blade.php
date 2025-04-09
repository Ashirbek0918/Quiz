@extends('dashboard.home')

@section('content')
    <div class="col-md-12 col-lg-12">
        <div class="card mb-4 shadow-1">

            <div class="card-header">
                <h4 class="card-header-title">
                    {{ __('quiz.quiz') }}
                </h4>
                    <a href="{{ route("exams.create") }}" class="btn btn-outline-success">
                        <i class="fa fa-plus button-2x"> {{ __('form.add') }}</i></a>
            </div>
            <div class="card-body collapse show" id="collapse1">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <form action="{{ route("exams.index") }}">
                            <td>
                                <select class="form-control select2 select2-hidden-accessible" name="limit"
                                        style="width: 65px">
                                    <option value="5" @selected(request('limit') == 5)>5</option>
                                    <option value="10" @selected(request('limit') == 10 || is_null(request('limit')))>
                                        10
                                    </option>
                                    <option value="20" @selected(request('limit') == 20)>20</option>
                                    <option value="30" @selected(request('limit') == 30)>30</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="name"
                                       placeholder="{{ __('validation.attributes.name') }}"
                                       value="{{ request('name') }}">
                            </td>
                            <td>
                                <input type="number" min="1" class="form-control" name="attempts_count"
                                       placeholder="{{ __('quiz.exams.attempts_count') }}"
                                       value="{{ request('attempts_count') }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="duration"
                                       placeholder="{{ __('quiz.exams.duration') }}"
                                       oninput="customTime(input)"
                                       value="{{ request('duration') }}">
                            </td>

{{--                            <td>--}}
{{--                                <select class="form-control select2 select2-hidden-accessible" tabindex="-1"--}}
{{--                                        aria-hidden="true" id="department_id" name="department_id">--}}
{{--                                    <option value="" selected--}}
{{--                                            disabled>{{ __('form.departments.departments') }} {{ __('form.choose') }}</option>--}}
{{--                                    @foreach($departments as $department)--}}
{{--                                        <option--}}
{{--                                            value="{{ $department->id }}"--}}
{{--                                            @selected(request('department_id') == $department->id)--}}
{{--                                        >{{ $department->hname }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </td>--}}

                            <td>
                            </td>
                            <td>
                                <div class="row">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                    <a href="{{ route('exams.index') }}" class="btn btn-outline-info"><i
                                            class="fa fa-refresh"></i></a>
                                </div>
                            </td>
                        </form>
                    </tr>
                    <tr>
                        <th>#</th>
                        <th>{{ __('validation.attributes.name') }}</th>
                        <th>{{ __('quiz.exams.attempts_count') }}</th>
                        <th>{{ __('quiz.exams.duration') }}</th>
                        <th>{{ __('quiz.exams.from_date') }} | {{ __('quiz.exams.to_date') }}</th>
                            <th>{{ __('form.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pagination->items() as $exam)
                        <tr>
                            <th scope="row">{{ ($pagination->currentpage()-1) * $pagination->perpage() + $loop->index + 1 }}</th>
                            <td>
                                <a href="{{ route('exams.show', [$exam->id]) }}">{{ $exam->name }}</a>
                            </td>
                            <td>{{ $exam->attempts_count }}</td>
                            <td>{{ $exam->duration }}</td>
                            <td>{{ $exam->fromDate. ' | ' . $exam->toDate }}</td>
                            <td>
                                    <a href="{{ route("exams.edit", [$exam->id]) }}">
                                        <i class="fa fa-edit text-purple button-2x"></i></a>
                                    <a href="{{ route("exams.delete", [$exam->id]) }}" class=""
                                       onclick="return confirm(this.getAttribute('data-message'));"
                                       data-message="{{ __('form.confirm_delete') }}">
                                        <i class="fa fa-trash-o text-danger button-2x"></i></a>
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
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="{{ asset('assets/js/imask.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/formatter/jquery.formatter.min.js') }}"></script>
    <script src="{{ asset('assets/js/formatter.js') }}"></script>
@endsection
