@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.checkout') }}
@endsection
@section('content')
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark d-flex breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-bold" href="{{ URL::to('/') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} text-primary fw-bold active"
                            aria-current="page">{{ trans('labels.checkout') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    @if (count($getcartlist) > 0)
        @php
            $totaltax = 0;
            $order_total = 0;
            $total_item_qty = 0;
            $totalcarttax = 0;
        @endphp
        @foreach ($taxArr['tax'] as $k => $tax)
            @php
                $rate = $taxArr['rate'][$k];
                $totalcarttax += (float) $taxArr['rate'][$k];
            @endphp
        @endforeach
        @foreach ($getcartlist as $item)
            @php
                $total_price =
                    ($item['item_price'] + $item['addons_total_price'] + $item['extras_total_price']) * $item['qty'];
                $order_total += (float) $total_price;
                $total_item_qty += $item['qty'];
            @endphp
        @endforeach
        <section class="my-5">
            <div class="container">
                <h3 class="fw-bold fs-2 mb-4 truncate-2">{{ trans('labels.checkout') }}</h3>
                <div class="cart-view">
                    <div class="row">
                        <div class="col-lg-8 order-md2">
                            <div class="card mb-3 order-option">
                                <div class="card-body">
                                    <div class="">
                                        <div class="heading mb-2 border-bottom">
                                            <h5>{{ trans('labels.order_type') }}</h5>
                                        </div>
                                        <div class="col-12 d-flex gap-3">
                                            @if ($getsettings->pickup_delivery == 1)
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="order_type"
                                                        value="1" checked id="delivery">
                                                    <label class="form-check-label fs-7 fw-500" for="delivery">
                                                        {{ trans('labels.delivery') }}
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="order_type"
                                                        value="2" id="pickup">
                                                    <label class="form-check-label fs-7 fw-500" for="pickup">
                                                        {{ trans('labels.take_away') }}
                                                    </label>
                                                </div>
                                            @elseif($getsettings->pickup_delivery == 2)
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="order_type"
                                                        value="1" checked id="delivery">
                                                    <label class="form-check-label fs-7 fw-500" for="delivery">
                                                        {{ trans('labels.delivery') }}
                                                    </label>
                                                </div>
                                            @elseif($getsettings->pickup_delivery == 3)
                                                <div class="form-check form-check-inline mb-0">
                                                    <input class="form-check-input" type="radio" name="order_type"
                                                        value="2" id="pickup" checked>
                                                    <label class="form-check-label fs-7 fw-500" for="pickup">
                                                        {{ trans('labels.take_away') }}
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (helper::appdata()->ordertype_date_time == 1)
                                <div class="card mb-3 date-view">
                                    <div class="card-body">
                                        <div class="heading mb-3 border-bottom">
                                            <h5>{{ trans('labels.date_time') }}</h5>
                                        </div>
                                        <div class="row g-3">
                                            <div
                                                class="col-sm-6 delivery-date {{ session()->get('direction') == '2' ? 'text-right' : '' }}">
                                                <label id="delivery_date"
                                                    class="form-label justify-content-start">{{ trans('labels.delivery_date') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label id="pickup_date" class="form-label d-none">
                                                    {{ trans('labels.pickup_date') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control rounded-2 p-3 delivery_pickup_date"
                                                    name="delivery_date" value="{{ old('delivery_date') }}"
                                                    id="delivery_dt" min="@php echo date('Y-m-d'); @endphp">
                                            </div>
                                            <div
                                                class="col-sm-6 delivery-time {{ session()->get('direction') == '2' ? 'text-right' : '' }}">
                                                <label id="delivery_time"
                                                    class="form-label justify-content-start">{{ trans('labels.delivery_time') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label id="pickup_time"
                                                    class="form-label justify-content-start d-none">{{ trans('labels.pickup_time') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <label id="store_close"
                                                    class="d-none form-label text-danger label14">{{ trans('messages.restaurant_closed') }}</label>
                                                <select name="delivery_time" id="delivery_slot_time"
                                                    class="form-select rounded-2 py-3">
                                                    <option value="{{ old('delivery_time') }}">
                                                        {{ trans('labels.select') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="heading mb-2 border-bottom">
                                        <h5>{{ trans('labels.customer_info') }}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="first_name" class="form-label">{{ trans('labels.first_name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="first_name" id="first_name"
                                                placeholder="{{ trans('labels.first_name') }}"
                                                value="{{ Auth::user() && Auth::user()->type == 2 ? Auth::user()->name : old('first_name') }}"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="last_name" class="form-label">{{ trans('labels.last_name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="last_name" id="last_name"
                                                placeholder="{{ trans('labels.last_name') }}"
                                                value="{{ old('last_name') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">{{ trans('labels.email') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="email" id="email"
                                                placeholder="{{ trans('labels.email') }}"
                                                value="{{ Auth::user() && Auth::user()->type == 2 ? Auth::user()->email : old('email') }}"
                                                required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="mobile" class="form-label">{{ trans('labels.mobile') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="mobile" id="mobile"
                                                placeholder="{{ trans('labels.mobile') }}"
                                                value="{{ Auth::user() && Auth::user()->type == 2 ? Auth::user()->mobile : old('mobile') }}"
                                                required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3" id="addressdiv">
                                <div class="card-body">
                                    <div
                                        class="d-flex justify-content-between align-items-center heading mb-2 border-bottom">
                                        <h5>{{ trans('labels.delivery_address') }}</h5>
                                    </div>
                                    <div class="row g-3">
                                        @if (Auth::user() && Auth::user()->type == 2)
                                            <div class="col-md-9 col-sm-8">
                                                @if ($getaddresses->count() > 0)
                                                    <label class="form-label">{{ trans('labels.select_address') }}</label>
                                                    <select name="address_type" id="address_type" class="form-select">
                                                        @foreach ($getaddresses as $address)
                                                            <option value="{{ $address->id }}"
                                                                {{ $address->is_default == 1 ? 'selected' : '' }}>
                                                                {{ $address->title }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                            <div class="col-md-3 col-sm-4 py-sm-4">
                                                <a href="{{ URL::to('/address') }}" type="button"
                                                    class="btn btn-address mt-sm-2 w-100">
                                                    <i class="fa-solid fa-plus mx-1"></i>
                                                    {{ trans('labels.add_address') }}</a>
                                            </div>
                                        @endif
                                        <div class="col-12">
                                            <label for="address" class="form-label">{{ trans('labels.address') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="address" id="new_address" class="form-control" rows="6"
                                                placeholder="{{ trans('labels.address') }}" required>{{ old('address') }}</textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="landmark" class="form-label">{{ trans('labels.landmark') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="landmark" id="new_landmark"
                                                placeholder="{{ trans('labels.landmark') }}"
                                                value="{{ old('landmark') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">{{ trans('labels.city') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="city" id="new_city"
                                                placeholder="{{ trans('labels.city') }}" value="{{ old('city') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="state" class="form-label">{{ trans('labels.state') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="state" id="new_state"
                                                placeholder="{{ trans('labels.state') }}" value="{{ old('state') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="country" class="form-label">{{ trans('labels.country') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="country" id="new_country"
                                                placeholder="{{ trans('labels.country') }}"
                                                value="{{ old('country') }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="pincode" class="form-label">{{ trans('labels.pincode') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control" name="pincode" id="new_pincode"
                                                placeholder="{{ trans('labels.pincode') }}"
                                                value="{{ old('pincode') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3" id="shipping_area">
                                <div class="card-body">
                                    <div class="heading mb-2 border-bottom">
                                        <h5>{{ trans('labels.shippingarea') }}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <select name="delivery_area" id="delivery_area" class="form-select">
                                                <option value="" data-charge="0">{{ trans('labels.select') }}
                                                </option>
                                                @foreach ($shippingarea as $area)
                                                    <option value="{{ $area->id }}"
                                                        data-charge="{{ $area->delivery_charge }}">{{ $area->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="payment-option mb-3 border">
                                <div class="heading mb-2 border-bottom">
                                    <h2>{{ trans('labels.choose_payment') }}</h2>
                                </div>
                                <!-- payment-options -->
                                @include('web.paymentmethodsview')
                                <div class="row g-3 justify-content-between mt-4 align-items-center">
                                    <div class="align-items-center col-sm-6 col-12">
                                        <a href="{{ URL::to('/') }}" class="btn btn-outline-dark w-100 p-2"><i
                                                class="fa-solid fa-circle-arrow-left {{ session()->get('direction') == '2' ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.continue_shopping') }}</a>
                                    </div>
                                    <div class="align-items-center col-sm-6 col-12">
                                        <button
                                            class="btn btn-primary w-100 d-flex gap-3 justify-content-center align-items-center checkout"
                                            onclick="isopenclose('{{ URL::to('/isopenclose') }}','{{ $total_item_qty }}','{{ $order_total }}')">
                                            {{ trans('labels.proceed_pay') }}
                                            <div class="loader d-none checkout_loader"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 order-md1">
                            @if (@helper::checkaddons('coupon'))
                                <div class="promocode mb-4 py-3">
                                    <label class="mb-3">{{ trans('labels.apply_promo') }}</label>
                                    <div class="row justify-content-between align-items-center">
                                        @if (session()->get('discount_data'))
                                            <form action="{{ URL::to('/promocodes/remove') }}" method="post">
                                                @csrf
                                                <div class="d-flex">
                                                    <input type="text" class="form-control" name="offer_code"
                                                        value="{{ session()->get('discount_data')['offer_code'] }}"
                                                        placeholder="{{ trans('labels.have_promocode') }}" disabled>
                                                    <button type="submit"
                                                        class="btn btn-primary bg-primary border-0 ms-2">{{ trans('labels.remove') }}
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ URL::to('/promocodes/apply') }}" method="post">
                                                @csrf
                                                <div class="d-flex">
                                                    <input type="hidden" name="order_amount"
                                                        value="{{ $order_total }}">
                                                    <input type="text" class="form-control" name="offer_code"
                                                        value="{{ old('offer_code') }}" id="offer_code"
                                                        placeholder="{{ trans('labels.have_promocode') }}" required>
                                                    <button type="submit"
                                                        class="btn px-4 btn-primary bg-primary border-0 {{ session()->get('direction') == '2' ? 'me-2' : 'ms-2' }}">{{ trans('labels.apply') }}</button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <!-- payment-summary -->
                            <div class="summary py-3 mb-4">
                                <h2 class="border-bottom">{{ trans('labels.payment_summary') }}</h2>
                                <div class="bill-details border-bottom pb-2">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto"><span>{{ trans('labels.subtotal') }}</span></div>
                                        <div class="col-auto">
                                            <span>{{ helper::currency_format($order_total) }}</span>
                                        </div>
                                    </div>
                                    @php
                                        if (session()->has('discount_data')) {
                                            $discount_amount = session()->get('discount_data')['offer_amount'];
                                        } else {
                                            $discount_amount = 0;
                                        }
                                        if (session()->has('addressdata')) {
                                            $grand_total = $order_total - $discount_amount + $totalcarttax;
                                        } else {
                                            $grand_total = $order_total - $discount_amount + $totalcarttax;
                                        }
                                    @endphp

                                    @if (session()->has('discount_data'))
                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto"><span>{{ trans('labels.discount') }}
                                                    {{ session()->has('discount_data') == true ? '(' . session()->get('discount_data')['offer_code'] . ')' : '' }}
                                                </span></div>
                                            <div class="col-auto">
                                                <span>- {{ helper::currency_format($discount_amount) }}</span>
                                            </div>
                                        </div>
                                    @endif
                                    @php
                                        $totalcarttax = 0;
                                    @endphp
                                    @foreach ($taxArr['tax'] as $k => $tax)
                                        @php
                                            $rate = $taxArr['rate'][$k];
                                            $totalcarttax += (float) $taxArr['rate'][$k];
                                        @endphp

                                        <div class="row justify-content-between align-items-center">
                                            <div class="col-auto"><span>{{ $tax }}</span></div>
                                            <div class="col-auto">
                                                <span> {{ helper::currency_format($rate) }}</sp>
                                            </div>
                                        </div>
                                    @endforeach
                                    @php $delivery_charge = 0; @endphp
                                    <div class="row justify-content-between align-items-center" id="delivery_charge">
                                        <div class="col-auto"><span>{{ trans('labels.delivery_charge') }}</span>
                                        </div>
                                        <div class="col-auto">
                                            <span class="delivery_charge" id="delivery_amount">
                                                {{ helper::currency_format(0) }}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                <div class="bill-total mt-2">
                                    <div class="row justify-content-between align-items-center">
                                        <div class="col-auto"><span>{{ trans('labels.grand_total') }}</span></div>
                                        <div class="col-auto"><span class="grand_total"
                                                id="total_amount">{{ helper::currency_format($grand_total) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- special-instruction -->
                            <div class="special-instruction mb-3 border">
                                <label class="form-label mb-3 border-bottom pb-2 w-100"
                                    for="order_notes">{{ trans('labels.special_instruction') }}</label>
                                <textarea class="form-control" name="order_notes" id="order_notes" rows="3"
                                    placeholder="{{ trans('labels.special_instruction') }}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>


                <input type="hidden" name="user_id" id="user_id" value="{{ @Auth::user()->id }}">
                <input type="hidden" name="session_id" id="session_id" value="{{ @Session::getId() }}">
                <input type="hidden" name="order_type" id="order_type" value="{{ session()->get('order_type') }}">
                <input type="hidden" name="grand_total" id="grand_total" value="{{ helper::currency_format($grand_total) }}">
                <input type="hidden" name="sub_total" id="sub_total" value="{{ $order_total }}">
                <input type="hidden" name="discount" id="discount" value="{{ $discount_amount }}">
                <input type="hidden" name="totaltaxamount" id="totaltaxamount" value="{{ $totalcarttax }}">
                <input type="hidden" name="tax" id="tax" value="{{ implode('|', $taxArr['rate']) }}">
                <input type="hidden" name="tax_name" id="tax_name" value="{{ implode('|', $taxArr['tax']) }}">
                <input type="hidden" name="shipping_charge" id="shipping_charge" value="">
                <input type="hidden" name="delivery_charge" id="delivery_charge" value="{{ $delivery_charge }}">
                <input type="hidden" name="user_name" id="user_name" value="{{ @Auth::user()->name }}">
                <input type="hidden" name="user_email" id="user_email" value="{{ @Auth::user()->email }}">
                <input type="hidden" name="user_mobile" id="user_mobile" value="{{ @Auth::user()->mobile }}">
                <input type="hidden" name="buynow" id="buynow" value="{{ request()->get('buynow') }}">

                <input type="hidden" name="sloturl" id="sloturl" value="{{ URL::to('/timeslot') }}">
                <input type="hidden" name="orderurl" id="orderurl" value="{{ URL::to('placeorder') }}">
                <input type="hidden" name="paymentsuccess" id="paymentsuccess"
                    value="{{ URL::to('/paymentsuccess') }}">
                <input type="hidden" name="paymentfail" id="paymentfail" value="{{ URL::to('/paymentfail') }}">
                <input type="hidden" name="continueurl" id="continueurl" value="{{ URL::to('/') }}">
                <input type="hidden" name="environment" id="environment" value="{{ env('Environment') }}">
                <input type="hidden" name="myfatoorahurl" id="myfatoorahurl" value="{{ URL::to('/myfatoorah') }}">
                <input type="hidden" name="mercadopagourl" id="mercadopagourl"
                    value="{{ URL::to('/mercadorequest') }}">
                <input type="hidden" name="paypalurl" id="paypalurl" value="{{ URL::to('/paypal') }}">
                <input type="hidden" name="toyyibpayurl" id="toyyibpayurl" value="{{ URL::to('/toyyibpay') }}">
                <input type="hidden" name="paytaburl" id="paytaburl" value="{{ URL::to('/paytab') }}">
                <input type="hidden" name="phonepeurl" id="phonepeurl" value="{{ URL::to('/phonepe') }}">
                <input type="hidden" name="mollieurl" id="mollieurl" value="{{ URL::to('/mollie') }}">
                <input type="hidden" name="khaltiurl" id="khaltiurl" value="{{ URL::to('/khalti') }}">

                <input type="hidden" value="{{ URL::to('getaddress') }}" name="getaddress" id="getaddress">

                <input type="hidden" value="{{ trans('messages.delivery_date_required') }}"
                    name="delivery_date_message" id="delivery_date_message">
                <input type="hidden" value="{{ trans('messages.delivery_time_required') }}"
                    name="delivery_time_message" id="delivery_time_message">
                <input type="hidden" value="{{ trans('messages.pickup_date_required') }}" name="pickup_date_message"
                    id="pickup_date_message">
                <input type="hidden" value="{{ trans('messages.pickup_time_required') }}" name="pickup_time_message"
                    id="pickup_time_message">
                <input type="hidden" value="{{ trans('messages.first_name_required') }}" name="first_name_message"
                    id="first_name_message">
                <input type="hidden" value="{{ trans('messages.last_name_required') }}" name="last_name_message"
                    id="last_name_message">
                <input type="hidden" value="{{ trans('messages.email_required') }}" name="email_message"
                    id="email_message">
                <input type="hidden" value="{{ trans('messages.mobile_required') }}" name="mobile_message"
                    id="mobile_message">
                <input type="hidden" value="{{ trans('messages.address_required') }}" name="new_address_message"
                    id="new_address_message">
                <input type="hidden" value="{{ trans('messages.landmark_required') }}" name="new_landmark_message"
                    id="new_landmark_message">
                <input type="hidden" value="{{ trans('messages.pincode_required') }}" name="new_pincode_message"
                    id="new_pincode_message">
                <input type="hidden" value="{{ trans('messages.country_required') }}" name="new_country_message"
                    id="new_country_message">
                <input type="hidden" value="{{ trans('messages.state_required') }}" name="new_state_message"
                    id="new_state_message">
                <input type="hidden" value="{{ trans('messages.city_required') }}" name="new_city_message"
                    id="new_city_message">
                <input type="hidden" value="{{ trans('messages.select_shipping_area') }}" name="shipping_area_message"
                    id="shipping_area_message">
                <input type="hidden" value="{{ trans('messages.payment_selection_required') }}"
                    name="payment_type_message" id="payment_type_message">

                <form action="{{ URL::to('paypal') }}" method="post" class="d-none">
                    {{ csrf_field() }}
                    <input type="hidden" name="return" value="2">
                    <input type="submit" class="callpaypal" name="submit">
                </form>
            </div>
        </section>
    @else
        @include('web.nodata')
    @endif
    <input type="hidden" name="buynow_key" id="buynow_key" value="0">
    <div class="modal fade" id="modalbankdetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalbankdetailsLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalbankdetailsLabel">{{ trans('labels.banktransfer') }}</h5>
                    <button type="button" class="btn-close bg-white border-0" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="{{ URL::to('createorder') }}" method="POST">
                    <div class="modal-body">
                        @csrf

                        <input type="hidden" name="payment_type" id="payment_type" class="form-control"
                            value="">
                        <input type="hidden" name="modal_customer_name" id="modal_customer_name" class="form-control"
                            value="">
                        <input type="hidden" name="modal_customer_email" id="modal_customer_email" class="form-control"
                            value="">
                        <input type="hidden" name="modal_customer_mobile" id="modal_customer_mobile"
                            class="form-control" value="">
                        <input type="hidden" name="modal_delivery_date" id="modal_delivery_date" class="form-control"
                            value="">
                        <input type="hidden" name="modal_delivery_time" id="modal_delivery_time" class="form-control"
                            value="">
                        <input type="hidden" name="modal_delivery_area" id="modal_delivery_area" class="form-control"
                            value="">
                        <input type="hidden" name="modal_delivery_charge" id="modal_delivery_charge"
                            class="form-control" value="">
                        <input type="hidden" name="modal_address" id="modal_address" class="form-control"
                            value="">
                        <input type="hidden" name="modal_address_type" id="modal_address_type" class="form-control"
                            value="">

                        <input type="hidden" name="modal_landmark" id="modal_landmark" class="form-control"
                            value="">
                        <input type="hidden" name="modal_pincode" id="modal_pincode" class="form-control"
                            value="">

                        <input type="hidden" name="modal_message" id="modal_message" class="form-control"
                            value="">
                        <input type="hidden" name="modal_subtotal" id="modal_subtotal" class="form-control"
                            value="">
                        <input type="hidden" name="modal_discount_amount" id="modal_discount_amount"
                            class="form-control" value="">
                        <input type="hidden" name="modal_couponcode" id="modal_couponcode" class="form-control"
                            value="">
                        <input type="hidden" name="modal_ordertype" id="modal_ordertype" class="form-control"
                            value="">
                        <input type="hidden" name="modal_vendor_id" id="modal_vendor_id" class="form-control"
                            value="">
                        <input type="hidden" name="modal_grand_total" id="modal_grand_total" class="form-control"
                            value="">
                        <input type="hidden" name="modal_tax" id="modal_tax" class="form-control" value="">
                        <input type="hidden" name="modal_tax_name" id="modal_tax_name" class="form-control"
                            value="">
                        <input type="hidden" name="modal_order_type" id="modal_order_type" class="form-control"
                            value="">

                        <input type="hidden" name="modal_buynow" id="modal_buynow" class="form-control"
                            value="">
                        <p>{{ trans('labels.payment_description') }}</p>
                        <hr>
                        <p class="payment_description" id="payment_description"></p>
                        <hr>
                        <div class="form-group col-md-12">
                            <label for="screenshot"> {{ trans('labels.screenshot') }} </label>
                            <div class="controls">
                                <input type="file" name="screenshot" id="screenshot"
                                    class="form-control  @error('screenshot') is-invalid @enderror" required>
                                @error('screenshot')
                                    <span class="text-danger"> {{ $message }} </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger"
                            data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                        <button type="submit" class="btn btn-primary"> {{ trans('labels.save') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/checkout.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        var select = "{{ trans('labels.select') }}";
        var dateFormat = "{{ helper::appdata()->date_format }}";
        var placeholderFormat = dateFormat
            .replace(/Y/g, 'yyyy') // Full year
            .replace(/m/g, 'mm') // Month
            .replace(/d/g, 'dd'); // Day

        document.getElementById("delivery_dt").setAttribute("placeholder", placeholderFormat);

        flatpickr(".delivery_pickup_date", {
            dateFormat: dateFormat,
            enableTime: false,
            altInput: true,
            altFormat: dateFormat,
        });
    </script>
@endsection
