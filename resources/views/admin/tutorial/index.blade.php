@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="alert top-alert">
                <i class="fa-regular fa-circle-exclamation"></i> {{ trans('labels.only_mobile') }}
            </div>
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" id="table-display">
                        @include('admin.tutorial.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/tutorial.js') }}"></script>
@endsection