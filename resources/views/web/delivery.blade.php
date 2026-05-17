@extends('web.layout.default')
@section('page_title')| Location @endsection
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
                    @if(!empty($response) && count($response) > 0)
                    @foreach($response as $ship)

                    <div class="card mt-3 mx-auto">
                        <div class="card-header d-flex justify-content-between align-items-center"
                             style="background: #D6B62B">
                            <span
                                class="fw-bold">Delivery Providers - {{ $ship['name'] }}</span>
                        </div>
                        <div class="card-body">
                                <div class="mb-4">
                                    <!-- Carriers List -->
                                    @foreach($ship['carriers'] as $carrier)
                                        <div class="d-flex align-items-center justify-content-between py-2 px-3 bg-light rounded mb-2">
                                            <div>
                                                <h6 class="mb-1 text-secondary">
                                                    <img src="{{ helper::image_path($carrier['image']) }}" alt="{{ $carrier['name'] }}" class="img-fluid rounded h-50px mt-1" style="height: 45px">
                                                     {{ $carrier['name'] }}
                                                     @if(isset($carrier['description']) && $carrier['description'] !== "")
                                                        <small>({{ $carrier['description'] }} )</small>
                                                     @endif
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

                        </div>
                    </div>
                    @endforeach
                    @else
                    No Delivery Providers found for Selected Branch
                    @endif
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
