@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ URL::to('/admin/report') }}" class="my-3">
                    <div class="input-group col-md-12 ps-0 justify-content-end">
                        <div class="input-group-append col-auto px-1">
                            <input type="date" class="form-control rounded" name="startdate"
                                @isset($_GET['startdate']) value="{{ $_GET['startdate'] }}" @endisset
                                aria-label="{{ trans('labels.type_and_enter') }}" aria-describedby="basic-addon2" required>
                        </div>
                        <div class="input-group-append col-auto px-1">
                            <input type="date" class="form-control rounded" name="enddate"
                                @isset($_GET['enddate']) value="{{ $_GET['enddate'] }}" @endisset
                                aria-label="{{ trans('labels.type_and_enter') }}" aria-describedby="basic-addon2" required>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary rounded" type="submit">{{ trans('labels.fetch') }}</button>
                        </div>
                    </div>
                </form>
                @include('admin.orders.statistics')
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive reportstable" id="table-display">
                            @include('admin.orders.orderstable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/orders.js') }}"></script>
@endsection
