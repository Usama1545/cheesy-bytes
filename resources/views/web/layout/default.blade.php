<!doctype html>
<html lang="en" dir="{{ session('direction') == 2 ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta property="og:title" content="{{ @helper::appdata()->og_title }}"/>
    <meta property="og:description" content="{{ @helper::appdata()->og_description }}"/>
    <meta property="og:image" content='{{ helper::image_path(@helper::appdata()->og_image) }}'/>
    <title> {{ @helper::appdata()->title }} @yield('page_title')</title>
    <link rel="icon" href="{{ helper::image_path(@helper::appdata()->favicon) }}"><!-- Favicon -->
    <link rel="stylesheet" href="{{ url(env('ASSETSPATHURL') . 'web-assets/css/bootstrap.min.css') }}">
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
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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

        <!-- index CART item modal -->
        {{--            @if (!request()->is('cart') && !request()->is('checkout'))--}}
        {{--                @if (helper::get_user_cart() != 0)--}}
        {{--                    <div class="cart-modal rounded-bottom-0">--}}
        {{--                        <div class="rounded-lg">--}}
        {{--                            <div class="d-flex gap-3 justify-content-between align-items-center">--}}
        {{--                                <p class="mb-0 text-white fs-7 fw-600 d-flex align-items-center gap-1"><span--}}
        {{--                                        class="count">{{ helper::get_user_cart() }}</span>--}}
        {{--                                    {{ trans('labels.item_added') }} </p>--}}
        {{--                                <a href="{{ route('cart') }}" class="text-white fw-500 fs-7 text-uppercase">--}}
        {{--                                    {{ trans('labels.view') }} {{ trans('labels.cart') }}--}}
        {{--                                    <i class="fa-solid fa-bag-shopping ps-1"></i>--}}
        {{--                                </a>--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                @endif--}}
        {{--            @endif--}}

        {{-- cookie modal --}}
        @include('cookie-consent::index')

    </div>
</main>

<!-- Modal Item Details -->
<div class="modal modalitemdetails" id="modalitemdetails" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
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

