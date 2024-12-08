@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.menu') }} | {{ @$categorydata->category_name }}
@endsection
@section('content')
    @if (!empty($categorydata))
        {{--        <div class="breadcrumb-sec mb-3">--}}
        {{--            <div class="container">--}}
        {{--                <div class="breadcrumb-sec-content">--}}
        {{--                    <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">--}}
        {{--                        <ol class="breadcrumb">--}}
        {{--                            <li--}}
        {{--                                class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">--}}
        {{--                                <a class="text-dark fw-600" href="{{ URL::to('/') }}">{{ trans('labels.home') }}</a>--}}
        {{--                            </li>--}}
        {{--                            <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"--}}
        {{--                                aria-current="page">{{ @$categorydata->category_name }}</li>--}}
        {{--                        </ol>--}}
        {{--                    </nav>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        <section class="menu-section">

            <div class="container">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <div>
                        <h2 class="my-3 text-uppercase">
                            CHEESY BITE {{ $categorydata->category_name }}
                        </h2>
                        <p class="mb-0" style="font-size: 12px; color: gray;">
                            Discover Everything On
                        </p>
                        <p class="mb-4" style="font-size: 12px; color: gray;">
                            The Cheesy Bite Lunch
                        </p>
                    </div>
                    <div>
                        @if(strtolower(@$categorydata->category_name) == strtolower('Pizza'))
                            <button
                                class="btn btn-sm btn-secondary fw-500 py-2 px-4 rounded-3 d-flex justify-content-center align-items-center"
                                data-bs-toggle="modal" data-bs-target="#customPizzaModal"
                                style="min-width: 120px;">
                                Create Pizza
                                <i class="fa fa-solid fa-plus ms-2"></i>
                                <div class="loader d-none"></div>
                            </button>
                        @endif
                    </div>
                </div>

                <div class="row">

                    @if (count($getitemlist) > 0)
                        <div class="menu my-0">
                            <div class="row g-4 boxes">
                                @foreach ($getitemlist as $subcategory => $groupItems)
                                    <div class="card mx-1" style="background-color: #D6B62B">
                                        <h5 class="my-3 text-uppercase fw-bold"> {{ $subcategory }}</h5>
                                    </div>

                                    @foreach ($groupItems as $itemdata)

                                        <div class="col-12 col-lg-2-4 col-md-4 col-sm-12">
                                            <div class="w-full" style="">
                                                <div class="card  overflow-hidden h-100">
                                                    <a href="{{ URL::to('item-' . $itemdata->slug) }}">

                                                        <img
                                                            src="{{ @helper::image_path($itemdata['item_image']->image_name) }}"
                                                            class="card-img-top border-0 rounded-0 rounded-top position-relative"
                                                            alt="dishes" height="190px">

                                                    </a>

                                                    @php
                                                        if ($itemdata->is_top_deals == 1 && $topdeals != null) {
                                                            if (@$topdeals->offer_type == 1) {
                                                                if ($itemdata->item_price > @$topdeals->offer_amount) {
                                                                    $price = $itemdata->item_price - @$topdeals->offer_amount;
                                                                } else {
                                                                    $price = $itemdata->item_price;
                                                                }
                                                            } else {
                                                                $price = $itemdata->item_price - $itemdata->item_price * (@$topdeals->offer_amount / 100);
                                                            }
                                                            $original_price = $itemdata->item_price;
                                                            $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                                                        } else {
                                                            $price = $itemdata->item_price;
                                                            $original_price = $itemdata->original_price;
                                                            $off = $itemdata->discount_percentage;
                                                        }
                                                    @endphp
                                                    <div class="card-body pb-0 border-bottom">
                                                        <h5 class="item-card-title pb-3 fs-6 d-flex justify-content-between align-items-center">
                                                            <a href="{{ URL::to('item-' . $itemdata->slug) }}"
                                                               class="flex-grow-1">
                                                                <p class="item-card-title mb-0 line-2 fs-7">
                                                                    {{ $itemdata->item_name }}
                                                                </p>
                                                            </a>
                                                            <div class="d-flex gap-1">
                                                                @if ($original_price > $price)
                                                                    <del
                                                                        class="text-muted">{{ helper::currency_format($original_price) }}</del>
                                                                @endif
                                                                <span>{{ helper::currency_format($price) }}</span>

                                                            </div>
                                                        </h5>

                                                    </div>


                                                    @if ($off > 0)
                                                        <div
                                                            class="offer-lable {{ session()->get('direction') == '2' ? 'rtl' : '' }}">
                                                            <h5>{{ $off }}% {{ trans('labels.off') }}</h5>
                                                        </div>
                                                    @endif

                                                </div>
                                                <div class="item-card-footer mt-2">
                                                    <div class="d-flex justify-content-between align-items-center">

                                                        @if ($itemdata->is_cart == 1)
                                                            <div class="item-quantity py-1 px-5">
                                                                <button type="button" class="btn btn-sm  fw-500"
                                                                        onclick="removefromcart('{{ URL::to('/cart') }}','{{ trans('messages.remove_cartitem_note') }}','{{ trans('labels.goto_cart') }}')">
                                                                    -
                                                                </button>
                                                                <input
                                                                    class="fw-500 item-total-qty-{{ $itemdata->slug }}"
                                                                    type="text"
                                                                    value="{{ helper::get_item_cart($itemdata->id) }}"
                                                                    disabled/>
                                                                <button class="btn btn-sm fw-500 border-0"
                                                                        onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')">
                                                                    +
                                                                </button>
                                                            </div>
                                                        @else
                                                            <button
                                                                class="btn btn-sm btn-secondary fw-500 py-2 px-4 w-full float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_{{ $itemdata->slug }}"
                                                                onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')"
                                                                style="width: 100%">
                                                                Order Now

                                                                <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->slug }}"></i>
                                                                <div
                                                                    class="loader d-none addon_modal_loader_{{ $itemdata->slug }}"></div>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    @else
                        @include('web.nodata')
                    @endif
                </div>
            </div>
        </section>
    @else
        @include('web.nodata')
    @endif

    <script>

    </script>

    <style>
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
            background-color: #ac1515; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
        }

        .round-button.selected {
            background-color: #ac1515 !important;
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
            color: #ac1515;
        }
        .btn-outline-primary:hover {
            background-color: #ac1515; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
        }


        .btn.btn-primary {
            padding: 9px !important;
            font-weight: 500;
            font-size: 12px;
            color: white;
        }
        .btn.btn-primary:hover {
            background-color: #ac1515; /* Hover color for all buttons */
            color: #fff; /* Optional: Change text color on hover */
            border-color: #ac1515;
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
            fill: #ac1515; /* Highlight color on selection */
        }

        .pizza-topping__label {
            margin-top: 5px; /* Add some space between SVG and label */
            font-size: 14px;
            color: #333;
        }

        @media (min-width: 992px) {
            .modal-lg, .modal-xl {
                --bs-modal-width: 900px;
            }
        }

    </style>

@endsection
