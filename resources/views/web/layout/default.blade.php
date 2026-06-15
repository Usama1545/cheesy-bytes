<!doctype html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">
@php
    use Illuminate\Support\Facades\Request;
    $branchSlug = Request::segment(1); // Gets the first segment from the URL
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="google-site-verification" content="43RMDsT_Hodd4oCijCAfZfVpciJDOlJDYCYukBckGN8"   />
    <meta property="og:title" content="{{ @helper::appdata()->og_title }}" />
    <meta property="og:description" content="{{ @helper::appdata()->og_description }}" />
    <meta property="og:image" content='{{ helper::image_path(@helper::appdata()->og_image) }}' />
    <title>@yield('page_title') {{ @helper::appdata()->title }}</title>
    <meta name="description" content="@yield('meta_description')">
    <link rel="icon" href="{{ helper::image_path(@helper::appdata()->favicon) }}"><!-- Favicon -->
    <link rel="canonical" href="{{ rtrim(url()->current(), '/') }}/" />
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/bootstrap.min.css') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/owl_carousel/owl.carousel.min.css') }}">
    <!-- owl-carousel css -->
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/owl_carousel/owl.theme.default.min.css') }}">
    <!-- owl-carousel css -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/font_awesome/all.css') }}">
    <!-- Font Awesome CSS -->
    <!-- COMMON-CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/toastr/toastr.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet"
        href="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/css/sweetalert/sweetalert2.min.css') }}">
    <!-- Sweetalert CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/style.css') }}"><!-- Custom CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/responsive.css') }}">
    <!-- Media Query Resposive CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/fancybox/fancybox-v4-0-27.css') }}">
    <!-- Fancybox 4.0 CSS -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/animate.min.css') }}">
    <!-- home banner animation CSS -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Google tag (gtag.js) -->
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '2425470157809730');
        fbq('init', '714068061098147');
        fbq('track', 'PageView');
    </script>
    <script>
        (function(h, o, t, j, a, r) {
            h.hj = h.hj || function() {
                (h.hj.q = h.hj.q || []).push(arguments)
            };
            h._hjSettings = {
                hjid: 6405025,
                hjsv: 6
            };
            a = o.getElementsByTagName('head')[0];
            r = o.createElement('script');
            r.async = 1;
            r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
            a.appendChild(r);
        })(window, document, 'https://static.hotjar.com/c/hotjar-', '.js?sv=');
    </script>
    <!-- End Meta Pixel Code -->
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=714068061098147&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
<meta name="google-site-verification" content="JMp4fvFTm4an5uvdb7-AKDhAV9AVFm_RbYVPc4V3DnU">

    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=2425470157809730&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    @foreach (@helper::getScripts() as $script)
        {!! $script->script !!}
    @endforeach


    <!-- PWA -->
    @if (@helper::checkaddons('pwa'))
        @if (helper::appdata()->pwa == 1)
            @include('web.pwa.pwa')
        @endif
    @endif
    <style>
        :root {
            --bs-primary: {{ helper::appdata()->web_primary_color != null ? helper::appdata()->web_primary_color : '#F82647' }};
            --bs-secondary: {{ helper::appdata()->web_secondary_color != null ? helper::appdata()->web_secondary_color : '#FFC344' }};
        }
    </style>
    @yield('styles')
</head>

<body>
    <main id="main-content" class="">
        <div class="wrapper">
            <input type="hidden" name="hdnsession" id="hdnsession" value="{{ session()->get('direction') }}">
            @include('web.layout.header')
            <div class="content-wrapper">
                @yield('content')
                @include('web.layout.footer')
            </div>

            @if (!request()->is('cart') && !request()->is('checkout'))
                @if (helper::get_user_cart() != 0)
                    <div class="cart-modal rounded-bottom-0" id="cart-timer">
                        <div class="rounded-lg">
                            <div class="d-flex gap-3 justify-content-between align-items-center">
                                <p class="mb-0 text-white fs-7 fw-600 d-flex align-items-center gap-1">
                                    <span class="count">{{ helper::get_user_cart() }}</span>
                                    {{ trans('labels.item_added') }}
                                </p>
                                <a href="{{ helper::branch_route('cart') }}"
                                    class="text-white fw-500 fs-7 text-uppercase">
                                    {{ trans('labels.view') }} {{ trans('labels.cart') }}
                                    <i class="fa-solid fa-bag-shopping ps-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            @endif



            {{-- cookie modal --}}
            @include('cookie-consent::index')

        </div>
    </main>

    <!-- Modal Item Details -->
    <div class="modal modalitemdetails" id="modalitemdetails" tabindex="-1" style="z-index: 1052"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" id="modalitem_body">
            </div>
        </div>
    </div>

    <!-- All modals here -->

    <!-- Product Allergens Modal -->
    <div class="modal" id="itemallergens" tabindex="-1" aria-labelledby="itemallergensTitle" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h1 class="modal-title fs-5" id="itemallergensTitle">{{ trans('labels.allergens') }}</h1>
                    <button type="button" class="btn-close {{ session()->get('direction') == '2' ? 'm-0' : '' }}"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-0" id="allergensDisplay"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                        data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Deals Mix and Match model -->
    <div class="modal" id="DealModal" tabindex="-1" style="z-index: 1051" data-bs-keyboard="false"
        data-bs-backdrop="static" aria-labelledby="DealModelTitle" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h1 class="modal-title fs-5" id="itemDealTitle"></h1>
                    <button type="button" class="btn-close {{ session()->get('direction') == '2' ? 'm-0' : '' }}"
                        data-bs-dismiss="modal" aria-label="Close" id="DealClose"></button>
                </div>
                <div class="modal-body">
                    <div class="item-list"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="PizzaModal" tabindex="-1" style="z-index: 1052" aria-labelledby="PizzaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="PizzaModalLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-7 border-end">
                        <!-- Size Selection -->
                        <div class="card mb-3">
                            <div class="card-header" style="background: #D6B62B">Select Size</div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between flex-wrap gap-2 mx-5"
                                    id="pizzaSizesContainer">
                                    <!-- Dynamically loaded sizes will go here -->
                                </div>
                                <hr>
                                <div class="card-body d-flex flex-wrap gap-2" id="pizzaCrustContainer">
                                    <!-- Dynamically loaded crusts will go here -->
                                </div>
                            </div>
                        </div>
                        <!-- Crust Selection -->
                        <div id="pizzaExtrasContainer"></div>

                        <div id="pizzaAddonsContainer"></div>

                        <!--<div class="card mb-3">-->
                        <!--    <div class="card-header" style="background: #D6B62B">Select Dipping Sause</div>-->
                        <!--    <div class="card-body">-->
                        <!--        @foreach (helper::getSides() as $dipping)
-->
                        <!--            <div class="d-flex align-items-center gap-3 mb-3 pizza-dipping-item"-->
                        <!--                 data-name="{{ $dipping->name }}"-->
                        <!--                 data-price="{{ $dipping->price }}"-->
                        <!--                 data-id="{{ $dipping->id }}">-->
                        <!-- Dipping Image -->
                        <!--                <img src="{{ helper::image_path($dipping->image) }}"-->
                        <!--                     alt="Dipping Sauce"-->
                        <!--                     class="img-fluid rounded h-70px"-->
                        <!--                     style="object-fit: fill;width:40px;height:40px">-->

                        <!-- Dipping Name -->
                        <!--                <span class="flex-grow-1 text-sm">{{ $dipping->name }}</span>-->

                        <!-- Quantity Controls -->
                        <!--                <div class="d-flex align-items-center ms-auto">-->
                        <!-- Decrease Button -->
                        <!--                    <button data-action="decrease"-->
                        <!--                            class="btn btn-secondary bg-gray rounded-circle d-flex justify-content-center align-items-center"-->
                        <!--                            style="width: 40px; height: 40px; font-size: 1.2rem; background: #a8a7a7; border-color: gray;">-->
                        <!--                        --->
                        <!--                    </button>-->

                        <!-- Quantity Display -->
                        <!--                    <span class="fw-semibold mx-3 quantity"-->
                        <!--                          style="min-width: 30px; text-align: center;">0</span>-->

                        <!-- Increase Button -->
                        <!--                    <button data-action="increase"-->
                        <!--                            class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"-->
                        <!--                            style="width: 40px; height: 40px; font-size: 1.2rem;">-->
                        <!--                        +-->
                        <!--                    </button>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--
