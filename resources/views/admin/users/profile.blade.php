@extends('dashboard.home')
@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div class="card  col-md-6">
            <nav >
                <h5 class="text-center mt-4" >{{ __('form.employees.edit_profile') }}</h5>
            </nav>
            <div class="tab-content "  id="pills-tabContent">
                <div class="tab-pane fade show active" id="my-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('users.updateProfile') }}" enctype="multipart/form-data" >
                            @csrf
                            <div class="form-group">
                                <label for="username" class="col-md-12">{{ __('validation.attributes.username') }}</label>
                                <div class="col-md-12">
                                    <input type="text"  value="{{ old('username',$item->username) }}" class="form-control" name="username" id="username">
                                    @if($errors->has('username'))
                                        <div class="text-danger">{{ $errors->first('username') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">{{ __('validation.attributes.password') }}</label>
                                <div class="col-md-12">
                                    <input type="password" name="password" value="{{ old('password') }}" class="form-control">
                                    @if($errors->has('password'))
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group text-center">
                                    <button class="btn btn-info">{{ __('form.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
