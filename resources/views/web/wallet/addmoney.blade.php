@extends('web.layout.default')
@section('page_title')
    | {{ trans('labels.add_money') }}
@endsection
@section('content')
    <div class="breadcrumb-sec">
        <div class="container">
            <div class="breadcrumb-sec-content">
                <nav class="text-dark breadcrumb-divider" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li
                            class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }}">
                            <a class="text-dark fw-600" href="{{ route('home') }}">{{ trans('labels.home') }}</a>
                        </li>
                        <li class="breadcrumb-item {{ session()->get('direction') == '2' ? 'breadcrumb-item-rtl ps-0' : '' }} active"
                            aria-current="page">{{ trans('labels.add_money') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <section>
        <div class="container my-5">
            <div class="row">
                <div class="col-lg-3">
                    @include('web.layout.usersidebar')
                </div>
                <div class="col-lg-9">
                    <div class="user-content-wrapper">
                        <div class="mb-3 border-bottom  pb-3">
                            <p class="title mb-0">{{ trans('labels.add_money') }}</p>
                        </div>
                        <div class="row mb-3">
                            <div class="form-group">
                                <label for="" class="form-label">{{ trans('labels.amount') }}
                                    <span class="text-danger">*</span>
                                </label>
                                <div class="input-group gap-2">
                                    <span class="input-group-text rounded">{{ @helper::appdata()->currency }}</span>
                                    <input type="text" class="form-control rounded" name="amount" id="amount"
                                        placeholder="{{ trans('messages.amount_required') }}">
                                </div>
                            </div>
                        </div>
                        <div class="payment-option mb-3">
                            {{-- payment-options --}}
                            @include('web.paymentmethodsview')
                        </div>
                        <div class="d-flex justify-content-center my-4">
                            <button
                                class="btn btn-primary px-4 py-2 d-flex gap-3 justify-content-center align-items-center add_money"
                                onclick="addmoney()">
                                {{ trans('labels.proceed_to_pay') }}
                                <div class="loader d-none add_money_loader"></div>
                            </button>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0">{{ trans('labels.notes') }} :</p>
                            <ul>
                                <li class="text-muted d-flex">
                                    <i class="fa-regular fa-circle-check text-success align-items-center d-flex"></i>
                                    <p class="mb-0 mx-2">{{ trans('labels.wallet_add_note_1') }}</p>
                                </li>
                                <li class="text-muted d-flex">
                                    <i class="fa-regular fa-circle-check text-success align-items-center d-flex"></i>
                                    <p class="mb-0 mx-2">{{ trans('labels.wallet_add_note_2') }}</p>
                                </li>
                            </ul>
                        </div>
                        <input type="hidden" name="walleturl" id="walleturl" value="{{ URL::to('/wallet/recharge') }}">
                        <input type="hidden" name="successurl" id="successurl" value="{{ URL::to('/wallet') }}">
                        <input type="hidden" name="user_name" id="user_name" value="{{ Auth::user()->name }}">
                        <input type="hidden" name="user_email" id="user_email" value="{{ Auth::user()->email }}">
                        <input type="hidden" name="user_mobile" id="user_mobile" value="{{ Auth::user()->mobile }}">

                        <input type="hidden" name="addsuccessurl" id="addsuccessurl"
                            value="{{ URL::to('/addwalletsuccess') }}">
                        <input type="hidden" name="addfailurl" id="addfailurl" value="{{ URL::to('/wallet') }}">

                        <input type="hidden" name="myfatoorahurl" id="myfatoorahurl" value="{{ URL::to('myfatoorah') }}">
                        <input type="hidden" name="mercadopagourl" id="mercadopagourl"
                            value="{{ URL::to('mercadorequest') }}">
                        <input type="hidden" name="paypalurl" id="paypalurl" value="{{ URL::to('paypal') }}">
                        <input type="hidden" name="toyyibpayurl" id="toyyibpayurl" value="{{ URL::to('toyyibpay') }}">
                        <input type="hidden" name="paytaburl" id="paytaburl" value="{{ URL::to('/paytab') }}">
                        <input type="hidden" name="phonepeurl" id="phonepeurl" value="{{ URL::to('/phonepe') }}">
                        <input type="hidden" name="mollieurl" id="mollieurl" value="{{ URL::to('/mollie') }}">
                        <input type="hidden" name="khaltiurl" id="khaltiurl" value="{{ URL::to('/khalti') }}">

                        <input type="hidden" value="{{ trans('messages.payment_selection_required') }}"
                            name="payment_type_message" id="payment_type_message">

                        <input type="hidden" value="{{ trans('messages.amount_required') }}" name="amount_message"
                            id="amount_message">

                        <form action="{{ URL::to('paypal') }}" method="post" class="d-none">
                            {{ csrf_field() }}
                            <input type="hidden" name="return" value="2">
                            <input type="submit" class="callpaypal" name="submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="{{ url(env('ASSETSPATHURL') . 'web-assets/js/custom/wallet.js') }}"></script>
@endsection
