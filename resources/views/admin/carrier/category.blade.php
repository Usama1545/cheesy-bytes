@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h3>Carriers</h3>
            <a href="carrier/add" class="btn btn-primary">Add New <i class="fa fa-plus"></i></a>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            @include('admin.carrier.categorytable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/category.js') }}"></script>
@endsection
