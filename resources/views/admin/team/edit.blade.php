@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/our-team/update-' . $teamdata->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.name') }} <span
                                                    class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $teamdata->name }}" placeholder="{{ trans('labels.name') }}"
                                                required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.designation') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="designation"
                                                value="{{ $teamdata->designation }}"
                                                placeholder="{{ trans('labels.designation') }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.image') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image" accept="image/*">
                                            <img src="{{ helper::image_path($teamdata->image) }}" alt=""
                                                class="img-fluid rounded h-50px mt-1">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="">{{ trans('labels.description') }}
                                                <span class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="description" rows="6" placeholder="{{ trans('labels.description') }}"
                                                required>{{ $teamdata->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.facebook_link') }}</label>
                                            <input type="url" class="form-control" name="fb"
                                                value="{{ $teamdata->fb }}"
                                                placeholder="{{ trans('labels.facebook_link') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.youtube_link') }}</label>
                                            <input type="url" class="form-control" name="youtube"
                                                value="{{ $teamdata->youtube }}"
                                                placeholder="{{ trans('labels.youtube_link') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.instagram_link') }}</label>
                                            <input type="url" class="form-control" name="insta"
                                                value="{{ $teamdata->insta }}"
                                                placeholder="{{ trans('labels.instagram_link') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label"
                                                for="">{{ trans('labels.twitter_link') }}</label>
                                            <input type="url" class="form-control" name="twitter"
                                                value="{{ $teamdata->twitter }}"
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
