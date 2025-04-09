@extends('auth.layout')
@section('content')
    <div >
        <div class="mg-y-120">
            <div class="card mx-auto wd-350 text-center pd-25 shadow-3">
                <div class="nav-tabs-top text-center">
                    <ul class="nav nav-tabs justify-content-center">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#employee"><span style="font-size: large">Ishtirokchi</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active show" data-toggle="tab" href="#admin"><span style="font-size: large">Admin</span></a>
                        </li>

                    </ul>
                    <h4 class="card-title mt-3 text-center">Login</h4>
                    <p class="text-center">Hisobingizga kiring</p>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="employee">
                            <div class="card-body">
                                <form method="post" action="{{ route('web.loginParticipant') }}">
                                    @csrf
                                    @if($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                    <div class="form-group input-group mb-4 mt-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text pd-x-9 text-muted"> <i class="fa fa-envelope"></i> </span>
                                        </div>
                                        <input class="form-control" placeholder="Email address" type="text" name="username" value="{{ old('username') }}">
                                    </div>
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                    <div class="form-group input-group mb-5">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-muted"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input class="form-control" placeholder="Create password" type="password" name="password">
                                    </div>
                                    {{--                                    <p class="text-center"><a href="page-password.html">Forget Password?</a></p>--}}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-block tx-13 hover-white"> Login </button>
                                    </div>
                                    {{--                                    <p class="text-center">Don't have an account? <a href="page-singup.html">Create Account</a> </p>--}}
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="admin">
                            <div class="card-body">
                                <form method="post" action="{{ route('web.loginPost') }}">
                                    @csrf
                                    @if($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                    <div class="form-group input-group mb-4 mt-0">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text pd-x-9 text-muted"> <i class="fa fa-envelope"></i> </span>
                                        </div>
                                        <input class="form-control" placeholder="Email address" type="text" name="username" value="{{ old('username') }}">
                                    </div>
                                    @if($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                    <div class="form-group input-group mb-5">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text text-muted"> <i class="fa fa-lock"></i> </span>
                                        </div>
                                        <input class="form-control" placeholder="Create password" type="password" name="password">
                                    </div>
                                    {{--                                    <p class="text-center"><a href="page-password.html">Forget Password?</a></p>--}}
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-block tx-13 hover-white"> Login </button>
                                    </div>
                                    {{--                                    <p class="text-center">Don't have an account? <a href="page-singup.html">Create Account</a> </p>--}}
                                </form>
                            </div>
                        </div>
                        @if($errors->any())
                            @foreach($errors->all() as  $error)
                                {{ $error }} <br>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
