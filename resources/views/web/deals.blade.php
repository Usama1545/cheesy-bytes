@extends('web.layout.default')
@section('page_title')
    | {{ 'Deals' }}
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
                            aria-current="page"> {{ 'deals' }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section class="theme-1-top-deal menu-special position-relative sec-padding bg-primary-rgb">

        <div class="container mt-2">
            <div class="row g-4">

                <div class="d-none d-md-block">
                    @include('web.home1.dealsStack') <!-- Show on md and larger -->
                </div>

                <div class="d-block d-md-none">
                    @include('web.home1.dealsMobileStack') <!-- Show only on smaller than md -->
                </div>

            </div>
        </div>

    </section>

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

        .gallery-slider .item {
            width: 345px !important; /* Fixed width */
            height: 340px; /* Fixed height */
            margin: 10px; /* Add spacing */
        }

        .gallery-slider .item img.fixed-dimensions {
            width: 100%; /* Make the image fit the fixed container */
            height: 100%; /* Stretch the image to fill the container */
            object-fit: cover; /* Ensure proper scaling */
        }

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
                autoplaySpeed: 3000,
                smartSpeed: 3000,
                autoplayTimeout: 3000,
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
