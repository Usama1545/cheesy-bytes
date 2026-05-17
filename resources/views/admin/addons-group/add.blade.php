@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/addongroup/store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="addons_name"
                                                placeholder="{{ trans('labels.name') }}" value="{{ old('name') }}"
                                                required>
                                        </div>
                                    </div>
                                    <!-- select_type -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.selection_type') }}
                                                <span class="text-danger">*</span> </label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selection_type"
                                                        value="1" id="required" checked required>
                                                    <label class="form-check-label"
                                                        for="required">{{ trans('labels.required') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input" type="radio" name="selection_type"
                                                        value="2" id="optional" required>
                                                    <label class="form-check-label text-nowrap"
                                                        for="optional">{{ trans('labels.optional') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- select_count -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.selection_count') }}
                                                <span class="text-danger">*</span> </label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input get_count" type="radio"
                                                        name="selection_count" value="1" id="single" checked
                                                        required>
                                                    <label class="form-check-label"
                                                        for="single">{{ trans('labels.single') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input get_count" type="radio"
                                                        name="selection_count" value="2" id="multiple"
                                                        {{ old('selection_count') == 2 ? 'checked' : '' }} required>
                                                    <label class="form-check-label text-nowrap"
                                                        for="multiple">{{ trans('labels.multiple') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group count_row">
                                            <label class="col-form-label"
                                                for="min_count">{{ trans('labels.minimum_count') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only count_input"
                                                name="min_count" id="min_count"
                                                placeholder="{{ trans('labels.minimum_count') }}"
                                                value="{{ old('min_count') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group count_row">
                                            <label class="col-form-label"
                                                for="max_count">{{ trans('labels.maximum_count') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only count_input"
                                                name="max_count" id="max_count"
                                                placeholder="{{ trans('labels.maximum_count') }}"
                                                value="{{ old('max_count') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/addongroup') }}"
                                        class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                    <button class="btn btn-primary"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @elseif(Auth::user()->type == 5)  type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/addons.js') }}"></script>
@endsection
