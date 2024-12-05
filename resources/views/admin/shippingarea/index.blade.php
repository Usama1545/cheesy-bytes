@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin.shippingarea.shippingareatable')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/shipping.js') }}"></script>
@endsection
