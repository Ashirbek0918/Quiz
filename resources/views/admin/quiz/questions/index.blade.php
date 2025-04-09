@extends('dashboard.home')

@section('content')
    <div class="col-md-12 col-lg-12">

        <div class="card mb-4 shadow-1">

            <div class="card-header">
                <h4 class="card-header-title">
                    {{ __('quiz.questions.questions') }}
                </h4>
{{--                @include('admin.quiz.questions.import')--}}
{{--                    <span data-toggle="modal" data-target="#m_question_import"> <i class="btn fa fa-cloud-upload ml-3">{{ __('form.upload') }} </i> </span>--}}
                    <a href="{{ route("questions.create", [$topic]) }}" class="btn btn-outline-success">
                        <i class="fa fa-plus button-2x"> {{ __('form.add') }}</i></a>
            </div>
            <div class="card-body overflow-auto">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('quiz.questions.questions') }}</th>
                        <th>{{ __('quiz.questions.lang') }}</th>
                        <th>{{ __('quiz.questions.types.types') }}</th>
                        <th>{{ __('quiz.answers.answers_count') }}</th>
                            <th>{{ __('form.actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pagination->items() as $document)
                        <tr>
                            <th scope="row">{{ ($pagination->currentpage()-1) * $pagination->perpage() + $loop->index + 1 }}</th>
                            <td>{!! $document->content !!}</td>
                            <td>{{ $document->lang }}</td>
                            <td>{{ $document->typeName }}</td>
                            <td>{{ $document->answers_count}}</td>
                            <td>
                                    <a href="{{ route("questions.edit", [$topic, $document->id]) }}">
                                        <i class="fa fa-edit text-purple button-2x"></i></a>
                                    <a href="{{ route("questions.delete", [$topic, $document->id]) }}" class=""
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
