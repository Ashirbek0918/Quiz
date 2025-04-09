@extends('dashboard.home')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="card mb-4 shadow-1">

                <div class="card-body collapse show" id="collapse8">
                    <form autocomplete="false" class="needs-validation" action="{{ route("users.store") }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="username2">{{ __('validation.attributes.username') }}</label>
                                <input type="text" class="form-control" id="username2" name="username" autocomplete="false" required value="{{ old('username') }}">
                                @if($errors->has('username'))
                                    <div class="text-danger">{{ $errors->first('username') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password2">{{ __('validation.attributes.password') }}</label>
                                <input type="password" class="form-control" id="password2" name="password" autocomplete="false" required>
                                @if($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
{{--                                                        @dd($errors)--}}

                            <div class="col-md-12 mb-3">
                                @forelse($roles as $item)
                                        <input type="checkbox" class="" name="roles[]"
                                               id="{{ $item->id }}" value="{{ $item->name }}">
                                        <label for="{{ $item->id }}" class="mr-2 ">{{ $item->name }}</label>
                                    @if($errors->has('roles.*id'))
                                        <div class="text-danger">{{ $errors->first('roles.*id') }}</div>
                                    @endif
                                    <br>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="form-group text-center ">
                                <a href="{{ route('users.index') }}"
                                   class="btn btn-slack">{{{ __('form.cancel') }}}</a>
                                <button class="btn btn-info">{{ __('form.add') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/formatter/jquery.formatter.min.js') }}"></script>
    <script src="{{ asset('assets/js/formatter.js') }}"></script>
@endsection
