@extends('admin.theme.default')
@section('content')
    @php
        if (request()->is('admin/bannersection-1*')) {
            $add_url = URL::to('admin/bannersection-1/add');
            $section = 1;
            $title = trans('labels.section-1');
        } elseif (request()->is('admin/bannersection-2*')) {
            $add_url = URL::to('admin/bannersection-2/add');
            $section = 2;
            $title = trans('labels.section-2');
        } elseif (request()->is('admin/bannersection-3*')) {
            $add_url = URL::to('admin/bannersection-3/add');
            $section = 3;
            $title = trans('labels.section-3');
        } else {
            $add_url = URL::to('admin/bannersection-4/add');
            $section = 4;
            $title = trans('labels.section-4');
        }
    @endphp
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="table-responsive" id="table-display">
                            @include('admin.banner.bannertable')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/banner.js') }}"></script>
@endsection
