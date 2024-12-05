@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/shippingarea/update-' . $shippingareadata->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id"value="{{ $shippingareadata->id }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.area_name') }}
                                        <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ $shippingareadata->name }}" placeholder="{{ trans('labels.area_name') }}"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.delivery_charge') }}
                                        <span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control numbers_only" name="delivery_charge"
                                        value="{{ $shippingareadata->delivery_charge }}"
                                        placeholder="{{ trans('labels.delivery_charge') }}" required>
                                </div>
                            </div>
                            <div class="form-group {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <a href="{{ URL::to('admin/shippingarea') }}"
                                    class="btn btn-danger">{{ trans('labels.cancel') }}</a>
                                <button class="btn btn-primary "
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
