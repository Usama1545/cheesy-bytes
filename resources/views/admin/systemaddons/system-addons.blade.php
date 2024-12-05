@extends('admin.theme.default')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-3 border-0 box-shadow">
                <div class="px-4 py-4">
                    <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1 fw-bold">Visit our store to purchase addons</h5>
                            <p class="text-muted fw-medium">Install our addons to unlock premium features</p>
                        </div>
                        <a href="https://infotechgravity.com/category?category=foodefy-single-restaurant" target="_blank" class="btn btn-success">Visit Our Store</a>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center mb-3">
                <h5 class="fs-4 fw-600">{{ trans('labels.addons_manager') }}</h5>
                <div class="d-inline-flex">
                    <a href="{{ URL::to('admin/createsystem-addons') }}" class="btn btn-secondary px-4 d-flex">
                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.install_update_addons') }}</a>
                </div>
            </div>
            <div class="card border-0 mb-3 box-shadow">
                <div class="card-body">
                    <div class="card border-0 box-shadow h-100">
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-link active" id="installed-tab" data-bs-toggle="tab" href="#installed" role="tab" aria-controls="installed" aria-selected="true">{{ trans('labels.installed_addons') }} ({{count($addons)}})</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="installed" role="tabpanel" aria-labelledby="installed-tab">
                                    <div class="row">
                                    @if(count($addons) > 0)
                                        @foreach($addons as $addon)
                                            <div class="col-md-6 col-lg-3 mt-3 d-flex">
                                                <div class="card h-100 w-100">
                                                    <img class="img-fluid" src='{!! asset('storage/app/public/addons/' . $addon->image) !!}' alt="">
                                                    <div class="card-body">
                                                        
                                                        <h5 class="card-title">
                                                            {{$addon->name}}
                                                        </h5>
                                                    </div>
                                                    <div class="card-footer">
                                                        <p class="card-text d-inline"><small class="text-muted">{{ date('d M Y', strtotime($addon->created_at)); }}</small></p>
                                                        @if ($addon->activated == 1)
                                                            <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addon->id }}','2','{{ URL::to('admin/systemaddons/update') }}')" @endif class="btn btn-sm btn-success {{session()->get('direction') == 2 ? 'float-start' : 'float-end'}}">{{ trans('labels.activated') }}</a>
                                                        @else
                                                            <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="StatusUpdate('{{ $addon->id }}','1','{{ URL::to('admin/systemaddons/update') }}')" @endif class="btn btn-sm btn-danger {{session()->get('direction') == 2 ? 'float-start' : 'float-end'}}">{{ trans('labels.deactivated') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Col -->
                                        @endforeach
                                    @else
                                        <div class="col col-md-12 text-center text-muted mt-4">
                                            <h4>{{ trans('labels.no_addon_installed') }}</h4>
                                            <a href="https://infotechgravity.com/category?category=foodefy-single-restaurant" target="_blank" class="btn btn-success mt-4">Visit Our Store</a>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/systemaddons.js') }}"></script>
@endsection