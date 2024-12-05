@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/employee/update-' . $employeedata->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="name">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $employeedata->name }}" id="name"
                                                placeholder="{{ trans('labels.name') }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="mobile">{{ trans('labels.mobile') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="tel" class="form-control" name="mobile"
                                                value="{{ $employeedata->mobile }}" id="mobile"
                                                placeholder="{{ trans('labels.mobile') }}">
                                            @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="email">{{ trans('labels.email') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $employeedata->email }}" id="email"
                                                placeholder="{{ trans('labels.email') }}">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="role">{{ trans('labels.role') }} <span
                                                    class="text-danger">*</span> </label>
                                            <select class="form-select" name="role" data-live-search="true"
                                                id="type">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getroles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $employeedata->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div
                                    class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/employee') }}"
                                        class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
