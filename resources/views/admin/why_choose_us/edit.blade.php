@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/choose_us/update-' . $whychooseusdata->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.title') }} <span
                                                class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ $whychooseusdata->title }}" placeholder="{{ trans('labels.title') }}"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label" for="">{{ trans('labels.subtitle') }}
                                            <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="subtitle"
                                            value="{{ $whychooseusdata->subtitle }}"
                                            placeholder="{{ trans('labels.subtitle') }}" required>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="col-form-label" for="">{{ trans('labels.image') }}
                                            <span class="text-danger">*</span> </label>
                                        <input type="file" class="form-control" name="image" accept="image/*">
                                        <img src="{{ helper::image_path($whychooseusdata->image) }}" alt=""
                                            class="img-fluid rounded h-50px mt-1">
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/choose_us') }}"
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
