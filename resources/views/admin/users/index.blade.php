@extends('dashboard.home')
@section('content')
    <div class="row clearfix">
        <div class="col-md-12 col-lg-12">
            <div class="card mb-4 shadow-1">
                <div class="card-header">
                    <div class="card-header-title">
                        <h5><a href="{{ route('users.index') }}">{{ __('form.users.users') }}</a></h5>
                    </div>
                    @can('users.store')
                        <a href="{{ route("users.create") }}" class="btn btn-outline-success">
                            <i class="fa fa-plus button-2x"> {{ __('form.add') }}</i></a>
                    @endcan

                </div>
                <div class="card-body collapse show" id="collapse2">
                    <table class="table table-striped table-responsive-sm">
                        <thead>
                        <tr>
                            <form action="{{ route("users.index") }}">
                                <td>
                                    <select class="form-control select2 select2-hidden-accessible" name="limit"
                                            style="width: 65px">
                                        <option value="5" @selected(request('limit') == 5)>5</option>
                                        <option
                                            value="10" @selected(request('limit') == 10 || is_null(request('limit')))>10
                                        </option>
                                        <option value="20" @selected(request('limit') == 20)>20</option>
                                        <option value="30" @selected(request('limit') == 30)>30</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="search"
                                           placeholder="{{ __('form.search') }}"
                                           value="{{ request('search') }}">
                                </td>
                                <td>
                                    <select class="form-control select2 select2-hidden-accessible" tabindex="-1"
                                            aria-hidden="true" id="role_id" name="role_id">
                                        <option value="" selected
                                                disabled>{{ __('form.roles.role') }} {{ __('form.choose') }}</option>
                                        @foreach($roles as $role)
                                            <option
                                                value="{{ $role->id }}"
                                                @selected(request('role_id') == $role->id)
                                            >{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <div class="row">
                                        <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                        <a href="{{ route('users.index') }}" class="btn btn-outline-info"><i
                                                class="fa fa-refresh"></i></a>
                                    </div>
                                </td>
                            </form>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>{{ __('validation.attributes.name') }}</th>
                            <th>{{ __('form.roles.roles') }}</th>
                            <th>{{ __('form.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pagination->items() as $item)
                            <tr>
                                <th scope="row">{{ ($pagination->currentpage()-1) * $pagination->perpage() + $loop->index + 1 }}</th>
                                <td>{{ $item->username }}</td>
                                <td>
                                    @foreach($item->roles as $userRole)
                                        <span class="badge badge-success">{{ $userRole['name'] }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('users.update')
                                        <a href="{{ route("users.edit", [$item->id]) }}">
                                            <i class="fa fa-edit text-purple button-2x"></i></a>
                                    @endcan
                                    @can('users.delete')
                                        <a href="{{ route("users.delete", [$item->id]) }}" class=""
                                           onclick="return confirm(this.getAttribute('data-message'));"
                                           data-message="{{ __('table.confirm_delete') }}">
                                            <i class="fa fa-trash-o text-danger button-2x"></i></a>
                                    @endcan
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
    </div>
@endsection
