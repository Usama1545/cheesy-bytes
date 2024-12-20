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
                    <h5 class="card-title text-center mb-4">HOW DO YOU WANT YOUR CHEESYBYTE TODAY?</h5>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card border-primary" id="delivery-card" onclick="showDeliveryFields()">
                                <div class="card-body delivery-card text-center">
                                    <h6 class="card-title"><i class="fas fa-cab" style="font-size: 20px;"></i> DELIVERY
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-primary" id="carryout-card" onclick="showCarryoutFields()">
                                <div class="card-body carryout-card text-center">
                                    <h6 class="card-title"><i class="fas fa-hand-holding-box"
                                                              style="font-size: 20px;"></i> CARRYOUT</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form class="mt-4 mx-5" action="{{ URL::to('/location/store') }}" method="post">
                        <!-- Delivery Fields -->
                        @csrf
                        <div id="delivery-fields" class="row d-none mx-5">
                            <input name="type" value="delivery" hidden >
                            <div class="mb-3 col-md-6">
                                <label for="addressType" class="form-label">Address Type</label>
                                <select class="form-control form-select" id="addressType" onchange="updateFields()">
                                    <option value="House">House</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="Business">Business</option>
                                    <option value="Hotel">Hotel</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3  col-md-6" id="apartmentNameField">
                                <label for="apartmentName" class="form-label" >Apartment Name</label>
                                <input type="text" class="form-control" name="name" id="apartmentName">
                            </div>


                            <div class="mb-3  col-md-6" id="unitField">
                                <label for="unit" class="form-label">Unit #</label>
                                <input type="text" class="form-control" name="unit" id="unit" required>
                            </div>

                            <div class="mb-3  col-md-6" id="zipCodeField">
                                <label for="zipCode" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" name="zip" id="zipCode" required>
                            </div>

                            <div class="mb-3  col-md-6" id="cityField">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" name="city" id="city" required>
                            </div>

                            <div class="mb-3  col-md-6" id="businessNameField">
                                <label for="businessName" class="form-label">Business Name</label>
                                <input type="text" class="form-control" name="name" id="businessName">
                            </div>

                            <div class="mb-3  col-md-6" id="hotelNameField">
                                <label for="hotelName" class="form-label">Hotel Name</label>
                                <input type="text" class="form-control" name="name" id="hotelName">
                            </div>

                            <div class="mb-3  col-md-6" id="roomField">
                                <label for="room" class="form-label">Room #</label>
                                <input type="text" class="form-control" name="room" id="room">
                            </div>

                            <div class="mb-3  col-md-6" id="otherField">
                                <label for="other" class="form-label">Other Information</label>
                                <input type="text" class="form-control" id="other">
                            </div>

                            <div class="mb-3  col-md-6" id="stateField">
                                <label for="state" class="form-label">State</label>
                                <select class="form-control form-select" name="state_id" id="state">
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3  col-md-6" id="streetAddressField">
                                <label for="streetAddress" class="form-label" >Street Address</label>
                                <input type="text" class="form-control" id="streetAddress"  name="street_address" required>
                            </div>
                            <div class="mb-3  col-md-12" id="addressField">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">CONTINUE FOR DELIVERY</button>
                        </div>
                    </form>
                    <form class="mt-4 mx-5" action="{{ URL::to('/location/store') }}" method="post">
                        <!-- Carryout Fields -->
                        @csrf
                        <div id="carryout-fields" class="row d-none mx-5">
                            <input hidden name="type" value="carryout" >
                            <div class="mb-3 col-md-12">
                                <label for="zipCodeCarryout" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" id="zipCodeCarryout" name="zip" required>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="cityCarryout" class="form-label">City</label>
                                <input type="text" class="form-control" id="cityCarryout" name="city" required>
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="stateCarryout" class="form-label">State</label>
                                <select class="form-control  form-select" id="stateCarryout" name="state_id" required>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">FIND A STORE</button>
                        </div>
                    </form>
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
    <script>
        const deliveryCard = document.querySelector('.delivery-card');
        const carryoutCard = document.querySelector('.carryout-card');
        const urlParams = new URLSearchParams(window.location.search);
        const type = urlParams.get("type");


        function showDeliveryFields() {

            document.getElementById('delivery-fields').classList.remove('d-none');
            document.getElementById('carryout-fields').classList.add('d-none');
            deliveryCard.classList.add('bg-primary', 'text-white');
            carryoutCard.classList.remove('bg-primary', 'text-white');

        }

        // Function to show carryout fields
        function showCarryoutFields() {
            const carryoutFields = document.getElementById("carryout-fields");
            document.getElementById('carryout-fields').classList.remove('d-none');
            document.getElementById('delivery-fields').classList.add('d-none');
            carryoutCard.classList.add('bg-primary', 'text-white');
            deliveryCard.classList.remove('bg-primary', 'text-white');

            carryoutFields.querySelectorAll("input, select").forEach((field) => {
                if (field.hasAttribute("required")) {
                    field.setAttribute("data-required", "true"); // Track originally required fields
                }
            });
        }

        if (type === "Delivery") {
            showDeliveryFields();
        } else if (type === "Carryout") {
            showCarryoutFields();
        }else {
            showDeliveryFields();
        }

        const addressTypeFields = {
            House: ["streetAddress", "unit", "zipCode", "city", "state"],
            Apartment: ["apartmentName", "address", "unit", "zipCode", "city", "state"],
            Business: ["businessName", "address", "unit", "zipCode", "city", "state"],
            Hotel: ["hotelName", "address", "room", "zipCode", "city", "state"],
            Other: ["streetAddress", "unit", "zipCode", "city", "state"],
        };

        // Function to update fields based on selected address type
        function updateFields() {
            const selectedType = document.getElementById("addressType").value;

            // All field IDs
            const allFields = ["apartmentName", "streetAddress", "address", "unit", "zipCode", "city", "businessName", "hotelName", "room", "other"];
            const requiredFields = addressTypeFields[selectedType];

            allFields.forEach((fieldId) => {
                const fieldElement = document.getElementById(`${fieldId}Field`);
                const inputElement = document.getElementById(fieldId);

                if (requiredFields.includes(fieldId)) {
                    // Show the field and make it required
                    fieldElement.style.display = "block";
                    inputElement.setAttribute("required", "true");
                } else {
                    // Hide the field and remove the required attribute
                    fieldElement.style.display = "none";
                    inputElement.removeAttribute("required");
                }
            });
        }

        document.querySelector("form").addEventListener("submit", (event) => {
            const hiddenInputs = document.querySelectorAll("input[required]:not(:visible), select[required]:not(:visible)");
            hiddenInputs.forEach((input) => input.removeAttribute("required"));
        });

        // Initialize fields on page load
        document.addEventListener("DOMContentLoaded", updateFields);


        // Update fields dynamically on change
        document.getElementById("addressType").addEventListener("change", updateFields);
    </script>
@endsection
