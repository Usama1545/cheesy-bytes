@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/global_extras/store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="{{ trans('labels.name') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.price') }} <span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_only" name="price"
                                    value="{{ old('price') }}" placeholder="{{ trans('labels.price') }}" id="price"
                                    required>
                            </div>
                            <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/global_extras') }}"
                                    class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button
                                    class="btn btn-primary {{ Auth::user()->type == 4 ? (helper::check_access('role_global_extras', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button"
                                    onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
