@extends('admin.theme.default')
@section('content')
    @include('admin.breadcrumb')
    <div class="container-fluid">
        <div class="row g-4 my-3">
            <div class="col-xl-3 col-md-4 col-sm-4 col-12 d-flex">
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
            <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-flex">
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
            <div class="col-xl-2 col-md-4 col-sm-4 col-12 d-flex">
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
            <div class="col-xl-2 col-sm-6 col-12">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body">
                        <div>
                            <h5 class="card-title fw-500 text-dark text-left border-bottom pb-3 mb-3">
                                {{ trans('labels.wallet') }}</h5>
                            <div class="d-flex">
                                <div class="w-100 text-left w-50">
                                    <p class="text-muted mb-0">{{ trans('labels.wallet_balance') }}</p>
                                    <h4 class="media-heading fw-400 my_wallet">
                                        {{ helper::currency_format(@$getusers->wallet) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card border-0 w-100 h-100">
                    <div class="card-body">
                        <h5 class="card-title fw-500 text-dark text-left border-bottom pb-3 mb-3">
                            {{ trans('labels.manage_wallet') }}</h5>
                        <input type="hidden" name="id" id="id" value="{{ @$getusers->id }}">
                        <input type="hidden" name="price_message" id="price_message"
                            value="{{ trans('messages.amount_required') }}">
                        <input type="text" class="form-control mt-2 mb-2 numbers_only" name="money"
                            placeholder="{{ trans('labels.amount') }}" id="price">
                        <div class="row g-2">
                            <div class="col-xxl-6 col-xl-12 col-md-6">
                                <button class="btn btn-sm btn-success add w-100" data-type="add"
                                    data-url="{{ URL::to('admin/users/change-wallet') }}"> <i class="fa fa-arrow-up"></i>
                                    <small>{{ trans('labels.add_money') }}</small></button>
                            </div>
                            <div class="col-xxl-6 col-xl-12 col-md-6">
                                <button class="btn btn-sm btn-warning deduct w-100" data-type="deduct"
                                    data-url="{{ URL::to('admin/users/change-wallet') }}"> <i class="fa fa-arrow-down"></i>
                                    <small>{{ trans('labels.deduct_money') }}</small></button>
                            </div>
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
        <div class="row my-3">
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <h4 class="card-title">{{ trans('labels.transactions') }}</h4>
                        <div class="table-responsive" id="table-display">
                            @include('admin.users.transactiontable')
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
