@extends('dashboard.home')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-6">
            <div class="card mb-4 shadow-1">
                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('form.permissions.edit_permission') }}
                    </h4>
                </div>
                <div class="card-body collapse show" id="collapse8">
                    <form class="needs-validation" action="{{ route("permissions.update", [$item->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="name">{{ __('validation.attributes.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ $item->name }}">
                                @if($errors->has('name'))
                                    <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="{{ route('permissions.index') }}" class="btn btn-slack">{{{ __('form.cancel') }}}</a>
                            <button class="btn btn-success" type="submit">{{ __('form.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
