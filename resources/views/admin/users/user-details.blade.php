@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row g-4 my-3">
            <div class="col-xl-4 col-md-4 col-sm-4 col-12 d-flex">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body">
                        <div class="text-center">
                            <img src='{{ helper::image_path($getusers->profile_image) }}'
                                class="rounded-circle user-profile-image" alt="">
                            <h5 class="mt-3 mb-1 fs-6 fw-500">{{ $getusers->name }}</h5>
                            <p class="m-0 fs-7">{{ $getusers->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-4 col-12 d-flex">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <span class="card-icon mx-auto">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                            </span>
                            <h5 class="mt-3 mb-1 fs-6 fw-500">{{ count($getorders) }}</h5>
                            <p class="m-0 fs-7">{{ trans('labels.orders') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 col-sm-4 col-12 d-flex">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body d-flex justify-content-center align-items-center">
                        <div class="text-center">
                            <span class="card-icon mx-auto">
                                <i class="fa-solid fa-share-from-square fs-5"></i>
                            </span>
                            <h5 class="mt-3 mb-1 fs-6 fw-500">
                                {{ $getusers->referral_code == '' ? '-' : $getusers->referral_code }}
                            </h5>
                            <p class="m-0 fs-7">{{ trans('labels.referral_code') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('labels.orders') }}</h4>
                        <div class="table-responsive" id="table-display">
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
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/users.js') }}"></script>
@endsection
