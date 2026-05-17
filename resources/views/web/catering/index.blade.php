@extends('web.layout.default')
@section('page_title')| {{ trans('labels.home') }}@endsection
@section('content')
    <!-- Slider Area Start Here -->
    @if (count($sliders) > 0)
        <section class="slider-area">
            <div id="slidercarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sliders as $key => $sliderdata)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <img src="{{ helper::image_path($sliderdata->image) }}" class="d-block img-fluid"
                                 alt="slider">
                            <div
                                class="carousel-caption d-flex h-100 align-items-center justify-content-center flex-column">
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

    <!-- Why Choose Us Start Here -->
    @if (count($getwhychooseus) > 0)
        <section class="about sec-padding pt-5">
            <div class="container">
                <div class="row g-md-5 g-3">
                    <div class="col-lg-6 d-md-block d-none">
                        <div class="about-img h-100"><img
                                src="{{ helper::image_path(helper::appdata()->why_choose_image) }}"
                                class="w-100 h-100 object-fit-cover rounded-4" alt=""></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="h-100 d-flex align-items-center py-md-4">
                            <div class="about-details">
                                <h1 class="text-uppercase">{{ helper::appdata()->why_choose_title }}</h1>
                                <p class="sub-lables text-capitalize mt-2 mb-0">
                                    {{ helper::appdata()->why_choose_subtitle }}
                                </p>
                                <p class="mb-4 line-4">{{ helper::appdata()->why_choose_description }}</p>
                                <div class="row g-4">
                                    @foreach ($getwhychooseus as $whychooseus)
                                        <div class="d-flex align-items-center">
                                            <div class="service-icon">
                                                <img src="{{ helper::image_path($whychooseus->image) }}" alt=""
                                                     class="w-100 h-100">
                                            </div>
                                            <div class="{{ session()->get('direction') == '2' ? 'pe-3' : 'ps-3' }}">
                                                <h4 class="service-name mb-1 line-1">{{ $whychooseus->title }}</h4>
                                                <p class="service-des mb-0 line-2">{{ $whychooseus->subtitle }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- Why Choose Us End Here -->


    <!-- Top Deal Section End Here -->
    @if (true)
        <section class="table-booking sec-padding pb-5">
            <div class="container">
                <div class="row g-0 align-items-center bg-section-gray rounded-5">
                    <div class="reservation-content col-lg-6 p-sm-5 p-4">
                        <h1 class="text-uppercase">{{ trans('labels.book_table') }}</h1>
                        <p class="sub-lables mb-4">{{ trans('labels.make_reservation') }}</p>
                        <div>
                            <form class="rounded-5" action="{{ URL::to('reservation/store') }}" method="POST">
                                @csrf
                                <div class="row g-md-2 g-3 mb-3">
                                    <div class="col-xl-4 col-md-12 form-group">
                                        <label for="reservation_name"
                                               class="form-label fs-7 mb-1">{{ trans('labels.full_name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input class="form-control" type="text" name="name"
                                               value="{{ old('name') }}" id="reservation_name"
                                               placeholder="{{ trans('labels.full_name') }}" required>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group">
                                            <label for="reservation_email"
                                                   class="form-label fs-7 mb-1">{{ trans('labels.email') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="email" name="email"
                                                   value="{{ old('email') }}" id="reservation_email"
                                                   placeholder="{{ trans('labels.email') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="form-group">
                                            <label for="reservation_mobile"
                                                   class="form-label fs-7 mb-1">{{ trans('labels.mobile') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input class="form-control" type="text" name="mobile"
                                                   value="{{ old('mobile') }}" id="reservation_mobile"
                                                   placeholder="{{ trans('labels.mobile') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <div class="row g-md-2 g-3 mb-3">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="reservation_date"
                                                           class="form-label fs-7 mb-1">{{ trans('labels.date') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control" type="date" name="date"
                                                           min="<?php echo date('Y-m-d'); ?>" value="{{ old('date') }}"
                                                           id="reservation_date" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="reservation_time"
                                                           class="form-label fs-7 mb-1">{{ trans('labels.time') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control" type="time" name="time"
                                                           value="{{ old('time') }}" id="reservation_time" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-md-2 g-3 mb-3">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="reservation_guest"
                                                           class="form-label fs-7 mb-1">{{ trans('labels.number_guest') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control" type="text" name="guests"
                                                           value="{{ old('guests') }}" id="reservation_guest"
                                                           placeholder="{{ trans('labels.number_guest') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="form-group">
                                                    <label for="reservation_type"
                                                           class="form-label fs-7 mb-1">{{ trans('labels.reservation_type') }}
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input class="form-control" type="text" name="reservation_type"
                                                           value="{{ old('reservation_type') }}" id="reservation_type"
                                                           placeholder="{{ trans('labels.reservation_type') }}"
                                                           required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="special_request"
                                                   class="form-label fs-7 mb-1">{{ trans('labels.special_request') }}</label>
                                            <textarea class="form-control" name="special_request" id="special_request"
                                                      placeholder="{{ trans('labels.special_request_o') }}"
                                                      rows="3">{{ old('special_request') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <button type="submit"
                                                class="btn px-md-5 py-md-3 btn-primary float-end">{{ trans('labels.submit') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 d-lg-block d-none table-booking-1 p-0">
                        <img src="{{ helper::image_path(@helper::appdata()->booknow_bg_image) }}"
                             class="w-100 object-fit-cover rounded-5" alt="table booking">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- slider-gallery start Here -->
    @if (count($getgalleries) > 0)
        <section class="gallery pb-5 position-relative">
            <div class="container">
                <div class="row align-items-center mb-sm-5 mb-4">
                    <div class="gallery-heading col-auto menu-heading">
                        <h1 class="text-uppercase">{{ trans('labels.gallery') }}</h1>
                        <p class="sub-lables text-capitalize mt-2 mb-0">{{ trans('labels.our_gallery') }}</p>
                    </div>
                </div>
            </div>
            <div class="gallery-slider owl-carousel owl-theme">
                @foreach ($getgalleries as $image)
                    <div class="item" data-src="{{ $image->image_url }}" data-fancybox="gallery"
                         data-thumb="{{ $image->image_url }}">
                        <img src="{{ helper::image_path($image->image) }}" class="rounded-4" alt="">
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Blog Section Start Here -->
    @if (@helper::checkaddons('blog'))
        @if (count($getblogs) > 0)
            <section>
                <div class="blog-wrapper sec-padding pt-4">
                    <div class="container">
                        <div class="row g-2 align-items-center justify-content-between mb-sm-5 mb-4">
                            <div class="col-auto blog-heading">
                                <h1 class="text-uppercase">{{ trans('labels.latest_blogs') }}</h1>
                                <p class="sub-lables text-capitalize mt-2 mb-0">{{ trans('labels.top_blogs') }}</p>
                            </div>
                            <div class="col-auto">
                                <a href="{{ helper::branch_route('userblogs') }}"
                                   class="btn btn-sm btn-outline-primary px-4 py-2 rounded-3">{{ trans('labels.view_all') }}</a>
                            </div>
                        </div>
                        <div class="row g-sm-4 g-3">
                            @foreach ($getblogs as $bloglist)
                                @include('web.blogs.blogview')
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- Blog Section End Here -->


    <!-- slider-gallery end Here -->
    <style>
        .county-details p {
            color: #8e8e8e; /* Apply color to all paragraphs */
        }

        .county-details h1 {
            color: #5e5e5e; /* Apply color to all h1 tags */
        }

        .county-details span {
            color: #8e8e8e; /* Apply color to all span tags */
        }

        .county-details {
            margin-top: 40px;
            display: block; /* Ensures the content is block-level for better layout */
            margin-bottom: 1em; /* Adds some space below the content */
            font-family: 'Arial', sans-serif; /* Sets a clean, readable font */
            line-height: 1.6; /* Increases line height for better readability */
            color: #989898 !important; /* Sets the text color to a dark gray for contrast */
            padding: 10px; /* Adds padding around the content for better spacing */
            /*border: 1px solid #ddd; !* Adds a subtle border for structure *!*/
            border-radius: 5px; /* Adds rounded corners for a more modern look */
            /*background-color: #f9f9f9; !* Light background color to enhance readability *!*/
        }


        /* Optional: Add responsive styling if needed */
        @media (max-width: 768px) {
            .county-details {
                font-size: 14px; /* Adjust font size for smaller screens */
                padding: 8px; /* Reduce padding for smaller screens */
            }
        }

        @media (min-width: 1440px) {
            .col-lg-2-4 {
                flex: 0 0 20%; /* Makes the columns take up 20% of the container on large screens */
                max-width: 20%;
            }
        }

        .round-button {
            width: 70px; /* adjust to your desired width */
            height: 70px; /* adjust to your desired height */
            border-radius: 50% !important; /* make the corners fully rounded */
            border: 1px solid;
            cursor: pointer;
            background-color: #f48384;
            transition: background-color 0.3s ease; /* Smooth transition for background color */

        }

        .round-button:hover {
            background-color: #DE1616; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
        }

        .round-button.selected {
            background-color: #DE1616 !important;
            color: #fff; /* Optional: Change text color for better visibility */
        }


        .topping-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two columns with equal width */
            gap: 16px; /* Adjust gap between rows and columns */

            align-items: center; /* Center items vertically */
        }

        .topping-grid .topping-item {
            width: 100%; /* Ensure consistent width */
            text-align: center; /* Center content */
            padding: 10px;
            border: 1px solid #ccc; /* Optional: Add a border for visual clarity */
            border-radius: 8px; /* Optional: Add rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Optional: Add a subtle shadow */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Optional: Add hover effects */
        }

        .topping-grid .topping-item:hover {
            transform: translateY(-5px); /* Lift item slightly on hover */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Enhance shadow on hover */
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
            background-color: #DE1616; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
        }


        .btn.btn-primary {
            padding: 9px !important;
            font-weight: 500;
            font-size: 12px;
            color: white;
        }

        .btn.active {
            background-color: #DE1616; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
            border-color: #DE1616;
        }

        .btn.btn-primary:hover {
            background-color: #DE1616; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
            border-color: #DE1616;
        }

        .pizza-topping__part {
            display: inline-flex;
            flex-direction: column; /* Stack SVG and label vertically */
            align-items: center; /* Center align SVG and label */
            margin: 5px;
            cursor: pointer;
        }

        .pizza-topping__icon {
            width: 30px;
            height: 30px;
            fill: lightgray; /* Default icon color */
            transition: fill 0.3s;
        }

        .pizza-topping__part input:checked + svg {
            fill: #DE1616; /* Highlight color on selection */
        }

        .pizza-topping__label {
            margin-top: 5px; /* Add some space between SVG and label */
            font-size: 14px;
            color: #333;
        }

        #myPizzaCard {
            position: sticky;
            top: 15px; /* Adjust the top position for the sticky card */
            z-index: 1050; /* Ensure it's above other content */
        }

        @media (max-width: 767px) {
            #myPizzaCard {
                position: relative; /* For mobile screens, we can revert to a non-sticky position */
                margin-top: 10px; /* Add a bit of spacing on top for smaller screens */
            }
        }

        @media (min-width: 992px) {
            .modal-lg, .modal-xl {
                --bs-modal-width: 900px;
            }
        }

        .carousel-caption {
            position: absolute;
            bottom: 20px; /* Adjust the space from the bottom of the image */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            z-index: 10;
        }

        .carousel-caption h5 {
            margin-top: 140px; /* Moves the title lower */
        }

        .button-container {
            margin-top: 20px; /* Adds a gap between the title and the buttons */
            display: flex;
            justify-content: center; /* Centers buttons horizontally */
            gap: 100px; /* Space between the buttons */
        }

        .carousel-item img {
            object-fit: cover; /* Ensures the image covers the entire space */
        }

        /*.gallery-slider .item {*/
        /*    width: 345px !important; !* Fixed width *!*/
        /*    height: 340px; !* Fixed height *!*/
        /*    margin: 10px; !* Add spacing *!*/
        /*}*/

        /*.gallery-slider .item img.fixed-dimensions {*/
        /*    width: 100%; !* Make the image fit the fixed container *!*/
        /*    height: 100%; !* Stretch the image to fill the container *!*/
        /*    object-fit: cover; !* Ensure proper scaling *!*/
        /*}*/
        @media (max-width: 786px) {
            .carousel-caption h5 {
                margin-top: 90px; /* Moves the title lower */
            }
        }

        /*.blog-wrapper .owl-item {*/
        /*    width: 360px !important; !* Set the fixed width *!*/
        /*}*/
    </style>
@endsection
@section('scripts')
    <!-- JS For Promotional Banner Section 1 -->
    <script>
        $(document).ready(function () {
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
        $(document).ready(function () {
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
        $(document).ready(function () {
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
                rtl: @if (session()->get('direction') == '2') true @else false @endif,
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
            rtl: @if (session()->get('direction') == '2') true @else false @endif,
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
