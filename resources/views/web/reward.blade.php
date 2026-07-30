@extends('web.layout.default')
@section('page_title')
    | Location
@endsection
@section('content')
    <div class="container my-5">
        <!-- Header -->
        <h1 class="custom-heading-top ">CHEESY BITE'S </h1>
        <h1 class="custom-heading-bottom ">REWARDS</h1>
        <p class="sub-heading">NOW, EARN <span class="text-danger fw-bold">FREE</span> CHEESY BITE'S EVERY 2 ORDERS</p>
        <div class="text-center mb-3">
            <small>1 ORDER OF $5 OR MORE = 10 POINTS</small>
        </div>
        @if(!auth()->user())
            <div class="justify-content-center gap-2 d-flex  ">
                <div class="d-flex justify-content-center gap-2 mb-5 border border-radius  p-3">
                    <a href="{{ URL::to('/login') }}" class="btn btn-danger px-4">Sign In</a>
                    <span class="mt-2 text-muted">-or-</span>
                    <a href="{{ URL::to('/register') }}" class="btn btn-danger px-4">Join Now</a>
                </div>
            </div>
        @endif
        <!-- Rewards Options -->
        <div class="container">
            <!-- Cards Row -->
            <div class="row text-center">
                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card border p-3 rounded shadow-sm mb-5">
                        <img src="{{ asset('assets/images/default.png') }}" alt="default" loading="lazy" decoding="async" />
                        <p class="mt-4"><strong>CHOOSE FROM:</strong> Free Dip Cup, 16-Piece Bread Bites, or 20 Oz Drink
                        </p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card border p-3 rounded shadow-sm mb-5">
                        <img src="{{ asset('assets/images/default.png') }}" alt="default" loading="lazy" decoding="async" />

                        <p class="mt-4"><strong>CHOOSE FROM:</strong> Free Bread Twists OR Stuffed Cheesy Bread</p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card border p-3 rounded shadow-sm mb-5">
                        <img src="{{ asset('assets/images/default.png') }}" alt="default" loading="lazy" decoding="async" />

                        <p class="mt-4">
                            <strong>CHOOSE FROM:</strong> Free Medium 2-Topping Pizza, Pasta, Oven-Baked Sandwich,
                            or 3-Piece Chocolate Lava Crunch Cakes
                        </p>
                    </div>
                </div>
            </div>

            <!-- Divider Line with Badges -->
            <div class="position-relative divider-container">
                <!-- Divider Line -->
                <div class="divider"></div>
                <!-- Points Badges -->
                <div class="points-badge" style="left: 16.5%;">20 <br> POINTS</div>
                <div class="points-badge" style="left: 50%;">40 <br> POINTS</div>
                <div class="points-badge" style="left: 83.5%;">60 <br> POINTS</div>
            </div>
        </div>


        <!-- More Rewards -->
        <div class="rewards-section text-center justify-content-center py-4">
            <span class="loyalty-rewards__flag--wrapper grid__cell--1 py-4 !py-4">
                <h2 class="loyalty-rewards__flag">More choices</h2>
            </span>

        </div>

        <!-- Claim Points Section -->
        <div class=" text-center rounded">
            <div class="my-4">
                <!-- First Item -->
                <div class="border rounded py-3 px-4 my-2 mx-auto" style="max-width: 600px;">
                    <span class="fw-bold text-muted d-block mb-1">EXCLUSIVE ACCESS TO</span>
                    <span class="text-warning">MEMBER-ONLY DEALS</span>
                </div>
                <!-- Second Item -->
                <div class="border rounded py-3 px-4 my-2 mx-auto" style="max-width: 600px;">
                    <span class="fw-bold text-muted d-block mb-1">OPPORTUNITIES TO EARN</span>
                    <span class="text-success">BONUS POINTS</span> AND MORE
                </div>
                <!-- Third Item -->
                <div class="border rounded py-3 my-2 mx-auto" style="max-width: 600px;">
                    <span class="fw-bold text-muted d-block mb-1">SPECIAL DISCOUNTS</span>
                    DURING MEMBER APPRECIATION WEEKS
                </div>
            </div>
        </div>


        <div class="border p-4 my-5 rounded d-flex flex-column flex-md-row align-items-center justify-content-between"
             style="max-width: 800px; margin: 0 auto;">
            <!-- Left Icon -->
            <div class="mb-3 mb-md-0 me-md-5 text-center text-md-start">
                <i class="fas fa-file-invoice text-danger" style="font-size: 50px;"></i>
            </div>

            <!-- Middle Content -->
            <div class="text-center text-md-start flex-grow-1 mb-3 mb-md-0">
                <h5 class="fw-bold text-warning mb-1">CLAIM POINTS FOR A PREVIOUS ORDER</h5>
                <p class="mb-0 text-muted" style="font-size: 14px;">
                    Get Points For A Qualifying<br>
                    Order Placed Within The Last 30 Days
                </p>
            </div>

            <!-- Claim Now Button -->
            <div class="text-center text-md-end">
                <button class="btn btn-danger px-4">CLAIM NOW</button>
            </div>
        </div>


        <div class="rewards-section text-center justify-content-center py-4">
            <span class="loyalty-rewards__flag--wrapper grid__cell--1 py-4 !py-4">
                <h2 class="loyalty-rewards__flag">PROGRAM DETAILS</h2>
            </span>

        </div>
        <!-- Program Details -->
        <div class="text-center">
            <h4 class="text-danger mb-3"></h4>
            <div>
                <h1 class="text-secondary" style="color: #D6B62B !important;">EARN REWARD POINTS</h1>
                <span style="font-size: 14px">Just Place An Order Of $5 Or More To Earn 10 Points Toward Select</span>
                <span class="text-warning">Cheesy Bite's Rewards Items</span>.
            </div>
            <div class="mt-5">
                <h1 class="text-secondary" style="color: #D6B62B !important;">REDEEM REWARD POINTS</h1>
                <span> Use Your Points For Rewards On Select Items.</span>
            </div>
        </div>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        /* Divider Line */
        .divider {
            width: 100%;
            height: 28px;
            background: linear-gradient(to right, #ac1515, #D6B62B);
            position: relative;
        }

        /* Points Badges Styling */
        .points-badge {
            background: #ffffff;
            color: #ac1516;
            font-weight: bold;
            border-radius: 50%;
            border: 8px solid gray;
            width: 80px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: -25px; /* Half sits on the divider */
            transform: translateX(-50%);
            text-align: center;
            font-size: 0.9rem;
            line-height: 1.2;
        }


        .loyalty-rewards__container {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-align: center;
            align-items: center;
            margin: 8rem 1rem 1rem
        }

        .loyalty-rewards__flag--wrapper {
            filter: url('data:image/svg+xml;charset=utf-8,<svg xmlns="http://www.w3.org/2000/svg"><filter id="filter"><feGaussianBlur in="SourceAlpha" stdDeviation="16" /><feOffset dx="1" dy="1" result="offsetblur" /><feFlood flood-color="rgba(247,0,45,0.5)" /><feComposite in2="offsetblur" operator="in" /><feMerge><feMergeNode /><feMergeNode in="SourceGraphic" /></feMerge></filter></svg>#filter');
            filter: drop-shadow(0 .25rem .5rem rgba(247, 0, 45, .5));
            z-index: 1;
            margin: 10px auto
        }

        .loyalty-rewards__flag {
            font-family: One Dot Extended Bold, One Dot Condensed Bold, Arial Narrow, Arial, Helvetica, sans-serif;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            clip-path: polygon(0 0, 100% 0, 95% 50%, 100% 100%, 0 100%, 5% 50%);
            -webkit-clip-path: polygon(0 0, 100% 0, 95% 50%, 100% 100%, 0 100%, 5% 50%);
            background: #e70023;
            margin: -1.5rem auto;
            padding: .75rem 4rem;
            color: #fff;
            font-size: .9rem;
            letter-spacing: .35rem;
            line-height: 1rem;
            text-transform: uppercase;
            text-align: center;
            width: fit-content
        }

        @media screen and (max-width: 374px) {
            .loyalty-rewards__flag {
                padding: .75rem 3rem
            }
        }


        .custom-heading-top, .custom-heading-bottom {
            font-weight: bold;
            text-align: center;
            margin-bottom: 1rem;
            color: #D6B62B;
        }

        /* Small screens (default) */
        .custom-heading-top {
            font-size: 1.5rem; /* Normal font size for small screens */
            letter-spacing: normal;
            color: #D6B62B;
        }

        .custom-heading-bottom {
            font-size: 2.5rem; /* Normal font size for small screens */
        }

        /* Screens larger than 425px */
        @media (min-width: 426px) {
            .custom-heading-top {
                font-size: 56px; /* Font size for larger screens */
                letter-spacing: 12px;
            }

            .custom-heading-bottom {
                font-size: 100px;
            }
        }

        /* Screens larger than 786px */
        @media (min-width: 786px) {
            .custom-heading-top {
                font-size: 96px; /* Font size for even larger screens */
                letter-spacing: 12px;
            }

            .custom-heading-bottom {
                font-size: 150px;
            }
        }

        .sub-heading {
            font-size: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .rewards-section {
            margin: 3rem 0;
        }

        @media (max-width: 576px) {
            .custom-heading {
                font-size: 1.8rem;
            }
        }
    </style>
@endsection
