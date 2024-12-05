@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow mb-3">
                    <div class="card-body">
                        <form action="{{ URL::to('admin/settings/update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.title') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="why_choose_title"
                                            id="why_choose_title"
                                            value="{{ @$getsettings->why_choose_title == '' ? old('why_choose_title') : @$getsettings->why_choose_title }}"
                                            placeholder="{{ trans('labels.title') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label"
                                            for="why_choose_subtitle">{{ trans('labels.subtitle') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="why_choose_subtitle"
                                            id="why_choose_subtitle"
                                            value="{{ @$getsettings->why_choose_subtitle == '' ? old('why_choose_subtitle') : @$getsettings->why_choose_subtitle }}"
                                            placeholder="{{ trans('labels.subtitle') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="">{{ trans('labels.image') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="why_choose_image">
                                        <img src="{{ helper::image_path(@$getsettings->why_choose_image) }}"
                                            class="img-fluid rounded h-50px mt-1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label"
                                            for="why_choose_description">{{ trans('labels.description') }}
                                            <span class="text-danger">*</span></label>
                                        <textarea class="form-control" rows="5" placeholder="{{ trans('labels.description') }}"
                                            name="why_choose_description" id="why_choose_description" required>{{ @$getsettings->why_choose_description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <button class="btn btn-primary"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="whychooseus_update" value="1" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <div class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                            <a class="btn btn-primary mb-3"
                                href="{{ URL::to('admin/choose_us/add') }}"><i class="fa-regular fa-plus"></i> {{ trans('labels.add_new') }}</a>
                        </div>
                        <div class="table-responsive" id="table-display">
                            @include('admin.why_choose_us.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/whychooseus.js') }}"></script>
@endsection
