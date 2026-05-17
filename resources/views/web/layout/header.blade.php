<!-- header section start -->
<header>

    <div class="header-bar" id="header1">

        <nav class="navbar navbar-expand-lg sticky-top p-0">
            <div class="container navbar-container">
                <a class="navbar-brand" href="{{ helper::branch_route('home') }}">
                    <img class="img-resposive img-fluid" src="{{ asset('assets/images/logo.png') }}"
                         alt="logo">
                </a>
                                <a class="d-md-none navbar-brand" href="{{ helper::branch_route('home') }}">
                    <img class="img-resposive img-fluid" src="{{ asset('assets/images/halal.png') }}"
                         alt="logo">
                </a>
                <!-- language-btn -->
                {{--                @if (@helper::checkaddons('language'))--}}
                {{--                    <div class="buttons d-flex align-items-center">--}}
                {{--                        <div class="dropdown d-block d-lg-none">--}}
                {{--                            <a class="btn text-white dropdown px-1 fs-6 border-0 header-box" type="button"--}}
                {{--                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">--}}
                {{--                                <i class="fa-solid fa-globe fs-5"></i></a>--}}
                {{--                            <ul class="dropdown-menu {{ session()->get('direction') == '2' ? 'min-dropdown-rtl' : 'min-dropdown' }}"--}}
                {{--                                aria-labelledby="dropdownMenuButton1">--}}
                {{--                                @foreach (helper::language() as $lang)--}}
                {{--                                    <li>--}}
                {{--                                        <a class="dropdown-item text-dark d-flex gap-2"--}}
                {{--                                            href="{{ URL::to('/language-' . $lang->code) }}">--}}
                {{--                                            <img src="{{ helper::image_path($lang->image) }}"--}}
                {{--                                                class="img-fluid lag-img rounded-5" alt="">{{ $lang->name }}--}}
                {{--                                        </a>--}}
                {{--                                    </li>--}}
                {{--                                @endforeach--}}
                {{--                            </ul>--}}
                {{--                        </div>--}}

                {{--                    </div>--}}
                {{--                @endif--}}
                <!-- language-btn -->

                {{-- for large devices - for header bar --}}
                <div class="navbar-collapse collapse">
                    <div class="navbar-nav mx-auto">
                        {{--                        <a class="nav-link px-3 {{ request()->is('/') ? 'active' : '' }}"--}}
                        {{--                            href="{{ route('home') }}">{{ trans('labels.home') }}</a>--}}
                        {{--                        <a class="nav-link px-3 {{ request()->is('categories') ? 'active' : '' }}"--}}
                        {{--                            href="{{ route('categories') }}">{{ trans('labels.menu') }}</a>--}}
                        {{--                        <a class="nav-link px-3 {{ request()->is('blogs') ? 'active' : '' }}"--}}
                        {{--                            href="{{ route('blogs') }} ">{{ trans('labels.blogs') }}</a>--}}
                        {{--                        <a class="nav-link px-3 {{ request()->is('faq') ? 'active' : '' }}"--}}
                        {{--                            href="{{ route('faq') }}">{{ trans('labels.faq') }}</a>--}}
                        {{--                        <a class="nav-link px-3 {{ request()->is('contactus') ? 'active' : '' }}"--}}
                        {{--                            href="{{ route('contact-us') }} ">{{ trans('labels.help_contact_us') }}</a>--}}


                    </div>
                    <div class="d-flex gap-3 align-items-center justify-content-center nav-sidebar-d-none" style="padding: 10px;">
                        <!-- language-btn -->


                        <!-- cart-btn -->
                        <div class="navbar-nav mx-auto header-head-box">
                            <a class="nav-link px-3 {{ request()->is('/') ? 'active' : '' }}"
                               href="{{ helper::branch_route('home') }}">{{ trans('labels.home') }}</a>
                               <a class="nav-link px-3 {{ request()->is('deals') ? 'active' : '' }}"
                               href="{{ helper::branch_route('deals') }}">{{ trans('labels.deals') }}</a>
                            <a class="nav-link px-3 {{ request()->is('categories') || request()->is('*/categories') ? 'active' : '' }}"
                               href="{{ helper::branch_route('categories') }}">{{ trans('labels.menu') }}</a>
                            <a class="nav-link px-3 {{ request()->is('reward') || request()->is('*/reward') ? 'active' : '' }}"
                                href="#">Rewards</a>
                                 <a class="nav-link px-3 {{ request()->is('catering') || request()->is('*/catering') ? 'active' : '' }}"
                                href="{{ helper::branch_route('catering') }}">Catering</a>

                                <!-- href="{{ helper::branch_route('reward') }} ">Rewards</a>-->
                            <a class="nav-link px-3 {{ request()->is('location')  || request()->is('*/location')   ? 'active' : '' }}"
                               href="{{ route('location') }} ">Location</a>
                            <div class="nav-link px-3">
                                <div class="header-banner">
                                    <div class="header-banner-content">
                                        <span class="text-primary fw-bold">NOW EARN</span>
                                        <span class="header-badge">FREE</span>
                                        <span class="text-primary fw-bold">CHEESY BITE</span>
                                    </div>
                                    <div class="header-banner-subtext">EVERY 2 ORDER'S</div>
                                </div>
                            </div>

                            {{--                        <a class="nav-link px-3 {{ request()->is('faq') ? 'active' : '' }}"--}}
                            {{--                           href="{{ route('faq') }}">{{ trans('labels.faq') }}</a>--}}
                            {{--                        <a class="nav-link px-3 {{ request()->is('contactus') ? 'active' : '' }}"--}}
                            {{--                           href="{{ route('contact-us') }} ">{{ trans('labels.help_contact_us') }}</a></div>--}}


                            <!-- user-btn -->
                            <div class="text-center" style="width: 110px">
                                @if (auth()->user() && auth()->user()->type == 2)
                                    <a class="nav-link text-white" href="{{ route('user-profile') }}" role="button">
                                        <i class="fa-solid fa-user"></i>
                                    </a>
                                @else
                                    <span style="width: 120px;">
                                <a href="{{ route('login') }}" class="text-white" style="font-size: 12px">SIGN IN & EARN REWARD</a>
                                </span>
                                @endif
                            </div>
                            <div class="header-search header-box">
                                <input type="text" class="search-form" placeholder="{{ trans('labels.search_here') }}"
                                       required>
                                @if (session()->get('direction') == '')
                                    <a href="{{ helper::branch_route('search') }}" class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                @elseif (session()->get('direction') == '2')
                                    <a href="{{ helper::branch_route('search') }}" class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                @else
                                    <a href="{{ helper::branch_route('search') }}" class="search-button">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="cart-area header-box">
                                <a href="{{ helper::branch_route('cart') }} " class="text-white">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    <span class="cart-badge">{{ helper::get_user_cart() }}</span>
                                </a>
                            </div>
                            <div >
                                <a href="#" class="text-white">
                                    <img src="{{ asset('assets/images/halal.png') }}" alt="Halal" style="width: 50px;margin-top: 5px;margin-left:50px">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </nav>
    </div>
</header>
<div class="bg-secondary text-white py-2">
    <div class="container">
        <marquee behavior="scroll" direction="left" scrollamount="5">
            Images are for illustrative purposes only. Actual items may vary slightly in appearance depending on ingredients, preparation, and toppings.
        </marquee>
    </div>
</div>
<!-- header section end -->

<!-- offer btn start-->
<!--<div class="ltr-buttons">-->

<!--           <button class="btn btn-primary offer-button" style="padding: 0px 40px 1px 1px !important;" type="button" data-bs-toggle="offcanvas"-->
<!--                data-bs-target="" aria-controls="offcanvasOffer">-->
<!--            <img src="{{ asset('assets/images/halal.png') }}" alt="Halal" style="width: 45px">-->
<!--            </button>-->

<!--</div>-->
<div class="offer">
    <div class="offcanvas {{ session()->get('direction') == '2' ? 'offcanvas-start' : 'offcanvas-end' }}"
         tabindex="-1" id="offcanvasOffer" aria-labelledby="offcanvasOfferLabel">
        <div class="offcanvas-header border-bottom bg-light">
            <div class="d-flex d-grid gap-2 align-items-center">
                <i class="fa-sharp fa-solid fa-badge-percent"></i>
                <h5 class="offcanvas-title fw-600" id="offcanvasOfferLabel">{{ trans('labels.offers') }}</h5>
            </div>
            <button type="button"
                    class="btn-close {{ session()->get('direction') == '2' ? 'me-auto ms-0' : 'ms-auto me-0' }}"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="row g-3">
                @foreach (helper::getoffers() as $offers)
                    @php
                        $count = helper::getcouponcodecount($offers->offer_code);
                    @endphp
                    @if ($offers->usage_type == 1)
                        @if ($count < $offers->usage_limit)
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <span class="coupons-label">{{ $offers->offer_code }}</span>
                                            @if (request()->is('checkout'))
                                                <p class="fw-500 cursor-pointer copy_coupon_code mb-0"
                                                   data-bs-dismiss="offcanvas"
                                                   onclick="getoffercode('{{ $offers->offer_code }}')">
                                                    {{ trans('labels.copy_code') }}
                                                </p>
                                            @endif
                                        </div>
                                        <h5 class="pt-3 mb-0 offer-text">{{ $offers->offer_name }}</h5>
                                        <p class="text-muted fw-400 fs-8 pt-2 mb-0">{{ $offers->description }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <span class="coupons-label">{{ $offers->offer_code }}</span>
                                        @if (request()->is('checkout'))
                                            <p class="fw-500 cursor-pointer copy_coupon_code mb-0"
                                               data-bs-dismiss="offcanvas"
                                               onclick="getoffercode('{{ $offers->offer_code }}')">
                                                {{ trans('labels.copy_code') }}
                                            </p>
                                        @endif
                                    </div>
                                    <h5 class="pt-3 mb-0 offer-text">{{ $offers->offer_name }}</h5>
                                    <p class="text-muted fw-400 fs-8 pt-2 mb-0">{{ $offers->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- offer btn end-->

<div class="mobile_menu_footer d-lg-none">
    <div class="container">
        <ul class="d-flex justify-content-between align-items-center mb-0 gap-3">
            <li class="text-center">
                <a href="{{ helper::branch_route('home') }}" class="{{ request()->is('/') ? 'active1' : '' }}">
                    <i class="fa-light fa-house"></i>
                    <p class="mb-0">{{ trans('labels.home') }}</p>
                </a>
            </li>
            <li class="text-center">
                <a href="{{ helper::branch_route('deals') }}" class="{{ request()->is('deals') ? 'active1' : '' }}">
                    <i class="fa-light fa-gift"></i>
                    <p class="mb-0">{{ trans('labels.deals') }}</p>
                </a>
            </li>
            <li class="text-center">
                <a href="{{ helper::branch_route('cart') }}" class="{{ request()->is('cart') ? 'active1' : '' }}">
                    <div class="position-relative">
                        <i class="fa-light fa-bag-shopping"></i>
                        <span class="qut_counter">{{ helper::get_user_cart() }}</span>
                    </div>
                    <p class="mb-0">{{ trans('labels.cart') }}</p>
                </a>
            </li>
            <li class="text-center">
                <a href="{{ helper::branch_route('categories') }}"
                   class="{{ request()->is('categories') ? 'active1' : '' }}">
                    <i class="fa-light fa-file"></i>
                    <p class="mb-0">Menu</p>
                </a>
            </li>
            <li class="text-center">
                <a href="{{ Auth::user() ? route('user-profile') : route('login') }}"
                   class="{{ request()->is('profile') ? 'active1' : '' }}">
                    <i class="fa-light fa-user"></i>
                    <p class="mb-0">{{ trans('labels.account') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
<style>
    /* Header Banner Container */
    .header-banner {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #ffffff; /* Gold background */
        padding: 12px 16px;
        margin: 0 auto;
        width: 250px;
        clip-path: polygon(10% 0%, 90% 0%, 100% 50%, 90% 100%, 10% 100%, 0% 50%);
        -webkit-clip-path: polygon(10% 0%, 90% 0%, 100% 50%, 90% 100%, 10% 100%, 0% 50%);
    }

    /* Banner Content */
    .header-banner-content {
        display: flex;
        align-items: center;
        gap: 6px;
        text-align: center;
    }

    /* Free Badge */
    .header-badge {
        background-color: #ff0000; /* Red background */
        color: #ffffff; /* White text */
        font-size: 6px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    /* Primary Text Styles */
    .text-primary {
        color: #3d2b1f; /* Dark brown text */
        font-size: 10px;
        font-weight: bold;
    }

    /* Subtext */
    .header-banner-subtext {
        font-size: 10px;
        color: #4d4d4d; /* Gray text */
    }

    .header-head-box{
        height: 40px;
        /* width: 40px; */
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
    }

</style>
