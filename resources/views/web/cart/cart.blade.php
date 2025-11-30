@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.my_cart') }}
@endsection
@section('content')
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-600" href="{{ helper::branch_route('home') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                            aria-current="page">{{ trans('labels.cart') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container">
            <div class="cart-view my-5">
                @if (count($getcartlist) > 0)
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card px-0 overflow-hidden border-bottom-0 rounded-3">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead class="table-light bg-primary" style="background-color: #D6B62B">
                                        <tr style="background-color: #D6B62B">
                                            <th class="cart-table-title p-3 text-white"
                                                style="background-color: #D6B62B">
                                                {{ trans('labels.item') }}
                                            </th>
                                            <th class="cart-table-title p-3 text-white"
                                                style="background-color: #D6B62B">
                                                {{ trans('labels.price') }}
                                            </th>
                                            <th class="cart-table-title p-3 text-white"
                                                style="background-color: #D6B62B">
                                                {{ trans('labels.qty') }}</th>
                                            <th class="cart-table-title p-3 text-white"
                                                style="background-color: #D6B62B">
                                                {{ trans('labels.total') }}</th>
                                            <th class="cart-table-title p-3 text-white text-center"
                                                style="background-color: #D6B62B">
                                                {{ trans('labels.action') }}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $order_total = 0;
                                            $total_item_qty = 0;
                                        @endphp
                                        @foreach ($getcartlist as $cartitems)
                                            <tr>
                                                <td>
                                                    <div class="tbl_cart_product gap-3">
                                                        <div
                                                            class="col-auto d-md-flex  justify-content-center item-img-none">
                                                            <div class="item-img">
                                                                <img
                                                                    src="{{ helper::image_path($cartitems->item_image) }}"
                                                                    alt="item-image">
                                                            </div>
                                                        </div>
                                                        <div class="tbl_cart_product_caption">
                                                            <h5 class="tbl_pr_title line-2 mb-1 fs-6">
                                                                {{ $cartitems->item_name }}
                                                            </h5>
                                                            @if ($cartitems->addons_id != '' || $cartitems->extras_id != '')
                                                                <small>
                                                                    <a class="text-muted fw-400 fs-7"
                                                                       href="javascript:void(0)"
                                                                       onclick="showaddons('{{ $cartitems['addons_name'] }}','{{ $cartitems['addons_price'] }}','{{ $cartitems['extras_name'] }}','{{ $cartitems['extras_price'] }}','{{ $cartitems['dipping_name'] }}','{{ $cartitems['dipping_price'] }}','{{ $cartitems['item_name'] }}')">{{ trans('labels.customize') }}
                                                                    </a>
                                                                </small>
                                                                <br>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </td>
                                                @php
                                                    $total_price =
                                                        ($cartitems->item_price +
                                                            $cartitems->addons_total_price +
                                                            $cartitems->extras_total_price) *
                                                        $cartitems->qty;
                                                    $order_total += (float) $total_price;
                                                    $total_item_qty += $cartitems->qty;
                                                @endphp
                                                <td data-label="{{ trans('labels.price') }}">
                                                    <h4 class="tbl_org_price">
                                                        {{ helper::currency_format($cartitems->item_price + $cartitems->addons_total_price + $cartitems->extras_total_price) }}
                                                    </h4>
                                                </td>
                                                <td data-label="{{ trans('labels.qty') }}">
                                                    <nav aria-label="Page navigation example">
                                                        <ul
                                                            class="qtladd mb-0 {{ session()->get('direction') == '2' ? 'rtl' : '' }}">
                                                            <li>
                                                                <button class="qty_button" {{ $cartitems->qty == 1 ? 'disabled' : ''}}
                                                                        onclick="qtyupdate('{{ $cartitems['id'] }}','minus','{{ URL::to('/cart/qtyupdate') }}')">
                                                                        <span aria-hidden="true">
                                                                            <i class="fa-light fa-minus fs-10"></i>
                                                                        </span>
                                                                </button>
                                                            </li>
                                                            <li class="qtl-count">
                                                                <input type="text" class="border py-1 w-100"
                                                                       id="number_{{ $cartitems->id }}" name="number"
                                                                       value="{{ $cartitems->qty }}" readonly="">
                                                            </li>
                                                            <li>
                                                                <button class="qty_button"
                                                                        onclick="qtyupdate('{{ $cartitems['id'] }}','plus','{{ URL::to('/cart/qtyupdate') }}')">
                                                                        <span aria-hidden="true">
                                                                            <i class="fa-light fa-plus fs-10"></i>
                                                                        </span>
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </td>
                                                <td data-label="{{ trans('labels.total') }}">
                                                    <h4 class="tbl_org_price">
                                                        {{ helper::currency_format($total_price) }}
                                                    </h4>
                                                </td>
                                                <td>
                                                    <div class="tbl_pr_action">
                                                        <a class="tbl_remove"
                                                           onclick="deletecartitem('{{ $cartitems['id'] }}','{{ URL::to('/cart/deleteitem') }} ')  ">
                                                            <i class="fa-light fa-trash-can fs-7"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (!empty($discount['cartDiscountMessage']))
                                <div class="alert alert-success text-green-800 font-semibold my-2">
                                    {{ $discount['cartDiscountMessage'] }}
                                </div>
                            @endif
                            <div class="row g-3 justify-content-between mt-0 align-items-center">
                                <div
                                    class="col-xl-3 col-lg-4 col-sm-6 col-12 {{ session()->get('direction') == '2' ? 'text-end' : '' }}">
                                    <a href="{{ helper::branch_route('home') }}" class="btn btn-outline-dark w-100">
                                        <i
                                            class="fa-solid {{ session()->get('direction') == '2' ? 'fa-circle-arrow-right ms-2' : 'fa-circle-arrow-left me-2' }}"></i>
                                        {{ trans('labels.continue_shopping') }}</a>
                                </div>
                                <div
                                    class="col-xl-3 col-lg-4 col-sm-6 col-12 {{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                    <button
                                        class="btn btn-primary w-100 d-flex gap-3 justify-content-center align-items-center cart_checkout"
                                        onclick="isopenclose('{{ URL::to('/isopenclose') }}','{{ $total_item_qty }}','{{ $order_total }}')">
                                        {{ trans('labels.continue') }}
                                        <div class="loader d-none cart_checkout_loader"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5 mb-3">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card px-0 overflow-hidden border-bottom-1 rounded-3">
                                <div class="card-header" style="background: #D6B62B">Drinks</div>
                                @php     $data = json_decode(helper::getCategories('drinks')->getContent());
                                @endphp
                                <div class="row g-3 p-3">
                                    @foreach ($data->data as $itemdata)

                                        <div class="col-12 col-lg-2 col-md-4 col-sm-12">
                                            <div class="h-100 d-flex flex-column">
                                                <div class="card overflow-hidden h-100 flex-grow-1">

                                                        <img
                                                            src="{{ @helper::image_path($itemdata->item_image->image_name) }}"
                                                            class="card-img-top border-0 rounded-0 rounded-top position-relative"
                                                            alt="dishes" height="190px">


                                                    <div class="card-body pb-0 border-bottom">
                                                        <h5 class="item-card-title pb-3 fs-6 d-flex justify-content-between align-items-center">

                                                               <p class="item-card-title mb-0 line-2 fs-7">
                                                                    {{ $itemdata->item_name }}
                                                                </p>
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
                                                            <div
                                                                class="d-flex gap-1">
                                                                @if ($original_price > $price)
                                                                    <del
                                                                        class="text-muted">{{ helper::currency_format($original_price) }}</del>
                                                                @endif
                                                                <span>{{ $price !== '0.00' ? helper::currency_format($price) : '' }}</span>
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

                                                        <button
                                                            class="btn btn-sm btn-secondary fw-500 py-2 px-4 w-100 float-end rounded-3 d-flex gap-2 justify-content-center align-items-center addon_modal_{{ $itemdata->slug }}"
                                                            onclick="showitem('{{ $itemdata->slug }}','{{ URL::to('/show-item') }}')">
                                                            Order Now
                                                            <i class="fa-solid fa-plus addon_modal_icon_{{ $itemdata->slug }}"></i>
                                                            <div
                                                                class="loader d-none addon_modal_loader_{{ $itemdata->slug }}"></div>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                    @include('web.nodata')
                @endif
            </div>
        </div>
    </section>
    <input type="hidden" name="request_url" id="request_url" value="{{ request()->segments()[0] }}">

@endsection
@section('scripts')
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/cart.js') }}"></script>
@endsection

<!-- MODAL_SELECTED_ADDONS--START -->
<div class="modal addons" id="modal_selected_addons" tabindex="-1" aria-labelledby="selected_addons_Label"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <p class="mb-0 fw-600 fs-5" id="addon_item_name"></p>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-0">
                <!-- Addons -->
                <div class="mt-2 p-2 border-bottom d-none" id="addons">
                    <p class="m-0 fs-6 fw-500">{{ trans('labels.addons') }}</p>
                    <ul class="m-0 {{ session()->get('direction') == '2' ? 'pe-2' : 'ps-2' }}" id="item-addons"></ul>
                </div>
                <!-- Extras -->
                <div class="mt-2 p-2 border-bottom d-none" id="extras">
                    <p class="m-0 fs-6 fw-500">{{ trans('labels.extras') }} </p>
                    <ul class="m-0 {{ session()->get('direction') == '2' ? 'pe-2' : 'ps-2' }}" id="item-extras"></ul>
                </div>

            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-primary m-0 px-4 py-2"
                    data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
            </div> --}}
        </div>
    </div>
</div>
<style>
    @media (max-width: 768px) {
        @media (max-width: 768px) {
            .table-responsive .table {
                display: block;
                width: 100%;
                border: none;
            }

            .table-responsive .table thead {
                display: none; /* Hide table headers */
            }

            .table-responsive .table tbody {
                display: block;
                width: 100%;
            }

            .table-responsive .table tbody tr {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
                border: 1px solid #e5e5e5;
                border-radius: 8px;
                padding: 0.5rem;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .table-responsive .table tbody tr td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                width: 100%;
                margin-bottom: 0.5rem;
                padding: 0.5rem 0; /* Add padding for better alignment */
            }

            .table-responsive .table tbody tr td:last-child {
                margin-bottom: 0;
            }

            .table-responsive .table tbody tr td:before {
                content: attr(data-label);
                font-weight: bold;
                flex-shrink: 0;
                margin-right: 10px;
                color: #555;
            }

            .tbl_cart_product {
                display: flex;
                align-items: center;
                width: 100%; /* Ensure full width */
            }

            .tbl_cart_product img {
                width: 60px;
                height: 60px;
                margin-right: 10px;
                object-fit: cover;
                border-radius: 8px;
            }

            .tbl_cart_product_caption {
                flex-grow: 1;
            }
        }

</style>
<!-- MODAL_SELECTED_ADDONS--END -->