<div class="modal" id="customPizzaModal" tabindex="-1" aria-labelledby="customPizzaModalLabel" aria-hidden="true">
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
                            <div class=" d-flex justify-content-between flex-wrap gap-2 mx-5" id="sizeContainer">
                                @foreach(helper::customPizzaSize() as $size)
                                    <button type="button"
                                            class="btn round-button size-btn"
                                            data-size-id="{{ $size->id }}"
                                            data-label="{{ $size->label }}"
                                            data-price="{{ $size->price }}">
                                        {{ $size->name }}"
                                    </button>
                                @endforeach
                            </div>
                            <hr>
                            <div class="card-body d-flex flex-wrap gap-2" id="crustContainer"></div>
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
                        <div class="card-header" style="background: #D6B62B">Select Sauces</div>
                        <div class="card-body justify-content-between gap-2" id="sauceContainer"></div>
                    </div>


                    <!-- Dipping Selection -->
                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Select Dipping Sause</div>
                        <div class="card-body">
                            @foreach(helper::getSides() as $dipping)
                                <div class="d-flex align-items-center gap-3 mb-3 dipping-item" data-name="{{ $dipping->name }}">
                                    <!-- Dipping Image -->
                                    <img src="{{ helper::image_path($dipping->image) }}"
                                         alt="Dipping Sauce"
                                         class="img-fluid rounded h-70px"
                                         style="object-fit: cover;">

                                    <!-- Dipping Name -->
                                    <span class="flex-grow-1 text-sm">{{ $dipping->name }}</span>

                                    <!-- Quantity Controls -->
                                    <div class="d-flex align-items-center ms-auto">
                                        <!-- Decrease Button -->
                                        <button data-action="decrease"
                                                class="btn btn-secondary bg-gray rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; font-size: 1.2rem; background: #a8a7a7; border-color: gray;">
                                            -
                                        </button>

                                        <!-- Quantity Display -->
                                        <span class="fw-semibold mx-3 quantity"
                                              style="min-width: 30px; text-align: center;">0</span>

                                        <!-- Increase Button -->
                                        <button data-action="increase"
                                                class="btn btn-primary rounded-circle d-flex justify-content-center align-items-center"
                                                style="width: 40px; height: 40px; font-size: 1.2rem;">
                                            +
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Special Selection -->

                    <div class="card mb-3">
                        <div class="card-header" style="background: #D6B62B">Special Instructions</div>
                        <div class="card-body">
                            <div class="row col-12" style="">
                                <!-- Bake Options -->
                                <div class="col-12 col-md-3" style="border-right: 1px solid #cccaca">
                                    <h6>BAKE</h6>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="bake" class="form-check-input" value="well-done" >
                                            Well Done
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="bake" class="form-check-input" value="normal-bake" checked>
                                            Normal Bake
                                        </label>
                                    </div>
                                </div>

                                <!-- Seasoning Options -->
                                <div class="col-12 col-md-5" style="border-right: 1px solid #cccaca">
                                    <h6>SEASONING</h6>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="seasoning" class="form-check-input" value="garlic-seasoned-crust" checked>
                                            Garlic-Seasoned Crust
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="seasoning" class="form-check-input" value="no-garlic-seasoned-crust" >
                                            No Garlic-Seasoned Crust
                                        </label>
                                    </div>
                                </div>

                                <!-- Cut Options -->
                                <div class="col-12 col-md-4">
                                    <h6>CUT</h6>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="cut" class="form-check-input" value="pie-cut" checked>
                                            Pie Cut
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="cut" class="form-check-input" value="square-cut" >
                                            Square Cut
                                        </label>
                                    </div>
                                    <div>
                                        <label class="text-sm" style="font-size: 11px">
                                            <input type="radio" name="cut" class="form-check-input" value="uncut">
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
                                <label
                                    class="text-black form-label fs-7 mb-1">{{ trans('labels.email') }}</label>
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
{{--    @if (@helper::checkaddons('quick_call'))--}}
{{--        @if (@helper::appdata()->quick_call == 1)--}}
{{--        @include('web.quick_call')--}}
{{--        @endif--}}
{{--    @endif--}}


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
<div class="modal" id="useroption" tabindex="-1" aria-labelledby="useroptionLabel"
     aria-hidden="true">
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
                        <a class="btn btn-outline-dark w-100 p-2" href="javascript:void(0)"
                           onclick="showlogin()" type="button">
                            <i class="fa-solid fa-user-plus"></i>
                            <span class="px-2">{{ trans('labels.create_account') }}</span>
                        </a>
                    </div>
                    <div class="col-md-6 col-12">
                        <a class="btn btn-primary w-100 p-2" target="_blank" onclick="checkout()">
                            <i class="fa-solid fa-address-card"></i>
                            <span
                                class="px-2">{{ trans('labels.continue_as_guest') }}</span>
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
                                    <img src="" class="h-100 w-100 object-fit-cover rounded-4 border"/>
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
                            <textarea name="comment" rows="2" class="form-control mt-1"
                                      placeholder="Message"></textarea>
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
        circle.addEventListener('click', function () {
            circle.classList.toggle('filled');
        });
    });


    function updateOverallQuantity(change) {
        const quantityDisplay = document.getElementById('overall-quantity');
        let currentQuantity = parseInt(quantityDisplay.textContent, 10);
        console.log(currentQuantity);
        currentQuantity = Math.max(1, currentQuantity + change); // Ensure the quantity is at least 1
        quantityDisplay.textContent = currentQuantity;
        document.getElementById('overall-quantity').textContent = currentQuantity;
    }


    document.addEventListener('DOMContentLoaded', function () {
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

        increaseButton.addEventListener('click', () => {
            quantity++;
            updateQuantityDisplay();
        });

        increaseQuantityButton.addEventListener('click', () => {
            pizzaQuantity++;
            updateQuantityDisplay();
        });

        decreaseButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                updateQuantityDisplay();
            }
        });
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
                    const modal = bootstrap.Modal.getInstance(document.getElementById('customPizzaModal'));
                    if (modal) {
                        modal.hide();
                    }
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
        let selectedSauces = null;

        let allCrusts = [];
        let allToppings = [];
        let allSauces = [];
        let selectedSize = null;

        // Fetch all options on page load
        function fetchOptions() {
            Promise.all([
                fetch('/getCrusts').then(res => res.json()),
                fetch('/getToppings').then(res => res.json()),
                fetch('/getSauces').then(res => res.json()),
            ])
                .then(([crusts, toppings, sauces]) => {
                    allCrusts = crusts;
                    allToppings = toppings;
                    allSauces = sauces;
                    displayOptions(); // Initially empty until size is selected
                    autoSelectFirstSize();
                    autoSelectFirstCrust();
                })
                .catch(error => console.error('Error fetching options:', error));
        }

        function autoSelectFirstSize() {
            const firstSize = sizeContainer.querySelector('.size-btn');
            if (firstSize) {
                firstSize.click();
            }
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

            selectedSauces = null;
            selectedCrusts = null;
            selectedToppings = [];
            // Filter and display crusts
            displayCrusts();

            // Filter and display toppings
            displayToppings();

            // Filter and display sauces
            displaySauces();
        }

        function displayCrusts() {
            crustContainer.innerHTML = ''; // Clear crust container
            console.log(selectedSize);
            const filteredCrusts = allCrusts.filter(crust =>
                String(crust.size_id) === String(selectedSize.id)
            );

            filteredCrusts.forEach(crust => {
                const label = document.createElement('label');
                label.className = 'form-check-label d-block';
                label.innerHTML = `
            <input
                type="radio"
                name="crust"
                class="form-check-input crust-checkbox"
                data-crust-id="${crust.id}"
                data-price="${crust.price}"
            />
             <span>${crust.name}</span>
        <div class="text-muted small mx-4">${crust.description}</div> <!-- Added description -->

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
                        const index = selectedToppings.findIndex(t => t.topping_id === topping.id);
                        if (index > -1) {
                            selectedToppings.splice(index, 1);
                        }
                        label.querySelectorAll('[data-part]').forEach(input => input.checked = false);
                        label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList.add('btn-outline-primary'));
                        label.querySelectorAll('.quantity-btn').forEach(btn => btn.classList.remove('btn-primary'));

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
                        updateToppingSelection(topping.id, topping.name, selectedSide, undefined);
                    });
                });

                quantityButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        updateButtonGroup(button, 'quantity-btn');
                        const selectedQuantity = button.dataset.quantity;
                        updateToppingSelection(topping.id, topping.name, undefined, selectedQuantity);
                    });
                });

                toppingContainer.appendChild(label);
            });
        }

        function clearOtherToppingOptions(selectedToppingId) {
            const allOptions = document.querySelectorAll('.topping-options');
            allOptions.forEach(options => {
                const toppingId = options.querySelector('.side-btn')?.closest('.form-group').dataset.toppingId;
                if (toppingId && toppingId !== String(selectedToppingId)) {
                    options.style.display = 'none';
                    const input = document.querySelector(`.topping-checkbox[data-topping-id="${toppingId}"]`);
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
            console.log(selectedToppings);
            renderPizzaSummary();
        }

        function displaySauces() {
            sauceContainer.innerHTML = ''; // Clear sauces container
            const filteredSauces = allSauces.filter(sauce =>
                String(sauce.size_id) === String(selectedSize.id)
            );
            filteredSauces.forEach(sauce => {
                const label = document.createElement('label');
                label.className = 'form-check-label d-block text-sm mb-1';
                label.innerHTML = `
            <input
                type="radio"
                name="sauce"
                class="form-check-input sauce-checkbox"
                data-sauce-id="${sauce.id}"
                data-price="${sauce.price}"
            />
            ${sauce.name} ($${sauce.price})
        `;
                label.querySelector('input').addEventListener('change', (event) => toggleSauce(sauce, event.target.checked));
                sauceContainer.appendChild(label);
            });
        }

        // Handle size selection
        sizeContainer.addEventListener('click', function (event) {
            const card = event.target.closest('.size-btn');
            if (card) {
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

        function toggleSauce(sauce, isChecked) {
            selectedSauces = sauce;
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

                dippingsArray.push({'name': dippingName, 'quantity': newQuantity});
                updateSelectedDippings();
            });

            // Decrease quantity
            decreaseButton.addEventListener('click', () => {
                const currentQuantity = parseInt(quantityElement.textContent, 10);
                if (currentQuantity > 0) {
                    const newQuantity = currentQuantity - 1;
                    quantityElement.textContent = newQuantity;

                    if (newQuantity === 0) {
                        dippingsArray = dippingsArray.filter(dipping => dipping.name !== dippingName);
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
            pizzaSummaryElement.innerHTML = ''; // Clear previous summary

            // Size and Crust
            const sizeCrustElement = document.createElement('div');
            sizeCrustElement.style.marginBottom = '10px';

            sizeCrustElement.innerHTML = `<strong>  ${selectedSize.label} (${selectedSize.name}), ${selectedCrusts.name}</strong> `;
            pizzaSummaryElement.appendChild(sizeCrustElement);


            // Sauce
            const sauceElement = document.createElement('div');
            sauceElement.style.marginBottom = '10px';
            if (selectedSauces) {
                sauceElement.innerHTML = `<span class="text-sm" style="font-size: 12px">${selectedSauces.name}</span>`;
            }
            pizzaSummaryElement.appendChild(sauceElement);

            const dippingElement = document.createElement('div');
            dippingElement.style.marginBottom = '10px';

            dippingElement.innerHTML = `<span class="fw-bold text-sm" style="font-size: 12px">Dippings</span>:<span class="text-sm" style="font-size: 12px"> ${dippingName} </span>`;
            if(dippingName) {
                pizzaSummaryElement.appendChild(dippingElement);
            }

            // Toppings grouped by side
            const sides = ['left', 'right', 'full'];
            sides.forEach(side => {
                const toppingsOnSide = selectedToppings.filter(topping => topping.side === side);
                if (toppingsOnSide.length > 0) {
                    const toppingElement = document.createElement('div');
                    toppingElement.style.display = 'flex';
                    toppingElement.style.alignItems = 'center'; // Vertically center content
                    toppingElement.style.marginBottom = '10px'; // Add spacing between elements if needed

                    const sideSvg = side === 'left'
                        ? `
                            <div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                                <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                    <path d="M11.4847 21.876L12.5861 21.9883V20.8811V3.11841V2.01126L11.4847 2.12357C9.03877 2.37296 6.77239 3.52107 5.12442 5.34558C3.47646 7.17009 2.56415 9.54119 2.56415 11.9998C2.56415 14.4583 3.47646 16.8294 5.12442 18.6539C6.77238 20.4785 9.03876 21.6266 11.4847 21.876Z"></path>
                                </svg>
                            </div>`
                        : side === 'right'
                            ? `
                                <div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                                    <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                        <path d="M12.5861 2.01126V2.12357C15.0321 2.37296 17.2985 3.52107 18.9465 5.34558C20.5945 7.17009 21.5068 9.54119 21.5068 11.9998C21.5068 14.4583 20.5945 16.8294 18.9465 18.6539C17.2985 20.4785 15.0321 21.6266 12.5861 21.876V2.01126Z"></path>
                                    </svg>
                                </div>`
                            : `
                                <div style="display: inline-flex; justify-content: center; align-items: center; border: 2px solid #DE1616; border-radius: 50%; width: 30px; height: 30px; flex-shrink: 0;">
                                    <svg aria-hidden="true" fill="none" focusable="false" height="24" viewBox="0 0 25 24" width="25" class="pizza-topping__icon" style="fill: #DE1616">
                                        <circle cx="12.5" cy="12" r="10"></circle>
                                    </svg>
                                </div>`;

                    toppingElement.innerHTML = `
                        ${sideSvg}
                        <div  class="text-sm" style="margin-left: 10px; font-size: 12px;">
                            ${toppingsOnSide.map(topping => `${topping.topping_name} (${topping.quantity || ''})`).join(', ')}
                        </div>
                    `;

                    pizzaSummaryElement.appendChild(toppingElement);
                }
            });





        }

        renderPizzaSummary();


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
<script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/top_deals.js') }}"></script>
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
                        }, "{{helper::appdata()->notification_display_time}}"); // 4000 milliseconds = 4 seconds for demo purposes
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

                    setInterval(function () {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: "{{ URL::to('get_notification_data') }}",

                            method: 'POST',
                            success: function (response) {
                                toggleLoadedClass();
                                $('#sales-booster-popup').show();
                                $('#notification_body').html(response.output);
                            },
                        });
                    }, "{{helper::appdata()->notification_display_time+helper::appdata()->next_time_popup}}"); // 8000 milliseconds = 8 seconds

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

</html>
