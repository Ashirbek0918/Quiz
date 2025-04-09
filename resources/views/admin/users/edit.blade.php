@extends('dashboard.home')
@section('content')
    <div class="d-flex justify-content-center">
        <div class="col-md-12 col-lg-10">
            <div class="card mb-4 shadow-1">

                <div class="card-body collapse show" id="collapse8">
                    <form class="needs-validation" action="{{ route("users.update",[$item->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="username">{{ __('validation.attributes.username') }}</label>
                                <input type="text" class="form-control" id="username"  name="username" required value="{{ $item->username }}">
                                @if($errors->has('username'))
                                    <div class="text-danger">{{ $errors->first('username') }}</div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password">{{ __('validation.attributes.password') }}</label>
                                <input type="password" class="form-control" id="password"  name="password"  >
                                @if($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                            {{--                                                        @dd($errors)--}}

                            <div class="col-md-12 mb-3">
                                @forelse($roles as $role)
{{--                                    @dd($item->roles)--}}
                                    <input type="checkbox" class="" name="roles[]"
                                           @checked(in_array($role->id, array_column($item->roles, 'id')))
                                           id="{{ $role->id }}" value="{{ $role->name }}">
                                    <label for="{{ $role->id }}" class="mr-2 ">{{ $role->name }}</label>
                                    {{--                                    @if($errors->has('roles.*'))--}}
                                    {{--                                        <div class="text-danger">{{ $errors->first('roles') }}</div>--}}
                                    {{--                                    @endif--}}
                                    <br>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="form-group text-center ">
                                <a href="{{ route('users.index') }}"
                                   class="btn btn-slack ">{{{ __('form.cancel') }}}</a>
                                <button class="btn btn-info">{{ __('form.save') }}</button>
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
