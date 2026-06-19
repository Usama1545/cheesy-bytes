@extends('web.layout.default')
<?php
use App\Helpers\Helper;

$itemData = Helper::getBranch(); // ✅ works
?>
@section('page_title')
    {{ @$getitemdata->item_name }} {{ $getitemdata->category_info->category_name }} | {{ $itemData->seo_name }} |
@endsection
@section('meta_description')
    Craving cheesy {{ strtolower(@$getitemdata->item_name) }} {{ strtolower(@$getitemdata->category_info->category_name) }}?
    Enjoy fresh, delicious {{ strtolower(@$getitemdata->item_name) }} at our {{ $itemData->seo_name }} location. Order now!
@endsection
@section('content')
    <!-- <div class="breadcrumb-sec">
                                                        <div class="container">
                                                            <div class="breadcrumb-sec-content">
                                                                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                                                                    <ol class="breadcrumb">
                                                                        <li
                                                                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                                                                            <a class="text-dark fw-600" href="{{ route('home') }}">{{ trans('labels.home') }}</a>
                                                                        </li>
                                                                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                                                                            aria-current="page">{{ trans('item details') }}</li>
                                                                    </ol>
                                                                </nav>
                                                            </div>
                                                        </div>
                                                    </div> -->
    <section class="mt-5">
        <div class="container">
            <div class="item-details border-bottom pb-4">
                <div class="row mb-4 justify-content-between">
                    <div class="col-lg-5 col-12 mb-3">
                        <div class="item-img-cover">
                            {{-- image --}}
                            <div class="card h-100 overflow-hidden rounded-0 border-0 position-relative">
                                <!-- new big-view -->
                                <div class="sp-loading"><img src="https://via.placeholder.com/1100x1220" alt=""
                                        class="rounded-4"><br>LOADING IMAGES</div>
                                <div class="sp-wrap">
                                    @foreach ($getitemdata['item_images'] as $key => $firstimage)
                                        <a href="{{ @helper::image_path($firstimage->image_name) }}">
                                            <img src="{{ @helper::image_path($firstimage->image_name) }}" alt=""
                                                class="rounded-4"></a>
                                    @endforeach
                                </div>
                                <!-- new big-view -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <div class="item-content">
                            <div class="item-heading">
                                @php
                                    if ($getitemdata->is_top_deals == 1 && $topdeals != null) {
                                        if (@$topdeals->offer_type == 1) {
                                            if ($getitemdata->item_price > @$topdeals->offer_amount) {
                                                $price = $getitemdata->item_price - @$topdeals->offer_amount;
                                            } else {
                                                $price = $getitemdata->item_price;
                                            }
                                        } else {
                                            $price =
                                                $getitemdata->item_price -
                                                $getitemdata->item_price * (@$topdeals->offer_amount / 100);
                                        }
                                        $original_price = $getitemdata->item_price;
                                        $off =
                                            $original_price > 0
                                                ? number_format(100 - ($price * 100) / $original_price, 1)
                                                : 0;
                                    } else {
                                        $price = $getitemdata->item_price;
                                        $minPrice =
                                            (float) $price > 0
                                                ? helper::currency_format($price)
                                                : helper::currency_format($getitemdata->price);

                                        $original_price = $getitemdata->original_price;
                                        $off = $getitemdata->discount_percentage;
                                    }
                                @endphp
                                @if ($off > 0)
                                    <div class="my-2">
                                        <span class="py-1 px-2 mb-2 offer-badge">{{ $off }}%
                                            {{ trans('labels.off') }}</span>
                                    </div>
                                @endif
                                <div>
                                    <span
                                        class="text-muted fs-7 fw-500">{{ $getitemdata['category_info']->category_name }}</span>
                                </div>
                                <div class="d-flex text-align-center mt-2">
                                    <img class="col-1 {{ session()->get('direction') == 2 ? 'ms-1' : 'me-1' }}"
                                        @if ($getitemdata->item_type == 1) src="{{ helper::image_path('veg.svg') }}" @else src="{{ helper::image_path('nonveg.svg') }}" @endif
                                        alt="">
                                    <span class="item-title">{{ $getitemdata->item_name }}</span>
                                </div>
                            </div>
                            <div class="row my-2 align-items-center">
                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                    <div class="d-flex align-items-center gap-2">
                                        <p class="item-price item_price m-0 text-black subtotal_{{ $getitemdata['id'] }}"
                                            @if ($getitemdata->is_price_range && $getitemdata->max_price > 0) data-price-range-locked="1" @endif>
                                            @if ($getitemdata->is_price_range && $getitemdata->max_price > 0)
                                                {{ $minPrice . ' - ' . helper::currency_format($getitemdata->max_price) }}
                                            @else
                                                {{ helper::currency_format($price) }}
                                            @endif
                                        </p>
                                        @if (!$getitemdata->is_price_range && $original_price > $price)
                                            <del class="item-price item_price fs-7 text-muted">
                                                {{ helper::currency_format($original_price) }}</del>
                                        @endif
                                    </div>
                                    <a href="#review-tab">
                                        <div class="d-flex align-items-center">
                                            <p class="fs-8 mb-0"><i
                                                    class="text-warning fa-solid fa-star {{ session()->get('direction') == '2' ? 'ps-1' : 'pe-1' }}"></i><span
                                                    class="text-dark fw-500">{{ number_format($getitemdata->avg_ratting, 1) }}</span>
                                            </p>
                                            <span
                                                class="px-2 d-inline-block fs-8 text-muted fw-500">({{ count($itemreviewdata) }}
                                                {{ trans('labels.reviews') }})</span>
                                        </div>
                                    </a>
                                </div>

                            </div>



                            @if ($getitemdata->is_top_deals == 1 && $topdeals != null)
                                <h5 class="mt-3">⏰ {{ trans('labels.hurry_up') }}</h5>
                                <div class="product-detail-countdown d-flex border-bottom gap-2 my-3 pb-3" id="countdown">
                                </div>
                            @endif
                            @if ($isPizza && !empty($crustSizes))
                                <div class="item-details mt-3 border-bottom pb-3">

                                    {{-- SIZE --}}
                                    <h5 class="mb-2 fs-6">Select Size</h5>

                                    <div class="d-flex flex-column gap-2">

                                        @foreach ($crustSizes as $sizeIndex => $size)
                                            <div class="form-check border rounded ">
                                                <div class="p-3">

                                                    <input class="form-check-input pizza-size-radio" type="radio"
                                                        name="pizza_size_{{ $getitemdata['id'] }}"
                                                        id="pizza_size_{{ $size['id'] }}" value="{{ $size['id'] }}"
                                                        data-size-price="{{ $size['size_price'] }}"
                                                        {{ $sizeIndex == 0 ? 'checked' : '' }}
                                                        onchange="selectPizzaSize('{{ $getitemdata['id'] }}', this)">

                                                    <label class="form-check-label w-100 cursor-pointer"
                                                        for="pizza_size_{{ $size['id'] }}">

                                                        <div class="d-flex justify-content-between">
                                                            <div>
                                                                <strong>{{ $size['name'] }}</strong>
                                                                ({{ $size['label'] }}")
                                                            </div>

                                                            <div>
                                                                {{ helper::currency_format($size['size_price']) }}
                                                            </div>
                                                        </div>
                                                    </label>

                                                    {{-- CRUSTS --}}
                                                    <div class="pizza-crusts mt-2 ps-3"
                                                        id="crust_container_{{ $size['id'] }}"
                                                        style="{{ $sizeIndex == 0 ? '' : 'display:none;' }}">

                                                        @foreach ($size['crusts'] as $crustIndex => $crust)
                                                            <div class="form-check">

                                                                <input
                                                                    class="form-check-input pizza-crust-radio crust_size_{{ $size['id'] }}"
                                                                    type="radio"
                                                                    name="pizza_crust_{{ $getitemdata['id'] }}"
                                                                    id="pizza_crust_{{ $crust['id'] }}"
                                                                    value="{{ $crust['id'] }}"
                                                                    data-crust-price="{{ $crust['price'] }}"
                                                                    {{ $crustIndex == 0 ? 'checked' : '' }}
                                                                    onchange="calculatePizzaPrice('{{ $getitemdata['id'] }}')">

                                                                <label class="form-check-label w-100"
                                                                    for="pizza_crust_{{ $crust['id'] }}">
                                                                    <div class="d-flex justify-content-between">
                                                                        <span>{{ $crust['name'] }}</span>

                                                                        <span>
                                                                            +{{ helper::currency_format($crust['price']) }}
                                                                        </span>
                                                                    </div>
                                                                </label>

                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    {{-- hidden selected ids --}}
                                    <input type="hidden" id="selected_size_id_{{ $getitemdata['id'] }}"
                                        value="{{ $crustSizes[0]['id'] }}">

                                    <input type="hidden" id="selected_crust_id_{{ $getitemdata['id'] }}"
                                        value="{{ $crustSizes[0]['crusts'][0]['id'] ?? '' }}">

                                </div>
                            @endif
                            @if (!empty($getitemdata->addons_group) && count($getitemdata->addons_group) > 0)
                                <div class="row align-items-center">
                                    <div class="col-lg-12 col-md-12 col-sm-12 m-auto">
                                        <div class="addon-item-details scroll-addon-details">
                                            @foreach ($getitemdata['addons_group'] as $addons_group)
                                                @php
                                                    $availableAddons = collect($getitemdata['addons'])->where(
                                                        'addongroup_id',
                                                        $addons_group->id,
                                                    );
                                                    $addon_index = 0;
                                                @endphp
                                                @if ($availableAddons->isNotEmpty())
                                                    <div class="item-addons-list mt-3 border-bottom pb-3"
                                                        id="item_addons_group_{{ $getitemdata['id'] }}_{{ $addons_group->id }}">
                                                        <h5 class="mb-1 fs-6">{{ $addons_group->name }}</h5>
                                                        <div class="d-flex align-items-center gap-1 pb-1">
                                                            @if ($addons_group->selection_type == 1)
                                                                <i class="fa-solid fa-triangle-exclamation addon_group_color fs-8"
                                                                    id="addon_required_icon_{{ $addons_group->id }}_{{ $getitemdata['id'] }}"></i>
                                                                <span class="fs-8 fw-600 addon_group_color"
                                                                    id="addon_required_text_{{ $addons_group->id }}_{{ $getitemdata['id'] }}">{{ trans('labels.required') }}</span>
                                                                <span class="fs-8">•</span>
                                                            @elseif ($addons_group->selection_type == 2)
                                                                <span
                                                                    class="fs-8">({{ trans('labels.optional') }})</span>
                                                                <span class="fs-8">•</span>
                                                            @endif
                                                            @if ($addons_group->selection_count == 1)
                                                                <span class="fs-8">{{ trans('labels.select') }}
                                                                    1</span>
                                                            @else
                                                                <span class="fs-8">{{ trans('labels.min') }}
                                                                    {{ $addons_group->min_count }} |
                                                                    {{ trans('labels.max') }}
                                                                    {{ $addons_group->max_count }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if ($getitemdata->is_price_range && $addons_group->selection_type == 1)
                                                            {{-- Dropdown for price-range items --}}
                                                            <div class="mx-2 mt-2">
                                                                <select class="form-select"
                                                                    onchange="syncAddonSelect('{{ $getitemdata['id'] }}', '{{ $addons_group->id }}', this)">
                                                                    <option value="" selected disabled>
                                                                        Select {{ $addons_group->name ?? 'an option' }}
                                                                    </option>
                                                                    @foreach ($availableAddons as $addon)
                                                                        <option value="{{ $addon->id }}"
                                                                            data-addons-id="{{ $addon->id }}"
                                                                            data-addons-price="{{ $addon->price }}"
                                                                            data-addons-name="{{ $addon->name }}">
                                                                            {{ $addon->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                {{-- Off-screen radios: visible to jQuery :checked selectors, invisible to users --}}
                                                                @foreach ($availableAddons as $addonIdx => $addon)
                                                                    <input type="radio"
                                                                        class="form-check-input addons_chk_{{ $getitemdata['id'] }}"
                                                                        style="position:absolute;left:-9999px;width:1px;height:1px;"
                                                                        name="addons_id_{{ $addons_group->id }}_{{ $getitemdata['id'] }}"
                                                                        id="addons_{{ $addons_group->id }}_{{ $getitemdata['id'] }}_{{ $addon->id }}"
                                                                        value="{{ $addon->id }}"
                                                                        data-addons-id="{{ $addon->id }}"
                                                                        data-addons-price="{{ $addon->price }}"
                                                                        data-addons-name="{{ $addon->name }}"
                                                                        {{ $addonIdx === 0 ? 'checked' : '' }}>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            @foreach ($getitemdata['addons'] as $addons)
                                                                @if ($addons->addongroup_id == $addons_group->id)
                                                                    <div
                                                                        class="mx-2 {{ session()->get('direction') == '2' ? 'd-flex gap-2' : 'form-check' }}">
                                                                        @php
                                                                            if ($addons_group->selection_count == 1) {
                                                                                $type = 'radio';
                                                                            } elseif (
                                                                                $addons_group->selection_count == 2
                                                                            ) {
                                                                                $type = 'checkbox';
                                                                            }
                                                                            $autoSelect =
                                                                                $addons_group->selection_count == 1 &&
                                                                                $addons_group->selection_type == 1 &&
                                                                                $addon_index == 0
                                                                                    ? 'checked'
                                                                                    : '';
                                                                            $addon_index = 1;
                                                                        @endphp
                                                                        <input
                                                                            class="form-check-input cursor-pointer addons_chk_{{ $getitemdata['id'] }} {{ session()->get('direction') == '2' ? 'ms-0' : '' }}"
                                                                            type="{{ $type }}"
                                                                            value="{{ $addons->id }}"
                                                                            data-addons-id="{{ $addons->id }}"
                                                                            data-addons-price="{{ $addons->price }}"
                                                                            data-addons-name="{{ $addons->name }}"
                                                                            onclick="getaddons('{{ $getitemdata['id'] }}'); calculatePizzaPrice('{{ $getitemdata['id'] }}')"
                                                                            name="addons_id_{{ $addons_group->id }}_{{ $getitemdata['id'] }}"
                                                                            id="addons_{{ $addons_group->id }}_{{ $getitemdata['id'] }}_{{ $addons->id }}"
                                                                            {{ $autoSelect }}>
                                                                        <div
                                                                            class="d-flex justify-content-between w-100 {{ session()->get('direction') == '2' ? 'ps-2' : 'pe-2' }}">
                                                                            <label
                                                                                class="form-check-label cursor-pointer fs-7"
                                                                                for="addons_{{ $addons_group->id }}_{{ $getitemdata['id'] }}_{{ $addons->id }}">{{ $addons->name }}</label>
                                                                            <label
                                                                                class="form-check-label cursor-pointer fs-7"
                                                                                for="addons_{{ $addons_group->id }}_{{ $getitemdata['id'] }}_{{ $addons->id }}">
                                                                                {{ helper::currency_format($addons->price) }}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        @if ($addons_group->selection_type == 1)
                                                            <span
                                                                class="addons_error_{{ $addons_group->id }}_{{ $getitemdata['id'] }} text-danger fs-7 ms-2"></span>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- Item Extra --}}
                            @if (!empty($getitemdata->extras) && count($getitemdata->extras) > 0)
                                <div class="item-details mt-3">
                                    <h5 class="mb-1 fs-6">{{ trans('labels.extras') }}</h5>
                                    <div class="item-addons-list mt-2 border-bottom pb-3 px-2">
                                        @foreach ($getitemdata->extras as $extras)
                                            <div
                                                class="{{ session()->get('direction') == '2' ? 'd-flex' : 'form-check' }}">
                                                <input
                                                    class="form-check-input cursor-pointer extras_chk_{{ $getitemdata['id'] }} {{ session()->get('direction') == '2' ? 'ms-0' : '' }}"
                                                    type="checkbox" value="{{ $extras->id }}"
                                                    data-extras-id="{{ $extras->id }}"
                                                    data-extras-price="{{ $extras->price }}"
                                                    data-extras-name="{{ $extras->name }}"
                                                    id="extras_{{ $extras->id }}_{{ $getitemdata['id'] }}"
                                                    onchange="calculatePizzaPrice('{{ $getitemdata['id'] }}')"
                                                    name="extras_id_{{ $getitemdata['id'] }}"
                                                    {{ $extras->is_default ? 'checked disabled' : '' }}>

                                                <div
                                                    class="d-flex justify-content-between align-items-center w-100 text-black">
                                                    <label class="form-check-label cursor-pointer me-2 fs-7"
                                                        for="extras_{{ $extras->id }}_{{ $getitemdata['id'] }}">{{ $extras->name }}</label>
                                                    <label class="form-check-label cursor-pointer me-2 fs-7"
                                                        for="extras_{{ $extras->id }}_{{ $getitemdata['id'] }}">
                                                        {{ helper::currency_format($extras->price) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <input type="hidden" name="addongroup" id="addongroup_{{ $getitemdata['id'] }}"
                                data-addongroup_val="{{ $getitemdata['addons_group'] }}">
                            <input type="hidden" name="slug" id="slug_{{ $getitemdata['id'] }}"
                                value="{{ $getitemdata['slug'] }}">
                            <input type="hidden" name="item_name" id="item_name_{{ $getitemdata['id'] }}"
                                value="{{ $getitemdata['item_name'] }}">
                            <input type="hidden" name="item_type" id="item_type_{{ $getitemdata['id'] }}"
                                value="{{ $getitemdata['item_type'] }}">
                            <input type="hidden" name="image_name" id="image_name_{{ $getitemdata['id'] }}"
                                value="{{ $getitemdata['item_image']->image_name }}">
                            <input type="hidden" name="tax" id="item_tax_{{ $getitemdata['id'] }}"
                                value="{{ $getitemdata['tax'] }}">
                            <input type="hidden" name="item_price" id="item_price_{{ $getitemdata['id'] }}"
                                value="{{ $price }}">
                            <input type="hidden" name="item_qty" id="item_qty_{{ $getitemdata['id'] }}"
                                value="1">

                            <input type="hidden" name="request_url" id="request_url_{{ $getitemdata['slug'] }}"
                                value="{{ request()->segments()[0] }}">
                            <input type="hidden" name="login_required" id="login_required_{{ $getitemdata['slug'] }}"
                                value="{{ helper::appdata()->login_required }}">
                            <input type="hidden" name="checklogin" id="checklogin_{{ $getitemdata['slug'] }}"
                                value="{{ Auth::user() && Auth::user()->type == 2 }}">
                            <input type="hidden" name="customer_login" id="customer_login_{{ $getitemdata['slug'] }}"
                                value="{{ App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() }}">
                            <div class="border-bottom border-top py-3">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-auto col-12">
                                        <div class="d-flex align-items-center gap-2">
                                            <div>
                                                <p class="mb-0">{{ trans('labels.quantity') }} :</p>
                                            </div>
                                            <div class="btn item-quantity">
                                                <button class="btn btn-sm item-quantity-minus"
                                                    onclick="changeqty('{{ $getitemdata['slug'] }}','{{ $getitemdata['id'] }}','minus')">-</button>
                                                <input class="item-quantity-input" type="text" value="1"
                                                    readonly="" id="item_qty_{{ $getitemdata['slug'] }}">
                                                <button class="btn btn-sm item-quantity-plus"
                                                    onclick="changeqty('{{ $getitemdata['slug'] }}','{{ $getitemdata['id'] }}','plus')">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-6">
                                        <button
                                            class="btn btn-secondary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center cart"
                                            onclick="addtocart('{{ URL::to('addtocart') }}','{{ $getitemdata['id'] }}','0')">
                                            {{ trans('labels.add_to_cart') }}
                                            <div class="loader d-none cart_loader"></div>
                                        </button>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-6">
                                        @if (@helper::checkaddons('customer_login'))
                                            @if (helper::appdata()->login_required == 1)
                                                <button
                                                    class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center quick_order"
                                                    @if (helper::appdata()->is_checkout_login_required == 1) onclick="showlogin()" @else  onclick="addtocart('{{ URL::to('addtocart') }}','{{ $getitemdata['id'] }}','1')" @endif>
                                                    {{ trans('labels.quick_order') }}
                                                    <div class="loader d-none quick_order_loader"></div>
                                                </button>
                                            @else
                                                <button
                                                    class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center quick_order"
                                                    onclick="addtocart('{{ URL::to('addtocart') }}','{{ $getitemdata['id'] }}','1')">
                                                    {{ trans('labels.quick_order') }}
                                                    <div class="loader d-none quick_order_loader"></div>
                                                </button>
                                            @endif
                                        @else
                                            <button
                                                class="btn btn-primary w-100 m-0 fs-7 fw-500 rounded-3 d-flex gap-3 justify-content-center align-items-center quick_order"
                                                onclick="addtocart('{{ URL::to('addtocart') }}','{{ $getitemdata['id'] }}','1')">
                                                {{ trans('labels.quick_order') }}
                                                <div class="loader d-none quick_order_loader"></div>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between mt-3 align-items-center">
                                <div class="col-sm-6">
                                    <div class="wishlist set-fav-{{ $getitemdata->id }}">
                                        @if ($getitemdata->is_favorite == 1)
                                            <a class="text-dark fw-600 fs-7 d-flex gap-1 py-2 align-items-center"
                                                @if (Auth::user() && Auth::user()->type == 2) href="javascript:void(0)" onclick="managefavorite('{{ $getitemdata->id }}',0,'{{ URL::to('/managefavorite') }}')" @else href="{{ URL::to('/login') }}" @endif>
                                                <i class="fa-solid fa-heart fs-6"></i>
                                                {{ trans('labels.remove_wishlist') }}
                                            </a>
                                        @else
                                            <a class="text-dark fw-600 fs-7 d-flex gap-1 py-2 align-items-center"
                                                @if (Auth::user() && Auth::user()->type == 2) href="javascript:void(0)" onclick="managefavorite('{{ $getitemdata->id }}',1,'{{ URL::to('/managefavorite') }}')" @else href="{{ URL::to('/login') }}" @endif>
                                                <i class="fa-regular fa-heart fs-6"></i>
                                                {{ trans('labels.add_wishlist') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        @if (helper::appdata()->google_review_url != '')
                                            <a href="{{ helper::appdata()->google_review_url }}" class="icon-box"
                                                target="_blank" tooltip="{{ trans('labels.review') }}">
                                                <i class="fa-solid fa-star fs-8"></i>
                                            </a>
                                        @endif
                                        @if (helper::appdata()->mobile != '')
                                            <a href="callto:{{ helper::appdata()->mobile }}"
                                                tooltip="{{ trans('labels.call') }}" class="icon-box">
                                                <i class="fa-solid fa-phone fs-8"></i>
                                            </a>
                                        @endif
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            @if (whatsapp_helper::whatsapp_message_config()->whatsapp_number != '')
                                                <a href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config()->whatsapp_number }}'&text={{ $getitemdata->item_name }}"
                                                    target="_blank" tooltip="{{ trans('labels.whatsapp') }}"
                                                    class="icon-box">
                                                    <i class="fa-brands fa-whatsapp fs-8"></i>
                                                </a>
                                            @endif
                                        @endif
                                        @if ($getitemdata->video_url != '')
                                            <a href="{{ $getitemdata->video_url }}" target="_blank"
                                                tooltip="{{ trans('labels.video') }}" class="icon-box">
                                                <i class="fa-solid fa-video fs-8"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-view" id="review-tab">
                    <ul class="nav nav-pills py-3 mb-4 border-bottom border-top" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" href="javascript:void(0)" data-bs-toggle="pill"
                                data-bs-target="#pills-review" aria-selected="false" role="tab"
                                tabindex="-1">{{ trans('labels.reviews') }}</a>
                        </li>

                    </ul>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade" id="pills-review" role="tabpanel" aria-labelledby="pills-review-tab">
                        <div class="row gx-4 gx-xxl-5 gy-md-0 gy-4">
                            <div class="col-md-12 col-lg-7 col-xxl-6">
                                <!-- Customer rating -->
                                <h4 class="heading mb-3 fw-600 text-dark text-truncate">
                                    {{ trans('labels.customer_rating') }}
                                </h4>
                                <div class="card border-0 bg-gray rounded-3 p-4 mb-4 rounded-3">
                                    <div class="row g-4 align-items-center">
                                        <!-- Rating info -->
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <!-- Info -->
                                                <h2 class="mb-0 fw-bold text-dark">
                                                    <i class="fa-solid fa-star text-warning"></i>
                                                    {{ number_format($getitemdata->avg_ratting, 1) }}
                                                </h2>
                                                <p class="mb-2 text-muted">{{ trans('labels.based_on') }}
                                                    {{ count($itemreviewdata) }}
                                                    {{ trans('labels.reviews') }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Progress-bar START -->
                                        <div class="col-md-8">
                                            <div class="card-body p-0">
                                                <div class="row gx-3 g-2 align-items-center">
                                                    <!-- 5.0 Progress bar and Rating -->
                                                    <div class="col-2 col-sm-2 text-end">
                                                        <span class="h6 fw-semibold mb-0 text-dark">5.0</span>
                                                    </div>
                                                    @php
                                                        if (count(@$itemreviewdata) != 0) {
                                                            $five = ($fivestaraverage / count(@$itemreviewdata)) * 100;
                                                        } else {
                                                            $five = 0;
                                                        }
                                                    @endphp
                                                    <div class="col-2 col-sm-8">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $five }}%"
                                                                aria-valuenow="{{ round($five) }}%" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- 5.0 Percentage -->
                                                    <div
                                                        class="col-2 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <span
                                                            class="h6 fw-semibold mb-0 text-dark">{{ round($five) }}%</span>
                                                    </div>

                                                    <!-- 4.0 Progress bar and Rating -->
                                                    <div class="col-2 col-sm-2 text-end">
                                                        <span class="h6 fw-semibold mb-0 text-dark">4.0</span>
                                                    </div>
                                                    @php
                                                        if (count(@$itemreviewdata) != 0) {
                                                            $four = ($fourstaraverage / count(@$itemreviewdata)) * 100;
                                                        } else {
                                                            $four = 0;
                                                        }
                                                    @endphp
                                                    <div class="col-8 col-sm-8">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $four }}%"
                                                                aria-valuenow="{{ round($four) }}%" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- 4.0 Percentage -->
                                                    <div
                                                        class="col-2 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <span
                                                            class="h6 fw-semibold mb-0 text-dark">{{ round($four) }}%</span>
                                                    </div>

                                                    <!-- 3.0 Progress bar and Rating -->
                                                    <div class="col-2 col-sm-2 text-end">
                                                        <span class="h6 fw-semibold mb-0 text-dark">3.0</span>
                                                    </div>
                                                    @php
                                                        if (count(@$itemreviewdata) != 0) {
                                                            $three =
                                                                ($threestaraverage / count(@$itemreviewdata)) * 100;
                                                        } else {
                                                            $three = 0;
                                                        }
                                                    @endphp
                                                    <div class="col-8 col-sm-8">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $three }}%"
                                                                aria-valuenow="{{ round($three) }}%" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- 3.0 Percentage -->
                                                    <div
                                                        class="col-2 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <span
                                                            class="h6 fw-semibold mb-0 text-dark">{{ round($three) }}%</span>
                                                    </div>

                                                    <!-- 2.0 Progress bar and Rating -->
                                                    <div class="col-2 col-sm-2 text-end">
                                                        <span class="h6 fw-semibold mb-0 text-dark">2.0</span>
                                                    </div>
                                                    @php
                                                        if (count(@$itemreviewdata) != 0) {
                                                            $two = ($twostaraverage / count(@$itemreviewdata)) * 100;
                                                        } else {
                                                            $two = 0;
                                                        }
                                                    @endphp
                                                    <div class="col-8 col-sm-8">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $two }}%"
                                                                aria-valuenow="{{ round($two) }}%" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- 2.0 Percentage -->
                                                    <div
                                                        class="col-2 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <span
                                                            class="h6 fw-semibold mb-0 text-dark">{{ round($two) }}%</span>
                                                    </div>

                                                    <!-- 1.0 Progress bar and Rating -->
                                                    <div class="col-2 col-sm-2 text-end">
                                                        <span class="h6 fw-semibold mb-0 text-dark">1.0</span>
                                                    </div>
                                                    @php
                                                        if (count(@$itemreviewdata) != 0) {
                                                            $one = ($onestaraverage / count(@$itemreviewdata)) * 100;
                                                        } else {
                                                            $one = 0;
                                                        }
                                                    @endphp
                                                    <div class="col-8 col-sm-8">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: {{ $one }}%"
                                                                aria-valuenow="{{ round($one) }}%" aria-valuemin="0"
                                                                aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- 1.0 Percentage -->
                                                    <div
                                                        class="col-2 col-sm-2 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                                        <span
                                                            class="h6 fw-semibold mb-0 text-dark">{{ round($one) }}%</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Progress-bar END -->
                                    </div>
                                </div>
                                <!-- Customer rating -->
                                <div class="d-grid justify-items-center mt-4 mb-3">
                                    @if (Auth::user() && Auth::user()->type == 2)
                                        <button class="btn btn-primary fs-7 write-review"
                                            data-item-id="{{ $getitemdata->id }}"
                                            data-item-name="{{ $getitemdata->item_name }}"
                                            data-item-image="{{ helper::image_path($getitemdata['item_image']->image_name) }}">{{ trans('labels.write_review') }}</button>
                                    @else
                                        <button class="btn btn-primary fs-7"
                                            onclick="showlogin()">{{ trans('labels.write_review') }}</button>
                                    @endif
                                </div>
                            </div>

                            <!-- Customer Review -->
                            <div class="col-md-12 col-lg-5 col-xxl-6">
                                <h4 class="heading mb-3 fw-600 text-dark text-truncate">
                                    {{ trans('labels.customer_review') }}
                                </h4>
                                @if (count($itemreviewdata) > 0)
                                    @foreach ($itemreviewdata as $reviewdata)
                                        <div class="py-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-md-flex align-items-center">
                                                        <!-- review avatar -->
                                                        <div
                                                            class="avatar avatar-lg mb-md-0 mb-2 flex-shrink-0 {{ session()->get('direction') == 2 ? ' ms-sm-3' : 'me-sm-3' }}">
                                                            <img class="avatar-img rounded-circle w-100 h-100 object-fit-cover"
                                                                src="{{ $reviewdata->user_info->profile_image }}"
                                                                alt="avatar">
                                                        </div>
                                                        <!-- review avatar -->

                                                        <!-- review-content -->
                                                        <div class="w-100">
                                                            <div
                                                                class="d-flex flex-wrap gap-2 justify-content-between mt-1 mt-md-0 mb-2">
                                                                <div>
                                                                    <h6 class="mb-0 fw-600">
                                                                        {{ $reviewdata->user_info->name }}
                                                                    </h6>
                                                                    <!-- Info -->
                                                                    <p class="text-muted fs-8 fw-500 mt-1 mb-0">
                                                                        {{ helper::date_format($reviewdata->created_at) }}
                                                                    </p>
                                                                </div>
                                                                <!-- Review star -->
                                                                <span class="fw-600 fs-6">
                                                                    <i class="fas fa-star fa-fw text-warning fs-7"></i>
                                                                    {{ $reviewdata->ratting > 0 ? number_format($reviewdata->ratting, 1) : 0 }}</span>
                                                            </div>

                                                            <p class="text-muted fs-7 fw-normal line-2 mb-0 ">
                                                                {{ $reviewdata->comment }}
                                                            </p>
                                                        </div>
                                                        <!-- review-content -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @include('web.nodata')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- RELATED PRODUCTS Section Start Here -->
    @if (count($getrelateditems) > 0)
        <section class="menu py-5 m-0">
            <div class="container">
                <div class="row align-items-center justify-content-between mb-2 px-2">
                    <div class="col-auto menu-heading p-1">
                        <h2 class="text-capitalize fs-2 fw-600">
                            {{ trans('labels.related_items') }}</h2>
                    </div>
                    @if (isset($county))
                        <div class="col-auto px-1 pb-2"><a
                                href="{{ URL::to($county . '/menu/' . $getitemdata['category_info']->slug) }}"
                                class="btn btn-outline-primary px-4 py-2">{{ trans('labels.view_all') }}</a>
                        </div>
                    @else
                        <div class="col-auto px-1 pb-2"><a
                                href="{{ URL::to('menu/' . $getitemdata['category_info']->slug) }}"
                                class="btn btn-outline-primary px-4 py-2">{{ trans('labels.view_all') }}</a>
                        </div>
                    @endif
                </div>
                <div class="row g-4">
                    @foreach ($getrelateditems as $itemdata)
                        @include('web.home1.itemview')
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- RELATED PRODUCTS Section End Here -->
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/item-image-carousel/main.js') }}"></script>
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/item-image-carousel/zoom-image.js') }}"></script>

    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/smoothproducts.js') }}"></script>
    <script>
        $('.sp-wrap').smoothproducts();
        window.onload = function() {
            getaddons("{{ $getitemdata['id'] }}");
            @if ($getitemdata->is_price_range && $getitemdata->max_price > 0)
                // getaddons() overwrites .subtotal_xxx with a single price — restore the range display
                $('.subtotal_{{ $getitemdata['id'] }}')
                    .text("{{ $minPrice . ' - ' . helper::currency_format($getitemdata->max_price) }}")
                    .attr('data-price-range-locked', '1');
            @endif
        };

        var topdeals = "{{ $getitemdata->is_top_deals == 1 ? 1 : 0 }}";

        $(".write-review").click(function() {
            $("#data-item-name").text($(this).attr('data-item-name'));
            $("#data-item-id").val($(this).attr('data-item-id'));
            $("#reviewModal img").attr('src', $(this).attr('data-item-image'));
            $('#reviewModal').modal('show');
        });
    </script>
    <script>
        function changeqty(item_slug, id, type) {
            var qtys = parseInt($('#item_qty_' + item_slug).val());

            if (type == "minus") {
                qty = qtys - 1;
            } else {
                qty = qtys + 1;
            }

            if (qty >= 1) {

                $('#item_qty_' + item_slug).val(qty);
                $('#item_qty_' + id).val(qty);

                calculatePizzaPrice(id);
            }
        }
    </script>
    <script>
        function selectPizzaSize(itemId, el) {
            const selectedSizeId = el.value;

            $('#selected_size_id_' + itemId).val(selectedSizeId);

            $('.pizza-crusts').hide();

            $('#crust_container_' + selectedSizeId).show();

            const firstCrust = $('#crust_container_' + selectedSizeId)
                .find('input[type=radio]')
                .first();

            firstCrust.prop('checked', true);

            $('#selected_crust_id_' + itemId).val(firstCrust.val());

            calculatePizzaPrice(itemId);
        }

        function calculatePizzaPrice(itemId) {
            let qty = parseInt($('#item_qty_' + itemId).val());

            if (!qty || qty < 1) {
                qty = 1;
            }

            // SIZE PRICE
            let selectedSize = $('input[name="pizza_size_' + itemId + '"]:checked');

            let sizePrice = selectedSize.length ?
                parseFloat(selectedSize.attr('data-size-price')) :
                parseFloat($('#item_price_' + itemId).val());

            // CRUST PRICE
            let selectedCrust = $('input[name="pizza_crust_' + itemId + '"]:checked');

            let crustPrice = selectedCrust.length ?
                parseFloat(selectedCrust.attr('data-crust-price')) :
                0;

            if (selectedCrust.length) {
                $('#selected_crust_id_' + itemId).val(selectedCrust.val());
            }

            // OVERRIDE ITEM BASE PRICE
            $('#item_price_' + itemId).val(sizePrice);

            // ADDONS
            let addonsTotal = 0;

            $(".addons_chk_" + itemId + ":checked").each(function() {
                addonsTotal += parseFloat($(this).attr('data-addons-price'));
            });

            // EXTRAS
            let extrasTotal = 0;

            $(".extras_chk_" + itemId + ":checked").each(function() {
                extrasTotal += parseFloat($(this).attr('data-extras-price'));
            });

            let finalPrice =
                (sizePrice + crustPrice + addonsTotal + extrasTotal) * qty;

            // Don't overwrite the range display until the user picks from the dropdown
            if ($('.subtotal_' + itemId).data('price-range-locked')) return;

            $('.subtotal_' + itemId).text(currency_format(finalPrice));
        }

        function syncAddonSelect(itemId, groupId, selectEl) {
            if (!selectEl.value) return; // ignore blank placeholder

            // Unlock the subtotal so calculatePizzaPrice can update it from here on
            $('.subtotal_' + itemId).removeData('price-range-locked').removeAttr('data-price-range-locked');

            $('input[name="addons_id_' + groupId + '_' + itemId + '"][value="' + selectEl.value + '"]').prop('checked',
                true);
            getaddons(itemId);
            calculatePizzaPrice(itemId);
        }
    </script>
@endsection
