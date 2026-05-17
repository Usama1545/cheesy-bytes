@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="form-validation">
                            <form action="{{ URL::to('admin/store-review/store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="name">{{ trans('labels.full_name') }}
                                                <span class="text-danger">*</span> </label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name') }}" id="name"
                                                placeholder="{{ trans('labels.name') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="ratting">{{ trans('labels.rating') }} <span
                                                    class="text-danger">*</span> </label>
                                            <select id="ratting" name="ratting" class="form-select" required>
                                                <option value="" hidden>{{ trans('labels.select') }}
                                                </option>
                                                <option value="1" {{ old('ratting') == '1' ? 'selected' : '' }}>1
                                                </option>
                                                <option value="2" {{ old('ratting') == '2' ? 'selected' : '' }}>2
                                                </option>
                                                <option value="3" {{ old('ratting') == '3' ? 'selected' : '' }}>3
                                                </option>
                                                <option value="4" {{ old('ratting') == '4' ? 'selected' : '' }}>4
                                                </option>
                                                <option value="5" {{ old('ratting') == '5' ? 'selected' : '' }}>5
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="image">{{ trans('labels.image') }}<span
                                                    class="text-danger">*</span> </label>
                                            <input type="file" class="form-control" name="image"
                                                value="{{ old('image') }}" id="image" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-form-label" for="comment">{{ trans('labels.description') }}
                                                <span class="text-danger">*</span> </label>
                                            <textarea class="form-control" name="comment" id="comment" rows="2" required
                                                placeholder="{{ trans('labels.description') }}">{{ old('comment') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <a href="{{ URL::to('admin/store-review') }}"
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
