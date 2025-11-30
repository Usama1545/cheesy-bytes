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
                            aria-current="page">Restaurant</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="d-flex justify-content-center" style="min-height: 100vh;">
        <div class="container my-5">
            <div class="card col-md-10 mx-auto" >
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">HOW DO YOU WANT YOUR CHEESY BITE TODAY?</h5>

                    <div class="row justify-content-center">
                        <!-- Delivery Card -->
                        <div class="col-md-4 cursor-pointer active" onclick="submitForm('delivery-card-form')">
                            <div class="card card-button border-primary" id="delivery-card">
                                <form id="delivery-card-form" class="mt-1" action="{{ URL::to('/location/store') }}" method="post">
                                    @csrf
                                    <div id="carryout-fields" class="row d-none mx-0 mx-md-5">
                                        <input hidden name="type" value="delivery">
                                    </div>
                                </form>
                                <div class="card-body delivery-card text-center">
                                    <h6 class="card-title">
                                        <i class="fas fa-cab" style="font-size: 20px;"></i> DELIVERY
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <!-- Carryout Card -->
                        <div class="col-md-4 mt-2 mt-md-0 cursor-pointer" onclick="submitForm('carryout-card-form')">
                            <div class="card card-button border-primary" id="carryout-card">
                                <form id="carryout-card-form" class="mt-1" action="{{ URL::to('/location/store') }}" method="post">
                                    @csrf
                                    <div id="carryout-fields" class="row d-none mx-0 mx-md-5">
                                        <input hidden name="type" value="carryout">
                                    </div>
                                </form>
                                <div class="card-body carryout-card text-center">
                                    <h6 class="card-title">
                                        <i class="fas fa-hand-holding-box" style="font-size: 20px;"></i> CARRYOUT
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--                    <form class="mt-4 mx-2 mx-md-5" action="{{ URL::to('/location/store') }}" method="post">--}}
{{--                        <!-- Delivery Fields -->--}}
{{--                        @csrf--}}
{{--                        <div id="delivery-fields" class="row d-none mx-0 mx-md-5">--}}
{{--                            <input name="type" value="delivery" hidden >--}}
{{--                            <div class="mb-3 col-md-6">--}}
{{--                                <label for="addressType" class="form-label">Address Type</label>--}}
{{--                                <select class="form-control form-select" id="addressType" onchange="updateFields()">--}}
{{--                                    <option value="House">House</option>--}}
{{--                                    <option value="Apartment">Apartment</option>--}}
{{--                                    <option value="Business">Business</option>--}}
{{--                                    <option value="Hotel">Hotel</option>--}}
{{--                                    <option value="Other">Other</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="apartmentNameField">--}}
{{--                                <label for="apartmentName" class="form-label" >Apartment Name</label>--}}
{{--                                <input type="text" class="form-control" name="name" id="apartmentName">--}}
{{--                            </div>--}}


{{--                            <div class="mb-3  col-md-6" id="unitField">--}}
{{--                                <label for="unit" class="form-label">Unit #</label>--}}
{{--                                <input type="text" class="form-control" name="unit" id="unit" required>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="zipCodeField">--}}
{{--                                <label for="zipCode" class="form-label">ZIP Code</label>--}}
{{--                                <input type="text" class="form-control" name="zip" id="zipCode" required>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="cityField">--}}
{{--                                <label for="city" class="form-label">City</label>--}}
{{--                                <input type="text" class="form-control" name="city" id="city" required>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="businessNameField">--}}
{{--                                <label for="businessName" class="form-label">Business Name</label>--}}
{{--                                <input type="text" class="form-control" name="name" id="businessName">--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="hotelNameField">--}}
{{--                                <label for="hotelName" class="form-label">Hotel Name</label>--}}
{{--                                <input type="text" class="form-control" name="name" id="hotelName">--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="roomField">--}}
{{--                                <label for="room" class="form-label">Room #</label>--}}
{{--                                <input type="text" class="form-control" name="room" id="room">--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="otherField">--}}
{{--                                <label for="other" class="form-label">Other Information</label>--}}
{{--                                <input type="text" class="form-control" id="other">--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="stateField">--}}
{{--                                <label for="state" class="form-label">State</label>--}}
{{--                                <select class="form-control form-select" name="state_id" id="state">--}}
{{--                                    @foreach($states as $state)--}}
{{--                                        <option value="{{ $state->id }}">{{ $state->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3  col-md-6" id="streetAddressField">--}}
{{--                                <label for="streetAddress" class="form-label" >Street Address</label>--}}
{{--                                <input type="text" class="form-control" id="streetAddress"  name="street_address" required>--}}
{{--                            </div>--}}
{{--                            <div class="mb-3  col-md-12" id="addressField">--}}
{{--                                <label for="address" class="form-label">Address</label>--}}
{{--                                <input type="text" class="form-control" name="address" id="address" required>--}}
{{--                            </div>--}}
{{--                            <button type="submit" class="btn btn-primary w-100">CONTINUE FOR DELIVERY</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                    <form class="mt-4 mx-2 mx-md-5" action="{{ URL::to('/location/store') }}" method="post">--}}
{{--                        <!-- Carryout Fields -->--}}
{{--                        @csrf--}}
{{--                        <div id="carryout-fields" class="row d-none mx-0 mx-md-5">--}}
{{--                            <input hidden name="type" value="carryout" >--}}
{{--                            <div class="mb-3 col-md-12">--}}
{{--                                <label for="zipCodeCarryout" class="form-label">ZIP Code</label>--}}
{{--                                <input type="text" class="form-control" id="zipCodeCarryout" name="zip" required>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3 col-md-12">--}}
{{--                                <label for="cityCarryout" class="form-label">City</label>--}}
{{--                                <input type="text" class="form-control" id="cityCarryout" name="city" required>--}}
{{--                            </div>--}}

{{--                            <div class="mb-3 col-md-12">--}}
{{--                                <label for="stateCarryout" class="form-label">State</label>--}}
{{--                                <select class="form-control  form-select" id="stateCarryout" name="state_id" required>--}}
{{--                                    @foreach($states as $state)--}}
{{--                                        <option value="{{ $state->id }}">{{ $state->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <button type="submit" class="btn btn-primary">FIND A STORE</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </section>
    <style>
        .form-control {
            padding: 0.33rem .55rem;
            font-size: 13px;
        }
        .card-button {
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .card-button:hover {
            transform: scale(1.05);
            background-color: #ac1515;
        }
    </style>
    <script>
        function submitForm(formId) {
            document.getElementById(formId).submit();
        }
    </script>
@endsection
