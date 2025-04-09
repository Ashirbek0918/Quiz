@extends('employee.dashboard.home')
@section('head')
    <style>
        input[name="passport"] {
            text-transform: uppercase;
        }
    </style>
@endsection
@section('content')
    <div id="main-wrapper">
        <!--================================-->
        <!-- Breadcrumb Start -->
        <!--================================-->
        <div class="pageheader pd-y-25">
            <div class="pd-t-5 pd-b-5">
                <h1 class="pd-0 mg-0 tx-20 text-overflow">{{ __('form.employees.profile') }}</h1>
            </div>
        </div>
        <!--/ Breadcrumb End -->
        <!--================================-->
        <!-- User Profile Start -->
        <!--================================-->
        <div class="row  mg-b-25">
            <div class="col-lg-4 col-xlg-3 col-md-5">
                <div class="card">
                    <div class="card-body pd-b-0">
                        <div class="mt-4 tx-center">
                            @if($item->file != null )
                                <img src="{{asset('profile/'.$item->file['path']) }}"  class="rounded-circle" width="150" alt="">
                            @else
                                <img src="{{asset('assets/images/user/user1.png') }}"  class="rounded-circle" width="150" alt="">
                            @endif
                            <h4 class="card-title mt-2">{{ $item->fullname }}</h4>
                            <h6 class="card-subtitle tx-gray-500 tx-14 pd-y-10">{{ $item->position->hname }}</h6>
                            <p class="tx-gray-500">ID: {{ $item->id}}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body">
                        <div class="card-header">
{{--                            <h4 class="card-header-title">--}}
{{--                                About Me--}}
{{--                            </h4>--}}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-responsive-sm">
                                <tbody><tr>
                                    <td><strong>{{ __('validation.attributes.fullname') }}:</strong></td>
                                    <td>{{ $item->fullname }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('form.departments.department') }}:</strong></td>
                                    <td>{{ $item->department->hname }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('form.positions.position') }}:</strong></td>
                                    <td>{{ $item->position->hname }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('form.branches.branch') }}:</strong></td>
                                    <td>{{ $item->branch->name }}</td>
                                </tr>
{{--                                <tr>--}}
{{--                                    <td><strong>{{ __('validation.attributes.created_at') }}:</strong></td>--}}
{{--                                    <td>{{ $item->created_at }}</td>--}}
{{--                                </tr>--}}
                                <tr>
                                    <td><strong>{{ __('validation.attributes.birthdate') }}:</strong></td>
                                    <td>{{ $item->birthdate }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('validation.attributes.pinfl') }}:</strong></td>
                                    <td>{{ $item->pinfl }}</td>
                                </tr>
                                <tr>
                                    <td><strong>{{ __('validation.attributes.passport') }}:</strong></td>
                                    <td>{{ $item->passport }}</td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-xlg-9 col-md-7 ">
                <div class="card">
                    <nav >
                        <h5 class="text-center mt-4" >{{ __('form.employees.edit_profile') }}</h5>
                    </nav>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="my-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="card-body">
                                <form class="form-horizontal" action="{{ route('profile.edit') }}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="col-md-12">{{ __('validation.attributes.fullname') }}</label>
                                        <div class="col-md-12">
                                            <input type="text" value="{{ old('fullname',$item->fullname) }}" name="fullname" class="form-control">
                                            @if($errors->has('fullname'))
                                                <div class="text-danger">{{ $errors->first('fullname') }}</div>
                                            @endif
                                        </div>
                                    </div>
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
                                    <div class="form-group">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-control-label"
                                                   for="photo">{{ __('validation.attributes.photo') }}</label>
                                            <input type="file" class="form-control" name="photo" >
                                            @if($errors->has('photo'))
                                                <div class="text-danger">{{ $errors->first('photo') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button class="btn btn-info">{{ __('form.save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ User Profile End -->
    </div>
@endsection
@section('script')
    <script src="{{ asset('assets/plugins/formatter/jquery.formatter.min.js') }}"></script>
    <script src="{{ asset('assets/js/formatter.js') }}"></script>
@endsection
