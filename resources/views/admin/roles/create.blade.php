@extends('dashboard.home')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="card mb-4 shadow-1">
                <div class="card-header">
                    <h4 class="card-header-title">
                        {{ __('form.add') }}
                    </h4>
                </div>
                <div class="card-body collapse show" id="collapse8">
                    <form class="needs-validation" action="{{ route("roles.store") }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="name">{{ __('validation.attributes.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="{{ old('name') }}">
                                @if($errors->has('name'))
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-12 mb-3">
                                @forelse($permissions as $items)
                                    @foreach($items as $permission)
                                        <input type="checkbox" class="" name="permission_id[]"
                                               id="{{ $permission->id }}" value="{{ $permission->name }}">
                                        <label for="{{ $permission->id }}" class="mr-2 ">{{ $permission->name }}</label>
                                    @endforeach
                                    <br>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="{{ route('roles.index') }}" class="btn btn-slack">{{{ __('form.cancel') }}}</a>
                            <button class="btn btn-success" type="submit">{{ __('form.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
{{--    </div>--}}
{{--    </div>--}}
@endsection
