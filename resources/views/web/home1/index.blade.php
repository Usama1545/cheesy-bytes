@extends('web.layout.default')
<?php
use App\Helpers\Helper;

$itemData = Helper::getBranch(); // ✅ works
?>
@section('page_title'){{ trans('labels.home') }} | {{ $itemData->seo_name }} |@endsection
@section('meta_description')Craving something cheesy and delicious? Discover fresh, flavorful meals at {{ $itemData->seo_name }}. Order now and enjoy the taste of CheesyBite!@endsection
@section('content')
    <!-- Slider Area Start Here -->
    @if (count($sliders) > 0)
        <section class="slider-area">
            <div id="slidercarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sliders as $key => $sliderdata)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            
                            <picture>
                                <source media="(max-width: 768px)"
                                    srcset="{{ $sliderdata->mobile_image ? helper::image_path($sliderdata->mobile_image) : helper::image_path($sliderdata->image) }}">
                                
                                <img src="{{ helper::image_path($sliderdata->image) }}"
                                    class="d-block img-fluid w-100"
                                    alt="slider" @if ($key == 0) fetchpriority="high" @else loading="lazy" @endif decoding="async">
                            </picture>

                            <div class="carousel-caption d-flex h-100 align-items-center justify-content-center flex-column">
                                <h5 class="animate__animated animate__fadeInUp mb-3">
                                    {{ $sliderdata->title }}
                                </h5>

                                <p class="animate__animated animate__fadeInUp">
                                    {{ $sliderdata->description }}
                                </p>

                            </div>

                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev {{ count($sliders) == 1 ? 'd-none' : '' }}"
                        type="button"
                        data-bs-target="#slidercarousel"
                        data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>

                <button class="carousel-control-next {{ count($sliders) == 1 ? 'd-none' : '' }}"
                        type="button"
                        data-bs-target="#slidercarousel"
                        data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </section>
    @endif
    <div class="row g-4">

        <div class="d-none d-md-block">
            @include('web.home1.homeDealsStack') <!-- Show on md and larger -->
        </div>

        <div class="d-block d-md-none pt-3 pb-3">
            @include('web.home1.dealsMobileStack') <!-- Show only on smaller than md -->
        </div>

    </div>

    <!-- Category Section Start Here -->
    @if (count(helper::get_categories()) > 0)
        <section class="category position-relative bg-section-gray sec-padding">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row g-2 align-items-center justify-content-between mb-sm-5 mb-4">
                            <div class="col-auto">
                                <h1 class="text-uppercase fw-bold">{{ trans('labels.categories') }}</h1>
                                <p class="sub-lables text-capitalize mt-2 mb-0">{{ trans('labels.top_categories') }}</p>
                            </div>
                            <div class="col-auto text-end align-center">
                                <a href="{{ helper::branch_route('categories') }}"
                                    class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3">{{ trans('labels.view_all') }}</a>
                            </div>
                        </div>
                        <div id="category" class="owl-carousel mt-2">
                            @foreach (helper::get_categories() as $categorydata)
                                <div class="category-wrapper category-item rounded-4">
                                    <a href="{{ helper::branch_route('menu', ['category' => $categorydata->slug]) }}">
                                        <div class="d-flex justify-content-center">
                                            <div class="cat rounded-circle">
                                                <img src="{{ helper::image_path($categorydata->image) }}"
                                                    class="rounded-circle h-100 object-fit-cover" alt="category" loading="lazy" decoding="async">
                                            </div>
                                        </div>
                                    </a>
                                    <div class="text-center pt-3 category-text">
                                        <p class="fs-6 fw-500 mb-0">{{ $categorydata->category_name }}</p>
                                        <p class="fs-7 fw-400 text-primary mb-0">{{ $categorydata->item_info->count() }}
                                            {{ trans('labels.item') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="burger-shape d-md-block d-none">
                <img src="https://modinatheme.com/html/foodking-html/assets/img/shape/burger-shape-2.png" alt="shape-img" loading="lazy" decoding="async">
            </div>
            <div class="fry-shape d-xl-block d-none">
                <img src="https://modinatheme.com/html/foodking-html/assets/img/shape/fry-shape.png" alt="shape-img" loading="lazy" decoding="async">
            </div>
        </section>
    @endif
    <!-- Category Section End Here -->

    @if (count($topitemlist) > 0)
        <section class="menu sec-padding position-relative">
            <div class="container">
                <div class="row g-3 align-items-center justify-content-between mb-sm-5 mb-4">
                    <div class="col-auto menu-heading">
                        <h1 class="text-uppercase">{{ trans('labels.trending') }}</h1>
                        <p class="sub-lables text-capitalize mt-2 mb-0">Popular Products</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ helper::branch_route('viewall', ['type' => 'topitems']) }}"
                            class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3">{{ trans('labels.view_all') }}</a>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach ($topitemlist as $itemdata)
                        @include('web.home1.itemview')
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Top Deal Section Start Here -->

   
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



    <section class="blog-wrapper sec-padding">
        <div class="mx-5 mt-2">
            <div class="row">
                @foreach (helper::get_categories_list(4) as $categorydata)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-2 position-relative">
                        <a href="{{ helper::branch_route('menu', ['category' => $categorydata->slug]) }}"
                            class="d-block text-decoration-none">
                            <div class="position-relative">
                                <img src="{{ helper::image_path($categorydata->image) }}" class="rounded-4 img-fluid"
                                    alt="category" style="height: 340px;width:100%" loading="lazy" decoding="async">
                                <div
                                    class="position-absolute top-50 start-50 translate-middle text-black fw-bold px-3 rounded text-center">
                                    <!--<p class="m-0" style="font-size: 16px;">Restaurant</p>-->
                                    <!--<p class="m-0" style="font-size: 24px;">{{ $categorydata->category_name }}</p>-->
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

   
    <!-- slider-gallery end Here -->
    @push('style')
        <style>
            .county-details p {
                color: #8e8e8e;
                /* Apply color to all paragraphs */
            }

            .county-details h1 {
                color: #5e5e5e;
                /* Apply color to all h1 tags */
            }

            .county-details span {
                color: #8e8e8e;
                /* Apply color to all span tags */
            }

            .app-download-wrapper{
                /* background: linear-gradient(135deg,#0b1220,#1e2f47); linear-gradient(135deg, #ea0707, #D6B62B)*/
                background: linear-gradient(135deg, #D6B62B, #ea0707);
                border-radius: 16px;
            }

            .app-phones{
                display:flex;
                justify-content:center;
                align-items:flex-end;
                flex-wrap:nowrap;
            }

            .phone-img{
                height:320px;
                border-radius:.5rem;
                margin:0 6px;
            }

            .phone-center{
                height:360px;
            }

            /* Mobile */
            @media (max-width: 768px){

                .app-phones{
                    flex-direction:row;
                    gap:8px;
                }

                .phone-img{
                    height:180px;
                    margin:0;
                }

                .phone-center{
                    height:200px;
                }
            }

            .phone-img{
                height:320px;
                border-radius: .5rem;
                margin:0 6px;
            }

            .app-preview{
                max-height: 350px;
            }

            .county-details {
                margin-top: 40px;
                display: block;
                /* Ensures the content is block-level for better layout */
                margin-bottom: 1em;
                /* Adds some space below the content */
                font-family: 'Arial', sans-serif;
                /* Sets a clean, readable font */
                line-height: 1.6;
                /* Increases line height for better readability */
                color: #989898 !important;
                /* Sets the text color to a dark gray for contrast */
                padding: 10px;
                /* Adds padding around the content for better spacing */
                /*border: 1px solid #ddd; !* Adds a subtle border for structure *!*/
                border-radius: 5px;
                /* Adds rounded corners for a more modern look */
                /*background-color: #f9f9f9; !* Light background color to enhance readability *!*/
            }


            /* Optional: Add responsive styling if needed */
            @media (max-width: 768px) {
                .county-details {
                    font-size: 14px;
                    /* Adjust font size for smaller screens */
                    padding: 8px;
                    /* Reduce padding for smaller screens */
                }
            }

            @media (min-width: 1440px) {
                .col-lg-2-4 {
                    flex: 0 0 20%;
                    /* Makes the columns take up 20% of the container on large screens */
                    max-width: 20%;
                }
            }

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

            .round-button:hover {
                background-color: #DE1616;
                /* Hover color for all buttons */
                color: #fff;
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
                color: #DE1616;
            }

            .btn-outline-primary:hover {
                background-color: #DE1616;
                /* Hover color for all buttons */
                color: #fff;
                /* Optional: Change text color on hover */
            }


            .btn.btn-primary {
                padding: 9px !important;
                font-weight: 500;
                font-size: 12px;
                color: white;
            }

            .btn.active {
                background-color: #DE1616;
                /* Hover color for all buttons */
                color: #fff;
                /* Optional: Change text color on hover */
                border-color: #DE1616;
            }

            .btn.btn-primary:hover {
                background-color: #DE1616;
                /* Hover color for all buttons */
                color: #fff;
                /* Optional: Change text color on hover */
                border-color: #DE1616;
            }

            .pizza-topping__part {
                display: inline-flex;
                flex-direction: column;
                /* Stack SVG and label vertically */
                align-items: center;
                /* Center align SVG and label */
                margin: 5px;
                cursor: pointer;
            }

            .pizza-topping__icon {
                width: 30px;
                height: 30px;
                fill: lightgray;
                /* Default icon color */
                transition: fill 0.3s;
            }

            .pizza-topping__part input:checked+svg {
                fill: #DE1616;
                /* Highlight color on selection */
            }

            .pizza-topping__label {
                margin-top: 5px;
                /* Add some space between SVG and label */
                font-size: 14px;
                color: #333;
            }

            #myPizzaCard {
                position: sticky;
                top: 15px;
                /* Adjust the top position for the sticky card */
                z-index: 1050;
                /* Ensure it's above other content */
            }

            @media (max-width: 767px) {
                #myPizzaCard {
                    position: relative;
                    /* For mobile screens, we can revert to a non-sticky position */
                    margin-top: 10px;
                    /* Add a bit of spacing on top for smaller screens */
                }
            }

            @media (min-width: 992px) {

                .modal-lg,
                .modal-xl {
                    --bs-modal-width: 900px;
                }
            }

            .carousel-caption {
                position: absolute;
                bottom: 20px;
                /* Adjust the space from the bottom of the image */
                left: 50%;
                transform: translateX(-50%);
                text-align: center;
                z-index: 10;
            }

            .carousel-caption h5 {
                margin-top: 140px;
                /* Moves the title lower */
            }

            .button-container {
                margin-top: 20px;
                /* Adds a gap between the title and the buttons */
                display: flex;
                justify-content: center;
                /* Centers buttons horizontally */
                gap: 100px;
                /* Space between the buttons */
            }

            .carousel-item img {
                object-fit: cover;
                /* Ensures the image covers the entire space */
            }

            .gallery-slider .item {
                width: 345px !important;
                /* Fixed width */
                height: 340px;
                /* Fixed height */
                margin: 10px;
                /* Add spacing */
            }

            .gallery-slider .item img.fixed-dimensions {
                width: 100%;
                /* Make the image fit the fixed container */
                height: 100%;
                /* Stretch the image to fill the container */
                object-fit: cover;
                /* Ensure proper scaling */
            }

            @media (max-width: 786px) {
                .carousel-caption h5 {
                    margin-top: 90px;
                    /* Moves the title lower */
                }
            }

            /*.blog-wrapper .owl-item {*/
            /*    width: 360px !important; !* Set the fixed width *!*/
            /*}*/
        </style>
    @endpush
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $("#news-slider ").owlCarousel({
                rtl: @if (session()->get('direction') == '2')
                    true
                @else
                    false
                @endif ,
                loop: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    400: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    600: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    800: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1000: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1200: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    }
                }
            });
        });
    </script>
    <!-- JS For Category Section -->
    <script>
        $(document).ready(function() {
            $("#category").owlCarousel({
                rtl: @if (session()->get('direction') == '2')
                    true
                @else
                    false
                @endif ,
                loop: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                    },
                    426: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 15,
                    },
                    600: {
                        items: 4,
                        nav: false,
                        dots: false,
                        margin: 15,
                    },
                    800: {
                        items: 4,
                        nav: false,
                        dots: false,
                        margin: 10,
                    },
                    1025: {
                        items: 5,
                        dots: false,
                        nav: false,
                        loop: false,
                        arrows: true,
                        margin: 20,
                    },
                }
            });
        });
    </script>
    <!-- JS For Promotional Banner Section 3 -->
    <script>
        $(document).ready(function() {
            $("#bannersection2").owlCarousel({
                rtl: @if (session()->get('direction') == '2')
                    true
                @else
                    false
                @endif ,
                loop: true,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    400: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    600: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    800: {
                        items: 2,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1000: {
                        items: 3,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    },
                    1200: {
                        items: 4,
                        nav: false,
                        dots: false,
                        arrow: true,
                        margin: 10,
                        loop: false,
                        // rewind: true
                    }
                }
            });
            $('.testimonial-1').owlCarousel({
                rtl: @if (session()->get('direction') == '2')
                    true
                @else
                    false
                @endif ,
                loop: true,
                margin: 20,
                nav: false,
                dots: true,
                autoplay: true,
                autoplayTimeout: 4000,
                responsive: {
                    0: {
                        items: 1
                    },
                    500: {
                        items: 1
                    },
                    1000: {
                        items: 2
                    },
                    1200: {
                        items: 2
                    },
                }
            });
            $('.slider-small').owlCarousel({
                rtl: @if (session()->get('direction') == '2')
                    true
                @else
                    false
                @endif ,
                loop: true,
                margin: 10,
                nav: false,
                dots: false,
                center: true,
                autoplay: true,
                slideTransition: 'linear',
                autoplaySpeed: 10000,
                smartSpeed: 10000,
                autoplayTimeout: 10000,
                responsive: {
                    0: {
                        items: 2,
                        margin: 10

                    },
                    500: {
                        items: 2,
                        margin: 15

                    },
                    600: {
                        items: 2,
                        margin: 20

                    },
                    1000: {
                        items: 2,
                        margin: 20

                    }
                }
            });
        });
    </script>
    <!-- slider-gallery -->
    <script>
        $('.gallery-slider').owlCarousel({
            rtl: @if (session()->get('direction') == '2')
                true
            @else
                false
            @endif ,
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            center: true,
            autoplay: true,
            slideTransition: 'linear',
            autoplaySpeed: 3000,
            smartSpeed: 3000,
            autoplayTimeout: 3000,
            items: 5, // Set the number of visible items
        });
    </script>
@endsection
<style>
     .app-download-wrapper{
                /* background: linear-gradient(135deg,#0b1220,#1e2f47); linear-gradient(135deg, #ea0707, #D6B62B)*/
                background: linear-gradient(135deg, #D6B62B, #ea0707);
                border-radius: 16px;
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

            .phone-img{
                height:320px;
                border-radius: .5rem;
                margin:0 6px;
            }

            .app-preview{
                max-height: 350px;
            }
            </style>
