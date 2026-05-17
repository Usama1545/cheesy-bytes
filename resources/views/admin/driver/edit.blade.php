@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/driver/update-' . $getdriverdata->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="col-form-label" for="">{{ trans('labels.name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                placeholder="{{ trans('labels.name') }}" value="{{ $getdriverdata->name }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="col-form-label" for="">{{ trans('labels.email') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="{{ trans('labels.email') }}"
                                                value="{{ $getdriverdata->email }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="col-form-label" for="">{{ trans('labels.mobile') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                placeholder="{{ trans('labels.mobile') }}"
                                                value="{{ $getdriverdata->mobile }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.identity_type') }}
                                                <span class="text-danger">*</span> </label>
                                            <select id="identity_type" name="identity_type" class="form-select"
                                                aria-label="" required>
                                                <option value="" selected disabled>{{ trans('labels.select') }}
                                                </option>
                                                <option value="Passport"
                                                    {{ $getdriverdata->identity_type == 'Passport' ? 'selected' : '' }}>
                                                    {{ trans('labels.passport') }} </option>
                                                <option value="Driving License"
                                                    {{ $getdriverdata->identity_type == 'Driving License' ? 'selected' : '' }}>
                                                    {{ trans('labels.driving_license') }}
                                                </option>
                                                <option value="NID"
                                                    {{ $getdriverdata->identity_type == 'NID' ? 'selected' : '' }}>
                                                    {{ trans('labels.nid') }} </option>
                                                <option value="Restaurant Id"
                                                    {{ $getdriverdata->identity_type == 'Restaurant Id' ? 'selected' : '' }}>
                                                    {{ trans('labels.restaurant_id') }} </option>
                                                <option value="Other"
                                                    {{ $getdriverdata->identity_type == 'Other' ? 'selected' : '' }}>
                                                    {{ trans('labels.other') }} </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.identity_number') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="tel" class="form-control" name="identity_number"
                                                value="{{ $getdriverdata->identity_number }}" id="identity_number"
                                                placeholder="{{ trans('labels.identity_number') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.identity_image') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" id="image">
                                            <img src="{{ helper::image_path($getdriverdata->identity_image) }}"
                                                alt="" class="img-fluid rounded h-50px mt-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/driver') }}"
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