@endforeach-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>

                    <!-- Sauce Selection -->
                    <div class="col-md-5">
                        <div id="myPizzaCard">
                            <div class="card mb-3">
                                <div class="card-header" id="PizzaModalLabel" style="background: #D6B62B">My Pizza
                                </div>
                                <div class="card-body">
                                    <div id="MyPizzaSummary" class="pizza-summary"></div>
                                    <hr style="margin: 10px 0; border: 1px solid #ddd;">
                                    <div class="d-flex align-items-center gap-3" style="font-size: 0.800rem;">
                                        <span class="">Quantity:</span>
                                        <button data-action="decrease_pizza_quantity"
                                            class="btn btn-secondary rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px; font-size: 1.5rem;background: #a8a7a7; border-color: gray;">
                                            -
                                        </button>
                                        <span id="overall-pizza-quantity" class="fw-semibold"
                                            style="min-width: 30px; text-align: center;">1</span>
                                        <button data-action="increase_pizza_quantity"
                                            class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                            style="width: 40px; height: 40px; font-size: 1.5rem;">
                                            +
                                        </button>
                                    </div>
                                    <button id="addToCartButton" class="btn btn-primary mt-3"
                                        style="width: 100%;font-size: 15px">Add To Cart
                                    </button>
                                </div>
                            </div>
                            <div id="img-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="customPizzaModal" tabindex="-1" aria-labelledby="customPizzaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="customPizzaModalLabel">Customize Your Pizza</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="col-md-7 border-end">
                        <!-- Size Selection -->
                        <div class="card mb-3">
                            <div class="card-header" style="background: #D6B62B">Select Size</div>
                            <div class="card-body">
                                <div class="d-flex justify-content-center flex-wrap gap-5 mx-5" id="sizeContainer">
                                    <!-- Sizes will be loaded here -->
                                </div>
                                <hr>
                                <div class="card-body row" id="crustContainer"></div>
                            </div>
                        </div>
                        <!-- Crust Selection -->

                        <!-- Topping Selection -->
                        <div class="card mb-3">
                            <div class="card-header" style="background: #D6B62B">Select Toppings</div>
                            <div class="card-body">
                                <div class="topping-grid" id="toppingContainer"></div>
                            </div>
                        </div>

                        <!-- Sauce Selection -->
                        <div class="card mb-3">
                            <div class="card-header" style="background: #D6B62B">Extra Toppings</div>
                            <div class="card-body">
                                <div class="topping-grid" id="sauceContainer"></div>
                            </div>
                        </div>


                        <!-- Dipping Selection -->
                        <!--<div class="card mb-3">-->
                        <!--    <div class="card-header" style="background: #D6B62B">Select Dipping Sause</div>-->
                        <!--    <div class="card-body">-->
                        <!--        @foreach (helper::getSides() as $dipping)
-->
                        <!--            <div class="d-flex align-items-center gap-3 mb-3 dipping-item"-->
                        <!--                 data-name="{{ $dipping->name }}">-->
                        <!-- Dipping Image -->
                        <!--                <img src="{{ helper::image_path($dipping->image) }}"-->
                        <!--                     alt="Dipping Sauce"-->
                        <!--                     class="img-fluid rounded h-70px"-->

                        <!--                     style="object-fit: fill;width: 40px;height: 40px">-->

                        <!-- Dipping Name -->
                        <!--                <span class="flex-grow-1 text-sm">{{ $dipping->name }}</span>-->

                        <!-- Quantity Controls -->
                        <!--                <div class="d-flex align-items-center ms-auto">-->
                        <!-- Decrease Button -->
                        <!--                    <button data-action="decrease"-->
                        <!--                            class="btn btn-secondary bg-gray rounded-circle d-flex justify-content-center align-items-center"-->
                        <!--                            style="width: 40px; height: 40px; font-size: 1.2rem; background: #a8a7a7; border-color: gray;">-->
                        <!--                        --->
                        <!--                    </button>-->

                        <!-- Quantity Display -->
                        <!--                    <span class="fw-semibold mx-3 quantity"-->
                        <!--                          style="min-width: 30px; text-align: center;">0</span>-->

                        <!-- Increase Button -->
                        <!--                    <button data-action="increase"-->
                        <!--                            class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"-->
                        <!--                            style="width: 40px; height: 40px; font-size: 1.2rem;">-->
                        <!--                        +-->
                        <!--                    </button>-->
                        <!--                </div>-->
                        <!--            </div>-->
                        <!--
