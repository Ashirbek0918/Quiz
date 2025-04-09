@extends('dashboard.home')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="card mb-4 shadow-1">
                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('form.permissions.add_permission') }}
                    </h4>
                </div>
                <div class="card-body">
                    <form class="needs-validation" action="{{ route("permissions.store") }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="name">{{ __('validation.attributes.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                                @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="{{ route('permissions.index') }}" class="btn btn-slack">{{{ __('form.cancel') }}}</a>
                            <button class="btn btn-success " type="submit">{{ __('form.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
