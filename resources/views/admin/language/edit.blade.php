@extends('admin.theme.default')
@section('content')
<div class="d-flex justify-content-between align-items-center">


    <nav aria-label="breadcrumb">

        <ol class="breadcrumb mb-3">

            <li class="breadcrumb-item"><a href="{{ URL::to('admin/language-settings') }}">{{ trans('labels.language') }}</a></li>

            <li class="breadcrumb-item active {{session()->get('direction') == 2 ? 'breadcrumb-rtl' : ''}}" aria-current="page"><a href="#">{{ trans('labels.edit') }}</a></li>

        </ol>

    </nav>

</div>
<div class="row">
    <div class="col-12">
        <div class="card border-0 mb-3 box-shadow">
            <div class="card-body">
                <form action="{{ URL::to('/admin/language-settings/update-' . $getlanguage->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-3 col-md-12">
                            <div class="form-group mb-3">
                                <label for="layout" class="col-form-label">{{trans('labels.layout')}}</label>
                                <select name="layout" class="form-control layout-dropdown" id="layout">
                                    <option value="" selected>{{trans('labels.select')}}</option>
                                    <option value="1"{{ $getlanguage->layout == "1" ? 'selected' : '' }} >{{ trans('labels.ltr') }}</option>
                                    <option value="2"{{ $getlanguage->layout == "2" ? 'selected' : '' }} >{{ trans('labels.rtl') }}</option>
                                </select>
                                @error('layout') <br><span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="layout" class="col-form-label">{{trans('labels.image')}}</label>
                                <input type="file" class="form-control" name="image">
                                @error('image') <br><span class="text-danger">{{ $message }}</span> @enderror
                                <img src="{{ helper::image_path($getlanguage->image) }}" class="img-fluid rounded h-50px mt-1" alt="">
                            </div>

                            <label class="form-label"
                                    for="">{{ trans('labels.default') }} </label>
                            <input id="default-switch" type="checkbox" class="checkbox-switch" name="default" value="1" {{ $getlanguage->is_default == 1 ? 'checked' : '' }}>
                            <label for="default-switch" class="switch me-3">
                                <span class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span class="switch__circle-inner"></span></span>
                                <span class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                <span class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-3 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <a href="{{URL::to('admin/language-settings')}}" class="btn btn-danger px-4">{{ trans('labels.cancel') }}</a>
                        <button
                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                        class="btn btn-primary px-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_language_settings', Auth::user()->role_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection