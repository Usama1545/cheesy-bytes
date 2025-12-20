<?php
use App\Helpers\helper;

$helper = new App\Helpers\helper();
$itemData = $helper->getTopFourDeals();
$count = count($itemData);
$heightClass = 'dynamic-height-' . min($count, 3); // Max 3 for the height classes
?>

<div class="container container-model py-5">
    <div class="deals-wrapper justify-content-center">
        @if (isset($itemData[0]))
            <!-- Left Image with Heading and Button -->
            @php
                $item = $itemData[0];
                if ($item->deal_type !== 3 && $item->deal_type !== 1 && $item->deal_type !== 4) {
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
                        $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                    } elseif (@$item->offer_type !== 1 && @$item->deal_type == 1) {
                        $price = $item->product->original_price - $item->dealPrice;
                        $off = 0;
                        $original_price = $item->product->original_price ?? $item->offer_amount;
                    } else {
                        $price = $item->dealPrice - $item->offer_amount;
                        $original_price = $item->dealPrice;
                        $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                    }
                } else {
                    $price = $item->dealPrice;
                    $off = 0;
                    $original_price = $item->product->original_price;
                }
            @endphp
            <div class="deal-card left-deal-card">
                <img src="{{ @helper::image_path($item->product['item_image']->image_name) }}" alt="Main Deal"
                    class="left-image {{ $heightClass }}">
                <div class="deal-overlay {{ $heightClass }}">
                    <div>
                        <!--<div class="deal-heading">{{ $item->product->item_name }}</div>-->
                    </div>
                    <div>
                        @if ($item->deal_type !== 3 && $item->deal_type !== 4 && $item->deal_type !== 2 && $item->deal_type !== 0)
                            <div class="d-flex align-items-start">
                                <div class="d-flex flex-column align-items-center" style="line-height: 1;">
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
                                        <del class="text-muted">{{ helper::currency_format($original_price) }}</del>
                                    </small>
                                </div>
                            @endif
                        @endif

                        @if (
                            $item->deal_type == 1 ||
                                $item->deal_type == 3 ||
                                $item->deal_type == 4 ||
                                $item->deal_type == 2 ||
                                $item->deal_type == 0)
                            <a class="btn btn-sm deal-button btn-secondary fw-500 py-2 px-3 float-start rounded-3 d-flex gap-1 justify-content-center align-items-center addon_modal_{{ $item->product->slug }}"
                                href="{{ helper::branch_route('bogoDealDetails', ['id' => $item->deal_id]) }}">
                                Select
                                <i class="fa-solid fa-plus addon_modal_icon_{{ $item->product->slug }}"></i>
                                <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}"></div>
                            </a>
                        @else
                            <button
                                class="btn btn-sm deal-button btn-secondary fw-500 px-3 py-2 float-start rounded-3 d-flex gap-1 justify-content-center align-items-center addon_modal_{{ $item->product->slug }}"
                                onclick="showdealitem('{{ $item->product->slug }}','{{ $item->deal_id }}','{{ URL::to('/show-deal-item') }}')">
                                {{ trans('labels.add') }}
                                <i class="fa-solid fa-plus addon_modal_icon_{{ $item->product->slug }}"></i>
                                <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}"></div>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        @if ($count > 1)
            <!-- Right Images -->
            <div class="right-images">
                @for ($i = 1; $i < $count; $i++)
                    @if (isset($itemData[$i]))
                        @php
                            $item = $itemData[$i];
                            if ($item->deal_type !== 3 && $item->deal_type !== 1 && $item->deal_type !== 4) {
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
                        @endphp
                        <div class="deal-card">
                            <img src="{{ @helper::image_path($item->product['item_image']->image_name) }}"
                                class="deal-image" alt="Deal {{ $i }}">
                            <div class="deal-overlay">
                                <div>
                                    <!--<div class="deal-heading">{{ $item->product->item_name }}</div>-->
                                    @if ($i >= 2)
                                        <!-- Only show description for 3rd and 4th items -->
                                        <div class="deal-description">{{ $item->product->item_description }}</div>
                                    @endif
                                </div>
                                <div>
                                    @if ($item->deal_type !== 3 && $item->deal_type !== 4 && $item->deal_type !== 2 && $item->deal_type !== 0)
                                        <div class="d-flex align-items-start">
                                            <div class="d-flex flex-column align-items-center" style="line-height: 1;">
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
                                    @if ($item->deal_type == 1 || $item->deal_type == 3 || $item->deal_type == 4)
                                        <a class="btn btn-sm deal-button btn-secondary fw-500 py-2 px-3 float-start rounded-3 d-flex gap-1 justify-content-center align-items-center addon_modal_{{ $item->product->slug }}"
                                            href="{{ helper::branch_route('bogoDealDetails', ['id' => $item->deal_id]) }}">
                                            Select
                                            <i
                                                class="fa-solid fa-plus addon_modal_icon_{{ $item->product->slug }}"></i>
                                            <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}">
                                            </div>
                                        </a>
                                    @elseif($item->deal_type == 2 || $item->deal_type == 0)
                                        <a class="btn btn-sm deal-button btn-secondary fw-500 py-2 px-3 float-start rounded-3 d-flex gap-1 justify-content-center align-items-center addon_modal_{{ $item->product->slug }}"
                                            href="{{ helper::branch_route('flatDealDetails', ['id' => $item->deal_id]) }}">
                                            Select
                                            <i
                                                class="fa-solid fa-plus addon_modal_icon_{{ $item->product->slug }}"></i>
                                            <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}">
                                            </div>
                                        </a>
                                    @else
                                        <button
                                            class="btn btn-sm deal-button btn-secondary fw-500 px-3 py-2 float-start rounded-3 d-flex gap-1 justify-content-center align-items-center addon_modal_{{ $item->product->slug }}"
                                            onclick="showdealitem('{{ $item->product->slug }}','{{ $item->deal_id }}','{{ URL::to('/show-deal-item') }}')">
                                            {{ trans('labels.add') }}
                                            <i
                                                class="fa-solid fa-plus addon_modal_icon_{{ $item->product->slug }}"></i>
                                            <div class="loader d-none addon_modal_loader_{{ $item->product->slug }}">
                                            </div>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        @endif
    </div>