@endforeach-->
                        <!--    </div>-->
                        <!--</div>-->

                        <!-- Special Selection -->

                        <div class="card mb-3 d-none">
                            <div class="card-header" style="background: #D6B62B">Special Instructions</div>
                            <div class="card-body">
                                <div class="row col-12" style="">
                                    <!-- Bake Options -->
                                    <div class="col-12 col-md-3" style="border-right: 1px solid #cccaca">
                                        <h6>BAKE</h6>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="bake" class="form-check-input"
                                                    value="well-done">
                                                Well Done
                                            </label>
                                        </div>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="bake" class="form-check-input"
                                                    value="normal-bake" checked>
                                                Normal Bake
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Seasoning Options -->
                                    <div class="col-12 col-md-5" style="border-right: 1px solid #cccaca">
                                        <h6>SEASONING</h6>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="seasoning" class="form-check-input"
                                                    value="garlic-seasoned-crust" checked>
                                                Garlic-Seasoned Crust
                                            </label>
                                        </div>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="seasoning" class="form-check-input"
                                                    value="no-garlic-seasoned-crust">
                                                No Garlic-Seasoned Crust
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Cut Options -->
                                    <div class="col-12 col-md-4">
                                        <h6>CUT</h6>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="cut" class="form-check-input"
                                                    value="pie-cut" checked>
                                                Pie Cut
                                            </label>
                                        </div>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="cut" class="form-check-input"
                                                    value="square-cut">
                                                Square Cut
                                            </label>
                                        </div>
                                        <div>
                                            <label class="text-sm" style="font-size: 11px">
                                                <input type="radio" name="cut" class="form-check-input"
                                                    value="uncut">
                                                Uncut
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-5">
                        <div class="card mb-3" id="myPizzaCard">
                            <div class="card-header" style="background: #D6B62B">My Pizza</div>
                            <div class="card-body">
                                <div id="PizzaSummary" class="pizza-summary"></div>
                                <hr style="margin: 10px 0; border: 1px solid #ddd;">
                                <div class="d-flex align-items-center gap-3" style="font-size: 0.800rem;">
                                    <span class="">Quantity:</span>
                                    <button data-action="decrease_quantity"
                                        class="btn btn-secondary rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 40px; height: 40px; font-size: 1.5rem;background: #a8a7a7; border-color: gray;">
                                        -
                                    </button>
                                    <span id="overall-quantity" class="fw-semibold"
                                        style="min-width: 30px; text-align: center;">1</span>
                                    <button data-action="increase_quantity"
                                        class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                        style="width: 40px; height: 40px; font-size: 1.5rem;">
                                        +
                                    </button>
                                </div>
                                <button id="submit-quantity" class="btn btn-primary mt-3"
                                    style="width: 100%;font-size: 15px">Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="errorAlert" class="alert alert-danger d-none" role="alert">
        A simple danger alert—check it out!
    </div>
    <!-- Modal Subscribe-->
    <div class="modal" id="NewsModal" tabindex="-1" aria-labelledby="NewsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="modal-body p-0 position-relative">
                    <button type="button"
                        class="btn-close box-shadow-none {{ session()->get('direction') == '2' ? 'rtl' : '' }}"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="row g-0 align-items-center justify-content-between">
                        <div class="col-6 d-none d-lg-block">
                            <img src="{{ helper::image_path(@helper::appdata()->subscribe_newsletter_image) }}"
                                alt="" class="w-100 object-fit-cover newslatter-img">
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="py-5 px-4 px-sm-5">
                                <h2 class="subscribe-title mt-1">{{ trans('labels.newsletter') }}</h2>
                                <p class="text-dark fw-500 fs-7 mb-4">
                                    {{ trans('labels.subscribe_title') }}
                                </p>
                                <form method="post" action="{{ route('subscribe') }}">
                                    @csrf
                                    <label class="text-black form-label fs-7 mb-1">{{ trans('labels.email') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="email" class="form-control border text-dark fw-500 bg-light"
                                            name="subscribe_email" placeholder="{{ trans('labels.email') }}"
                                            required="">
                                    </div>
                                    <button type="submit"
                                        class="btn btn-secondary w-100 py-2">{{ trans('labels.subscribe') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (@helper::checkaddons('age_verification'))
        @include('web.age_modal')
    @endif
    @if (@helper::checkaddons('sales_notification'))
        @include('web.sales_notification')
    @endif

    <!-- Quick call -->
    {{--    @if (@helper::checkaddons('quick_call')) --}}
    {{--        @if (@helper::appdata()->quick_call == 1) --}}
    {{--        @include('web.quick_call') --}}
    {{--        @endif --}}
    {{--    @endif --}}


    <!-- MODAL_working_hours--START -->
    <div class="modal" id="modal_working_hours" tabindex="-1" aria-labelledby="working_hours_Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="working_hours_Label">{{ trans('labels.working_hours') }}</h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        @foreach (helper::gettime() as $time)
                            <li class="list-group-item d-flex justify-content-between fs-7"> {{ ucfirst($time->day) }}
                                @if ($time->always_close == 1)
                                    <span class="text-danger fs-6">{{ trans('labels.closing_time') }}</span>
                                @else
                                    <span>{{ $time->open_time }} <b>{{ trans('labels.to') }}</b>
                                        {{ $time->break_start }}
                                        <br>
                                        {{ $time->break_end }} <b>{{ trans('labels.to') }}</b>
                                        {{ $time->close_time }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-4 py-2"
                        data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL_working_hours--END -->

    <!-- MODAL_USER_TYPE_SELECTION--START -->
    <div class="modal" id="useroption" tabindex="-1" aria-labelledby="useroptionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="useroptionLabel">
                        {{ trans('labels.proceed_as_guest_or_login') }}
                    </h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="fs-7 twoline">
                        {{ trans('labels.dont_have_account_guest') }}
                    </p>
                    <div class="row g-2 justify-content-start social-share-icon mt-3">
                        <div class="col-md-6 col-12">
                            <a class="btn btn-outline-dark w-100 p-2" href="/login"
                                type="button">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="px-2">{{ trans('labels.create_account') }}</span>
                            </a>
                        </div>
                        <div class="col-md-6 col-12">
                            <a class="btn btn-primary w-100 p-2" target="_blank" href="/checkout?buynow=0">
                                <i class="fa-solid fa-address-card"></i>
                                <span class="px-2">{{ trans('labels.continue_as_guest') }}</span>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- MODAL_USER_TYPE_SELECTION--END -->

    <!-- ADD_REVIEW_ODAL_START -->
    <div class="modal" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h4 class="modal-title fw-bold" id="reviewmodalLabel">
                        {{ trans('labels.add_review') }}</h4>
                    <button type="button" class="btn-close {{ session()->get('direction') == 2 ? 'close' : '' }}"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ URL::to('/add-review') }}" method="POST" class="mb-0">
                    @csrf
                    <div class="modal-body">
                        <div class="form-body">
                            <div class="form-group col-lg-12">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="review-modal-img">
                                        <img src="" class="h-100 w-100 object-fit-cover rounded-4 border" />
                                    </div>
                                    <p class="fw-600 mb-0" id="data-item-name"></p>
                                </div>
                                <div class="star-rating">
                                    @for ($i = 5; $i > 0; $i = $i - 1)
                                        <input type="radio" id="{{ $i }}" name="rating"
                                            onclick="$('#ratting').val('{{ $i }}')"
                                            {{ $i == 1 ? 'checked' : '' }}>
                                        <label for="{{ $i }}"><i class="fa-solid fa-star fs-4"
                                                aria-hidden="true"></i></label>
                                    @endfor
                                </div>
                                <input type="hidden" name="ratting" id="ratting" value="1">
                            </div>
                            <div class="mt-3">
                                <label for="form-label"><span class="fs-7">{{ trans('labels.write_review') }}
                                        ({{ trans('labels.optional') }})</span></label>
                                <textarea name="comment" rows="2" class="form-control mt-1" placeholder="Message"></textarea>
                            </div>
                            <input type="hidden" name="item_id" id="data-item-id" value="">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <div class="row g-2 w-100">
                            <div class="col-sm-6">
                                <button type="button" class="btn btn-outline-danger px-4 fs-7 w-100"
                                    data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit"
                                    class="btn btn-primary px-4 fs-7 w-100">{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- ADD_REVIEW_ODAL_END -->


    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/jquery/jquery-3.6.0.js') }}"></script>
    <!-- jQuery JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/owl_carousel/owl.carousel.js') }}"></script>
    <!-- owl carousel js -->
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <!-- COMMON-FOR-TOASTER-&-SWEETALERT -->
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/toastr/toastr.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'admin-assets/assets/js/sweetalert/sweetalert2.min.js') }}"></script>
    <!-- Sweetalert JS -->
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/fancybox/fancybox-v4-0-27.js') }}"></script>
    <!-- Fancybox 4.0 JS -->
    <script>
        const roundButtons = document.querySelectorAll('.round-button');

        // Add event listeners to toggle the selected state
        roundButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove the 'selected' class from all buttons
                roundButtons.forEach(btn => btn.classList.remove('selected'));

                // Add the 'selected' class to the clicked button
                button.classList.add('selected');
            });
        });

        document.querySelectorAll('.circle').forEach(circle => {
            circle.addEventListener('click', function() {
                circle.classList.toggle('filled');
            });
        });


        function updateOverallQuantity(change) {
            const quantityDisplay = document.getElementById('overall-quantity');
            let currentQuantity = parseInt(quantityDisplay.textContent, 10);
            // console.log(currentQuantity);
            currentQuantity = Math.max(1, currentQuantity + change); // Ensure the quantity is at least 1
            quantityDisplay.textContent = currentQuantity;
            document.getElementById('overall-quantity').textContent = currentQuantity;
        }


        document.addEventListener('DOMContentLoaded', function() {
            var customPizzaModal = document.getElementById("customPizzaModal");
            customPizzaModal.addEventListener("show.bs.modal", function(event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var selectedPizzaSize = button.getAttribute("data-bs-size"); // Get size
                fetchSizes(selectedPizzaSize); // Send size to backend
            });
            const sizeContainer = document.getElementById('sizeContainer');
            const crustContainer = document.getElementById('crustContainer');
            const toppingContainer = document.getElementById('toppingContainer');
            const sauceContainer = document.getElementById('sauceContainer');
            const quantityValue = document.getElementById('overall-quantity');
            const decreaseButton = document.querySelector('button[data-action="decrease"]');
            const increaseButton = document.querySelector('button[data-action="increase"]');
            const decreaseQuantityButton = document.querySelector('button[data-action="decrease_quantity"]');
            const increaseQuantityButton = document.querySelector('button[data-action="increase_quantity"]');
            const submitButton = document.getElementById('submit-quantity');
            const dippingItems = document.querySelectorAll('.dipping-item');
            const selectedDippingsElement = document.getElementById('selected-dippings');
            const selectedDippings = {};
            let dippingsArray = [];
            let bake = '';
            let cut = '';
            let seasoning = '';
            let dippingName = '';

            let quantity = 1;
            let pizzaQuantity = 1;

            function updateQuantityDisplay() {
                quantityValue.textContent = pizzaQuantity;
            }

            // increaseButton.addEventListener('click', () => {
            //     quantity++;
            //     updateQuantityDisplay();
            // });

            increaseQuantityButton.addEventListener('click', () => {
                pizzaQuantity++;
                updateQuantityDisplay();
            });

            // decreaseButton.addEventListener('click', () => {
            //     if (quantity > 1) {
            //         quantity--;
            //         updateQuantityDisplay();
            //     }
            // });
            decreaseQuantityButton.addEventListener('click', () => {
                if (pizzaQuantity > 1) {
                    pizzaQuantity--;
                    updateQuantityDisplay();
                }
            });

            submitButton.addEventListener('click', () => {
                const payload = {
                    size: selectedSize,
                    crust: selectedCrusts,
                    toppings: selectedToppings,
                    sauce: selectedSauces,
                    quantity: pizzaQuantity,
                    bake: bake,
                    cut: cut,
                    seasoning: seasoning,
                    selectedDippings: dippingsArray
                };

                fetch('/create-pizza', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'customPizzaModal'));
                        if (modal) {
                            modal.hide();
                        }
                        window.location.reload();
                    })
                    .catch(error => {
                        const alert = document.getElementById("errorAlert");
                        alert.textContent = "Error submitting order: " + error.message;
                        alert.classList.remove("d-none");
                    });
            });

            updateQuantityDisplay();


            let selectedToppings = [];
            let selectedCrusts = null;
            let selectedSauces = [];

            let allCrusts = [];
            let allToppings = [];
            let allSauces = [];
            let selectedSize = null;

            // Fetch all options on page load
            function fetchOptions() {
                // Promise.all([
                //         fetch('/getCrusts').then(res => res.json()),
                //         fetch('/getToppings').then(res => res.json()),
                //         fetch('/getSauces').then(res => res.json()),
                //     ])
                //     .then(([crusts, toppings, sauces]) => {
                //         allCrusts = crusts;
                //         allToppings = toppings;
                //         allSauces = sauces;
                //         displayOptions(); // Initially empty until size is selected
                //         // Initially empty until size is selected
                //         autoSelectFirstCrust();
                //     })
                //     .catch(error => toastr.error('Error fetching options:', error));
            }

            function autoSelectFirstCrust() {
                const firstSize = crustContainer.querySelector('.crust-checkbox');
                if (firstSize) {
                    firstSize.click();
                }
            }

            // Display options based on the selected size
            function displayOptions() {
                if (!selectedSize) return;

                selectedSauces = [];
                selectedCrusts = null;
                selectedToppings = [];
                // Filter and display crusts
                displayCrusts();

                // Filter and display toppings
                displayToppings();
                // Filter and display sauces
                displaySauces();
            }

            function fetchSizes(size) {
                fetch("{{ route('get.pizza.sizes') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        },
                        body: JSON.stringify({
                            size: size
                        }) // Send selected size
                    })
                    .then(response => response.json())
                    .then(data => {
                        let sizeContainer = document.getElementById("sizeContainer");
                        sizeContainer.innerHTML = ""; // Clear previous sizes

                        data.sizes.forEach(size => {
                            let button = document.createElement("button");
                            button.className = "btn round-button size-btn";
                            button.setAttribute("data-size-id", size.id);
                            button.setAttribute("data-label", size.label);
                            button.setAttribute("data-price", size.price);
                            button.innerText = size.name;

                            sizeContainer.appendChild(button);
                        });

                        // Now that sizes are appended, auto-select the first one
                        autoSelectFirstSize();
                    })
                    .catch(error => toastr.error("Error fetching sizes:", error));
            }

            function autoSelectFirstSize() {
                const firstSize = document.querySelector('#sizeContainer .size-btn'); // Get first size button
                if (firstSize) {
                    firstSize.click(); // Simulate a click
                }
            }


            function displayCrusts() {
                crustContainer.innerHTML = ''; // Clear crust container
                // console.log(selectedSize);
                const filteredCrusts = allCrusts.filter(crust =>
                    String(crust.size_id) === String(selectedSize.id)
                );

                filteredCrusts.forEach(crust => {
                    const label = document.createElement('label');
                    label.className = 'form-check-label d-block col-md-6 mt-1 col-sm-12';
                    label.innerHTML = `
            <input
                type="radio"
                name="crust"
                class="form-check-input crust-checkbox"
                data-crust-id="${crust.id}"
                data-price="${crust.price}"
            />
             <span>${crust.name}</span>
        <!-- <div class="text-muted small mx-4">${crust.description}</div> Added description -->

        `;
                    label.querySelector('input').addEventListener('change', () => selectCrust(crust));
                    crustContainer.appendChild(label);
                });
                autoSelectFirstCrust();
            }

            function displayToppings() {
                toppingContainer.innerHTML = ''; // Clear toppings container
                const filteredToppings = allToppings.filter(topping =>
                    String(topping.size_id) === String(selectedSize.id)
                );

                filteredToppings.forEach(topping => {
                    const label = document.createElement('label');
                    label.className = 'form-check-label d-block text-sm';
                    label.innerHTML = `
            <input
                type="checkbox"
                class="form-check-input topping-checkbox"
                data-topping-id="${topping.id}"
                data-price="${topping.price}"
            />
            ${topping.name} ($${topping.price})
            <div class="topping-options" style="display: none; margin-top: 10px;">
                <div class="form-group justify-content-between">
                    <div class="btn-group" role="group" data-topping-id="${topping.id}">
                        <div class="pizza-topping">
                            <!-- Left -->
                            <label data-quid="topping-portion-C-1/2-left" class="pizza-topping__part pizza-topping__part--left">
                                <input aria-label="Cheese on left side" data-part="left" name="Part|${topping.id}" hidden type="radio" value="1/2">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                                </svg>
                                <span class="pizza-topping__label">Left</span>
                            </label>

                            <!-- Full -->
                            <label data-quid="topping-portion-C-full" class="pizza-topping__part pizza-topping__part--full">
                                <input aria-label="Cheese on full pizza" data-part="full" name="Part|${topping.id}" hidden type="radio" value="1">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <circle cx="12.5" cy="12" r="10"></circle>
                                </svg>
                                <span class="pizza-topping__label">Full</span>
                            </label>

                            <!-- Right -->
                            <label data-quid="topping-portion-C-1/2-right" class="pizza-topping__part pizza-topping__part--right">
                                <input aria-label="Cheese on right side" data-part="right" name="Part|${topping.id}" hidden type="radio" value="1/2">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                                </svg>
                                <span class="pizza-topping__label">Right</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 justify-content-between">
                    <div class="btn-group" role="group" data-topping-id="${topping.id}">
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="none">None</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="light">Light</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="normal">Normal</button>
                        <!--  <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="extra">Extra</button>-->
                    </div>
                </div>
            </div>
        `;

                    const input = label.querySelector('input.topping-checkbox');
                    const optionsContainer = label.querySelector('.topping-options');
                    const sideInputs = label.querySelectorAll('[data-part]');
                    const quantityButtons = label.querySelectorAll('.quantity-btn');

                    // Handle topping checkbox toggle
                    input.addEventListener('change', (event) => {
                        const isChecked = event.target.checked;
                        optionsContainer.style.display = isChecked ? 'block' : 'none';
                        if (!isChecked) {
                            const index = selectedToppings.findIndex(t => t.topping_id === topping
                                .id);
                            if (index > -1) {
                                selectedToppings.splice(index, 1);
                            }
                            label.querySelectorAll('[data-part]').forEach(input => input.checked =
                                false);
                            label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList
                                .add('btn-outline-primary'));
                            label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList
                                .remove('btn-primary'));

                            renderPizzaSummary();

                        } else {
                            selectedToppings.push({
                                topping_id: topping.id,
                                topping_name: topping.name,
                                side: null,
                                quantity: null
                            }); // Initialize if checked
                            clearOtherToppingOptions(topping.id);
                        }
                    });

                    sideInputs.forEach(sideInput => {
                        sideInput.addEventListener('change', () => {
                            const selectedSide = label.querySelector(
                                'input[name="Part|' + topping.id + '"]:checked'
                            )?.dataset.part || null;
                            updateToppingSelection(topping.id, topping.name, selectedSide,
                                undefined);
                        });
                    });

                    quantityButtons.forEach(button => {
                        button.addEventListener('click', (event) => {
                            updateButtonGroup(button, 'quantity-btn');
                            const selectedQuantity = button.dataset.quantity;
                            updateToppingSelection(topping.id, topping.name, undefined,
                                selectedQuantity);
                        });
                    });

                    toppingContainer.appendChild(label);
                });
            }

            function clearOtherToppingOptions(selectedToppingId) {
                const allOptions = document.querySelectorAll('.topping-options');
                allOptions.forEach(options => {
                    const toppingId = options.querySelector('.side-btn')?.closest('.form-group').dataset
                        .toppingId;
                    if (toppingId && toppingId !== String(selectedToppingId)) {
                        options.style.display = 'none';
                        const input = document.querySelector(
                            `.topping-checkbox[data-topping-id="${toppingId}"]`);
                        if (input) input.checked = false; // Uncheck the other topping
                    }
                });
            }

            function updateToppingSelection(toppingId, toppingName, side, quantity) {
                const index = selectedToppings.findIndex(t => t.topping_id === toppingId);

                if (index === -1) {
                    // Add a new topping if it doesn't exist
                    selectedToppings.push({
                        topping_id: toppingId || null,
                        topping_name: toppingName || null,
                        side: side || null,
                        quantity: quantity || null
                    });
                } else {
                    // Update the existing topping's values
                    if (side !== undefined) {
                        selectedToppings[index].side = side;
                    }
                    if (quantity !== undefined) {
                        selectedToppings[index].quantity = quantity;
                    }
                }
                renderPizzaSummary();
            }

            function displaySauces() {
                sauceContainer.innerHTML = ''; // Clear sauces container
                const filteredToppings = allSauces.filter(sauce =>
                    String(sauce.size_id) === String(selectedSize.id)
                );

                filteredToppings.forEach(topping => {
                    const label = document.createElement('label');
                    label.className = 'form-check-label d-block text-sm';
                    label.innerHTML = `
            <input
                type="checkbox"
                class="form-check-input topping-checkbox"
                data-topping-id="${topping.id}"
                data-price="${topping.price}"
            />
            ${topping.name} ($${topping.price})
            <div class="topping-options" style="display: none; margin-top: 10px;">
                <div class="form-group justify-content-between">
                    <div class="btn-group" role="group" data-topping-id="${topping.id}">
                        <div class="pizza-topping">
                            <!-- Left -->
                            <label data-quid="topping-portion-C-1/2-left" class="pizza-topping__part pizza-topping__part--left">
                                <input aria-label="Cheese on left side" data-part="left" name="Part|${topping.id}" hidden type="radio" value="1/2">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                                </svg>
                                <span class="pizza-topping__label">Left</span>
                            </label>

                            <!-- Full -->
                            <label data-quid="topping-portion-C-full" class="pizza-topping__part pizza-topping__part--full">
                                <input aria-label="Cheese on full pizza" data-part="full" name="Part|${topping.id}" hidden type="radio" value="1">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <circle cx="12.5" cy="12" r="10"></circle>
                                </svg>
                                <span class="pizza-topping__label">Full</span>
                            </label>

                            <!-- Right -->
                            <label data-quid="topping-portion-C-1/2-right" class="pizza-topping__part pizza-topping__part--right">
                                <input aria-label="Cheese on right side" data-part="right" name="Part|${topping.id}" hidden type="radio" value="1/2">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon">
                                    <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                                </svg>
                                <span class="pizza-topping__label">Right</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2 justify-content-between">
                    <div class="btn-group" role="group" data-topping-id="${topping.id}">
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="none">None</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="light">Light</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="normal">Normal</button>
                        <button type="button" class="btn btn-outline-primary quantity-btn p-1 text-sm" data-quantity="extra">Extra</button>
                    </div>
                </div>
            </div>
        `;

                    const input = label.querySelector('input.topping-checkbox');
                    const optionsContainer = label.querySelector('.topping-options');
                    const sideInputs = label.querySelectorAll('[data-part]');
                    const quantityButtons = label.querySelectorAll('.quantity-btn');

                    // Handle topping checkbox toggle
                    input.addEventListener('change', (event) => {
                        const isChecked = event.target.checked;
                        optionsContainer.style.display = isChecked ? 'block' : 'none';
                        if (!isChecked) {
                            const index = selectedSauces.findIndex(t => t.topping_id === topping
                                .id);
                            if (index > -1) {
                                selectedSauces.splice(index, 1);
                            }
                            label.querySelectorAll('[data-part]').forEach(input => input.checked =
                                false);
                            label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList
                                .add('btn-outline-primary'));
                            label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList
                                .remove('btn-primary'));

                            renderPizzaSummary();

                        } else {
                            selectedSauces.push({
                                topping_id: topping.id,
                                topping_name: topping.name,
                                side: null,
                                quantity: null
                            }); // Initialize if checked
                            clearOtherSauceOptions(topping.id);
                        }
                    });

                    sideInputs.forEach(sideInput => {
                        sideInput.addEventListener('change', () => {
                            const selectedSide = label.querySelector(
                                'input[name="Part|' + topping.id + '"]:checked'
                            )?.dataset.part || null;
                            updateSauceSelection(topping.id, topping.name, selectedSide,
                                undefined);
                        });
                    });

                    quantityButtons.forEach(button => {
                        button.addEventListener('click', (event) => {
                            updateButtonGroup(button, 'quantity-btn');
                            const selectedQuantity = button.dataset.quantity;
                            updateSauceSelection(topping.id, topping.name, undefined,
                                selectedQuantity);
                        });
                    });

                    sauceContainer.appendChild(label);
                });
            }

            function clearOtherSauceOptions(selectedToppingId) {
                const allOptions = document.querySelectorAll('.topping-options');
                allOptions.forEach(options => {
                    const toppingId = options.querySelector('.side-btn')?.closest('.form-group').dataset
                        .toppingId;
                    if (toppingId && toppingId !== String(selectedToppingId)) {
                        options.style.display = 'none';
                        const input = document.querySelector(
                            `.topping-checkbox[data-topping-id="${toppingId}"]`);
                        if (input) input.checked = false; // Uncheck the other topping
                    }
                });
            }

            function updateSauceSelection(toppingId, toppingName, side, quantity) {
                const index = selectedSauces.findIndex(t => t.topping_id === toppingId);

                if (index === -1) {
                    // Add a new topping if it doesn't exist
                    selectedSauces.push({
                        topping_id: toppingId || null,
                        topping_name: toppingName || null,
                        side: side || null,
                        quantity: quantity || null
                    });
                } else {
                    // Update the existing topping's values
                    if (side !== undefined) {
                        selectedSauces[index].side = side;
                    }
                    if (quantity !== undefined) {
                        selectedSauces[index].quantity = quantity;
                    }
                }
                renderPizzaSummary();
            }

            // Handle size selection
            sizeContainer.addEventListener('click', function(event) {
                const card = event.target.closest('.size-btn');
                if (card) {
                    // Remove active class from all size buttons
                    document.querySelectorAll('.size-btn').forEach(btn => btn.classList.remove('active'));

                    // Add active class to the clicked button
                    card.classList.add('active');

                    selectedSize = {
                        id: card.dataset.sizeId,
                        label: card.dataset.label,
                        name: card.textContent.trim(),
                        price: parseFloat(card.dataset.price),
                    };

                    displayOptions(); // Update options based on size
                }
            });


            // Fetch all options on page load
            fetchOptions();

            function selectCrust(crust) {
                selectedCrusts = crust;
                renderPizzaSummary();
            }


            function updateButtonGroup(selectedButton, className) {
                const buttons = selectedButton.parentElement.querySelectorAll(`.${className}`);
                buttons.forEach(button => button.classList.remove('btn-primary'));
                buttons.forEach(button => button.classList.add('btn-outline-primary'));
                selectedButton.classList.remove('btn-outline-primary');
                selectedButton.classList.add('btn-primary');
            }

            dippingItems.forEach(item => {
                const decreaseButton = item.querySelector('button[data-action="decrease"]');
                const increaseButton = item.querySelector('button[data-action="increase"]');
                const quantityElement = item.querySelector('.quantity');
                const dippingName = item.getAttribute('data-name');

                // Increase quantity
                increaseButton.addEventListener('click', () => {
                    const currentQuantity = parseInt(quantityElement.textContent, 10);
                    const newQuantity = currentQuantity + 1;
                    quantityElement.textContent = newQuantity;

                    selectedDippings[dippingName] = newQuantity;

                    dippingsArray.push({
                        'name': dippingName,
                        'quantity': newQuantity
                    });
                    updateSelectedDippings();
                });

                // Decrease quantity
                decreaseButton.addEventListener('click', () => {
                    const currentQuantity = parseInt(quantityElement.textContent, 10);
                    if (currentQuantity > 0) {
                        const newQuantity = currentQuantity - 1;
                        quantityElement.textContent = newQuantity;

                        if (newQuantity === 0) {
                            dippingsArray = dippingsArray.filter(dipping => dipping.name !==
                                dippingName);
                            delete selectedDippings[dippingName];
                        } else {
                            selectedDippings[dippingName] = newQuantity;
                        }


                        updateSelectedDippings();
                    }
                });
            });

            // Update the selected dippings display
            function updateSelectedDippings() {
                const namesWithQuantities = Object.entries(selectedDippings)
                    .filter(([name, quantity]) => quantity > 0)
                    .map(([name, quantity]) => `${quantity} ${name}`);

                dippingName = namesWithQuantities.length > 0 ? namesWithQuantities.join(', ') : '';
                renderPizzaSummary();
            }

            function getSelectedValues() {
                // Get the selected radio value for each category
                bake = document.querySelector('input[name="bake"]:checked')?.value || '';
                seasoning = document.querySelector('input[name="seasoning"]:checked')?.value || '';
                cut = document.querySelector('input[name="cut"]:checked')?.value || '';

            }

            // Add event listener to all radio buttons
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.addEventListener('change', getSelectedValues);
            });

            // Initial fetch to show default values
            getSelectedValues();

            function renderPizzaSummary() {
                const pizzaSummaryElement = document.getElementById('PizzaSummary');
                if (!pizzaSummaryElement) return; // stop if element not found
                pizzaSummaryElement.innerHTML = ''; // Clear previous summary

                // Size and Crust
                if (typeof selectedSize === "object" && selectedSize && selectedCrusts) {
                    const sizeCrustElement = document.createElement('div');
                    sizeCrustElement.style.marginBottom = '10px';
                    sizeCrustElement.innerHTML =
                        `<strong> ${selectedSize.label || ''} (${selectedSize.name || ''}), ${selectedCrusts.name || ''}</strong>`;
                    pizzaSummaryElement.appendChild(sizeCrustElement);
                }

                // Dipping
                if (typeof dippingName !== "undefined" && dippingName) {
                    const dippingElement = document.createElement('div');
                    dippingElement.style.marginBottom = '10px';
                    dippingElement.innerHTML =
                        `<span class="fw-bold text-sm" style="font-size: 12px">Dippings</span>: 
             <span class="text-sm" style="font-size: 12px"> ${dippingName} </span>`;
                    pizzaSummaryElement.appendChild(dippingElement);
                }

                // Ensure toppings & sauces arrays exist
                const safeToppings = Array.isArray(selectedToppings) ? selectedToppings : [];
                const safeSauces = Array.isArray(selectedSauces) ? selectedSauces : [];

                // Toppings grouped by side
                const sides = ['left', 'right', 'full'];
                sides.forEach(side => {
                    const toppingsOnSide = safeToppings.filter(topping => topping.side === side);
                    if (toppingsOnSide.length > 0) {
                        const toppingElement = document.createElement('div');
                        toppingElement.style.display = 'flex';
                        toppingElement.style.alignItems = 'center';
                        toppingElement.style.marginBottom = '10px';

                        const sideSvg = side === 'left' ?
                            `<div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                        <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                            <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                        </svg>
                    </div>` :
                            side === 'right' ?
                            `<div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                            <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                            </svg>
                        </div>` :
                            `<div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                            <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                <circle cx="12.5" cy="12" r="10"></circle>
                            </svg>
                        </div>`;

                        toppingElement.innerHTML = `
                ${sideSvg}
                <div class="text-sm" style="margin-left: 10px; font-size: 12px;">
                    ${toppingsOnSide.map(topping => `${topping.topping_name || ''} (${topping.quantity || ''})`).join(', ')}
                </div>
            `;

                        pizzaSummaryElement.appendChild(toppingElement);
                    }

                    const saucesOnSide = safeSauces.filter(topping => topping.side === side);
                    if (saucesOnSide.length > 0) {
                        const toppingElement = document.createElement('div');
                        toppingElement.style.display = 'flex';
                        toppingElement.style.alignItems = 'center';
                        toppingElement.style.marginBottom = '10px';

                        const sideSvg = /* same svg logic reused as above */ (side === 'left' ?
                            `<div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                        <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                            <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                        </svg>
                    </div>` :
                            side === 'right' ?
                            `<div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                            <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                            </svg>
                        </div>` :
                            `<div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                            <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                <circle cx="12.5" cy="12" r="10"></circle>
                            </svg>
                        </div>`);

                        toppingElement.innerHTML = `
                ${sideSvg}
                <div class="text-sm" style="margin-left: 10px; font-size: 12px;">
                    ${saucesOnSide.map(topping => `${topping.topping_name || ''} (${topping.quantity || ''})`).join(', ')}
                </div>
            `;

                        pizzaSummaryElement.appendChild(toppingElement);
                    }
                });
            }


            renderPizzaSummary();


        });
    </script>

    <script>
        $(document).ready(function() {
            let productId = null;
            const selectedDippings = {}; // To track selected dippings and their quantities
            let size_id = '';
            let sizeId = null;
            let dealId = null;
            const quantityValue = document.getElementById('overall-pizza-quantity');
            const decreaseQuantityButton = document.querySelector('button[data-action="decrease_pizza_quantity"]');
            const increaseQuantityButton = document.querySelector('button[data-action="increase_pizza_quantity"]');
            let totalPrice = 0;
            let final_price = 0;
            let sizePrice = 0;
            let basePrice = 0;
            let extras_id = '';
            let extras_name = '';
            let extras_price = '';
            let selectedExtras = [];
            let details = {};

            let pizzaQuantity = 1;

            function updateQuantityDisplay() {
                quantityValue.textContent = pizzaQuantity;
                updatePriceSummary();
            }

            increaseQuantityButton.addEventListener('click', () => {
                // console.log('clicked');
                pizzaQuantity++;
                updateQuantityDisplay();
            });

            decreaseQuantityButton.addEventListener('click', () => {
                if (pizzaQuantity > 1) {
                    pizzaQuantity--;
                    updateQuantityDisplay();
                }
            });


            // Open modal and load product data
            $(document).on('click', '[data-bs-target="#PizzaModal"]', function() {
                productId = $(this).data('product-id'); // Fetch product ID
                sizeId = $(this).data('size-id'); // Fetch size ID
                dealId = $(this).data('deal-id'); // Fetch deal ID
                categoryId = $(this).data('category-id');
                // console.log('dealId', dealId);
                loadPizzaData(productId);
                const DealOpened = sessionStorage.getItem('DealOpened');
                if (DealOpened !== 'false') {
                    if (window.location.pathname === '/') {
                        $('#DealModal').addClass('show').css('display', 'block');
                        sessionStorage.setItem('DealOpened', 'true');
                    }
                }
            });

            // Handle dipping quantity changes
            $(document).on('click', '.pizza-dipping-item button[data-action]', function() {
                const action = $(this).data('action');
                const item = $(this).closest('.pizza-dipping-item');
                const dippingId = item.data('id');
                const dippingPrice = parseFloat(item.data('price'));
                const quantityElement = item.find('.quantity');
                let currentQuantity = parseInt(quantityElement.text(), 10);


                if (action === 'increase') {
                    currentQuantity++;
                } else if (action === 'decrease' && currentQuantity > 0) {
                    currentQuantity--;
                }

                quantityElement.text(currentQuantity);

                if (currentQuantity > 0) {
                    selectedDippings[dippingId] = {
                        price: dippingPrice,
                        id: dippingId,
                        quantity: currentQuantity,
                    };
                } else {
                    delete selectedDippings[dippingId];
                }

                updatePriceSummary();
            });

            // Load product details
            function loadPizzaData(itemId) {
                $.ajax({
                    url: `/products/${itemId}/details`, // Replace with your API endpoint
                    data: { // Data sent as query parameters
                        dealId: dealId,
                        sizeId: sizeId,
                        dealCategoryId: categoryId
                    },
                    method: 'GET',
                    success: function(response) {
                        details = response.responce.item_detail;
                        $('#pizzaSizesContainer').empty();
                        $('#pizzaCrustContainer').empty();
                        $('#PizzaDetailsSummary').empty();
                        $('#pizzaAddonsContainer').empty();
                        const itemCard = `
                        <div class="card mb-3">
                            <img
                                src="${response.responce.item_detail.item_image.image_url}"
                                class="card-img-top border-0 rounded-0 rounded-top position-relative"
                                alt="${response.responce.item_detail.item_name}"
                                height="190px">
                        </div>
                    `;
                        $('#img-container').html(itemCard); //
                        if (response) {
                            // basePrice = parseFloat(response.responce.item_detail.price || 0);
                            $('#PizzaModalLabel').text(response.responce.item_detail.item_name);
                            $('#MyPizzaSummary').html(`
                            <div class="d-flex justify-content-between">
                                <span id="PizzaName">${response.responce.item_detail.item_name}</span>
                                <span id="PizzaPrice" class="text-muted">$${basePrice.toFixed(2)}</span>
                            </div>
                        `);

                            loadSizesAndCrusts(response.responce.crust_data);
                            loadAddonGroups(response.responce.item_detail.addons_group);
                            if (response.responce.item_detail.extras && response.responce.item_detail
                                .extras.length > 0) {
                                loadExtras(response.responce.item_detail.extras);
                            }

                        }
                    },
                    error: function(err) {
                        toastr.error("Failed to load product details. Please try again.");
                    }
                });
            }

            $(document).on('click', '#addToCartButton', function() {
                const payload = buildAddToCartPayload();
                // console.log(payload);
                $.ajax({
                    url: '/addpizzatocart',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'POST',
                    data: JSON.stringify(payload),
                    success: function(response) {
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'PizzaModal'));
                        if (modal) {
                            modal.hide();
                        }
                        window.location.reload();
                    },
                    error: function(err) {
                        let msg = err.responseJSON?.message || err.message;
                        toastr.error(msg);
                        return false;
                    }
                });
            });

            // Build Payload for Add-to-Cart
            function buildAddToCartPayload() {
                const addons = [];
                const extras = [];

                // Gather selected addons
                $('.addon-input:checked').each(function() {
                    const addonId = $(this).data('addon-id');
                    const addonName = $(this).closest('label').find('span:first').text();
                    const addonPrice = parseFloat($(this).data('price')).toFixed(2);

                    addons.push({
                        id: addonId,
                        name: addonName,
                        price: addonPrice,
                    });
                });

                // Generate addons data
                const addonsId = addons.map(addon => addon.id).join('|');
                const addonsName = addons.map(addon => addon.name).join('|');
                const addonsPrice = addons.map(addon => addon.price).join('|');
                const selectedCrust = $('#pizzaCrustContainer input:checked');
                let crust_id = selectedCrust.data('crust-id');

                // Gather crust data
                return {
                    slug: details.slug, // Replace with the server-side slug generation logic
                    item_name: details.item_name,
                    item_type: 1, // Assuming item type is fixed
                    image_name: details.item_image.image_name,
                    tax: '',
                    item_price: final_price,
                    deal_id: dealId,
                    deal_category_id: categoryId,
                    qty: pizzaQuantity,
                    addons_id: addonsId,
                    addons_name: addonsName,
                    addons_price: addonsPrice,
                    size_id: size_id,
                    crust_id: crust_id,
                    dippings: selectedDippings,
                    extras_id: extras_id, // Include extras if applicable
                    extras_name: extras_name,
                    extras_price: extras_price,
                    buynow: 0, // Assuming 0 for add-to-cart, 1 for buy now
                };
            }

            // Load sizes and crusts
            function loadSizesAndCrusts(crustData) {
                crustData.forEach((size, index) => {
                    const sizeContainer = $(`
            <div class="size-container text-center">
                <button type="button" class="btn round-button size-btn ${index === 0 ? 'active' : ''}" data-size-id="${size.id}">
                    ${size.label}
                </button>
                <span class="text-muted d-block">${size.name}</span>
            </div>
        `);
                    $('#pizzaSizesContainer').append(sizeContainer);
                });

                const firstSizeBtn = $('.size-btn').first();
                size_id = firstSizeBtn.data('size-id');

                if (crustData.length > 0) {
                    sizePrice = parseFloat(crustData[0].size_price);
                    updateCrusts(crustData[0].crusts);
                }

                $('.size-btn').on('click', function() {
                    const selectedSizeId = $(this).data('size-id');

                    size_id = selectedSizeId;
                    const selectedSize = crustData.find(size => size.id === selectedSizeId);
                    sizePrice = parseFloat(selectedSize.size_price);
                    updatePriceSummary();
                    $('.size-btn').removeClass('active');
                    $(this).addClass('active');
                    updateCrusts(selectedSize.crusts);

                });
            }

            // Update crusts
            function updateCrusts(crusts) {
                const crustContainer = $('#pizzaCrustContainer').empty();

                crusts.forEach(crust => {
                    const crustOption = $(`
                    <label class="form-check-label w-100 d-flex justify-content-between align-items-center">
                        <span>
                            <input type="radio" name="crust" class="form-check-input crust-checkbox" data-crust-id="${crust.id}" data-price="${crust.price}">
                            <span>${crust.name}</span>
                        </span>
                        <span>$${parseFloat(crust.price).toFixed(2)}</span>
                    </label>
                `);
                    crustOption.find('input').on('change', function() {
                        updatePriceSummary();
                    });
                    crustContainer.append(crustOption);
                });

                crustContainer.find('input:first').prop('checked', true).trigger('change');
            }

            // Load addons
            function loadAddonGroups(addonsGroup) {
                const addonsContainer = $('#pizzaAddonsContainer'); // Addons container in the modal
                addonsContainer.empty(); // Clear any previous content

                addonsGroup.forEach(group => {
                    // Create a card for each addon group
                    const card = $(`
            <div class="card mb-3">
                <div class="card-header d-flex justify-content-between align-items-center" style="background: #D6B62B">
                    ${group.name}
                    <span class="badge bg-info">${group.selection_type === 1 ? 'Required' : 'Optional'}</span>
                </div>
                <div class="card-body">
                    <p class="text-muted">Select ${group.selection_count === 1 ? 'one' : `up to ${group.max_count}`}</p>
                    <div class="row gy-3" id="group-${group.id}-addons"></div>
                </div>
            </div>
        `);

                    const addonsRow = card.find(`#group-${group.id}-addons`);
                    let selectedAddons = []; // Track selected addons for this group

                    const addons = Array.isArray(group.availableAddons) ?
                        group.availableAddons :
                        Object.values(group.availableAddons); // Handle both array and object formats

                    addons.forEach(addon => {
                        const inputType = group.selection_count === 1 ? 'radio' : 'checkbox';

                        // Create addon input with label
                        const addonItem = $(`
                <div class="col-12 col-md-6 ">
                    <div class="form-check">
                        <input
                            type="${inputType}"
                            class="form-check-input addon-input"
                            id="addon-${addon.id}"
                            name="addon-group-${group.id}"
                            data-addon-id="${addon.id}"
                            data-price="${addon.price}"
                            ${group.selection_type === 1 ? 'required' : ''}
                            ${selectedAddons.includes(addon.id) ? 'checked' : ''}
                            ${inputType === 'checkbox' && selectedAddons.length >= group.max_count ? 'disabled' : ''}
                        />
                        <label class="form-check-label d-flex justify-content-between" for="addon-${addon.id}">
                            <span>${addon.name}</span>
                            <span class="text-muted">$${parseFloat(addon.price).toFixed(2)}</span>
                        </label>
                    </div>
                </div>
            `);

                        addonsRow.append(addonItem);

                        // Handle addon selection changes
                        addonItem.find('input').on('change', function() {
                            const addonId = parseInt($(this).data('addon-id'));
                            const price = parseFloat($(this).data('price'));

                            if (this.checked) {
                                if (inputType === 'checkbox' && selectedAddons.length >=
                                    group.max_count) {
                                    this.checked = false;
                                    return;
                                }
                                selectedAddons.push(addonId);
                            } else {
                                selectedAddons = selectedAddons.filter(id => id !==
                                    addonId);
                            }

                            // Update the price summary dynamically
                            updatePriceSummary();
                        });
                    });

                    // Append the card to the container
                    addonsContainer.append(card);
                });
            }

            function loadExtras(extras) {
                const extrasContainer = $('#pizzaExtrasContainer'); // Extras container
                extrasContainer.empty(); // Clear previous content

                let selectedIds = [];
                let selectedNames = [];
                let selectedPrices = [];

                // Create the extras card
                const card = $(`
        <div class="card mb-3">
            <div class="card-header" style="background: #D6B62B">Default Toppings</div>
            <div class="card-body">
                <div class="row gy-3" id="extras-list"></div>
            </div>
        </div>
    `);
                const extrasRow = card.find('#extras-list');

                extras.forEach(extra => {
                    // Create each extra checkbox
                    extrasRow.append(`
            <div class="col-12 col-md-6">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input extra-input" id="extra-${extra.id}"
                        data-id="${extra.id}" data-name="${extra.name}" data-price="${extra.price}"
                        ${extra.is_default ? 'checked disabled' : ''} />
                    <label class="form-check-label d-flex justify-content-between" for="extra-${extra.id}">
                        <span>${extra.name}</span>
                        <span class="text-muted">$${parseFloat(extra.price).toFixed(2)}</span>
                    </label>
                </div>
            </div>
        `);

                    // Collect default extras
                    if (extra.is_default) {
                        selectedIds.push(extra.id);
                        selectedNames.push(extra.name);
                        selectedPrices.push(extra.price);
                    }
                });

                // Handle checkbox changes
                extrasRow.on('change', '.extra-input', function() {
                    const {
                        id,
                        name,
                        price
                    } = $(this).data();
                    if (this.checked) {
                        selectedIds.push(id);
                        selectedNames.push(name);
                        selectedPrices.push(price);
                    } else {
                        selectedIds = selectedIds.filter(extraId => extraId != id);
                        selectedNames = selectedNames.filter(extraName => extraName != name);
                        selectedPrices = selectedPrices.filter(extraPrice => extraPrice != price);
                    }
                    selectedExtras = selectedPrices;
                    updateExtrasPayload(selectedIds, selectedNames, selectedPrices);
                    updatePriceSummary();

                });

                // Append card and initialize payload
                extrasContainer.append(card);
                updateExtrasPayload(selectedIds, selectedNames, selectedPrices);

            }

            function updateExtrasPayload(selectedIds, selectedNames, selectedPrices) {
                $('#extras_id').val(selectedIds.join('|'));
                $('#extras_name').val(selectedNames.join('|'));
                $('#extras_price').val(selectedPrices.join('|'));
                extras_id = selectedIds.join('| ');
                extras_name = selectedNames.join('| ');
                extras_price = selectedPrices.join('| ');

            }

            // Update price summary
            function updatePriceSummary() {
                let totalAddonPrice = basePrice; // Start with the pizza's base price
                final_price = basePrice;
                // Add selected addons price
                $('.addon-input:checked').each(function() {
                    totalAddonPrice += parseFloat($(this).data('price'));
                });

                // Add selected dippings price
                Object.values(selectedDippings).forEach(dipping => {
                    totalAddonPrice += dipping.price * dipping.quantity;
                });
                Object.values(selectedExtras).forEach(extra => {
                    totalAddonPrice += extra;
                });

                // Add selected crust price
                const selectedCrust = $('#pizzaCrustContainer input:checked');
                if (selectedCrust.length) {
                    totalAddonPrice += parseFloat(selectedCrust.data('price'));
                    final_price += parseFloat(selectedCrust.data('price'));
                }
                totalAddonPrice = totalAddonPrice + sizePrice;
                final_price = final_price + sizePrice;
                totalAddonPrice = totalAddonPrice * pizzaQuantity;
                final_price = final_price * pizzaQuantity;
                totalPrice = totalAddonPrice;
                $('#PizzaPrice').text(`$${totalAddonPrice.toFixed(2)}`);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const itemModal = new bootstrap.Modal(document.getElementById('DealModal'));
            const storedProductId = sessionStorage.getItem('productId');
            const storedproductTitle = sessionStorage.getItem('productTitle');

            document.getElementById('itemDealTitle').innerText = storedproductTitle;

            // Check if the modal was previously opened and the page was reloaded
            if (sessionStorage.getItem('DealOpened') === 'true') {
                if (window.location.pathname === '/') {
                    itemModal.show(); // Show the modal if previously opened and page is not hidden
                    fetchProductDetails(storedProductId);
                }
            }
            $(document).on('click', '#DealClose', function() {
                sessionStorage.setItem('DealOpened',
                    'false'); // Set the modalOpened flag to false when modal is closed
                $('#DealModal').addClass('show').css('display', 'none');
            })
            // Listen for the modal close event to update localStorage
            document.getElementById('DealModal').addEventListener('hidden.bs.modal', function() {
                sessionStorage.setItem('DealOpened',
                    'true'); // Set the modalOpened flag to false when modal is closed
            });

            // Listen for modal triggers
            document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = button.getAttribute('data-deal-id');
                    var productTitle = button.getAttribute('data-deal-title');

                    if (productId) {
                        sessionStorage.setItem('productId',
                            productId); // Store productId in session storage
                        sessionStorage.setItem('productTitle',
                            productTitle); // Store productId in session storage
                        sessionStorage.setItem('DealOpened',
                            'true'); // Set the flag to true when modal is opened
                    } else {
                        console.error('Product ID is missing for modal trigger.');
                    }
                });
            });

            // Event listener to fetch and populate data when the modal is shown
            var dealModal = document.getElementById('DealModal');
            dealModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget; // Button that triggered the modal

                var productId = button.getAttribute('data-deal-id');
                var productTitle = button.getAttribute('data-deal-title');

                // Use this id to populate or do something inside the modal
                document.getElementById('itemDealTitle').innerText = productTitle;
                if (productId) {

                    fetchProductDetails(productId); // Fetch the product details when modal is shown
                } else {
                    console.error('Product ID is missing.');
                }
            });

            // Example function to fetch product details
            function fetchProductDetails(productId) {
                fetch(`/deal-detail/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data || data.length === 0) {
                            toastr.error('No data found.');
                            return;
                        }

                        // Clear existing items
                        document.querySelector('.item-list').innerHTML = '';

                        // Iterate over categories and items
                        data.forEach(category => {
                            const categoryContainer = document.createElement('div');
                            categoryContainer.className = 'card mb-5';

                            // Card Header
                            const cardHeader = document.createElement('div');
                            cardHeader.className =
                                'card-header bg-warning text-white text-uppercase fw-bold';
                            cardHeader.textContent = category.category_name;
                            categoryContainer.appendChild(cardHeader);

                            // Create a container to wrap items
                            const itemsContainer = document.createElement('div');
                            itemsContainer.className = 'card-body row';

                            // Iterate over each item in the category
                            category.items.forEach(item => {
                                const itemContainer = document.createElement('div');
                                itemContainer.className =
                                    'col-12 col-lg-4 col-md-6 col-sm-12 m-0 mb-1 mb-md-2 ';

                                const cardContainer = document.createElement('div');
                                cardContainer.className = 'h-100 d-flex flex-column card';

                                // Card Image
                                const itemImageLink = document.createElement('a');
                                // itemImageLink.href = `URL_TO_ITEM_PAGE/item-${item.slug}`;
                                const itemImage = document.createElement('img');
                                itemImage.src = item.item_image.image_url;
                                itemImage.className =
                                    'card-img-top border-0 rounded-0 rounded-top position-relative';
                                itemImage.style.height = '250px';
                                itemImageLink.appendChild(itemImage);
                                cardContainer.appendChild(itemImageLink);

                                // Card Body
                                const cardBody = document.createElement('div');
                                cardBody.className = 'card-body pb-3';

                                // Create a row container
                                const rowContainer = document.createElement('div');
                                rowContainer.className =
                                    'd-flex justify-content-between align-items-center';

                                // Item title
                                const itemTitle = document.createElement('h5');
                                itemTitle.className = 'item-card-title fs-6 text-black mb-0';
                                const itemTitleLink = document.createElement('a');
                                itemTitleLink.className = 'text-black';
                                itemTitleLink.textContent = item.item_name;
                                itemTitle.appendChild(itemTitleLink);


                                const itemPrice = document.createElement('p');
                                itemPrice.className = 'fs-6 text-primary mb-0';
                                itemPrice.textContent = item.item_price;

                                rowContainer.appendChild(itemTitle);
                                if (category.deal_type === 3) {
                                    rowContainer.appendChild(itemPrice);
                                }

                                cardBody.appendChild(rowContainer);
                                cardContainer.appendChild(cardBody);

                                // Item Footer and Order Now Button
                                const itemFooter = document.createElement('div');
                                itemFooter.className = 'item-card-footer';
                                const footerContent = document.createElement('div');
                                footerContent.className =
                                    'd-flex justify-content-between align-items-center';

                                if (item.is_cart === 1) {
                                    // Display item quantity if it's already in cart
                                    const orderNowButton = document.createElement('button');
                                    orderNowButton.className =
                                        'btn disabled btn-sm btn-secondary fw-500 py-2 px-4 w-100 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_' +
                                        item.slug;
                                    orderNowButton.textContent = 'Added to Cart';
                                    footerContent.appendChild(orderNowButton);
                                } else {
                                    if (category.category_name.toLowerCase() === 'pizza') {
                                        // Create the anchor element
                                        const pizzaModalLink = document.createElement('a');
                                        pizzaModalLink.setAttribute('data-bs-toggle', 'modal');
                                        pizzaModalLink.setAttribute('data-bs-target',
                                            '#PizzaModal');
                                        pizzaModalLink.className =
                                            'cursor-pointer btn btn-sm btn-secondary fw-500 py-2 px-4 w-100 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center';
                                        pizzaModalLink.textContent = 'Order Now';
                                        pizzaModalLink.setAttribute('data-product-id', item.id);
                                        pizzaModalLink.setAttribute('data-size-id', category
                                            .size_id
                                        ); // Assuming `item.id` holds the product ID
                                        pizzaModalLink.setAttribute('data-deal-id', category
                                            .deal_id);
                                        // Append the anchor to the footer content
                                        footerContent.appendChild(pizzaModalLink);
                                    } else {
                                        // Show "Order Now" button for non-pizza categories
                                        const orderNowButton = document.createElement('button');
                                        orderNowButton.className =
                                            'btn btn-sm btn-secondary fw-500 py-2 px-4 w-100 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_' +
                                            item.slug;
                                        orderNowButton.textContent = 'Order Now';
                                        orderNowButton.addEventListener('click', () =>
                                            showdealitem(item.slug, category.deal_id,
                                                '{{ URL::to('/show-deal-item') }}'));
                                        footerContent.appendChild(orderNowButton);
                                    }
                                }

                                itemFooter.appendChild(footerContent);
                                cardContainer.appendChild(itemFooter);
                                itemContainer.appendChild(cardContainer);
                                itemsContainer.appendChild(itemContainer);
                            });

                            categoryContainer.appendChild(itemsContainer);
                            document.querySelector('.item-list').appendChild(categoryContainer);
                        });
                    })
                    .catch(error => toastr.error('Error fetching product details:', error));
            }
        });
    </script>

    @if (@helper::checkaddons('age_verification'))
        @if (@helper::getagedetails($vendordata->id)->age_verification_on_off == 1)
            <script src="{{ url('resources/js/age.js') }}"></script>
        @endif
    @else
        <script>
            $('#main-content').removeClass('blur');
        </script>
    @endif

    <!-- whatsapp chat -->
    @if (@helper::checkaddons('whatsapp_message'))
        @if (@helper::getwhatsappmessage()->whatsapp_chat_on_off == 1)
            @include('web.whatsapp_chat')
        @endif
    @endif
    <!-- whatsapp_message btn end -->

    <!-- tawk chat -->
    @if (@helper::checkaddons('tawk_addons'))
        @if (@helper::appdata()->tawk_on_off == 1)
            {!! @helper::appdata()->tawk_widget_id !!}
        @endif
    @endif

    <!-- wizz chat -->
    @if (@helper::checkaddons('wizz_chat'))
        @if (@helper::appdata()->wizz_chat_on_off == 1)
            {!! @helper::appdata()->wizz_chat_settings !!}
        @endif
    @endif

    <script>
        // COMMON-SCRIPTS
        // to-display-success-error-message
        toastr.options = {
            "closeButton": true,
        }
        @if (Session::has('success'))
            toastr.success("{{ session('success') }}");
        @endif
        @if (Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif
        // for-sweetalert
        let are_you_sure = "{{ trans('messages.are_you_sure') }}";
        let yes = "{{ trans('messages.yes') }}";
        let no = "{{ trans('messages.no') }}";
        let wrong = "{{ trans('messages.wrong') }}";
        let record_safe = "{{ trans('messages.record_safe') }}";
        let okay = "{{ trans('labels.okay') }}";
        let track_order = "{{ trans('labels.track_order') }}";
        let continue_shopping = "{{ trans('labels.continue_shopping') }}";
        let order_placed = "{{ trans('labels.order_placed') }}";
        let order_placed_note = "{{ trans('messages.order_placed_note') }}";
        let restaurant_closed = "{{ trans('messages.restaurant_closed') }}";

        // others
        function currency_format(price) {
            "use strict";
            if ("{{ @helper::appdata()->currency_position }}" == 1) {
                return "{{ @helper::appdata()->currency }}" + parseFloat(price).toFixed(2);
            } else {
                return parseFloat(price).toFixed(2) + "{{ @helper::appdata()->currency }}";
            }
        }

        // top deals parameter
        var start_date = "{{ @$topdeals->start_date }}";
        var start_time = "{{ @$topdeals->start_time }}";
        var end_date = "{{ @$topdeals->end_date }}";
        var end_time = "{{ @$topdeals->end_time }}";
        @if (@helper::checkaddons('top_deals'))
            var enddate = "{{ App\Models\TopDeals::first()->end_date }}";
            var endtime = "{{ App\Models\TopDeals::first()->end_time }}";
            var deal_type = "{{ App\Models\TopDeals::first()->deal_type }}";
        @else
            var enddate = null;
            var endtime = null;
        @endif
        var topdeals = "{{ !empty(@$topdealsproduct) ? 1 : 0 }}";
        var time_zone = "{{ helper::appdata()->timezone }}";
        var current_date = "{{ \Carbon\Carbon::now()->toDateString() }}";

        var siteurl = "{{ URL::to('/') }}";
    </script>
    {{-- <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/top_deals.js') }}"></script> --}}
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/common.js') }}"></script><!-- web-common-js -->

    @if (@helper::checkaddons('sales_notification'))
        @if (helper::appdata()->fake_sales_notification == 1)
            <script>
                if ("{{ @helper::appdata()->fake_sales_notification }}" == "1") {
                    // Select the element with the ID 'sales-booster-popup'
                    const popup = document.getElementById('sales-booster-popup');

                    if (popup) {
                        // Define a function to add and remove the 'loaded' class
                        let isMouseOver = false;
                        const toggleLoadedClass = () => {
                            // Add the 'loaded' class
                            popup.classList.add('loaded');
                            // Remove the 'loaded' class after 5 seconds, unless the mouse is over the popup
                            setTimeout(() => {
                                    if (!isMouseOver) {
                                        popup.classList.remove('loaded');
                                    }
                                },
                                "{{ helper::appdata()->notification_display_time }}"
                            ); // 4000 milliseconds = 4 seconds for demo purposes
                        };

                        // Function to handle mouseover event
                        const handleMouseOver = () => {
                            isMouseOver = true;
                            // You can perform actions here when mouse is over the popup
                        };

                        // Function to handle mouseout event
                        const handleMouseOut = () => {
                            isMouseOver = false;
                        };

                        // Call the function initially
                        toggleLoadedClass();

                        setInterval(function() {
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: "{{ URL::to('get_notification_data') }}",

                                    method: 'POST',
                                    success: function(response) {
                                        toggleLoadedClass();
                                        $('#sales-booster-popup').show();
                                        $('#notification_body').html(response.output);
                                    },
                                });
                            },
                            "{{ helper::appdata()->notification_display_time + helper::appdata()->next_time_popup }}"
                        ); // 8000 milliseconds = 8 seconds

                        // Add mouseover and mouseout event listeners to the popup
                        popup.addEventListener('mouseover', handleMouseOver);
                        popup.addEventListener('mouseout', handleMouseOut);

                        // Select the close button within the popup
                        const closeButton = popup.querySelector('.close'); // Close button selector

                        if (closeButton) {
                            // Add an event listener to the close button
                            closeButton.addEventListener('click', () => {
                                // Remove the 'loaded' class immediately
                                popup.classList.remove('loaded');
                            });
                        }
                    }
                }
            </script>
        @endif
    @endif
    @yield('scripts')

</body>
<style>
    .round-button {
        width: 70px;
        /* adjust to your desired width */
        height: 70px;
        /* adjust to your desired height */
        border-radius: 50% !important;
        /* make the corners fully rounded */
        border: 1px solid;
        cursor: pointer;
        background-color: #f48384;
        transition: background-color 0.3s ease;
        /* Smooth transition for background color */

    }

    .btn.active {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
        border-color: #DE1616 !important;
    }

    .round-button:hover {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
    }

    .round-button.selected {
        background-color: #DE1616 !important;
        color: #fff;
        /* Optional: Change text color for better visibility */
    }


    .topping-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        /* Two columns with equal width */
        gap: 16px;
        /* Adjust gap between rows and columns */

        align-items: center;
        /* Center items vertically */
    }

    .topping-grid .topping-item {
        width: 100%;
        /* Ensure consistent width */
        text-align: center;
        /* Center content */
        padding: 10px;
        border: 1px solid #ccc;
        /* Optional: Add a border for visual clarity */
        border-radius: 8px;
        /* Optional: Add rounded corners */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Optional: Add a subtle shadow */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Optional: Add hover effects */
    }

    .topping-grid .topping-item:hover {
        transform: translateY(-5px);
        /* Lift item slightly on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        /* Enhance shadow on hover */
    }

    .text-sm {
        font-size: 14px;
        color: grey;
    }

    .btn-outline-primary {
        padding: 9px !important;
        font-size: 12px;
        font-weight: 500;
        color: #DE1616 !important;
    }

    .btn-outline-primary:hover {
        background-color: #DE1616 !important;
        /* Hover color for all buttons */
        color: #fff !important;
        /* Optional: Change text color on hover */
    }
</style>

</html>
