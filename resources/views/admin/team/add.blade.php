@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/our-team/store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" placeholder="{{ trans('labels.name') }}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.designation') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="designation"
                                                value="{{ old('designation') }}"
                                                placeholder="{{ trans('labels.designation') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.image') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" accept="image/*"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.description') }}
                                                <span class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="description" rows="6" placeholder="{{ trans('labels.description') }}"
                                                required>{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.facebook_link') }}</label>
                                            <input type="url" class="form-control" name="fb"
                                                value="{{ old('fb') }}"
                                                placeholder="{{ trans('labels.facebook_link') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.youtube_link') }}</label>
                                            <input type="url" class="form-control" name="youtube"
                                                value="{{ old('youtube') }}"
                                                placeholder="{{ trans('labels.youtube_link') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.instagram_link') }}</label>
                                            <input type="url" class="form-control" name="insta"
                                                value="{{ old('insta') }}"
                                                placeholder="{{ trans('labels.instagram_link') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.twitter_link') }}</label>
                                            <input type="url" class="form-control" name="twitter"
                                                value="{{ old('twitter') }}"
                                                placeholder="{{ trans('labels.twitter_link') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/our-team') }}"
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