</div>

<style>
    .sec-padding {
        padding: 10px 0px;
    }

    .container-model {
        display: flex;
        justify-content: center;
        background-color: transparent;
        flex-wrap: wrap;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .deals-wrapper {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        gap: 10px;
    }

    /* Common card styling */
    .deal-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* Images */
    .left-deal-card img,
    .right-images .deal-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Hover effect */
    .deal-card:hover .deal-image {
        transform: scale(1.03);
    }

    /* Overlay content */
    .deal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 1rem;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .deal-heading {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .deal-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #ff0000 !important;
    }

    .deal-description {
        font-size: 0.9rem;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .deal-button {
        background-color: #ff0000 !important;
        border: none;
        color: #fff;
        padding: 7px 7px;
        border-radius: 5px;
        font-size: 0.8rem;
        text-transform: uppercase;
        font-weight: bold;
        cursor: pointer;
    }

    /* --- RESPONSIVE LAYOUT --- */

    /* DESKTOP VIEW */
    @media (min-width: 992px) {
        .deals-wrapper {
            flex-direction: row;
        }

        .left-deal-card {
            flex: 1 1 60%;
            aspect-ratio: 1 / 1;
            /* Square */
            max-width: 530px;
            max-height: 530px;
        }

        .right-images {
            flex: 1 1 38%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 390px;
        }

        .right-images .deal-card {
            flex: 1;
            aspect-ratio: 3 / 2;
            /* 390x260 */
            max-height: 260px;
        }
    }

    /* TABLET & MOBILE VIEW */
    @media (max-width: 991px) {
        .deals-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .left-deal-card,
        .right-images .deal-card {
            width: 100%;
            max-width: 306px;
            aspect-ratio: 1 / 1;
            /* Square */
        }

        .right-images {
            flex-direction: column;
            width: 100%;
            align-items: center;
        }
    }

    .container-model {
        display: flex;
        justify-content: center;
        background-color: transparent;
        flex-wrap: wrap;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .deals-wrapper {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        gap: 10px;
    }

    /* Common card styling */
    .deal-card {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* Images */
    .left-deal-card img,
    .right-images .deal-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Hover effect */
    .deal-card:hover .deal-image {
        transform: scale(1.03);
    }

    /* Overlay content */
    .deal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 1rem;
        color: #fff;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .deal-heading {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .deal-price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #ff0000 !important;
    }

    .deal-description {
        font-size: 0.9rem;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .deal-button {
        background-color: #ff0000 !important;
        border: none;
        color: #fff;
        padding: 7px 7px;
        border-radius: 5px;
        font-size: 0.8rem;
        text-transform: uppercase;
        font-weight: bold;
        cursor: pointer;
    }

    /* --- RESPONSIVE LAYOUT --- */

    /* DESKTOP VIEW */
    @media (min-width: 992px) {
        .deals-wrapper {
            flex-direction: row;
        }

        .left-deal-card {
            flex: 1 1 60%;
            aspect-ratio: 1 / 1;
            /* Square */
            max-width: 530px;
            max-height: 530px;
        }

        .right-images {
            flex: 1 1 38%;
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 390px;
        }

        .right-images .deal-card {
            flex: 1;
            aspect-ratio: 3 / 2;
            /* 390x260 */
            max-height: 260px;
        }
    }

    /* TABLET & MOBILE VIEW */
    @media (max-width: 991px) {
        .deals-wrapper {
            flex-direction: column;
            align-items: center;
        }

        .left-deal-card,
        .right-images .deal-card {
            width: 100%;
            max-width: 306px;
            aspect-ratio: 1 / 1;
            /* Square */
        }

        .right-images {
            flex-direction: column;
            width: 100%;
            align-items: center;
        }
    }
</style>
