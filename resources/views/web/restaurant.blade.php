@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.refund_policy') }}
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
                            aria-current="page">{{ trans('labels.about_us') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="d-flex justify-content-center" style="min-height: 100vh;">
        <div class="container my-5">
            <div class="card col-md-10 mx-auto">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">HOW DO YOU WANT YOUR DOMINO'S TODAY?</h5>

                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card border-primary" id="delivery-card" onclick="showDeliveryFields()">
                                <div class="card-body text-center">
                                    <h6 class="card-title"><i class="fas fa-cab" style="font-size: 20px;"></i> DELIVERY
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-primary" id="carryout-card" onclick="showCarryoutFields()">
                                <div class="card-body text-center">
                                    <h6 class="card-title"><i class="fas fa-hand-holding-box"
                                                              style="font-size: 20px;"></i> CARRYOUT</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form class="mt-4 mx-5">
                        <!-- Delivery Fields -->
                        <div id="delivery-fields" class="row d-none mx-5">
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
                                <label for="apartmentName" class="form-label">Apartment Name</label>
                                <input type="text" class="form-control" id="apartmentName">
                            </div>


                            <div class="mb-3  col-md-6" id="unitField">
                                <label for="unit" class="form-label">Unit #</label>
                                <input type="text" class="form-control" id="unit" required>
                            </div>

                            <div class="mb-3  col-md-6" id="zipCodeField">
                                <label for="zipCode" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" id="zipCode" required>
                            </div>

                            <div class="mb-3  col-md-6" id="cityField">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control" id="city" required>
                            </div>

                            <div class="mb-3  col-md-6" id="businessNameField">
                                <label for="businessName" class="form-label">Business Name</label>
                                <input type="text" class="form-control" id="businessName">
                            </div>

                            <div class="mb-3  col-md-6" id="hotelNameField">
                                <label for="hotelName" class="form-label">Hotel Name</label>
                                <input type="text" class="form-control" id="hotelName">
                            </div>

                            <div class="mb-3  col-md-6" id="roomField">
                                <label for="room" class="form-label">Room #</label>
                                <input type="text" class="form-control" id="room">
                            </div>

                            <div class="mb-3  col-md-6" id="otherField">
                                <label for="other" class="form-label">Other Information</label>
                                <input type="text" class="form-control" id="other">
                            </div>

                            <div class="mb-3  col-md-6" id="stateField">
                                <label for="state" class="form-label">State</label>
                                <select class="form-control form-select" id="state">
                                    <option value="NY">NY</option>
                                    <option value="CA">CA</option>
                                    <option value="TX">TX</option>
                                </select>
                            </div>

                            <div class="mb-3  col-md-6" id="streetAddressField">
                                <label for="streetAddress" class="form-label">Street Address</label>
                                <input type="text" class="form-control" id="streetAddress" required>
                            </div>
                            <div class="mb-3  col-md-12" id="addressField">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">CONTINUE FOR DELIVERY</button>
                        </div>

                        <!-- Carryout Fields -->
                        <div id="carryout-fields" class="row d-none mx-5">
                            <div class="mb-3 col-md-4">
                                <label for="zipCodeCarryout" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control" id="zipCodeCarryout" required>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="cityCarryout" class="form-label">City</label>
                                <input type="text" class="form-control" id="cityCarryout" required>
                            </div>

                            <div class="mb-3 col-md-4">
                                <label for="stateCarryout" class="form-label">State</label>
                                <select class="form-control  form-select" id="stateCarryout" required>
                                    <option value="NY">NY</option>
                                    <option value="CA">CA</option>
                                    <option value="TX">TX</option>
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
            font-size: 10px;
        }
    </style>
    <script>
        function showDeliveryFields() {
            document.getElementById('delivery-fields').classList.remove('d-none');
            document.getElementById('carryout-fields').classList.add('d-none');
        }

        // Function to show carryout fields
        function showCarryoutFields() {
            document.getElementById('carryout-fields').classList.remove('d-none');
            document.getElementById('delivery-fields').classList.add('d-none');
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

            // Get all field IDs
            const allFields = ["apartmentName", "streetAddress", "address", "unit", "zipCode", "city", "businessName", "hotelName", "room", "other"];

            // Fields required for the selected type
            const requiredFields = addressTypeFields[selectedType];

            // Loop through all fields and update visibility/required status
            allFields.forEach((fieldId) => {
                const fieldElement = document.getElementById(`${fieldId}Field`);
                const inputElement = document.getElementById(fieldId);

                if (requiredFields.includes(fieldId)) {
                    fieldElement.style.display = "block"; // Show field
                    inputElement.setAttribute("required", "true");
                } else {
                    fieldElement.style.display = "none"; // Hide field
                    inputElement.removeAttribute("required");
                }
            });
        }

        // Initialize fields on page load
        document.addEventListener("DOMContentLoaded", updateFields);
    </script>
@endsection
