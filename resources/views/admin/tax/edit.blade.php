@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/tax/update-' . $taxdata->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="name">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="{{ trans('labels.name') }}" value="{{ $taxdata->name }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.type') }} <span
                                                    class="text-danger">*</span> </label>
                                            <select name="type" class="form-select" required>
                                                <option value="" hidden>{{ trans('labels.select') }}</option>
                                                <option value="1" {{ $taxdata->type == 1 ? 'selected' : '' }}>
                                                    {{ trans('labels.fixed') }}
                                                    ({{ helper::appdata()->currency }})</option>
                                                <option value="2" {{ $taxdata->type == 2 ? 'selected' : '' }}>
                                                    {{ trans('labels.percentage') }} (%)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="tax">{{ trans('labels.tax') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control numbers_only" name="tax"
                                                id="tax" placeholder="{{ trans('labels.tax') }}"
                                                value="{{ $taxdata->tax }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/tax') }}"
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
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/addons.js') }}"></script>
@endsection
