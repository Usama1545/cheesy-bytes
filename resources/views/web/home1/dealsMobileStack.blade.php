<?php

use App\Helpers\helper;

$helper = new App\Helpers\helper();
$itemData = $helper->getTopHomeDeals();
$count = count($itemData);

?>
@push('style-lib')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

<div class="container py-2">

    @if ($count > 0)
        <div id="dealsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @for ($i = 0; $i < $count; $i++)
                    @if (isset($itemData[$i]))
                        @php
                            $item = $itemData[$i];
                            if ($item->deal_type !== 3 && $item->deal_type !== 1) {
                                if (@$item->offer_type !== 1) {
                                    if (@$item->offer_type == 1) {
                                        $price =
                                            $item->dealPrice > @$item->offer_amount
                                                ? $item->dealPrice - @$item->offer_amount
                                                : $item->dealPrice;
                                    } else {
                                        $price = $item->dealPrice - $item->dealPrice * (@$item->offer_amount / 100);
                                    }
                                    $original_price = $item->dealPrice;
                                    $off =
                                        $original_price > 0
                                            ? number_format(100 - ($price * 100) / $original_price, 1)
                                            : 0;
                                } elseif (@$item->offer_type !== 1 && @$item->deal_type == 1) {
                                    $price = $item->product->original_price - $item->dealPrice;
                                    $off = 0;
                                    $original_price = $item->product->original_price ?? $item->offer_amount;
                                } else {
                                    $price = $item->dealPrice - $item->offer_amount;
                                    $original_price = $item->dealPrice;
                                    $off =
                                        $original_price > 0
                                            ? number_format(100 - ($price * 100) / $original_price, 1)
                                            : 0;
                                }
                            } else {
                                $price = $item->dealPrice;
                                $off = 0;
                                $original_price = $item->product->original_price;
                            }
                            $buttonConfig = \App\Helpers\Helper::getButtonConfig($item);

                        @endphp

                        <div class="carousel-item @if ($i == 0) active @endif">
                            <div class="carousel-card position-relative overflow-hidden rounded">
                                <img src="{{ @helper::image_path($item->web_image) }}"
                                    class="w-100 h-100 object-fit-cover" alt="{{ $item->product->item_name }}">
                                <div
                                    class="position-absolute top-0 start-0 w-100 h-100 bg-transparent p-3 d-flex flex-column justify-content-between text-white">
                                    <div>
                                        <h5 class="fw-bold mb-2"></h5>
                                        @if ($i >= 2)
                                            <p class="small">{{ $item->product->item_description }}</p>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column align-items-end">
                                        @if ($item->deal_type !== 3)
                                            <div class="d-flex align-items-start">
                                                <div class="d-flex flex-column align-items-center"
                                                    style="line-height: 1;">
                                                    <span class="fs-6 ">$</span>
                                                </div>
                                                <div class="d-flex flex-column ms-1" style="line-height: 1;">
                                                    <div class="d-flex">
                                                        <span class="fs-1 fw-bold line-1">{{ floor($price) }}</span>
                                                        <div class="line-1">
                                                            <span
                                                                class="fs-6  line-1">{{ sprintf('%02d', ($price - floor($price)) * 100) }}</span>
                                                            <small class="ms-1 ">each</small>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            @if ($original_price > $price)
                                                <div>
                                                    <small>
                                                        <del
                                                            class="text-muted">{{ helper::currency_format($original_price) }}</del>
                                                    </small>
                                                </div>
                                            @endif
                                        @endif


                                        <div class="mt-2">
                                            @if ($buttonConfig['type'] === 'link')
                                                <a href="{{ $buttonConfig['url'] }}" class="deal-button addon_modal_{{ $item->product->slug }}"
                                                    onclick="event.stopPropagation()">
                                                    <span>{{ $buttonConfig['text'] }}</span>
                                                    <i class="fa-solid fa-plus"></i>
                                                    <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}"></div>
                                                </a>
                                            @else
                                                <button onclick="{{ $buttonConfig['action'] }}"
                                                    class="deal-button addon_modal_{{ $item->product->slug }}" type="button">
                                                    <span>{{ $buttonConfig['text'] }}</span>
                                                    <i class="fa-solid fa-plus"></i>
                                                    <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}"></div>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#dealsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#dealsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    @endif
</div>


<style>
    .carousel-item img {
        object-fit: fill !important;
    }


    /* Custom carousel control styles */
    #dealsCarousel .carousel-control-prev,
    #dealsCarousel .carousel-control-next {
        height: 15%;
        /*background-color: #D6B62B; */
        border-radius: 50%;
        /* Makes it circular */
        top: 50%;
        opacity: 1;
        transform: translateY(-50%);
    }

    .carousel-control-next,
    .carousel-control-prev {
        width: 5% !important;
        margin-left: 5px;
    }

    .carousel-control-next,
    .carousel-control-next {
        width: 5% !important;
        margin-right: 5px;
    }

    /* Change the default icon to a custom one */
    #dealsCarousel .carousel-control-prev-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E");
    }

    #dealsCarousel .carousel-control-next-icon {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
    }

    /* Hover effects */
    #dealsCarousel .carousel-control-prev:hover,
    #dealsCarousel .carousel-control-next:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    /* Deal card common styles */
    .carousel-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        width: 100%;
        height: 200px;
        flex: 0 0 100%;
        /* prevent shrinking */
    }
</style>
