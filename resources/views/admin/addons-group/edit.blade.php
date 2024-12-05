@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/addongroup/update-' . $addongroupdata->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="addons_name"
                                                placeholder="{{ trans('labels.name') }}" value="{{ $addongroupdata->name }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.selection_type') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input type="radio" id="required" name="selection_type"
                                                        value="1" class="form-check-input" required
                                                        {{ $addongroupdata->selection_type == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="required">{{ trans('labels.required') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" id="optional" name="selection_type"
                                                        value="2" class="form-check-input" required
                                                        {{ $addongroupdata->selection_type == 2 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="optional">{{ trans('labels.optional') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.selection_count') }}
                                                <span class="text-danger">*</span></label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input type="radio" id="single" name="selection_count"
                                                        value="1" class="form-check-input get_count" required
                                                        {{ $addongroupdata->selection_count == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="single">{{ trans('labels.single') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" id="multiple" name="selection_count"
                                                        value="2" class="form-check-input get_count" required
                                                        @if (old('selection_count') == 2) {{ old('selection_count') == 2 ? 'checked' : '' }}
                                                        @else{{ $addongroupdata->selection_count == 2 ? 'checked' : '' }} @endif>
                                                    <label class="form-check-label"
                                                        for="multiple">{{ trans('labels.multiple') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group count_row @if ($addongroupdata->selection_count == 1) dn @endif">
                                            <label class="col-form-label"
                                                for="min_count">{{ trans('labels.minimum_count') }}
                                                <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control numbers_only count_input"
                                                name="min_count" id="min_count"
                                                placeholder="{{ trans('labels.minimum_count') }}"
                                                value="{{ $addongroupdata->min_count }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group count_row @if ($addongroupdata->selection_count == 1) dn @endif">
                                            <label class="col-form-label"
                                                for="max_count">{{ trans('labels.maximum_count') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only count_input"
                                                name="max_count" id="max_count"
                                                placeholder="{{ trans('labels.maximum_count') }}"
                                                value="{{ $addongroupdata->max_count }}" required>
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
            <div class="row page-titles mx-0 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item text-dark fs-5 fw-500">{{ trans('labels.addons') }}</li>
                    </ol>
                    <a href="{{ URL::to('admin/addons/add') }}" class="btn btn-primary">{{ trans('labels.add_new') }}</a>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            @include('admin.addons.addonstable')
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
