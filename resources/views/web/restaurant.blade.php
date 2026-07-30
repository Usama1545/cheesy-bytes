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
    <section class="d-flex justify-content-center" >
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
                </div>
            </div>
            <div class="app-download-section py-5">
                <div class="container">
                    <div class="app-download-wrapper p-5">
                        <div class="row align-items-center">

                            <!-- Left Content -->
                            <div class="col-md-6 text-white">
                                <span class="badge bg-light text-danger mb-3">Download Our App</span>

                                <h2 class="fw-bold mb-3">
                                    Shop Smarter, Faster
                                </h2>

                                <p class="mb-4">
                                    Get exclusive deals, faster checkout, real-time order tracking and get $5 off on your first order.
                                    Download our app now and enjoy seamless shopping experience.
                                </p>

                                <div class="d-flex gap-3 flex-wrap">
                                    <a href="https://apps.apple.com/us/app/cheesy-bite/id6759533522" target="_blank">
                                        <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
                                            height="45" loading="lazy" decoding="async">
                                    </a>

                                    <a href="https://play.google.com/store/apps/details?id=com.rohailcheesybite.app" target="_blank">
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
                                            height="45" loading="lazy" decoding="async">
                                    </a>
                                </div>
                            </div>

                            <!-- Right Images -->
                            <div class="col-md-6 text-center mt-4 mt-md-0 app-phones">
                                <img src="{{ asset('web-assets/images/app1.jpg') }}" class="phone-img" loading="lazy" decoding="async">
                                <img src="{{ asset('web-assets/images/app2.jpg') }}" class="phone-img phone-center" loading="lazy" decoding="async">
                                <img src="{{ asset('web-assets/images/app3.jpg') }}" class="phone-img" loading="lazy" decoding="async">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
       
    </section>
   
    <style>
        .app-download-wrapper{
            /* background: linear-gradient(135deg,#0b1220,#1e2f47); linear-gradient(135deg, #ea0707, #D6B62B)*/
            background: linear-gradient(135deg, #D6B62B, #ea0707);
            border-radius: 16px;
        }

        .phone-img{
            height:320px;
            border-radius: .5rem;
            margin:0 6px;
        }

        .app-preview{
            max-height: 350px;
        }
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

        .app-phones{
            display:flex;
            justify-content:center;
            align-items:flex-end;
            flex-wrap:nowrap;
        }

        .phone-img{
            height:320px  !important;
            border-radius:.5rem;
            margin:0 6px;
        }

        .phone-center{
            height:360px !important;
        }

        /* Mobile */
        @media (max-width: 768px){

            .app-phones{
                flex-direction:row;
                gap:8px;
            }

            .phone-img{
                height:180px  !important;
                margin:0;
            }

            .phone-center{
                height:200px !important;
            }
        }
    </style>
    <script>
        function submitForm(formId) {
            document.getElementById(formId).submit();
        }
    </script>
@endsection
