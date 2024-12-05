@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/slider/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.title') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="title"
                                                placeholder="{{ trans('labels.title') }}" value="{{ old('title') }}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.image') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" accept="image/*"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="type">{{ trans('labels.type') }}</label>
                                            <select name="type" class="form-select type" data-live-search="true"
                                                id="type">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>
                                                    {{ trans('labels.category') }}</option>
                                                <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>
                                                    {{ trans('labels.item') }}</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.description') }}
                                            </label>
                                            <textarea name="description" class="form-control" rows="5" placeholder="{{ trans('labels.description') }}">{{ old('description') }}</textarea>
                                        </div>
                                        <div class="form-group 1 gravity">
                                            <label class="col-form-label" for="">{{ trans('labels.category') }}
                                                <span class="text-danger">*</span> </label>
                                            <select name="cat_id" class="form-select selectpicker" data-live-search="true"
                                                id="cat_id">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getcategory as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('cat_id') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('cat_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group 2 gravity">
                                            <label class="col-form-label" for="">{{ trans('labels.item') }} <span
                                                    class="text-danger">*</span> </label>
                                            <select name="item_id" class="form-select selectpicker" data-live-search="true"
                                                id="item_id">
                                                <option value="" selected>{{ trans('labels.select') }}</option>
                                                @foreach ($getitem as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ old('item_id') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->item_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('item_id')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                        <a href="{{ URL::to('admin/slider') }}"
                                            class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                        <button class="btn btn-primary"
                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                    </div>
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
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/slider.js') }}"></script>
@endsection
