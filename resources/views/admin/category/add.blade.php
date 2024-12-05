@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/category/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.category') }}
                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="category_name"
                                            placeholder="{{ trans('labels.category') }}" value="{{ old('category_name') }}"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.image') }}
                                            <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" accept="image/*" required>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/category') }}"
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
