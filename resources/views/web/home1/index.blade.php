@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.home') }}
@endsection

@section('content')
    <!-- Slider Area Start Here -->
    @if (count($sliders) > 0)
        <section class="slider-area">
            <div id="slidercarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sliders as $key => $sliderdata)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ helper::image_path($sliderdata->image) }}" class="d-block img-fluid" alt="slider">
                            <div class="carousel-caption d-flex h-100 align-items-center justify-content-center flex-column">
                                <h5 class="animate__animated animate__fadeInUp mb-3">{{ $sliderdata->title }}</h5>
                                <p class="animate__animated animate__fadeInUp">{{ $sliderdata->description }}</p>
                                <!--<div class="button-container mt-auto">-->
                                <!--    <a href="{{ URL::to('/location?type=Delivery') }}"-->
                                <!--       class="btn btn-primary fw-500 px-4 py-2 mx-6 animate__animated animate__fadeInUp">-->
                                <!--        DELIVERY-->
                                <!--    </a>-->
                                <!--    <a href="{{ URL::to('/location?type=Carryout') }}"-->
                                <!--       class="btn btn-primary fw-500 px-4 py-2 animate__animated animate__fadeInUp">-->
                                <!--        CARRYOUT-->
                                <!--    </a>-->
                                <!--</div>-->
                            </div>
                        </div>
                    @endforeach
                </div>


                <button class="carousel-control-prev {{ count($sliders) == 1 ? 'd-none' : '' }}" type="button"
                    data-bs-target="#slidercarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next {{ count($sliders) == 1 ? 'd-none' : '' }}" type="button"
                    data-bs-target="#slidercarousel" data-bs-slide="next">
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
    <!-- Promotional topbanners Start Here -->
    {{--    @if (count($banners['topbanners']) > 0) --}}
    {{--        <section class="theme-1-banner1 sec-padding"> --}}
    {{--            <div class="container"> --}}
    {{--                <div class="slider-small owl-carousel owl-theme"> --}}
    {{--                    @foreach ($banners['topbanners'] as $key => $bannerdata) --}}
    {{--                        <div class="item"> --}}
    {{--                            <a href="{{ helper::branch_route('deals') }}"> --}}
    {{--                                <img src="{{ $bannerdata['image'] }}" alt="banner" --}}
    {{--                                     class="rounded-4"> --}}
    {{--                            </a> --}}

    {{--                        </div> --}}
    {{--                    @endforeach --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </section> --}}
    {{--    @endif --}}
    <!-- Promotional topbanners End Here -->



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
                                                    class="rounded-circle h-100 object-fit-cover" alt="category">
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
                <img src="https://modinatheme.com/html/foodking-html/assets/img/shape/burger-shape-2.png" alt="shape-img">
            </div>
            <div class="fry-shape d-xl-block d-none">
                <img src="https://modinatheme.com/html/foodking-html/assets/img/shape/fry-shape.png" alt="shape-img">
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
            {{--            <div class="tomato-shape-1 d-md-flex d-none"> --}}
            {{--                <img src="{{ asset('web-assets/images/theme-bg-image/tomato-shape.png') }}" --}}
            {{--                     alt="shape-img"> --}}
            {{--            </div> --}}
            {{--            <div class="chili-shape-1 d-md-flex d-none"> --}}
            {{--                <img src="{{ asset('web-assets/images/theme-bg-image/chili-shape.png') }}" --}}
            {{--                     alt="shape-img"> --}}
            {{--            </div> --}}
        </section>
    @endif

    <!-- Top Deal Section Start Here -->
    @if (count($topdealsproduct) > 0)
        <section class="theme-1-top-deal menu-special position-relative sec-padding bg-primary-rgb">
            <div class="container">
                <div class="row g-4">
                    <div class="col-6 align-self-start">
                        <div class=" rounded-4 overflow-hidden">
                            <div class="deals-heading mb-md-0 mb-3 text-start">
                                <p class="sub-lables text-capitalize mb-0 mt-md-2">
                                    {{ trans('labels.top_deals') }}
                                </p>
                            </div>
                            <div class="countdown d-flex justify-content-center gap-2 mt-3" id="countdown"></div>
                        </div>
                    </div>
                    <div class="col-6 d-flex flex-column align-items-end align-self-start">
                        <div class="px-4 rounded-4 overflow-hidden">
                            <div class="deals-heading mb-md-0 mb-3 text-end align-content-end">
                                <div class="col-lg-auto text-center">
                                    {{--                                    <a href="{{ URL::to('/view-all?type=topdeals') }}" --}}
                                    {{--                                       class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3"> --}}
                                    {{--                                        {{ trans('labels.view_all') }} --}}
                                    {{--                                        <i class="fa-solid fa-arrow-right"></i> --}}
                                    {{--                                    </a> --}}
                                </div>
                            </div>
                            <div class="countdown d-flex justify-content-center gap-2 mt-3" id="countdown"></div>
                        </div>
                    </div>
                    @foreach ($topdealsproduct as $itemdata)
                        @include('web.home1.todayitemview')
                    @endforeach
                </div>

            </div>

        </section>
    @endif
    <!-- Top Deal Section End Here -->


    <!-- slider-gallery start Here -->
    {{--    @if (count($getgalleries) > 0) --}}
    {{--        <section class="gallery pb-5 pt-5 position-relative"> --}}
    {{--            <div class="container"> --}}
    {{--                <div class="row align-items-center mb-sm-5 mb-4"> --}}
    {{--                    <div class="gallery-heading col-auto menu-heading"> --}}
    {{--                        <h1 class="text-uppercase">{{ trans('labels.gallery') }}</h1> --}}
    {{--                        <p class="sub-lables text-capitalize mt-2 mb-0">{{ trans('labels.our_gallery') }}</p> --}}
    {{--                    </div> --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--            <div class="gallery-slider owl-carousel owl-theme"> --}}
    {{--                @foreach ($getgalleries as $image) --}}
    {{--                    <div class="item" data-src="{{ $image->image_url }}" data-fancybox="gallery" --}}
    {{--                         data-thumb="{{ $image->image_url }}"> --}}
    {{--                        <img src="{{ helper::image_path($image->image) }}" class="rounded-4" alt=""> --}}
    {{--                    </div> --}}
    {{--                @endforeach --}}
    {{--            </div> --}}
    {{--        </section> --}}
    {{--    @endif --}}




    <section class="blog-wrapper sec-padding">
        <div class="mx-5 mt-2">
            <div class="row">
                @foreach (helper::get_categories_list(4) as $categorydata)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mt-2 position-relative">
                        <a href="{{ helper::branch_route('menu', ['category' => $categorydata->slug]) }}"
                            class="d-block text-decoration-none">
                            <div class="position-relative">
                                <img src="{{ helper::image_path($categorydata->image) }}" class="rounded-4 img-fluid"
                                    alt="category" style="height: 340px;width:100%">
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

    <!-- Blog Section Start Here -->
    <!--@if (@helper::checkaddons('blog'))-->
    <!--    @if (count($getblogs) > 0)
    -->
    <!--        <section>-->
    <!--            <div class="blog-wrapper sec-padding pt-4">-->
    <!--                <div class="container">-->
    <!--                    <div class="row g-2 align-items-center justify-content-between mb-sm-5 mb-4">-->
    <!--                        <div class="col-auto blog-heading">-->
    <!--                            <h1 class="text-uppercase">{{ trans('labels.latest_blogs') }}</h1>-->
    <!--                            <p class="sub-lables text-capitalize mt-2 mb-0">{{ trans('labels.top_blogs') }}</p>-->
    <!--                        </div>-->
    <!--                        <div class="col-auto">-->
    <!--                            <a href="{{ route('blogs') }}"-->
    <!--                               class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3">{{ trans('labels.view_all') }}</a>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!--                    <div class="row g-sm-4 g-3">-->
    <!--                        @foreach ($getblogs as $bloglist)
    -->
    <!--                            @include('web.blogs.blogview')-->
    <!--
    @endforeach-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--        </section>-->
    <!--
    @endif-->
    <!--@endif-->
    <!-- Blog Section End Here -->


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
