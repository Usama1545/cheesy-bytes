@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/addons/update-' . $addonsdata->id) }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.select_addongroup') }}
                                                <span class="text-danger">*</span> </label>
                                            <select class="form-select" name="addongroup_id" required>
                                                <option value="" disabled>{{ trans('labels.select') }}</option>
                                                @foreach ($getaddongroup as $addongroup)
                                                    <option value="{{ $addongroup->id }}"
                                                        @if ($addonsdata->addongroup_id == $addongroup->id) selected @endif>
                                                        {{ $addongroup->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="addons_name">{{ trans('labels.addons_name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="addons_name"
                                                placeholder="{{ trans('labels.addons_name') }}"
                                                value="{{ $addonsdata->name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label">{{ trans('labels.type') }} <span
                                                    class="text-danger">*</span> </label>
                                            <div class="d-flex">
                                                <div class="form-check-inline">
                                                    <input type="radio" name="type" value="1"
                                                        class="form-check-input get_price" id="free" required
                                                        {{ $addonsdata->price <= 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="free">{{ trans('labels.free') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input type="radio" name="type" value="2" id="paid"
                                                        class="form-check-input get_price" required
                                                        {{ $addonsdata->price > 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="paid">{{ trans('labels.paid') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group @if ($addonsdata->price <= 0) dn @endif" id="price_row">
                                            <label class="col-form-label" for="">{{ trans('labels.price') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="price" id="price"
                                                placeholder="{{ trans('labels.price') }}" value="{{ $addonsdata->price }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to(url()->previous()) }}"
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
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/addons.js') }}"></script>
@endsection
