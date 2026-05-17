@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="alert top-alert">
                    <i class="fa-regular fa-circle-exclamation"></i> {{ trans('labels.only_mobile') }}
                </div>
                <div class="card border-0 mb-3">
                    <div class="card-body">
                        <form action="{{ URL::to('admin/settings/update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label class="col-form-label" for="">{{ trans('labels.firebase_key') }} <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="firebase" id="firebase"
                                    value="{{ @$getsettings->firebase == '' ? old('firebase') : @$getsettings->firebase }}"
                                    placeholder="{{ trans('labels.firebase_key') }}" required>
                            </div>
                            <div class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <button class="btn btn-primary"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="firebase_key_update" value="1" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-body">
                        <div class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }} mb-3">
                            <a href="{{ URL::to('admin/notification/add') }}"
                                class="btn btn-primary"><i class="fa-regular fa-plus"></i> {{ trans('labels.add_new') }}</a>
                        </div>
                        <div class="table-responsive" id="table-display">
                            @include('admin.notification.notificationtable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
