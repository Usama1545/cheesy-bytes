@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/sub-category/update-' . $subcatdata->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.subcategory') }}
                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="{{ trans('labels.subcategory') }}"
                                            value="{{ $subcatdata->subcategory_name }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.category') }}
                                            <span class="text-danger">*</span> </label>
                                        <select class="form-select" name="category" required>
                                            <option value="" selected>{{ trans('labels.select') }}</option>
                                            @foreach ($getcategory as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $subcatdata->cat_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/sub-category') }}"
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
