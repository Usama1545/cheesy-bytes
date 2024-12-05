@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/users/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="name">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" id="name"
                                                placeholder="{{ trans('labels.name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="mobile">{{ trans('labels.mobile') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="tel" class="form-control numbers_only" name="mobile"
                                                value="{{ old('mobile') }}" id="mobile"
                                                placeholder="{{ trans('labels.mobile') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="email">{{ trans('labels.email') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="email" class="form-control" name="email"
                                                value="{{ old('email') }}" id="email"
                                                placeholder="{{ trans('labels.email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="password">{{ trans('labels.password') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="password" class="form-control" name="password"
                                                value="{{ old('password') }}" id="password"
                                                placeholder="{{ trans('labels.password') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/users') }}"
                                        class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                        @if (env('Environment') == 'sendbox') type="button"
                                    onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
