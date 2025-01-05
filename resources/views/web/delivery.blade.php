@extends('web.layout.default')
@section('page_title')
    | Location
@endsection
@section('content')
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-600" href="{{ URL::to('/') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                            aria-current="page">Restaurant
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="d-flex justify-content-center" style="min-height: 100vh;">
        <div class="container my-3">
            <div class="card col-md-10 mx-auto border-0">
                <h3 class="mx-3">Delivery RESULTS</h3>

                <div class="card-body">
                    @if(!$not_available)
                        <div class="card  mx-auto">
                            <div class="card-header d-flex justify-content-between align-items-center"
                                 style="background: #D6B62B">
                                <span class="fw-bold">YOUR DELIVERY STORE</span>
                                <span class="ms-auto fw-bold text-sm" style="font-size: 10px">based on your provided address</span>
                            </div>
                            <div class="card-body">
                                <span style="color: red">Sorry we don’t currently offer delivery to your location but we’ve displayed nearby carryout stores below.</span><br>
                                <a href="{{ URL::to('/location') }}" class="btn btn-primary mt-3">Change Location</a>
                            </div>
                        </div>
                    @endif

                    <div class="card mt-3 mx-auto">
                        <div class="card-header d-flex justify-content-between align-items-center"
                             style="background: #D6B62B">
                            <span
                                class="fw-bold">Stores near: {{ $address->address ? $address->address.'-'.$address->city : ($address->street_address ? $address->street_address.'-'.$address->city : $address->city.'-'.$address->state->name) }}</span>
                        </div>
                        <div class="card-body">
                            @foreach($response as $ship)
                                <div class="mb-4">
                                    <!-- Branch Name -->
                                    <h5 class="text-primary fw-bold border-bottom pb-2">
                                        <i class="fa-solid fa-building"></i> {{ $ship['name'] }}
                                    </h5>

                                    <!-- Carriers List -->
                                    @foreach($ship['carriers'] as $carrier)
                                        <div class="d-flex align-items-center justify-content-between py-2 px-3 bg-light rounded mb-2">
                                            <div>
                                                <h6 class="mb-1 text-secondary">
                                                    <i class="fa-solid fa-truck"></i> {{ $carrier['name'] }}
                                                </h6>
                                            </div>
                                            <div>
                                                <a href="{{ $carrier['link'] }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .form-control {
            padding: 0.33rem .55rem;
            font-size: 13px;
        }
    </style>

@endsection
