@extends('admin.theme.default')
@section('content')
    @php
        $table_url = URL::to('admin/bannersection-' . $getbanner->section);
        $title = trans('labels.section-' . $getbanner->section);
    @endphp
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/banner/update-' . $getbanner->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="section" value="{{ $getbanner->section }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="type">{{ trans('labels.type') }}</label>
                                            <select name="type" class="form-select type" data-live-search="true"
                                                id="type">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                <option value="1"
                                                {{ old('type') == 1 ? 'selected' : ($getbanner->type == 1 ? 'selected' : '') }}>
                                                {{ trans('labels.category') }}</option>
                                                <option value="2"
                                                    {{ old('type') == 2 ? 'selected' : ($getbanner->type == 2 ? 'selected' : '') }}>
                                                    {{ trans('labels.item') }}</option>
                                            </select>
                                        </div>
                                        <div
                                            class="form-group 1 gravity @if ($errors->has('cat_id')) @else @if ($errors->has('item_id')) dn @else @if ($getbanner->type == 1) @else dn @endif @endif @endif">
                                            <label class="col-form-label" for="">{{ trans('labels.category') }}
                                                <span class="text-danger">*</span> </label>
                                                <select name="cat_id" class="form-select selectpicker" data-live-search="true"
                                                id="cat_id">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getcategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $getbanner->cat_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        <div
                                            class="form-group 2 gravity @if ($errors->has('item_id')) @else @if ($errors->has('cat_id')) dn @else @if ($getbanner->type == 2) @else dn @endif @endif @endif">
                                            <label class="col-form-label" for="">{{ trans('labels.item') }} <span
                                                    class="text-danger">*</span> </label>
                                            <select name="item_id" class="form-select selectpicker" data-live-search="true"
                                                id="item_id">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getitem as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $getbanner->item_id == $item->id ? 'selected' : '' }}>
                                                        {{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.image') }}</label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            <img src="{{ helper::image_path($getbanner->image) }}" alt=""
                                                class="img-fluid rounded h-50px mt-1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a class="btn btn-danger"
                                        href="{{ $table_url }}">{{ trans('labels.cancel') }}</a>
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
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/banner.js') }}"></script>
@endsection
