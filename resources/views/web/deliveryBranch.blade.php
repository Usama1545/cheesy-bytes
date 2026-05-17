@extends('web.layout.default')
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
                <h3 class="mx-3">LOCATION RESULTS</h3>

                <div class="card-body">

                    <div class="card mt-3 mx-auto">
                        <div class="card-header d-flex justify-content-between align-items-center"
                             style="background: #D6B62B">
                            <span
                                class="fw-bold">Select Branch to get Delivery from</span>
                        </div>
                        <div class="card-body">
                            @foreach($shipping as $ship)
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5>{{ $ship->name }}</h5>
                                        @php
                                            $parts = [];
                                            if ($ship->city && !empty($ship->city)) {
                                                $parts[] = $ship->city;
                                            }
                                            if (!empty($ship->state?->name)) {
                                                $parts[] = $ship->state->name;
                                            }
                                            if (!empty($ship->address)) {
                                                $parts[] = $ship->address;
                                            }
                                        @endphp
                                
                                        {{ implode(' , ', $parts) }}
                                    </div>
                                    <div>
                                        <form action="{{ url('/location/getDelivery/'.$ship->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-door-open"></i> Select
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <hr />
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
