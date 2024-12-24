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
                <h3 class="mx-3">LOCATION RESULTS</h3>

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
                            @foreach($shipping as $ship)
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h5>{{ $ship->name ?? $ship->Address }}</h5>
                                        {{ $ship->city. ' , ' .$ship->state->name }}
                                    </div>
                                    <div>
                                        <form action="{{ URL::to('/location/update/'.$ship->id.'/'.$address->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-door-open"></i>Select</button>
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
