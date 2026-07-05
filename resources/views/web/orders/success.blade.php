@extends('web.layout.default')
@section('content')
    @if (!empty($ga4purchase))
        <script>
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({ ecommerce: null }); // clear previous ecommerce object
            dataLayer.push({
                event: 'purchase',
                ecommerce: @json($ga4purchase)
            });
        </script>
    @endif
    <section class="success">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-12">
                    <div class="success-image">
                        <img src="{{ url(env('ASSETSPATHURL') . 'web-assets/images/success.gif') }}" alt="">
                    </div>
                    <div class="">
                        <h3 class="fw-600 mb-3">{{ trans('labels.order_placed') }}</h3>

                        <h4 class="mb-0 fw-600">
                            <strong>Pickup Location:</strong>
                            {{ (new App\Helpers\helper)->getBranch()->name }}
                        </h4>

                        <h2 class="fw-800 mb-3">{{ trans('Your Order will be ready within 30 mins') }}</h2>

                        <p>{{ trans('labels.order_success_desc') }}</p>
                    </div>
                    <div class="row g-3 justify-content-center mt-3">
                        <div class="col-sm-auto col-12"><a href="{{ helper::branch_route('home') }}"
                                class="btn w-100 btn-outline-dark px-4 py-2 text-capitalize">{{ trans('labels.continue_shopping') }}</a>
                        </div>
                        @if (@helper::checkaddons('whatsapp_message'))
                            @if (whatsapp_helper::whatsapp_message_config()->order_created == 1)
                                @if (whatsapp_helper::whatsapp_message_config()->message_type == 2)
                                    <div class="col-sm-auto col-12"><a
                                            href="https://api.whatsapp.com/send?phone={{ whatsapp_helper::whatsapp_message_config()->whatsapp_number }}&text={{ @$whmessage }}"
                                            target="_blank"
                                            class="btn w-100 btn-success px-4 py-2 text-capitalize">{{ trans('labels.send_order_on_whatsapp') }}</a>
                                    </div>
                                @endif
                            @endif
                        @endif
                        <div class="col-sm-auto col-12"><a href="{{ URL::to('/orders-' . $orderdata->order_number) }}"
                                class="btn w-100 btn-primary px-4 py-2 text-capitalize">{{ trans('labels.track_order') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
